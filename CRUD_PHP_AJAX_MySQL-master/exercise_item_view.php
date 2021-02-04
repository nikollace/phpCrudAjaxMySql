<?php
require_once 'classes/Exercise.php'; // Pozivanje fajla gde je Exercise

include_once 'header.php';
$coachId = $_SESSION['user']['id'];

$exercies = Exercise::getAll($coachId)
?>
<style>
    <?php include 'exercise.css'; ?>
</style>
<h1 class="food_h1">All exercises from <?php echo $_SESSION['user']['username']?></h1><br>
<div class="main">
    <?php
    foreach ($exercies as $exercise) {
        $title = $exercise['title'];
        $series = $exercise['series'];
        $iterance = $exercise['iterance'];
        $break_series = $exercise['break_series'];
        $description = $exercise['description'];
        $secret = $exercise['secret'];
        $id = $exercise['id'];
    ?>
    <div class="info" id="info"></div>
    <form method="POST" action="exercise_update.php">
        <div class="section">
            <h2 name="title"><?php echo $title ?></h2>
            <input type="hidden" name="title" value="<?=$title?>" />
            <input type="hidden" name="id" id="idd" value="<?=$id?>" />
            <div class="description">
                <h3>Description<h3>
                        <textarea rows="4" cols="50" name="description"><?php echo $description ?></textarea>
            </div>
            <div class="info">
                <h3>Exercise info<h3>
                        <div class="exercise_info">
                            <ul class="ul_exercise">
                                <li>Series: <?php echo $series ?></li>
                                <input type="hidden" name="series" value="<?=$series?>" />
                                <li>Iterance: <?php echo $iterance ?></li>
                                <input type="hidden" name="iterance" value="<?=$iterance?>" />
                                <li>Break between series: <?php echo $break_series ?></li>
                                <input type="hidden" name="breakseries" value="<?=$break_series?>" />
                                <li>SECRET: <?php echo $secret ?></li>
                                <input type="hidden" name="secret" value="<?=$secret?>" />
                            </ul>
                        </div>
            </div>
            <div class="buttons">
                <button id="edit" class="btn btn-success" type="submit" name="edit">Edit</button>
                <button id="showid" class="btn btn-warning" type="submit" name="showid">Show ID</button>
                <button id="delete" class="btn btn-danger" type="submit" name="delete">Delete</button>
            </div>
        </div>
    </form>
    <?php
    } // end the loop after using the values
    ?>
</div>
<?php include_once 'footer.php'; ?>