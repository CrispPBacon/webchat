<?php

if (isset($_POST['request'])) {
    require_once 'functions.php';
    session_start();
    $userid = $_SESSION['userid'];
    $request = $_POST['request'];

    if ($request == 'fetch_chats_content') {
        $friend_id = $_POST['friend_id'];
        $warpper = array();
        
        $result = getResult('SELECT * FROM `messages` WHERE `from_id` = ? and `to_id` = ? or `to_id` = ? and `from_id` = ? ORDER BY message_id DESC', $conn, $friend_id, $userid, $friend_id, $userid);
        $currentRow = mysqli_num_rows($result);
        $lastRow = $_POST['lastRow'];
        if ($currentRow > $lastRow) {
            while($row = mysqli_fetch_assoc($result)) {
                $details = array();
                $details['from_id'] = $row['from_id'];
                $details['to_id'] = $row['to_id'];
                $details['message'] = $row['message'];
                $wrapper[] = $details;   
            }
    
            echo json_encode(array(
                'details' => $wrapper,
                'currentRow' => $currentRow,
                'userid' => $_SESSION['userid']
            ));
            
        }
        
        if ($currentRow == 0) {
            echo 'Empty';
        }
        exit();
    }

    if ($request == 'send_message') {
        $friend_id = $_POST['friend_id'];
        $message = $_POST['message'];
        insertSql("INSERT INTO `messages`(`message`, `from_id`, `to_id`, `message_status_read`, `date`) VALUES (?, ?, ?, 'UNREAD', NOW())", $conn, $message, $userid, $friend_id);
        exit();
    }

} else {
    header('location: ../../');
    exit();
}