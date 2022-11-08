<?= $this->extend('default') ?>

<?= $this->section('css') ?>

<?= $this->endSection() ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>

<?= $this->section('js_foot') ?>
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<script>
$(document).ready(function(){
  $("#saveButton").click(function(){

    //Only check time with server to avoid timezone issues
    jQuery.post("<?= base_url("training-" . $num) ?>", { type: "<?= $type ?>" } )
      .done(function( data ) {
        if(data == "success")
        {
          window.location.href = "<?= base_url($next) ?>";
        }
        else{
          alert("Please watch the video before continuing.");
        }
      });
  });
});
</script>

<?= $this->endSection() ?>


<?= $this->section('content') ?>
  <div class="container-fluid flex-fill" style="height: 85vh;">
    <div class="row flex-grow-1" style="height: 100%;width:100%;">
      <div class="col col-lg-12 d-flex flex-column" style="height: 100%;width:100%;">
        <?php if($type == "prov"):?>
          <video width="100%" height="100%" controls autoplay>
            <source src="<?= base_url('videos/prov.mp4') ?>" type="video/mp4"> 
            <source src="<?= base_url('videos/prov.webm') ?>" type="video/webm">
            <track label="English" kind="subtitles" srclang="en" src="<?= base_url('videos/prov.vtt') ?>" default>
          Your browser does not support the video tag.
          </video>
        <?php elseif($type == "proprov"): ?>
          <video width="100%" height="100%" controls autoplay>
            <source src="<?= base_url('videos/proprov.mp4') ?>" type="video/mp4">
            <source src="<?= base_url('videos/proprov.webm') ?>" type="video/webm">
            <track label="English" kind="subtitles" srclang="en" src="<?= base_url('videos/proprov.vtt') ?>" default>
          Your browser does not support the video tag.
          </video>
        <?php else: ?>
          <video width="100%" height="100%" controls autoplay>
            <source src="<?= base_url('videos/rego.mp4') ?>" type="video/mp4">
            <source src="<?= base_url('videos/rego.webm') ?>" type="video/webm">
            <track label="English" kind="subtitles" srclang="en" src="<?= base_url('videos/rego.vtt') ?>" default>
          Your browser does not support the video tag.
          </video>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?= $this->endSection() ?>