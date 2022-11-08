<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en">
  <!--<![endif]-->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Kevin Dennis">
    <link rel="icon" href="https://www.usf.edu/favicon.ico">
    <title>USF Provenance Study</title>

    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
      .box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
      .tab-pane {margin-top: 0.5em;}
      html, body { height: 100%; }
      .min-100 {min-height: 90%;}
      .CodeMirror { min-height: 100%; }
    </style>
    <link rel="stylesheet" href="/css/tree.css">
  </head>
  <body>

    <?php include("./header.php");?>

    <?php 
      if(!isset($_GET['task']) || $_GET['task'] < 1 || $_GET['task'] > 7){
        $task = 1;
      }
      else{
        $task = intval($_GET['task']);
      } 
    ?>
    
    <input id="task" type="hidden" value="<?php echo $task ?>">
    <div class="container-fluid min-100 d-flex flex-column">
      <div class="row flex-grow-1">
        <div id="leftPane" class="col-lg-7 d-flex flex-column" style="overflow: scroll;padding-left: 0;padding-right:20px; border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;">
                        <!--
              We will create a family tree using just CSS(3)
              The markup will be simple nested lists
              -->
              <div class="tree" id="tree" style="width: 400px;">
                <ul>
                  <li id="tree_root">
                    <select id="tree_root_select">
                    </select>
                  </li>
                </ul>
              </div>
        </div>
        <div id="rightPane" class="col-lg-5 d-flex flex-column" style="border-bottom: 1px solid #ccc;">
          <p class="text-center"><?php include("./graphs/policy-" . strval($task) . "/prompt.txt"); ?></p>
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
            <div class="tab-pane fade show active flex-grow-1" id="graph1" role="tabpanel" aria-labelledby="graph1-tab">
              <div class="flex-grow-1 graphImage" style="overflow: auto;margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo "/imgs/graphs/policy-" . strval($task) . "/Slide1.png"?>" />
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph2" role="tabpanel" aria-labelledby="graph2-tab">
              <div class="flex-grow-1 graphImage" style="overflow: auto;margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo "/imgs/graphs/policy-" . strval($task) . "/Slide2.png"?>" />
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph3" role="tabpanel" aria-labelledby="graph3-tab">
              <div class="flex-grow-1 graphImage" style="overflow: auto;margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo "/imgs/graphs/policy-" . strval($task) . "/Slide3.png"?>" />
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph4" role="tabpanel" aria-labelledby="graph4-tab">
              <div class="flex-grow-1 graphImage" style="overflow: auto;margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo "/imgs/graphs/policy-" . strval($task) . "/Slide4.png"?>" />
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph5" role="tabpanel" aria-labelledby="graph5-tab">
              <div class="flex-grow-1 graphImage" style="overflow: auto;margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo "/imgs/graphs/policy-" . strval($task) . "/Slide5.png"?>" />
              </div>
            </div>
          </div>
          <div class="d-flex" style="background: #f7f7f7;margin-left:-12px; margin-right:-12px;border: 1px solid rgba(0, 0, 0, 0.115);">
            <div class="me-auto p-2" style="width:95%">
              <div class="row flex-grow-1">
                <div class="col-lg-12 d-flex flex-column">
                  <div class="input-group">
                    <div class="input-group-btn">
                      <button type="button" id="RunButton" class="btn btn-success">Evaluate</button>
                    </div>
                    <input type="text" id="policyString" class="form-control" value="<policy>" disabled/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="flex-grow-1" style="margin-left:-12px; margin-right:-12px;" hidden>
            <textarea style="display: none" id="output">Click run for output...</textarea>
          </div> -->
        </div>
      </div>
    </div>

    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-tab.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/proprov.js"></script>
    
    <script type="text/javascript">
      $(document).ready(function(){
        $("#saveButton").click(function(){
            window.location.href = "/proprov.php?task=" + (parseInt($("#task").val()) + 1);
          });
      });
    </script>

  </body>
</html>