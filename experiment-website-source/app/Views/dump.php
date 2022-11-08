<?= $this->extend('default') ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <div class="container-fluid">
      <h1>User data</h1>
      <pre>
          <?php
              print_r($user);
          ?>
      </pre>
      <br/>
      <h1>Demographic data</h1>
      <pre>
          <?php
              print_r($demo);
          ?>
      </pre>
      <br/>
      <h1>Training data</h1>
      <pre>
          <?php
              print_r($train);
          ?>
      </pre>
      <br/>
      <h1>Rego Tasks data</h1>
      <pre>
          <?php
              print_r($regoTasks);
          ?>
      </pre>
      <br/>
      <h1>Rego Evaluations data</h1>
      <pre>
          <?php
              print_r($regoEvals);
          ?>
      </pre>
      <br/>
      <h1>ProProv Tasks data</h1>
      <pre>
          <?php
              print_r($proprovTasks);
          ?>
      </pre>
      <br/>
      <h1>ProProv Evals data</h1>
      <pre>
          <?php
              print_r($proprovEvals);
          ?>
      </pre>
      <br/>
      <h1>Exit Scale Answer data</h1>
      <pre>
          <?php
              print_r($eScale);
          ?>
      </pre>
      <br/>
      <h1>Exit Text data</h1>
      <pre>
          <?php
              print_r($eText);
          ?>
      </pre>
    </div>
<?= $this->endSection() ?>