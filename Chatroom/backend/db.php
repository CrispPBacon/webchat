<?php

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPass = '';
$dbName = 'userdata';

$conn = mysqli_connect($dbHost, $dbUsername, $dbPass, $dbName);

if (!$conn) {
    echo "CONN FAILED";
    die('Connection Failed: ' . mysqli_connect_error());
}

$tables = ["users", "messages", "friends"];

if (isset($create)) {
    echo "YES";
}

foreach ($tables as $table) {
    $query = "SHOW TABLES LIKE '$table'";
    $result = $conn->query($query);

    if (!$result->num_rows > 0) {
        if ($table == "users") {
            $create = "CREATE TABLE users (
                usersId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
                usersName varchar(128) NOT NULL,
                usersUid varchar(128) NOT NULL,
                usersPwd varchar(128) NOT NULL
            )";
        }

        if ($table == "messages") {
            $create = "CREATE TABLE messages (
                message_id  int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
                message varchar(256) NOT NULL,
                from_id int(11) NOT NULL,
                to_id int(11) NOT NULL,
                `date` datetime,
                message_status_read varchar(16)
            )";
        }

        if ($table == "friends") {
            $create = "CREATE TABLE friends (
                friends_id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
                person_id1 int(11) NOT NULL,
                person_id2 int(11) NOT NULL,
                `status` varchar(8) NOT NULL
            )";
        }
    }

    if (isset($create)) {
        echo "$table successfully created!"; 
        $result = $conn->query($create);
        if (!$result) {
            echo "Error creating table: " . $conn->error;
        } 
    }
}