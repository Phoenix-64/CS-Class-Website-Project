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
    $current = mysqli_fetch_assoc(mysqli_query($conn , "SELECT `requests` FROM user WHERE user.user_id='$requested_user'"))['requests'];
    echo($current);
    $new_requests = $current . ";" . $active_user . ":" . $N_public;
    // Update users requests
    $update = mysqli_query(
      $conn,
      "UPDATE `user` SET `requests`= '$new_requests' WHERE `user_id`='$requested_user'" 
    );
  }
?>
