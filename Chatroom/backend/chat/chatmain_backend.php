<?php

if (isset($_POST['request'])) {
    require_once 'functions.php';
    session_start();
    $request = $_POST['request'];
    
    if ($request == 'fetch_chatlist_history') {
        $userid = $_SESSION['userid'];
        $getMessages = getResult('SELECT * FROM `messages` WHERE from_id = ? or to_id = ? ORDER BY message_id DESC', $conn, $userid, $userid);   
        echo json_encode(array(
            'friends_info' => fetch_friends_information($conn, $userid, $getMessages),
            'userid' => $userid,
            ));
        exit();
    }

    if ($request == 'set_read_status') {
        $userid = $_SESSION['userid'];
        $friend_id = $_POST['friend_id'];
        insertSql("UPDATE `messages` SET `message_status_read`= 'READ' WHERE from_id = ? AND to_id = ? or to_id = ? AND from_id = ?",$conn,$userid,$friend_id,$userid,$friend_id);
        exit();
    }

    if ($request == 'fetch_chatbox_details') {
        $friend_id = $_POST['friend_id'];
        $getDetails = getResult('SELECT * FROM `users` WHERE usersId = ?', $conn, $friend_id);
        $row = mysqli_fetch_assoc($getDetails);
        echo json_encode($row);
        exit();
    }

    if ($request == 'get_search_profiles') {
        $search_data = $_POST['search_data'];
        $result = getResult("SELECT * FROM `users` WHERE usersUid LIKE CONCAT('%', ?, '%')", $conn, $search_data);
        $searches = array();
        $details = array();
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $details['friendUid'] = $row['usersUid'];
                $details['friendId'] = $row['usersId'];
                $searches[] = $details;
            }
            echo json_encode($searches);
        }
        exit();
    }
    exit();
} else {
    header('location: ../../');
    exit();
}
