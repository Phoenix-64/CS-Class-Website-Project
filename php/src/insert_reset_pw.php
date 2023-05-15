<?php
  // Start a new session
  session_start();

  // Include the config file
  require_once 'config.php';
  $password      = $_POST['pass1'];
  $email         = $_POST['emailadress'];
  $user_password = $_POST['hashed_pw_2'];
  // Insert the new user into the database
  $stmt = $conn->prepare("UPDATE user SET user_password=? pw_reset=`reset` WHERE user_email=?");
  $stmt->bind_param("ss", $user_password, $email);
  $stmt->execute();


  // Check if the insert was successful
if ($stmt->errno == 0) {
    // If the insert was successful, redirect to the login page with a success message
    header(
        'location: practice.php?login_error=<span style="color:green">Your password was sucsesfully reset</span>'
    );
} else {
    // If the insert failed, print an error message
    echo "failed";
}
