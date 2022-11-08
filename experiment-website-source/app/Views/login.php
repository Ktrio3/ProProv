<?= $this->extend('default') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
  <div class="container-fluid">
    <div class="d-flex justify-content-center align-items-center" style="height:20em">
      <div class="card align-self-center">
        <h5 class="card-header">Provenance Study Login</h5>
        <div class="card-body">
          <p class="card-text">Please enter the access code provided by the study coordinator<br/> or the Mechnical Turk instructions.</p>
          <form class="row g-3" action="<?= base_url('login') ?>" method="post">
            <div class="col-auto">
              <label for="accessCode" class="visually-hidden">Access Code</label>
              <?php if(isset($errors)): ?>
                <input type="text" class="form-control is-invalid" name="accessCode" id="accessCode" placeholder="Access Code">
                <div class="invalid-feedback"><?= $errors ?></div>
              <?php else: ?>
                <input type="text" class="form-control" name="accessCode" id="accessCode" placeholder="Access Code">
              <?php endif; ?>
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-primary mb-3">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?= $this->endSection() ?>