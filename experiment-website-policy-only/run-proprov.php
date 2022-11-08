<?php

if(isset($_GET['task']))
{
    $task = $_GET['task'];
}
else
{
    die("ERROR: Invalid task number");
}

if(isset($_POST['policy']))
{
    $policy = $_POST['policy'];
}
else
{
    die("ERROR: No policy provided");
}

if($task < 1 || $task > 7)
{
    die("ERROR: Invalid task number");
}

//Write the policy to a temp file
$tmpfname = tempnam("/tmp", "proprov");

rename($tmpfname, $tmpfname .= '.json');

$handle = fopen($tmpfname, "w");
fwrite($handle, $policy);
fclose($handle);

//Run the policy evaluator
$java = "java";  //Path to java executable 
$result = shell_exec($java . " -jar ./experiments-proprov.jar " . $task . " " . $tmpfname);

echo $result;
