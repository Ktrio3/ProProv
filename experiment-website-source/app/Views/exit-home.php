<?= $this->extend('default') ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <div class="container-fluid">
        <div class="bg-light p-5 rounded-lg">
          <h1 class="display-4">Step 6: Exit Survey</h1>
          <hr class="my-4">
          <p>This section contains questions about the usability of each tool.</p>
          <p>Please record your immediate response to each item, rather than thinking about items for a long time.  All multiple choice questions should be completed. If you feel that you cannot respond to a particular item, you should mark the centre point of the scale.
          </p>
          <a href="<?= base_url("exit/1") ?>" class="btn btn-primary btn-lg">Begin</a>
        </div>

    </div> 
<?= $this->endSection() ?>