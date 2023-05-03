<?php
  // Start a new session
  session_start();

  // Include the config file
  include_once('config.php');
  $password = $_POST['pass1'];  
  $email = $_POST['emailadress'];
  $password = password_hash($password, PASSWORD_ARGON2I);
  // Insert the new user into the database
  $result = mysqli_query(
    $conn,
    "UPDATE user SET `user_password`='$password' WHERE `user_email`='$email'"
  );


  // Check if the insert was successful
  if ($result) {
    // If the insert was successful, redirect to the login page with a success message
    header(
      'location: practice.php?login_error=<span style="color:green">Your password was sucsesfully reset</span>'
    );
  } else {
    // If the insert failed, print an error message
    echo "failed";
  }

?>
