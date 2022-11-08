<?= $this->extend('default') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('js_head') ?>
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>

<?= $this->section('js_foot') ?>
    
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <div class="container-fluid" style="padding-top: 1em;padding-bottom: 2em;">
    <form class="row g-3" action="<?= base_url('exit/' . $batch) ?>" id="content" method="post">

      <?php foreach($questions as $key=>$value): ?>

      <div class="d-flex justify-content-center align-items-center">
        <div class="card align-self-center" style="min-width: 40em;">
          <h5 class="card-header">Question <?= $key+$questionOffset ?></h5>
          <div class="card-body">
            <p class="card-text"><?= $value ?></p>
            <div class="col-auto">
              <textarea class="form-control" name="<?= "q" . ($key+$questionOffset) ?>" rows="3"></textarea>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </form>
  </div>
<?= $this->endSection() ?>
