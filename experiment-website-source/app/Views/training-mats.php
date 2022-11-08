<?= $this->extend('default') ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <div class="container-fluid">
        <div class="bg-light p-5 rounded-lg">
          <?php if($user['training_1'] == 1 || $user['training_2'] == 1): ?>
            <ul>
              <?php if($user['training_1'] == 1): ?>
                  <li><a href="<?= base_url("training-materials/prov") ?>" target="_blank">Provenance Training Video</a></li>
                  <li><a href="<?= base_url("slides/prov.pdf") ?>" target="_blank">Provenance Training Slides as PDF</a></li>
                  <br/>
                <?php if($user['rego_first'] == 1): ?>
                  <li><a href="<?= base_url("training-materials/rego") ?>" target="_blank">Rego Training Video</a></li>
                  <li><a href="<?= base_url("slides/rego.pdf") ?>" target="_blank">Rego Training Slides as PDF</a></li>
                  <br/>
                <?php else:?>
                  <li><a href="<?= base_url("training-materials/proprov") ?>" target="_blank">ProProv Training Video</a></li>
                  <li><a href="<?= base_url("slides/proprov.pdf") ?>" target="_blank">ProProv Training Slides as PDF</a></li>
                  <br/>
                <?php endif;?>
              <?php endif;?>
              <?php if($user['training_2'] == 1): ?>
                <?php if($user['rego_first'] == 1): ?>
                  <li><a href="<?= base_url("training-materials/proprov") ?>" target="_blank">ProProv Training Video</a></li>
                  <li><a href="<?= base_url("slides/proprov.pdf") ?>" target="_blank">ProProv Training Slides as PDF</a></li>
                <?php else:?>
                  <li><a href="<?= base_url("training-materials/rego") ?>" target="_blank">Rego Training Video</a></li>
                  <li><a href="<?= base_url("slides/rego.pdf") ?>" target="_blank">Rego Training Slides as PDF</a></li>
                <?php endif;?>
            <?php endif;?>
            </ul>
          <?php else:?>
            <p>You currently do not have access to any training materials. Please check again after you've completed step 2 or 4.</p>
          <?php endif;?>
        </div>
    </div> 
<?= $this->endSection() ?>