<?php
session_start();
// Include the config file
require_once 'config.php';
// Check if the chat form was submitted
if (isset($_POST['activ_user'])) {
    $active_user    = $_POST['activ_user'];
    $requested_user = $_POST['requested_user'];
    $N_public       = $_POST['N_public'];
    // Get current requests and append new one
    $stmt = $db->prepare("SELECT requests FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $requested_user);
    $stmt->execute();
    $result  = $stmt->get_result();
    $row     = $result->fetch_assoc();
    $current = $row['requests'];
    $new_requests = $current.";".$active_user.":".$N_public;
    // Update users requests
    $stmt = $conn->prepare("UPDATE user SET requests=? WHERE user_id=?");
    $stmt->bind_param("si", $new_requests, $requested_user);
    $stmt->execute();
}//end if
