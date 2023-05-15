<?php
  // Start a new session
  session_start();

  // Include the config file
  require_once 'config.php';

  // Check if the chat form was submitted
if (isset($_POST['activ_user_name'])) {
    $active_user_name = $_POST['activ_user_name'];
    $N = $_POST['N_public'];
    // Insert the new chat message into the database
    $stmt = $conn->prepare("UPDATE user SET N_public=? WHERE user_name=?");
    $stmt->bind_param("ss", $N, $active_user_name);
    $stmt->execute();
}
