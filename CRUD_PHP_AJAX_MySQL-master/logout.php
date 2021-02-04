<?php

require_once 'classes/User.php';

if(!User::isLoggedIn()){
    header("Location: index.php");

    exit;
}

User::logout();
header("Location: index.php");

exit;