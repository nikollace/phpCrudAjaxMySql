<?php
require_once 'classes/User.php'; // Pozivanje fajla gde je User
require_once 'classes/Exercise.php'; // Pozivanje fajla gde je Exercise

if ($_POST['type'] == 1) {

    $secret = User::getSecret($_SESSION['user']['id']);

    $output = '<label>Secret</label>
                <input type="text" name="secret" class="form-control" 
                id="secretq" value="' . $secret['secret'] . '">';

    echo $output;
}

if ($_POST['type'] == 2) {
        $output = '<p><label class="text-success font-weight-bold text-uppercase">
        Exercise ID: '. $_POST['id'].'.</label></p>';
        echo $output;
}