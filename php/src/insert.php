<?php
  // Get the form data
  $new_user_name     = $_POST['name'];
  $new_user_email    = $_POST['email'];
  $country           = $_POST['country'];
  $new_user_password = $_POST['hashed_pw'];
  $color = $_POST['color'];
  echo($password);
  // hash passowrd
  // Include the config file
  require_once 'config.php';

  // Insert the new user into the database
$stmt = $db->prepare(
    "INSERT INTO user (user_id, user_name, user_email, user_password, user_country, user_status, user_color) 
    VALUES (NULL,?,?,?,?,0,?)"
);
  $stmt->bind_param("sssss", $new_user_name, $new_user_email, $new_user_password, $country, $color);
  $stmt->execute();



  // Check if the insert was successful
if ($stmt->errno == 0) {
      // If the insert was successful, redirect to the login page with a success message
    header(
        "location: practice.php?registeration_successfull=<span style='color:green'>You have successfully registered. You can now login.</span>"
    );
} else {
    // If the insert failed, print an error message
    echo "failed";
}
