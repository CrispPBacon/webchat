<?php

if (isset($_POST['request'])) {
    session_start();
    session_unset();
    session_destroy();
    header('location: ../../');;
    exit();
} else {
    header('location: ../../');
    exit();
}