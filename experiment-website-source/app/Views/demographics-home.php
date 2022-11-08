<?= $this->extend('default') ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <div class="container-fluid">
        <div class="bg-light p-5 rounded-lg">
          <h1 class="display-4">Step 1: Demographics</h1>
          <hr class="my-4">
          <p>This section contains basic demographic questions.</p>
          <a href="<?= base_url("demographics/1") ?>" class="btn btn-primary btn-lg">Begin</a>
        </div>

    </div> 
<?= $this->endSection() ?>