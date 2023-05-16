<?php
session_start();
require_once 'config.php';
$result = mysqli_query($conn, "SELECT * FROM user");

$active_user = $_POST["activ_user"];

$stmt = $db->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("i", $active_user);
$stmt->execute();
$result_current = $stmt->get_result();
$current_user   = $result_current->fetch_assoc();


$active_chat = $current_user['active_chat'];
// Fetch availabel chats and requests that other users made to the active ones
$availabel_chats     = explode(";", $current_user['availabel_chats']);
$requests_for_active = $current_user['requests'];

// If array is NULL initialize to [];
if ($availabel_chats == null) {
    $availabel_chats = [];
}

while ($row = mysqli_fetch_assoc($result)) {
    $user_id  = $row['user_id'];
    $requests = $row['requests'];
    // skip if active user
    if ($active_user == $user_id) {
        continue;
    }

    if (str_contains($_POST["already_fetched"], $row['user_name'])) {
        continue;
    }

    echo("::".$user_id.";".$row['user_name']);

    if (in_array($user_id, $availabel_chats)) {
        // Check if user is Online and the one with the active chat
        if ($row['user_status'] == 1 && $user_id == $active_chat) {
            echo ";1";
        }
        // Chek if user is Online and not the one with the active chat
        else if ($row['user_status'] == 1 && $user_id != $active_chat) {
            echo ";2";
        }
        // Check if offline user is the one with the active chat
        else if ($user_id == $active_chat) {
            echo ";3";
        }
        // Remaining offline non active
        else {
            echo ";4";
        }
    }//end if
    // If there is already a request dont show reauest button
    else if (str_contains($requests, ";".$active_user)) {
        // Check if user is Online
        if ($row['user_status'] == 1) {
            echo ";5";
        }
        // Remaining offline
        else {
            echo ";6";
        }
    }
    // If the current user has a request from this id display butons
    else if (str_contains($requests_for_active, ";".$user_id)) {
        // Check if user is Online
        if ($row['user_status'] == 1) {
            echo ";7";
        }
        // Remaining offline
        else {
            echo ";8";
        }
    } else {
        // Check if user is Online
        if ($row['user_status'] == 1) {
            echo ";9";
        }
        // Remaining offline
        else {
            echo ";10";
        }
    }
}//end while
