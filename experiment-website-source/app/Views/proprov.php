<?= $this->extend('default') ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('codemirror/lib/codemirror.css')?>">
<link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css')?>">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
.tab-pane {margin-top: 0.5em;}
html, body { height: 100%; }
.min-100 {min-height: 90%;}
.CodeMirror { min-height: 100%; }
</style>
<style>
  /*https://thecodeplayer.com/index.php/walkthrough/css3-family-tree*/
* {margin: 0; padding: 0;}

.tree ul {
  padding-top: 20px; position: relative;
  
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
}

.tree li {
  float: left; text-align: center;
  list-style-type: none;
  position: relative;
  padding: 20px 5px 0 5px;
  
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/

.tree li::before, .tree li::after{
  content: '';
  position: absolute; top: 0; right: 50%;
  border-top: 1px solid #ccc;
  width: 50%; height: 20px;
}
.tree li::after{
  right: auto; left: 50%;
  border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without 
any siblings*/
.tree li:only-child::after, .tree li:only-child::before {
  display: none;
}

/*Remove space from the top of single children*/
.tree li:only-child{ padding-top: 0;}

/*Remove left connector from first child and 
right connector from last child*/
.tree li:first-child::before, .tree li:last-child::after{
  border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree li:last-child::before{
  border-right: 1px solid #ccc;
  border-radius: 0 5px 0 0;
  -webkit-border-radius: 0 5px 0 0;
  -moz-border-radius: 0 5px 0 0;
}
.tree li:first-child::after{
  border-radius: 5px 0 0 0;
  -webkit-border-radius: 5px 0 0 0;
  -moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree ul ul::before{
  content: '';
  position: absolute; top: 0; left: 50%;
  border-left: 1px solid #ccc;
  width: 0; height: 20px;
}

.tree li a{
  border: 1px solid #ccc;
  padding: 5px 10px;
  text-decoration: none;
  color: #666;
  font-family: arial, verdana, tahoma;
  font-size: 11px;
  display: inline-block;
  
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
/*.tree li a:hover, .tree li a:hover+ul li a {
  background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
}*/
/*Connector styles on hover*/
/*.tree li a:hover+ul li::after, 
.tree li a:hover+ul li::before, 
.tree li a:hover+ul::before, 
.tree li a:hover+ul ul::before{
  border-color:  #94a0b4;
}*/

/*Thats all. I hope you enjoyed it.
Thanks :)*/

.tree select {
  min-width: 250px; 
}

.tree input {
  min-width: 250px; 
}

.uncompleted{
  border: 1px solid red!important;
  border-radius: 5px !important;
}

.completed{
  border: 1px solid green!important;
  border-radius: 5px !important;
}

.uncompleted.select2-container--default{
  border: 1px solid red!important;
  border-radius: 5px !important;
}

.completed.select2-container--default{
  border: 1px solid green!important;
  border-radius: 5px !important;
}

</style>
<?= $this->endSection() ?> 

<?= $this->section('js_foot') ?>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="<?= base_url('js/proprov.js')?>"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#saveButton").click(function(){
        
        jQuery.post("<?= base_url("proprov-check") ?>", { task: "<?= $task ?>" } )
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
        jQuery.post("<?= base_url("proprov-time") ?>", { task: "<?= $task ?>" } )
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
    <input id="next" type="hidden" value="<?= base_url($next) ?>">
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
            <div class="tab-pane fade show active flex-grow-1" id="graph1" role="tabpanel" aria-labelledby="graph1-tab">
              <div class="flex-grow-1 graphImage" style="overflow: auto;margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo base_url("imgs/graphs/policy-" . strval($task) . "/Slide1.png")?>" />
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph2" role="tabpanel" aria-labelledby="graph2-tab">
              <div class="flex-grow-1 graphImage" style="overflow: auto;margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo base_url("imgs/graphs/policy-" . strval($task) . "/Slide2.png")?>" />
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph3" role="tabpanel" aria-labelledby="graph3-tab">
              <div class="flex-grow-1 graphImage" style="overflow: auto;margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo base_url("imgs/graphs/policy-" . strval($task) . "/Slide3.png")?>" />
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph4" role="tabpanel" aria-labelledby="graph4-tab">
              <div class="flex-grow-1 graphImage" style="overflow: auto;margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo base_url("imgs/graphs/policy-" . strval($task) . "/Slide4.png")?>" />
              </div>
            </div>
            <div class="tab-pane fade flex-grow-1" id="graph5" role="tabpanel" aria-labelledby="graph5-tab">
              <div class="flex-grow-1 graphImage" style="overflow: auto;margin-left:-12px; margin-right:-12px;">
                <img src="<?php echo base_url("imgs/graphs/policy-" . strval($task) . "/Slide5.png")?>" />
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
<?= $this->endSection() ?>