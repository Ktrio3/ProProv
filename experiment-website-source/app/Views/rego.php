<?= $this->extend('default') ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('/codemirror/lib/codemirror.css')?>">
<style>
    .box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
    .tab-pane {margin-top: 0.5em;}
    html, body { height: 100%; }
    .min-100 {min-height: 90%;}
    .CodeMirror { min-height: 100%; }
</style>
<?= $this->endSection() ?> 

<?= $this->section('js_head') ?>
<script src="<?= base_url('/codemirror/lib/codemirror.js')?>"></script>
<script src="<?= base_url('/js/rego.js')?>"></script>
<?= $this->endSection() ?> 

<?= $this->section('js_foot') ?>
  <script>
$(document).ready(function(){ 
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
      lineNumbers: true,
      mode: {name: "rego", globalVars: true}
    });

    var default_editor = editor.getValue();

    // var output = CodeMirror.fromTextArea(document.getElementById("output"), {
    //   lineNumbers: true, readOnly: true
    // });

    for(var i = 1; i < 6; i++)
    {
      var graph = CodeMirror.fromTextArea(document.getElementById("graph" + i + "-text"), {
        lineNumbers: true, readOnly: true
      });
      var box = graph.display.wrapper
      graph.setCursor(graph.lastLine());  //Trigger to fix any potential issues with resizing
      graph.setCursor(graph.firstLine());  //And reset
      box.style.height = box.parentElement.parentElement.parentElement.offsetHeight - 10 + "px"
    };

    $('.graphImage').hide();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      $('.graphText .CodeMirror').each(function(i, el){
        el.CodeMirror.refresh();
        el.style.height = el.parentElement.parentElement.parentElement.offsetHeight - 10 + "px"
      });
    });

    $( "#ToggleGraph" ).click(function() {
      if($('.graphImage').is(":visible"))
      {
        $('.graphImage').hide();
        $('.graphText').show();
        $( "#ToggleGraph" ).text("Show Graphs");
        $('.CodeMirror').each(function(i, el){
          el.CodeMirror.refresh();
        });
      }
      else
      {
        $('.graphImage').show();
        $('.graphText').hide();
        $( "#ToggleGraph" ).text("Show Graphs as Text");
      }
    });

    $( "#ResetPolicy" ).click(function() {
      if(confirm("This will delete your code and return the editor to its original state. Are you sure?"))
      {
        editor.setValue(default_editor);
      }
    });

    $( "#RunButton" ).click(function() {
      jQuery.post("/rego/" + $("#task").val(), { rules: editor.getValue() } )
        .done(function( data ) {
          var obj = jQuery.parseJSON( data );
          //output.setValue( obj.text );
          if(obj.success)
          {
            alert("Correct! Moving to next task.");
            window.location.href = "<?= base_url($next) ?>";
          }
          else
          {
            alert(obj.text);
          }
        });
    });

    $("#saveButton").click(function(){
      jQuery.post("<?= base_url("rego-check") ?>", { task: "<?= $task ?>" } )
        .done(function( data ) {
          if(data == "success")
          {
            window.location.href = "<?= base_url($next) ?>";
          }
          else{
            alert(data);
          }
        });
    });

    $("#saveButton").addClass("disabled");
    var intervalId = window.setInterval(function(){
      jQuery.post("<?= base_url("rego-time") ?>", { task: "<?= $task ?>" } )
        .done(function( data ) {
          if(data == "max")
          {
            alert("Time limit reached. Moving to next task.");
            window.location.href = "<?= base_url($next) ?>";
          }
          else if(data == "min")
          {
            $("#saveButton").removeClass("disabled");
          }
        });
      }, <?= intval(env("checkTime")) * 1000 ?>
    );

});
    </script> 

<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <input id="task" type="hidden" value="<?= $task ?>">
  <div class="container-fluid min-100 d-flex flex-column">
      <div class="row flex-grow-1">
        <div class="col-lg-7 flex-grow-1" style="padding-left: 0;padding-right:20px; border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;">
          <textarea style="display: none" id="code"><?php include("../graphs/default.rego") ?></textarea>
        </div>
        <div class="col-lg-5 d-flex flex-column" style="border-bottom: 1px solid #ccc;">
          <p class="text-center"><?php include("../graphs/policy-" . strval($task) . "/prompt.txt"); ?></p>
          <ul class="nav nav-tabs" id="graphTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="graph1-tab" data-toggle="tab" href="#graph1" role="tab" aria-controls="graph1" aria-selected="true">Input 1</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="graph2-tab" data-toggle="tab" href="#graph2" role="tab" aria-controls="graph2" aria-selected="false">Input 2</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="graph3-tab" data-toggle="tab" href="#graph3" role="tab" aria-controls="graph3" aria-selected="false">Input 3</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="graph4-tab" data-toggle="tab" href="#graph4" role="tab" aria-controls="graph4" aria-selected="false">Input 4</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="graph5-tab" data-toggle="tab" href="#graph5" role="tab" aria-controls="graph5" aria-selected="false">Input 5</a>
            </li>
          </ul>
          <div class="tab-content flex-grow-1" id="graphTabContent">
            <?php $hints = file("../graphs/policy-" . strval($task) . "/hints.txt");?>
            <div class="tab-pane fade show active flex-grow-1" id="graph1" role="tabpanel" aria-labelledby="graph1-tab">
              <!-- <div class="flex-grow-1 graphImage" style="margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo "../graphs/policy-" . strval($task) . "/Slide1.png"?>" />
              </div> -->
              <div class="flex-grow-1 graphText inputDivs" style="min-height: 100%;margin-left:-12px; margin-right:-12px;">
                <textarea style="display: none" id="graph1-text"><?php echo $hints[0]; include("../graphs/policy-" . strval($task) . "/input1.json"); ?></textarea>
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph2" role="tabpanel" aria-labelledby="graph2-tab">
              <!-- <div class="flex-grow-1 graphImage" style="margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo "./graphs/policy-" . strval($task) . "/Slide2.png"?>" />
              </div> -->
              <div class="flex-grow-1 graphText inputDivs" style="margin-left:-12px; margin-right:-12px;">
                <textarea style="display: none" id="graph2-text"><?php echo $hints[1]; include("../graphs/policy-" . strval($task) . "/input2.json"); ?></textarea>
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph3" role="tabpanel" aria-labelledby="graph3-tab">
              <!-- <div class="flex-grow-1 graphImage" style="margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo "./graphs/policy-" . strval($task) . "/Slide3.png"?>" />
              </div> -->
              <div class="flex-grow-1 graphText inputDivs" style="margin-left:-12px; margin-right:-12px;">
                <textarea style="display: none" id="graph3-text"><?php echo $hints[2]; include("../graphs/policy-" . strval($task) . "/input3.json"); ?></textarea>
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph4" role="tabpanel" aria-labelledby="graph4-tab">
              <!-- <div class="flex-grow-1 graphImage" style="margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo "./graphs/policy-" . strval($task) . "/Slide4.png"?>" />
              </div> -->
              <div class="flex-grow-1 graphText inputDivs" style="margin-left:-12px; margin-right:-12px;">
                <textarea style="display: none" id="graph4-text"><?php echo $hints[3]; include("../graphs/policy-" . strval($task) . "/input4.json"); ?></textarea>
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph5" role="tabpanel" aria-labelledby="graph5-tab">
              <!-- <div class="flex-grow-1 graphImage" style="margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo "./graphs/policy-" . strval($task) . "/Slide5.png"?>" />
              </div> -->
              <div class="flex-grow-1 graphText inputDivs" style="margin-left:-12px; margin-right:-12px;">
                <textarea style="display: none" id="graph5-text"><?php echo $hints[4]; include("../graphs/policy-" . strval($task) . "/input5.json"); ?></textarea>
              </div>
            </div>
          </div>
          <div class="d-flex" style="background: #f7f7f7;margin-left:-12px; margin-right:-12px;border: 1px solid rgba(0, 0, 0, 0.115);">
            <div class="me-auto p-2">
              <button type="button" id="RunButton" class="btn btn-success">Evaluate</button>
              <button type="button" id="ToggleGraph" class="btn btn-secondary" hidden>Show Graph as Text</button>
            </div>
            <div class="p-2 float-right">
              <button type="button" id="ResetPolicy" class="btn btn-danger">Reset</button>
            </div>
          </div>
          <!-- <div class="flex-grow-1" style="margin-left:-12px; margin-right:-12px;" hidden>
            <textarea style="display: none" id="output">Click run for output...</textarea>
          </div> -->
        </div>
      </div>
    </div>
<?= $this->endSection() ?>