<?php

if(isset($_GET['task']))
{
    $task = $_GET['task'];
}
else
{
    die("ERROR: Invalid task number");
}

if(isset($_POST['rules']))
{
    $rules = $_POST['rules'];
}
else
{
    die("No rules provided");
}

if($task < 1 || $task > 7)
{
    die("ERROR: Invalid task number");
}

$tmpfname = tempnam("/tmp", "rules");
rename($tmpfname, $tmpfname .= '.rego');

$handle = fopen($tmpfname, "w");
fwrite($handle, $rules);
fclose($handle);

$short_output = "";
$output = "";
$success = true;
for($i = 1; $i < 6; $i++)
{
    $input = "./graphs/policy-" . strval($task) . "/input" . strval($i) . ".json";
    $eval = shell_exec('./opa eval -d ' . $tmpfname . ' -i ' . $input . ' "data.study.final_policy"');
    $correct = shell_exec('./opa eval -d ./graphs/policy-' . strval($task) . '/correct.rego -i ' . $input . ' "data.study.final_policy"');
    $result = json_decode($eval);
    $correct_result = json_decode($correct);

    if(isset($result->result))
    {
        if(!isset($correct_result->result))
        {
            $short_output .= strval($i) . "v, ";
            $output .= "Unexpected result: Input " . strval($i) . " should violate your policy.\n";
            $success = false;
        }
    }
    else if(isset($result->errors))
    {
        $output = "Error on line ". $result->errors[0]->location->row . " col " . $result->errors[0]->location->col . ": " . $result->errors[0]->message;
        $short_output = "L" . $result->errors[0]->location->row . "C" . $result->errors[0]->location->col . ":" . $result->errors[0]->message;
        $success = false;
        break;
    }
    else
    {
        if(isset($correct_result->result))
        {
            $short_output .= strval($i) . "s, ";
            $output .= "Unexpected result: Input " . strval($i) . " should satisfy your policy.\n";
            $success = false;
        }
    }
}

$arr = array('success' => $success, 'text' => $output);

unlink($tmpfname);
echo json_encode($arr);

