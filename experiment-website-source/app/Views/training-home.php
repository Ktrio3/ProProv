<?= $this->extend('default') ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <div class="container-fluid">
        <div class="bg-light p-5 rounded-lg">
          <?php if($num == 1): ?>
          <h1 class="display-4">Step 2: Training</h1>
          <?php else:?>
            <h1 class="display-4">Step 4: Training</h1>
          <?php endif;?>
          <hr class="my-4">
          <?php if($num == 1): ?>
            <p>This section contains a short video that will introduce you to data provenance and policies. A second video will then demonstrate how provenance policies can be created using the <?php if($type == "rego") {echo "Rego";} else {echo "ProProv";} ?> policy tool. After the videos, you will be asked to create some policies using the <?php if($type == "rego") {echo "Rego";} else {echo "ProProv";} ?> policy tool.</p>
          <?php else:?>
            <p>This section contains a short video that will demonstrate how provenance policies can be created using <?php if($type == "rego") {echo "Rego";} else {echo "ProProv";} ?>, another policy tool. After the video, you will be asked to create some policies using the <?php if($type == "rego") {echo "Rego";} else {echo "ProProv";} ?> policy tool.</p>
          <?php endif;?>
          <p>After completing this section, you can access the videos and PDF versions of the slides using the <a href="<?= base_url("training-materials") ?>">"Training Materials"</a> link above.</p>
          <?php if($num == 1): ?>
          <a href="<?= base_url("training-1/1") ?>" class="btn btn-primary btn-lg">Begin</a>
          <?php else:?>
            <a href="<?= base_url("training-2/1") ?>" class="btn btn-primary btn-lg">Begin</a>
          <?php endif;?>
        </div>

    </div> 
<?= $this->endSection() ?>