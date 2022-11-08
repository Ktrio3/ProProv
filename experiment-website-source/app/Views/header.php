<nav class="navbar sticky-top navbar-expand-lg navbar-light d-flex" style="background: #f7f7f7; border: 1px solid rgba(0, 0, 0, 0.115);" >
  <a class="navbar-brand" style="margin-left: 2em;" href="<?= base_url() ?>">USF Provenance Study</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse me-auto" id="navbarSupportedContent">
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('training-materials')?>" target="_blank">Training Materials</a>
        </li>
    </ul>
  </div>
  <?php if(isset($controls) && $controls):?>
    <div>
      <nav class="navbar navbar-light bg-light">
          <form class="container-fluid justify-content-start">
            <!-- <span class="navbar-brand">Saved!</span> -->
            <!-- <button class="btn btn-outline-primary me-2" type="button">Save</button> -->
            <button id="saveButton" class="btn btn-outline-success me-2" form="content" type="submit">Save and Continue</button>
          </form>
      </nav>
    </div>
  <?php endif;?>
  <?php if(isset($user) && $user):?>
    <div>
      <nav class="navbar navbar-light bg-light">
        <i class="bi bi-person-circle" style="margin-right:.5em;"></i>
       <span class="navbar-brand"><?= $user['id'] ?></span>
      </nav>
    </div>
  <?php endif; ?>
</nav>