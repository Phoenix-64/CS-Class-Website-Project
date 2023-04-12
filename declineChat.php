<?php
  // Start a new session
  session_start();

  // Include the config file
  include_once('config.php');

  // Check if the chat form was submitted
  if (isset($_POST['activ_user'])) {
    echo("declined activated");
    $active_user = $_POST['activ_user'];
    $declined_user = $_POST['declined_user'];

    $result = mysqli_fetch_assoc(mysqli_query($conn , "SELECT * FROM user WHERE user.user_id='$active_user'"));
    //Get current requests and remove old one
    $current_request = $result['requests'];
    echo($current_request);
    echo("CurrentRequests");
    $new_requests = str_replace(";" . $declined_user,"", $current_request);
    // Update users requests and add to availabel chats
    $update = mysqli_query(
      $conn,
      "UPDATE `user` SET `requests`= '$new_requests' WHERE `user_id`='$active_user'" 
    );
  }
?>
