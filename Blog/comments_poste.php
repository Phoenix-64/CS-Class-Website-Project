<?php
  // Start a new session
  session_start();

  // Include the config file
  include_once(dirname(__FILE__)."/../config.php");



  // Check if the chat form was submitted
  if (isset($_POST['chat'])) {
    $poste_name = $_POST["poste_name"];
    // Insert the new chat message into the database
    $result = mysqli_query(
        $conn,
        "INSERT INTO `$_POST[poste_name]` (`comment_id`, `comment_person_name`, `comment_value`, `comment_location`, `comment_time`)
         VALUES (NULL, '$_SESSION[name]', '$_POST[chat]', '$_POSTE[location]', NOW())"
      );
  }
?>
