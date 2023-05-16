<?php
session_start();

// Include the config file
require_once 'config.php';

// Check if the chat form was submitted
if (isset($_POST['activ_user'])) {
  echo("declined activated");
  $active_user   = $_POST['activ_user'];
  $declined_user = $_POST['declined_user'];

  $stmt = $db->prepare("SELECT * FROM user WHERE user_id = ?");
  $stmt->bind_param("i", $active_user);
  $stmt->execute();
  $result = $stmt->get_result();
  $result = $result->fetch_assoc();
  // Get current requests and remove old one
  $current_request = $result['requests'];
  echo($current_request);
  echo("CurrentRequests");
  $new_requests = str_replace(";".$declined_user, "", $current_request);
  // Update users requests and add to availabel chats
  $update = mysqli_query(
      $conn,
      "UPDATE `user` SET `requests`= '$new_requests' 
      WHERE `user_id`='$active_user'"
  );
  $stmt   = $conn->prepare("UPDATE user SET requests=? WHERE user_id=?");
  $stmt->bind_param("si", $new_requests, $active_user);
  $stmt->execute();
}//end if
?>
