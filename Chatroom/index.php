<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
    <link rel="stylesheet" href="styles/body.css">
    <link rel="stylesheet" href="styles/authme.css">
    <link rel="stylesheet" href="styles/chatbox.css">
    <link rel="stylesheet" href="styles/helper.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src="scripts/script.js" defer></script>
    <!-- <script src="scripts/chatmain.js" defer></script> -->
    <!-- <script src="scripts/chatbox.js" defer></script> -->
</head>
<body id="statediv">
    <!-- INDEX PAGE -->
    <?php 
    if (isset($_SESSION['useruid'])) {
        $username = $_SESSION['useruid'];
        echo "<span style='position: absolute; top: 2%; color:greenyellow;'>$username <button id='logout'>LOGOUT</button></span>";
        include 'ajax/chatmain.php';
    } else {
        include 'ajax/authme.php';
    }
    ?>
</body>
</html>
