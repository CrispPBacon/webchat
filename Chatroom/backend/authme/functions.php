<?php
use function PHPSTORM_META\type;
require_once '../functions.php';
function uidExists($conn, $uid) {
    $result = getResult('SELECT * FROM `users` WHERE usersUid = ?', $conn, $uid);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else { return false; }
}

function loginUser($conn, $uid, $pwd) {
    $result = uidExists($conn, $uid);

    if (!$result) {
        header('location: ../index.php?error=UserNotFound');
        exit();
    }

    $HashedPwd = $result['usersPwd'];
    $PwdMatch = password_verify($pwd, $HashedPwd);
    $PwdMatch = $pwd == $result['usersPwd'];

    if ($PwdMatch) {
        // session_start();
        $_SESSION['userid'] = $result['usersId'];
        $_SESSION['useruid'] = $result['usersUid'];
        return true; // Indicate successful login
    } else {
        return 'Password not match!';
    }
}