<?php

require_once 'functions.php';
require_once 'classes/Exercise.php';

if (isset($_POST['add_exercise'])) {
  $exercise_title_add = clean($_POST['title']);
  $exercise_description_add = clean($_POST['description']);
  $exercise_series_add = clean($_POST['series']);
  $exercise_iterance_add = clean($_POST['iterance']);
  $exercise_break_series_add = clean($_POST['breakseries']);
  $exercise_secret_add = clean($_POST['secret']);

  $errors = array();

  if (empty($exercise_title_add)) {
    $errors['title'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter Title.</label></p>';
  }

  if (empty($exercise_description_add)) {
    $errors['description'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter Description.</label></p>';
  }

  if (empty($exercise_series_add)) {
    $errors['series'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter number of Series.</label></p>';
  }

  if (empty($exercise_iterance_add)) {
    $errors['iterance'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter Iterance.</label></p>';
  }

  if (empty($exercise_break_series_add)) {
    $errors['breakseries'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter break between series.</label></p>';
  }

  if (count($errors) == 0) {
    $data = array(
      "exercise_title_add" => $exercise_title_add,
      "exercise_description_add" => $exercise_description_add,
      "exercise_series_add" => $exercise_series_add,
      "exercise_iterance_add" => $exercise_iterance_add,
      "exercise_break_series_add" => $exercise_break_series_add,
      "exercise_secret_add" => $exercise_secret_add,
      "exercise_coach_id_add" => $_SESSION['user']['id'],
    );

    if (Exercise::takenTitle($exercise_title_add)) {
      $errors['taken_title'] = '<div class="alert alert-dismissible alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      Title already in use.
    </div>';
    } else if (Exercise::add($data)) {
      $_SESSION['add_success_message'] = "Successfully added new exercise";
      header("Location: exercise_item_view.php");

      exit;
    }
  } // COUNT errors CLOSE
} // POST REQ CLOSE
?>

<?php include 'header.php'; ?>

<style>
  <?php include 'exercise.css'; ?>
</style>

<!-- -------- VEZBA ---------- -->
<section id="vezba">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-sm-8 col-8">
        <h1 class="mt-5">Add exercise</h1>

        <?php echo $errors['taken_title'] ?? ""; ?>
        <?php echo $_SESSION['add_success_message'] ?? ""; ?>

        <form method="POST" class="mb-5" id="user_form">
          <fieldset>

            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="<?php echo $exercise_title_add ?? ""; ?>">
              <?php echo $errors['title'] ?? ""; ?>
            </div>

            <div class="form-group">
              <label for="series">Series</label>
              <input type="number" name="series" class="form-control" id="series" placeholder="Enter number of series" value="<?php echo $exercise_series_add ?? ""; ?>">
              <?php echo $errors['series'] ?? ""; ?>
            </div>

            <div class="form-group">
              <label for="iterance">Iterance</label>
              <input type="number" name="iterance" class="form-control" id="iterance" placeholder="Enter number of iterance" value="<?php echo $exercise_iterance_add ?? ""; ?>">
              <?php echo $errors['iterance'] ?? ""; ?>
            </div>

            <div class="form-group">
              <label for="breakseries">Break between series</label>
              <input type="number" name="breakseries" class="form-control" id="iterance" placeholder="Enter number of iterance" value="<?php echo $exercise_break_series_add ?? ""; ?>">
              <?php echo $errors['breakseries'] ?? ""; ?>
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea name="description" class="form-control" id="description" placeholder="Add description" value="<?php echo $exercise_description_add ?? ""; ?>"></textarea>
              <?php echo $errors['description'] ?? ""; ?>
            </div>

            <div class="secret" id="secret"></div>

            <button id="exercise-add-btn" type="submit" name="add_exercise" class="btn btn-success d-block w-100">Add Exercise</button>
            <button id="secret-add-btn" type="submit" class="btn btn-warning d-block w-100">Show secret</button>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>