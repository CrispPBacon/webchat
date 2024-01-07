<?php
require_once 'db.php';

function prepareStmt($sql, $conn) {
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../index.php?stmtError=preparation_failed');
        exit();
    }
    
    return $stmt;
}

function insertSql($sql, $conn, ...$variables) {
    $stmt = prepareStmt($sql, $conn);
    $params = array(&$stmt);
    $types = str_repeat('s', count($variables));
    $params[] = &$types;

    foreach ($variables as &$var) {
        $params[] = &$var;
    }

    call_user_func_array('mysqli_stmt_bind_param', $params);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getResult($sql, $conn, ...$variables) {
    $stmt = prepareStmt($sql, $conn);
    $params = array(&$stmt);
    $types = str_repeat('s', count($variables));
    $params[] = &$types;
    foreach ($variables as &$var) {
        $params[] = &$var;
    }
    
    call_user_func_array('mysqli_stmt_bind_param', $params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

// function createUser($conn, $name, $uid, $pwd) {
//     // $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
//     $sql = "INSERT INTO users(usersName, usersUid, usersPwd) VALUES(?, ?, ?)";
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header('location: ../index.php?stmtfailed');
//         exit();
//     }
    
//     mysqli_stmt_bind_param($stmt, "sss", $name, $uid, $pwd);
//     mysqli_stmt_execute($stmt);
    
//     loginUser($conn, $uid, $pwd);

//     header('location: ../index.php?error=none');
//     exit();
// }

// function invalidUid($uid) {
//     if(!preg_match("/^[a-zA-Z0-9]*$/", $uid)) {
//         return true;
//     } else {
//         return false;
//     }
// }

// function pwdNotMatch($password, $confirmpassword) {
//     $verifyPasswordMatch = $password == $confirmpassword;
//     if (!$verifyPasswordMatch) {
//         return true;
//     } else {
//         return false;
//     }
// }

// function isEmpty($name, $uid, $pwd, $ConfirmPwd) {
//     if (empty($name)) {
//         return 'Name';
//     }
//     if (empty($uid)) {
//         return 'Username';
//     }
//     if (empty($pwd)) {
//         return 'Passowrd';
//     }
//     if (empty($ConfirmPwd)) {
//         return 'RepeatPassword';
//     }
//     return false;
// }

// function emptyInput($uid, $pwd) {

//     if (empty($uid) && empty($pwd)) {
//         return "emptyInputs";
//     }

//     elseif (empty($uid)) {
//         return "emptyUsername";
//     }

//     elseif (empty($pwd)) {
//         return "emptyPassword";
//     }

//     return false;
// }

// function isFriends($result) {
//     if (mysqli_num_rows($result) > 0) {
//         $row = mysqli_fetch_assoc($result);
//         $friends = $row['status'] == 'FRIENDS';
//         if (!$friends) {
//             return false;
//         } else { return false; }
//     } else {
//         return true;
//     }
// }

// function getResult($sql, $conn, ...$variables) {
//     $stmt = prepareStmt($sql, $conn);
//     $params = array($stmt);
//     $params[] = str_repeat('s', count($variables));
//     foreach ($variables as $var) {
//         $params[] = $var;
//     }
    
//     call_user_func_array('mysqli_stmt_bind_param', $params);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);
//     return $result;
// }

// function insertSql($sql, $conn, ...$variables) {
//     $stmt = prepareStmt($sql, $conn);
//     $params = array(&$stmt);
//     $types = str_repeat('s', count($variables));
//     $params[] = &$types;

//     foreach ($variables as &$var) {
//         $params[] = &$var;
//     }

//     call_user_func_array('mysqli_stmt_bind_param', $params);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_close($stmt);
// }

// function prepareStmt($sql, $conn) {
//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header('location: ../index.php?stmtError=preparation_failed');
//         exit();
//     }
    
//     return $stmt;
// }

// function UidExist($conn, $uid) {
//     $sql = "SELECT * FROM `users` WHERE `usersUid` = ?";
//     $stmt = prepareStmt($sql, $conn);
    
//     mysqli_stmt_bind_param($stmt, "s", $uid);
//     mysqli_stmt_execute($stmt);

//     $resultData = mysqli_stmt_get_result($stmt);
    
//     if ($result = mysqli_fetch_assoc($resultData)) {
//         return $result;
//     } else {
//         return false;
//     }
//     mysqli_stmt_close($stmt);
// }

// function loginUser($conn, $uid, $pwd) {
//     $result = UidExist($conn, $uid);
//     if (!$result) {
//         header('location: ../index.php?error=UserNotFound');
//         exit();
//     }

//     $HashedPwd = $result['usersPwd'];
//     $PwdMatch = password_verify($pwd, $HashedPwd);
//     $PwdMatch = $pwd == $result['usersPwd'];

//     if ($PwdMatch) {
//         session_start();
//         $_SESSION['userid'] = $result['usersId'];
//         $_SESSION['useruid'] = $result['usersUid'];
//         header('location: ../');  
//         exit();
//     } else {
//         header('location: ../index.php?error=PwdNotMatch');
//         exit();
//     }
// }

// function getMessage($stmt, $userID, $friends_id) {
//     mysqli_stmt_bind_param($stmt, 'ii', $userID, $friends_id);
//     mysqli_stmt_execute($stmt);
//     return $stmt;
// }