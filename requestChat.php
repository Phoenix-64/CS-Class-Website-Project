<?php
  // Start a new session
  session_start();

  // Include the config file
  include_once('config.php');
echo("Request_started");
  // Check if the chat form was submitted
  if (isset($_POST['activ_user'])) {
    echo("If_passed");
    $active_user = $_POST['activ_user'];
    $requested_user = $_POST['requested_user'];
    $N_public = $_POST['N_public'];
    //Get current requests and append new one

    $stmt = $db->prepare("SELECT requests FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $requested_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $current = $row['requests'];

    echo($current);
    $new_requests = $current . ";" . $active_user . ":" . $N_public;
    // Update users requests
    $update = mysqli_query(
      $conn,
      "UPDATE `user` SET `requests`= '$new_requests' WHERE `user_id`='$requested_user'" 
    );
    $stmt= $conn->prepare("UPDATE user SET requests=? WHERE user_id=?");
    $stmt->bind_param("si", $new_requests, $requested_user);
    $stmt->execute();
  }
?>
