<?php
require_once '../functions.php';
function fetch_friends_information($conn, $userid, $getMessages) {
    $friends_information = array();
    $details = array();
    $nodups = array();

    while ($row = mysqli_fetch_assoc($getMessages)) {
        $friend_id = $userid == $row['from_id'] ? $row['to_id'] : $row['from_id'];
        $getFriendName = getResult('SELECT * FROM `users` WHERE usersId = ?', $conn, $friend_id);
        $friendUid = mysqli_fetch_assoc($getFriendName)['usersUid'];
        $message = $row['message'];
        $message_status = $row['message_status_read'];
        $sender_id = $row['from_id'];
        $message_date = $row['date'];
        
        //remove dups
        if (!in_array($friendUid, $nodups)) {
            $nodups[] = $friendUid;
            $details['friendId'] = $friend_id;
            $details['friendUid'] = $friendUid;
            $details['message'] = $message;
            $details['message_status'] = $message_status;
            $details['sender_id'] = $sender_id;
            $details['date'] = $message_date;
            if (!empty($message)) {
                if (strlen($message) > 34)
                $details['message'] = substr($message, 0, 35) . '...';
            }
            $friends_information[] = $details;
            
        }       
    }
    return $friends_information;
}