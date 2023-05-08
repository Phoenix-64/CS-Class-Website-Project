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
    $stmt = $db->prepare("UPDATE user SET active_chat=? WHERE user_id=?");
    $stmt->bind_param("si", $active_chat, $active_user);
    $stmt->execute();
  }
?>
