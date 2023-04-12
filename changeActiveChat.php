<?php
  // Start a new session
  session_start();

  // Include the config file
  include_once('config.php');

  // Check if the chat form was submitted
  if (isset($_POST['activ_user'])) {
    $active_user = $_POST['activ_user'];
    $active_chat = $_POST['active_chat'];
    // Insert the new chat message into the database
    $result = mysqli_query(
      $conn,
      "UPDATE `user` SET `active_chat`= $active_chat WHERE `user_id`='$active_user'" 
    );
  }
?>
