<?= $this->extend('default') ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <div class="container-fluid">
        <div class="bg-light p-5 rounded-lg">
          <h1 class="display-4">Provenance Policy Specification Tools</h1>
          <?php if($user['demographics'] && $user['training_1'] && $user['exercise_1']
                  && $user['training_2'] && $user['exercise_2'] && $user['exit']):?>
          <?php else: ?>
            <hr class="my-4">
            <p>Thank you for taking part in this study! The experiment is split into 6 steps, as follows. Each step provides instructions detailing how to complete the step.</p>
            <p>
              We are seeking individuals with experience in computer programming and/or computer security, to test the usability of policy-specification tools.  
              As part of the study, you will be asked to encode security policies using two different tools, 
              and to complete a short survey about your experiences.  Prior experience with policy specification is not required.  
              The study will be conducted over the course of a single 60–120-minute session. Please refrain from multi-tasking during the session. You will be compensated $11 for completing the session.
            </p>
            <p>
              <strong>You may only complete this survey once. Only lifetime approvals of zero will be accepted.</strong>
            </p>
            <p>
              At the end of the survey, you will receive a compensation code. Paste this code into the box on the Mechanical Turk site to receive credit for taking the survey.
            </p>
            <p>
            <strong>Important:</strong> We reserve the right to approve or deny compensation for performing these tasks.  We may deny compensation if it appears you have not made a good-faith effort to complete the tasks, per clause 3.b.vi. of the MTurk user agreement.  In order to receive compensation, your responses must consist of good-faith efforts to complete the tasks.  Thank you for your cooperation and participation!
            </p>
            <p>
              Thank you for participating!
            </p>
          <?php endif;?>
        </div>

        <?php if($user['demographics'] && $user['training_1'] && $user['exercise_1']
                  && $user['training_2'] && $user['exercise_2'] && $user['exit']):?>
          <div class="row justify-content-md-center">
            <div class="col-sm-auto ">
              <div class="card" style="width: 50rem;margin-top: 2em;">
                <div class="card-body">
                  <h5 class="card-title">Thank you for completing the experiment!</h5>
                  <p class="card-text">If you are using Mechanical Turk, your compensation code is: <span style="font-weight: bold;"><?= $user['verification_code']; ?></span></p>
                  <div class="d-grid gap-2 col-6 mx-auto">
                    <a href="<?= base_url("logout"); ?>" class="btn btn-danger">Log out</a>
                  </div>
                </div>
              </div> 
            </div>
          </div>
        <?php else:?>
          <div class="row justify-content-md-center">
            <div class="col-sm-auto ">
              <div class="card" style="width: 17rem;">
                <div class="card-body">
                  <h5 class="card-title">Step 1: Demographics</h5>
                  <p class="card-text">Complete a short demographics survey.</p>
                  <div class="d-grid gap-2 col-6 mx-auto">
                      <?php 
                        if(!$user['demographics'])
                        {
                          $link = base_url('demographics');
                          $style = "btn-primary";
                          $text = "Begin";
                        }
                        else
                        {
                          $link = "#";
                          $style = " btn-success disabled";
                          $text = "Completed";
                        }
                      ?>
                      <a href="<?= $link ?>" class="btn <?= $style ?>" tabindex="-1"><?= $text ?></a>
                  </div>
                </div>
              </div> 
            </div>
            <div class="col-sm-auto">
              <div class="card" style="width: 17rem;">
                <div class="card-body">
                  <h5 class="card-title">Step 2: Training 1</h5>
                  <p class="card-text">Watch training videos on a policy specification tool.</p>
                  <div class="text-center">
                      <?php 
                        if(!$user['training_1'] && $user['demographics'])
                        {
                          $link = base_url('training-1');
                          $style = "btn-primary";
                          $text = "Begin";
                        }
                        else if($user['training_1'])
                        {
                          $link = "#";
                          $style = " btn-success disabled";
                          $text = "Completed";
                        }
                        else
                        {
                          $link = "#";
                          $style = " btn-secondary disabled";
                          $text = "Complete previous step";
                        }
                      ?>
                      <a href="<?= $link ?>" class="btn <?= $style ?>" tabindex="-1"><?= $text ?></a>
                  </div>
                </div>
              </div> 
            </div>
            <div class="col-sm-auto">
              <div class="card" style="width: 17rem;">
                <div class="card-body">
                  <h5 class="card-title">Step 3: Policy Exercise</h5>
                  <p class="card-text">Develop policies using the policy specification tool.</p>
                  <div class="text-center">
                      <?php 
                        if(!$user['exercise_1'] && $user['training_1'])
                        {
                          if($user['rego_first'] == "1")
                          {
                            $link = base_url('rego');
                          }
                          else
                          {
                            $link = base_url('proprov'); 
                          }
                          $style = "btn-primary";
                          $text = "Begin";
                        }
                        else if($user['exercise_1'])
                        {
                          $link = "#";
                          $style = " btn-success disabled";
                          $text = "Completed";
                        }
                        else
                        {
                          $link = "#";
                          $style = " btn-secondary disabled";
                          $text = "Complete previous step";
                        }
                      ?>
                      <a href="<?= $link ?>" class="btn <?= $style ?>" tabindex="-1"><?= $text ?></a>
                  </div>
                </div>
              </div> 
            </div>
            <div class="col-sm-auto">
              <div class="card" style="width: 17rem;">
                <div class="card-body">
                  <h5 class="card-title">Step 4: Training 2</h5>
                  <p class="card-text">Watch training videos on another policy specification tool.</p>
                  <div class="text-center">
                      <?php 
                        if(!$user['training_2'] && $user['exercise_1'])
                        {
                          $link = base_url('training-2');
                          $style = "btn-primary";
                          $text = "Begin";
                        }
                        else if($user['training_2'])
                        {
                          $link = "#";
                          $style = " btn-success disabled";
                          $text = "Completed";
                        }
                        else
                        {
                          $link = "#";
                          $style = " btn-secondary disabled";
                          $text = "Complete previous step";
                        }
                      ?>
                      <a href="<?= $link ?>" class="btn <?= $style ?>" tabindex="-1"><?= $text ?></a>
                  </div>
                </div>
              </div> 
            </div>
            <div class="col-sm-auto">
              <div class="card" style="width: 17rem;">
                <div class="card-body">
                  <h5 class="card-title">Step 5: Policy Exercise</h5>
                  <p class="card-text">Develop policies using the second policy specification tool.</p>
                  <div class="text-center">
                      <?php 
                        if(!$user['exercise_2'] && $user['training_2'])
                        {
                          if($user['rego_first'] == "1")
                          {
                            $link = base_url('proprov');
                          }
                          else
                          {
                            $link = base_url('rego'); 
                          }
                          $style = "btn-primary";
                          $text = "Begin";
                        }
                        else if($user['exercise_2'])
                        {
                          $link = "#";
                          $style = " btn-success disabled";
                          $text = "Completed";
                        }
                        else
                        {
                          $link = "#";
                          $style = " btn-secondary disabled";
                          $text = "Complete previous step";
                        }
                      ?>
                      <a href="<?= $link ?>" class="btn <?= $style ?>" tabindex="-1"><?= $text ?></a>
                  </div>
                </div>
              </div> 
            </div>
            <div class="col-sm-auto">
              <div class="card" style="width: 17rem;">
                <div class="card-body">
                  <h5 class="card-title">Step 6: Exit Survey</h5>
                  <p class="card-text">Complete a short survey about the tools.</p>
                  <div class="text-center">
                      <?php 
                        if(!$user['exit'] && $user['exercise_2'])
                        {
                          $link = base_url('exit');
                          $style = "btn-primary";
                          $text = "Begin";
                        }
                        else if($user['exit'])
                        {
                          $link = "#";
                          $style = " btn-success disabled";
                          $text = "Completed";
                        }
                        else
                        {
                          $link = "#";
                          $style = " btn-secondary disabled";
                          $text = "Complete previous step";
                        }
                      ?>
                      <a href="<?= $link ?>" class="btn <?= $style ?>" tabindex="-1"><?= $text ?></a>
                  </div>
                </div>
              </div> 
            </div>
          </div>
        <?php endif;?>
    </div> 
<?= $this->endSection() ?>