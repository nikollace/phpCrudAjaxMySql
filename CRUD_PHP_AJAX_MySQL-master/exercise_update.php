<?php
require_once 'classes/Exercise.php'; // Pozivanje fajla gde je Exercise

include_once 'header.php';
$exercise = new Exercise();

if (isset($_POST['edit'])) {
    $exercise_title = $_POST['title'];
    $exercise_description = $_POST['description'];
    $exercise_series = $_POST['series'];
    $exercise_iterance = $_POST['iterance'];
    $exercise_break_series = $_POST['breakseries'];
    $exercise_id = $_POST['id'];
}

if (isset($_POST['update'])) {
    $exercise_title_update = $_POST['title'];
    $exercise_description_update = $_POST['description'];
    $exercise_series_update = $_POST['series'];
    $exercise_iterance_update = $_POST['iterance'];
    $exercise_break_series_update = $_POST['breakseries'];

    $errors = array();

    if (empty($exercise_title_update)) {
        $errors['title'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter Title.</label></p>';
    }

    if (empty($exercise_description_update)) {
        $errors['description'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter Description.</label></p>';
    }

    if (empty($exercise_series_update)) {
        $errors['series'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter number of Series.</label></p>';
    }

    if (empty($exercise_iterance_update)) {
        $errors['iterance'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter Iterance.</label></p>';
    }

    if (empty($exercise_break_series_update)) {
        $errors['breakseries'] = '<p><label class="text-danger font-weight-bold text-uppercase">Please Enter break between series.</label></p>';
    }

    if (count($errors) == 0) {
        $data = array(
            "exercise_title_update" => $exercise_title_update,
            "exercise_description_update" => $exercise_description_update,
            "exercise_series_update" => $exercise_series_update,
            "exercise_iterance_update" => $exercise_iterance_update,
            "exercise_break_series_update" => $exercise_break_series_update,
        );
    }

    if (Exercise::update($data, $_POST['id'])) {
        $_SESSION['update_success_message'] = "Successfully updated exercise";
        header("Location: exercise_item_view.php");

        exit;
    }
}
if (isset($_POST['delete'])) {
    if (Exercise::delete($_POST['id'])) {
        $_SESSION['delete_success_message'] = "Successfully deleted exercise";
        header("Location: exercise_item_view.php");

        exit;
    }
 }

// COUNT errors CLOSE
// POST REQ CLOSE
?>
<?php include_once 'header.php'; ?>

<style>
    <?php include 'exercise.css'; ?>
</style>

<section id="prijave">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8 col-8">
                <h1 class="mt-5">Update exercise</h1>

                <?php echo $_SESSION['update_success_message'] ?? ""; ?>
                <?php echo $_SESSION['delete_success_message'] ?? ""; ?>

                <form method="POST" class="mb-5">
                    <fieldset>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" value="<?php echo $exercise_title ?? ""; ?>">
                            <input type="hidden" name="id" value="<?= $exercise_id ?>" />
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description"><?php echo $exercise_description ?? ""; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="series">Series</label>
                            <input type="number" name="series" class="form-control" id="series" value="<?php echo $exercise_series ?? ""; ?>">
                        </div>

                        <div class="form-group">
                            <label for="iterance">Iterance</label>
                            <input type="number" name="iterance" class="form-control" id="iterance" value="<?php echo $exercise_iterance ?? ""; ?>">
                        </div>

                        <div class="form-group">
                            <label for="breakseries">Break between series</label>
                            <input type="number" name="breakseries" class="form-control" id="breakseries" value="<?php echo $exercise_break_series ?? ""; ?>">
                        </div>

                        <button id="update-btn" type="submit" name="update" class="btn btn-success d-block w-100">Update</button>
                        <button id="discard-btn" type="submit" class="btn btn-danger d-block w-100">Discard</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include_once 'footer.php'; ?>