<?= $this->extend('default') ?>


<!-- Latest compiled and minified JavaScript -->

<?= $this->section('css') ?>
  <style>
    input[type=radio][disabled] {
      background-color: #000000;
    }
  </style>

<?= $this->endSection() ?>

<?= $this->section('js_head') ?>
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>

<?= $this->section('js_foot') ?>
  <script>
        $(document).ready(function(){
            $('input[type=radio][name=SpecifiedPolicy]').trigger('change');          
            $('input[type=radio][name=SpecifiedPolicy]').change(function() {
                if (this.value == '1') {
                    $('textarea[name=PoliciesWorkedWith]').prop('disabled', false);
                    $('input[type=radio][name=SpecifiedPolicyRego]').prop('disabled', false);
                    $('textarea[name=PoliciesWorkedWith]').prop('required', true)
                    $('input[type=radio][name=SpecifiedPolicyRego]').prop('required', true)
                }
                else {
                    $('textarea[name=PoliciesWorkedWith]').prop('disabled', true);
                    $('input[type=radio][name=SpecifiedPolicyRego]').prop('disabled', true);
                    $('textarea[name=PoliciesWorkedWith]').prop('required', false)
                    $('input[type=radio][name=SpecifiedPolicyRego]').prop('required', false)
                }
            });
        });
    </script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container-fluid">
        <form class="row g-3" action="<?= base_url('demographics/2') ?>" id="content" method="post">
            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="width: 30em; margin-top: 1em;">
                <h5 class="card-header">Question 9</h5>
                <div class="card-body">
                    <p class="card-text">If applicable, how many years have you spent <br/>working professionally in Computer Security?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCyS" value="None" required <?php if(isset($vals['YearsCyS']) && $vals['YearsCyS'] == "None"){echo 'checked';} ?>>
                            None
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCyS" value="Some, but less than 2 years" required <?php if(isset($vals['YearsCyS']) && $vals['YearsCyS'] == "Some, but less than 2 years"){echo 'checked';} ?>>
                            Some, but less than 2 years
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCyS" value="Between 2 to 5 years" required <?php if(isset($vals['YearsCyS']) && $vals['YearsCyS'] == "Between 2 to 5 years"){echo 'checked';} ?>>
                            Between 2 to 5 years
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCyS" value="Greater than 5 years" required <?php if(isset($vals['YearsCyS']) && $vals['YearsCyS'] == "Greater than 5 years"){echo 'checked';} ?>>
                            Greater than 5 years
                          </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('YearsCyS')):?>
                          <span style="color:red;"><?= $validation->getError('YearsCyS')?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="width: 30em; margin-top: 1em;">
                <h5 class="card-header">Question 10</h5>
                <div class="card-body">
                    <p class="card-text">If applicable, how many years have you spent working <br/>professionally in Computer Science?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCS" value="None" required <?php if(isset($vals['YearsCS']) && $vals['YearsCS'] == "None"){echo 'checked';} ?>>
                            None
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCS" value="Some, but less than 2 years" required <?php if(isset($vals['YearsCS']) && $vals['YearsCS'] == "Some, but less than 2 years"){echo 'checked';} ?>>
                            Some, but less than 2 years
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCS" value="Between 2 to 5 years" required <?php if(isset($vals['YearsCS']) && $vals['YearsCS'] == "Between 2 to 5 years"){echo 'checked';} ?>>
                            Between 2 to 5 years
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCS" value="Greater than 5 years" required <?php if(isset($vals['YearsCS']) && $vals['YearsCS'] == "Greater than 5 years"){echo 'checked';} ?>>
                            Greater than 5 years
                          </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('YearsCS')):?>
                          <span style="color:red;"><?= $validation->getError('YearsCS')?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="width: 30em; margin-top: 1em;">
                <h5 class="card-header">Question 11</h5>
                <div class="card-body">
                    <p class="card-text">If applicable, how many years have you spent working <br/>professionally in Computer Engineering?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCE" value="None" required <?php if(isset($vals['YearsCE']) && $vals['YearsCE'] == "None"){echo 'checked';} ?>>
                            None
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCE" value="Some, but less than 2 years" required <?php if(isset($vals['YearsCE']) && $vals['YearsCE'] == "Some, but less than 2 years"){echo 'checked';} ?>>
                            Some, but less than 2 years
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCE" value="Between 2 to 5 years" required <?php if(isset($vals['YearsCE']) && $vals['YearsCE'] == "Between 2 to 5 years"){echo 'checked';} ?>>
                            Between 2 to 5 years
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsCE" value="Greater than 5 years" required <?php if(isset($vals['YearsCE']) && $vals['YearsCE'] == "Greater than 5 years"){echo 'checked';} ?>>
                            Greater than 5 years
                          </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('YearsCE')):?>
                          <span style="color:red;"><?= $validation->getError('YearsCE')?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="width: 30em; margin-top: 1em;">
                <h5 class="card-header">Question 12</h5>
                <div class="card-body">
                    <p class="card-text">If applicable, how many years have you spent working <br/>professionally in Information Technology (IT)?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsIT" value="None" required <?php if(isset($vals['YearsIT']) && $vals['YearsIT'] == "None"){echo 'checked';} ?>>
                            None
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsIT" value="Some, but less than 2 years" required <?php if(isset($vals['YearsIT']) && $vals['YearsIT'] == "Some, but less than 2 years"){echo 'checked';} ?>>
                            Some, but less than 2 years
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsIT" value="Between 2 to 5 years" required <?php if(isset($vals['YearsIT']) && $vals['YearsIT'] == "Between 2 to 5 years"){echo 'checked';} ?>>
                            Between 2 to 5 years
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsIT" value="Greater than 5 years" required <?php if(isset($vals['YearsIT']) && $vals['YearsIT'] == "Greater than 5 years"){echo 'checked';} ?>>
                            Greater than 5 years
                          </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('YearsIT')):?>
                          <span style="color:red;"><?= $validation->getError('YearsIT')?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="width: 30em; margin-top: 1em;">
                <h5 class="card-header">Question 13</h5>
                <div class="card-body">
                    <p class="card-text">How many years of programming experience do you have?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsProg" value="None" required <?php if(isset($vals['YearsProg']) && $vals['YearsProg'] == "None"){echo 'checked';} ?>>
                            None
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsProg" value="Some, but less than 2 years" required <?php if(isset($vals['YearsProg']) && $vals['YearsProg'] == "Some, but less than 2 years"){echo 'checked';} ?>>
                            Some, but less than 2 years
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsProg" value="Between 2 to 5 years" required <?php if(isset($vals['YearsProg']) && $vals['YearsProg'] == "Between 2 to 5 years"){echo 'checked';} ?>>
                            Between 2 to 5 years
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="YearsProg" value="Greater than 5 years" required <?php if(isset($vals['YearsProg']) && $vals['YearsProg'] == "Greater than 5 years"){echo 'checked';} ?>>
                            Greater than 5 years
                          </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('YearsProg')):?>
                          <span style="color:red;"><?= $validation->getError('YearsProg')?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="width: 30em; margin-top: 1em;">
                <h5 class="card-header">Question 14</h5>
                <div class="card-body">
                    <p class="card-text">Have you ever specified a computer security policy <br/>(e.g., firewall rules, email spam filters)?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="SpecifiedPolicy" value="1" required <?php if(isset($vals['SpecifiedPolicy']) && $vals['SpecifiedPolicy'] == "1"){echo 'checked';} ?>>
                            Yes
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="SpecifiedPolicy" value="0" required <?php if(isset($vals['SpecifiedPolicy']) && $vals['SpecifiedPolicy'] == "0"){echo 'checked';} ?>>
                            No
                          </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('SpecifiedPolicy')):?>
                          <span style="color:red;"><?= $validation->getError('SpecifiedPolicy')?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" id="PoliciesWorkedWith" style="width: 30em; margin-top: 1em;">
                <h5 class="card-header">Question 15</h5>
                <div class="card-body">
                    <p class="card-text">If so, please briefly describe the types of policies you have worked with.</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <textarea class="form-control" name="PoliciesWorkedWith" rows="3" maxlength="200"><?php if(isset($vals['PoliciesWorkedWith'])){echo $vals['PoliciesWorkedWith'];} ?></textarea>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('PoliciesWorkedWith')):?>
                          <span style="color:red;"><?= $validation->getError('PoliciesWorkedWith')?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" id="SpecifiedPolicyRego" style="width: 30em; margin-top: 1em;margin-bottom: 2em;">
                <h5 class="card-header">Question 16</h5>
                <div class="card-body">
                    <p class="card-text">If so, have you ever specified a security policy with <br/>Rego, the specification language for Open Policy Agent?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="SpecifiedPolicyRego" value="1" <?php if(isset($vals['SpecifiedPolicyRego']) && $vals['SpecifiedPolicyRego'] == "1"){echo 'checked';} ?>>
                            Yes
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="SpecifiedPolicyRego" value="0" <?php if(isset($vals['SpecifiedPolicyRego']) && $vals['SpecifiedPolicyRego'] == "0"){echo 'checked';} ?>>
                            No
                          </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('SpecifiedPolicyRego')):?>
                          <span style="color:red;"><?= $validation->getError('SpecifiedPolicyRego')?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

        </form>
    </div>
<?= $this->endSection() ?>