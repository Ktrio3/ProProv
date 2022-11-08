<?= $this->extend('default') ?>


<!-- Latest compiled and minified JavaScript -->

<?= $this->section('css') ?>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?= $this->endSection() ?>

<?= $this->section('js_head') ?>
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>

<?= $this->section('js_foot') ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            language = $('.searchable-select').select2();

            <?php if(!isset($vals['Gender']) || $vals['Gender'] != "other"): ?>
              $('input[type=text][name=Gender_other]').prop('disabled', true);
            <?php endif;?>

            <?php if(!isset($vals['Education']) || $vals['Education'] == "some_high" || $vals['Education'] == 'high'): ?>
              $('input[type=text][name=Major]').prop('disabled', true);
            <?php endif;?>


            <?php if(isset($vals['Language']) && $vals['Language'] != ""): ?>
              language.val(<?= "'" . $vals["Language"] . "'" ?>);
              language.trigger('change');
            <?php endif;?>
              

            $('input[type=radio][name=Gender]').change(function() {
                if (this.value == 'other') {
                    $('input[type=text][name=Gender_other]').prop('disabled', false);
                    $('input[type=text][name=Gender_other]').prop('required', true)
                }
                else {
                    $('input[type=text][name=Gender_other]').prop('disabled', true);
                    $('input[type=text][name=Gender_other]').prop('required', false)
                }
            });

            $('input[type=radio][name=Education]').change(function() {
                if (this.value != 'none' && this.value != 'some_high' && this.value != 'high') {
                    $('input[type=text][name=Major]').prop('disabled', false);
                    $('input[type=text][name=Major]').prop('required', true)
                }
                else {
                    $('input[type=text][name=Major]').prop('disabled', true);
                    $('input[type=text][name=Major]').prop('required', false) 
                }
            });
        });
    </script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container-fluid">
        <form class="row g-3" action="<?= base_url('demographics/1') ?>" id="content" method="post">
            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="min-width: 30em; margin-top: 1em;">
                <h5 class="card-header">Question 1</h5>
                <div class="card-body">
                    <p class="card-text">What is your gender?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Gender" value="male" required <?php if(isset($vals['Gender']) && $vals['Gender'] == "male"){echo 'checked';} ?>>
                            Male
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Gender" value="female" required <?php if(isset($vals['Gender']) && $vals['Gender'] == "female"){echo 'checked';} ?>>
                            Female
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Gender" value="transgender_female" required <?php if(isset($vals['Gender']) && $vals['Gender'] == "transgender_female"){echo 'checked';} ?>>
                            Transgender Female
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Gender" value="transgender_male" required <?php if(isset($vals['Gender']) && $vals['Gender'] == "transgender_male"){echo 'checked';} ?>>
                            Transgender Male
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Gender" value="no" required <?php if(isset($vals['Gender']) && $vals['Gender'] == "no"){echo 'checked';} ?>>
                            Prefer not to answer
                          </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="Gender" value="other" required <?php if(isset($vals['Gender']) && $vals['Gender'] == "other"){echo 'checked';} ?>>
                                Other: 
                                <div id="gender_other">
                                  <input class="form-control" name="Gender_other" type="text" maxlength="20" <?php if(isset($vals['Gender_other'])){echo 'value=' . $vals['Gender_other'];} ?>>
                                  <?php if(isset($validation) && $validation->hasError('Gender_other')): ?>
                                    <span style="color:red;"><?= $validation->getError('Gender_other') ?></span>
                                  <?php endif;?>
                                </div>
                            </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('Gender')):?>
                          <span style="color:red;"><?= $validation->getError('Gender')?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="min-width: 30em;">
                <h5 class="card-header">Question 2</h5>
                <div class="card-body">
                    <p class="card-text">What is your age?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-label">
                            <input class="form-control" type="number" name="Age" min="18" required <?php if(isset($vals['Age'])){echo 'value=' . $vals['Age'];} ?>>
                            <?php if(isset($validation) && $validation->hasError('Age')): ?>
                              <span style="color:red;"><?= $validation->getError('Age') ?></span>
                            <?php endif;?>
                          </label>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="min-width: 30em;">
                <h5 class="card-header">Question 3</h5>
                <div class="card-body">
                    <p class="card-text">What is your native language?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-label">
                            <select class="searchable-select" name="Language" required>
                              <?= $this->include('language') ?>
                            </select>
                            <?php if(isset($validation) && $validation->hasError('Language')): ?>
                              <br/><span style="color:red;"><?= $validation->getError('Language') ?></span>
                            <?php endif;?>
                          </label>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="min-width: 30em;">
                <h5 class="card-header">Question 4</h5>
                <div class="card-body">
                    <p class="card-text">On a scale from 1 to 5, how fluent are you in English?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Fluency" value="Beginner" required <?php if(isset($vals['Fluency']) && $vals['Fluency'] == "Beginner"){echo 'checked';} ?>>
                            1&mdash;Beginner
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Fluency" value="Intermediate" required <?php if(isset($vals['Fluency']) && $vals['Fluency'] == "Intermediate"){echo 'checked';} ?>>
                            2&mdash;Intermediate
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Fluency" value="Proficient" required <?php if(isset($vals['Fluency']) && $vals['Fluency'] == "Proficient"){echo 'checked';} ?>>
                            3&mdash;Proficient
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Fluency" value="Fluent" required <?php if(isset($vals['Fluency']) && $vals['Fluency'] == "Fluent"){echo 'checked';} ?>>
                            4&mdash;Fluent
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Fluency" value="Native" required <?php if(isset($vals['Fluency']) && $vals['Fluency'] == "Native"){echo 'checked';} ?>>
                            5&mdash;Native or Bilingual
                          </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('Fluency')): ?>
                          <span style="color:red;"><?= $validation->getError('Fluency') ?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="min-width: 30em;">
                <h5 class="card-header">Question 5</h5>
                <div class="card-body">
                    <p class="card-text">What is the highest degree or level of school you have <br/>completed?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Education" value="none" required <?php if(isset($vals['Education']) && $vals['Education'] == "none"){echo 'checked';} ?>>
                            No schooling or only below high school
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Education" value="some_high" required <?php if(isset($vals['Education']) && $vals['Education'] == "some_high"){echo 'checked';} ?>>
                            Some high school
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Education" value="high" required <?php if(isset($vals['Education']) && $vals['Education'] == "high"){echo 'checked';} ?>>
                            High school diploma or equivalent
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Education" value="some_college" required <?php if(isset($vals['Education']) && $vals['Education'] == "some_college"){echo 'checked';} ?>>
                            Some college credit
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Education" value="assoc" required <?php if(isset($vals['Education']) && $vals['Education'] == "assoc"){echo 'checked';} ?>>
                            Associates Degree
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Education" value="bach" required <?php if(isset($vals['Education']) && $vals['Education'] == "bach"){echo 'checked';} ?>>
                            Bachelor's Degree
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Education" value="master" required <?php if(isset($vals['Education']) && $vals['Education'] == "master"){echo 'checked';} ?>>
                            Master's Degree
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Education" value="prof" required <?php if(isset($vals['Education']) && $vals['Education'] == "prof"){echo 'checked';} ?>>
                            Professional degree
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Education" value="doc" required <?php if(isset($vals['Education']) && $vals['Education'] == "doc"){echo 'checked';} ?>>
                            Doctorate degree
                          </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('Education')): ?>
                          <span style="color:red;"><?= $validation->getError('Education') ?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center" >
              <div class="card align-self-center"  id="major" style="min-width: 30em;">
                <h5 class="card-header">Question 6</h5>
                <div class="card-body">
                    <p class="card-text">If you attended or are currently attending college, <br/>what was/is your major?</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-label">
                            <input class="form-control" type="text" name="Major" maxlength="20" <?php if(isset($vals['Major'])){echo 'value=' . $vals['Major'];} ?>>
                            <?php if(isset($validation) && $validation->hasError('Major')): ?>
                              <span style="color:red;"><?= $validation->getError('Major') ?></span>
                            <?php endif;?>
                          </label>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="min-width: 30em;">
                <h5 class="card-header">Question 7</h5>
                <div class="card-body">
                    <p class="card-text">Please check the most appropriate category.</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Ethnicity" value="Hispanic or Latino" required <?php if(isset($vals['Ethnicity']) && $vals['Ethnicity'] == "Hispanic or Latino"){echo 'checked';} ?>>
                            Hispanic or Latino
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="Ethnicity" value="Not Hispanic or Latino" required <?php if(isset($vals['Ethnicity']) && $vals['Ethnicity'] == "Not Hispanic or Latino"){echo 'checked';} ?>>
                            Not Hispanic or Latino
                          </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('Ethnicity')):?>
                          <span style="color:red;"><?= $validation->getError('Ethnicity')?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-center align-items-center">
              <div class="card align-self-center" style="min-width: 30em;margin-bottom: 2em;">
                <h5 class="card-header">Question 8</h5>
                <div class="card-body">
                    <p class="card-text">Please check the most appropriate categories.</p>
                    <div class="col-auto">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="Race[]" value="American Indian or Alaskan Native" <?php if(isset($vals['Race']) && in_array("American Indian or Alaskan Native", $vals['Race'])){echo 'checked';} ?>>
                            American Indian or Alaskan Native
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="Race[]" value="Asian" <?php if(isset($vals['Race']) && in_array("Asian", $vals['Race'])){echo 'checked';} ?>>
                            Asian
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="Race[]" value="Black or African American" <?php if(isset($vals['Race']) && in_array("Black or African American", $vals['Race'])){echo 'checked';} ?>>
                            Black or African American
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="Race[]" value="Native Hawaiian or Other Pacific Islander" <?php if(isset($vals['Race']) && in_array("Native Hawaiian or Other Pacific Islander", $vals['Race'])){echo 'checked';} ?>>
                            Native Hawaiian or Other Pacific Islander
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="Race[]" value="White" <?php if(isset($vals['Race']) && in_array("White", $vals['Race'])){echo 'checked';} ?>>
                            White
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="Race[]" value="no" <?php if(isset($vals['Race']) && in_array("no", $vals['Race'])){echo 'checked';} ?>>
                            Prefer not to answer
                          </label>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('Race')):?>
                          <span style="color:red;"><?= $validation->getError('Race')?></span>
                        <?php endif;?>
                    </div>
                </div>
              </div>
            </div>

        </form>
    </div>
<?= $this->endSection() ?>