<?= $this->extend('default') ?>

<?= $this->section('header') ?>
    <?= $this->include('header') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <div class="container-fluid">
        <div class="bg-light p-5 rounded-lg">
          <?php if($user['rego_first'] == "1"):?>
            <h1 class="display-4">Step 5: Policy Exercise</h1>
          <?php else:?>
            <h1 class="display-4">Step 3: Policy Exercise</h1>
          <?php endif;?>
          <hr class="my-4">
          <p>In this section, you will use the Proprov tool introduced in the last step to write a few provenance policies. Please attempt every problem at least once. If you are unable to solve the problem, after 2.5 minutes you will be allowed to move to the next question.</p>
          <hr class="my-4">
          <h3>Experiment Scenario</h3>
          <?php if($user['rego_first'] == 1):?>
            <p>
              The scenario is the same as before, where you and the USF registrar are securely computing a list of USF students who attended a career fair.
            </p>
          <?php else:?>
            <p>
              Imagine you work for an organization that hosts a career fair at the University of South Florida (USF). Students from USF and all surrounding universities can attend the career fair. You will attend as a recruiter for your organization.
            </p>
            <p>
              For admission to the career fair, students must provide their names and phone numbers. At the conclusion of the event, you are impressed by the USF students and would like to invite only the USF students back to an exclusive hiring event. However, because you only have names and phone numbers for students, you have no way of distinguishing between USF and non-USF students. 
            </p>
            <p>
              You then contact USF’s registrar for a list of USF students, in order to filter out the non-USF students from your list. The registrar, however, does not want to provide this list because it would contain information you are not authorized to access, such as the names of students who did not attend the career fair. 
            </p>
            <p>
              To securely filter out the non-USF students from your list, you and the registrar agree to employ a secure computation to perform filtering. After the computation is completed, you would like to ensure that the results were generated as expected. You will write 7 policies to make this determination.
            </p>
          <?php endif;?>
          <a href="<?= base_url("proprov/1") ?>" class="btn btn-primary btn-lg">Begin</a>
        </div>
    </div> 
<?= $this->endSection() ?>