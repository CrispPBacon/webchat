<?php

if ($_POST['request'] == 'login' && isset($_POST['request'])) {
    session_start();
    require_once 'functions.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = uidExists($conn, $username);
    $uidMatch = 0;
    if ($result) { 
        $uidMatch = $username == $result['usersUid']; 
        $pwdMatch = $password == $result['usersPwd'];
        if (!$pwdMatch) {
            echo '!pwdMatch';
            exit();
        }
    };
    
    if (!$result || !$uidMatch) {
        echo '!Uidfound';
        exit();
    }

    $logged = loginUser($conn, $username, $password);
    if (!$logged) {
        echo $logged;
        exit();
    }

    

} else {
    header("Location: ../../ ");
    exit();
}