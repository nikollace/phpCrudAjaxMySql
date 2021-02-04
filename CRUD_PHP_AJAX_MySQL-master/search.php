<?php 
require_once 'classes/Exercise.php'; // Pozivanje fajla gde je Exercise

if(isset($_POST['search'])){
    $search_value = $_POST['ripper'];
    $coach_id = $_SESSION['user']['id'];
    $values = (Exercise::search($search_value, $coach_id));
}
?>

<style>
    <?php include 'exercise.css'; ?>
</style>
<?php include_once 'header.php'; ?>
<h1 class="food_h1">Trazene vezbe</h1><br>
<div class="main">
    <?php
    foreach ($values as $value) {
        $title = $value['title'];
        $series = $value['series'];
        $iterance = $value['iterance'];
        $break_series = $value['break_series'];
        $description = $value['description'];
        $id = $value['id'];
    ?>
    <form method="POST" action="exercise_update.php">
        <div class="section">
            <h1 name="title"><?php echo $title ?></h1>
            <input type="hidden" name="title" value="<?=$title?>" />
            <input type="hidden" name="id" value="<?=$id?>" />
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
                            </ul>
                        </div>
            </div>
            <div class="buttons">
                <button id="first" class="btn btn-success" type="submit" name="edit">Edit</button>
                <button id="second" class="btn btn-danger" type="submit" name="delete">Delete</button>
            </div>
        </div>
    </form>
    <?php
    } // end the loop after using the values
    ?>
</div>