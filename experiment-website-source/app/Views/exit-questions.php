<?= $this->extend('default') ?>

<?= $this->section('css') ?>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;margin:0px auto;}
.tg td{border-style:solid;border-width:0px;font-family:Arial, sans-serif;font-size:14px;overflow:hidden;
  padding:13px 20px;word-break:normal;}
.tg th{border-style:solid;border-width:0px;font-family:Arial, sans-serif;font-size:14px;font-weight:normal;
  overflow:hidden;padding:13px 20px;word-break:normal;}
.tg .tg-fe7a{border-color:#ffffff;font-weight:bold;position:-webkit-sticky;position:sticky;text-align:center;top:-1px;
  vertical-align:middle;will-change:transform}
.tg .tg-44qx{border-color:#ffffff;font-weight:bold;text-align:center;vertical-align:middle}
.tg .tg-3jwr{border-color:#ffffff;position:-webkit-sticky;position:sticky;text-align:center;top:-1px;vertical-align:middle;
  will-change:transform}
.tg .tg-v0mg{border-color:#ffffff;text-align:center;vertical-align:middle}
@media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;margin: auto 0px;}}

input[type=radio]{
  transform:scale(1.5);
}
</style>

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
        <div class="card align-self-center" style="min-width: 30em;">
          <h5 class="card-header">Question <?= $key+$questionOffset ?></h5>
          <div class="card-body">
            <p class="card-text"><?= $value ?></p>
            <div class="col-auto">
              <div class="tg-wrap"><table class="tg">
                <thead>
                  <tr>
                    <?php if($eachTool):?>
                      <th class="tg-3jwr"></th>
                    <?php endif;?>
                    <th class="tg-3jwr" style="width:10em;font-weight:bold;">Strongly Disagree</th>
                    <th class="tg-3jwr" style="width:10em;font-weight:bold;">Disagree</th>
                    <th class="tg-3jwr" style="width:10em;font-weight:bold;">Neither Agree <br>or Disagree</th>
                    <th class="tg-3jwr" style="width:10em;font-weight:bold;">Agree</th>
                    <th class="tg-3jwr" style="width:10em;font-weight:bold;">Strongly Agree</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $first = "ProProv";
                    $second = "Rego";
                    if($user["rego_first"] == 1)
                    {
                      $first = "Rego";
                      $second = "ProProv";
                    }
                  ?>
                  <?php if($eachTool):?>
                    <tr>
                      <td class="tg-v0mg" style="font-weight:bold;"><?= $first ?></td>
                      <?php for($i = 1; $i < 6; $i++):?>
                        <td class="tg-v0mg">
                          <input class="form-check-input" type="radio" name="<?= $first . "_q" . ($key+$questionOffset) ?>" value="<?= $i ?>" required>
                        </td>
                      <?php endfor;?>
                    </tr>
                    <tr>
                      <td class="tg-v0mg" style="font-weight:bold;"><?= $second ?></td>
                      <?php for($i = 1; $i < 6; $i++):?>
                        <td class="tg-v0mg">
                          <input class="form-check-input" type="radio" name="<?= $second . "_q" . ($key+$questionOffset) ?>" value="<?= $i ?>" required>
                        </td>
                      <?php endfor;?>
                    </tr>
                  <?php else:?>
                    <tr>
                      <?php for($i = 1; $i < 6; $i++):?>
                        <td class="tg-v0mg">
                          <input class="form-check-input" type="radio" name="<?= "q" . ($key+$questionOffset) ?>" value="<?= $i ?>" required>
                        </td>
                      <?php endfor;?>
                    </tr>
                  <?php endif;?>
                </tbody>
              </table></div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </form>
  </div>
<?= $this->endSection() ?>
