<?php
  // Start a new session
  session_start();

  // Include the config file
  include_once('config.php');

  // Get the email and password from the POST request
  $email = $_POST['email'];
  $password = $_POST['password'];



  // Select the user with the matching email
  $stmt = $db->prepare("SELECT * FROM user WHERE user.user_email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  // Fetch the name of the user and its password hash
  $row = $result->fetch_assoc();
  $name = $row['user_name'];
  $password_hash = $row['user_password'];

  // Check if a user was found
  if ($result->num_rows > 0 && password_verify($password, $password_hash)) {
    
      // If a user was found and password is corect, set session variables and redirect to the chatroom
      echo "success";
      $_SESSION['email'] = $email;
      $_SESSION['password'] = $password_hash;
      $_SESSION['name'] = $name;

      // Update the user's status to "online"
      $query = mysqli_query(
        $conn,
        "UPDATE user SET user_status='1' WHERE user_email='$email'"
      );
      $stmt= $conn->prepare("UPDATE user SET user_status='1' WHERE user_email=?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      if ($_POST["page"] == "poste") {
        header('location: Blog/poste.php');
      }
      else {
        header('location: chatroom.php');
      }
    

  } 
  else {
    // If no user was found or password is incorect, redirect back to the login page with an error message
    echo "failed";
    if ($_POST["page"] == "poste") {
      header(
        'location: Blog/poste.php?login_error=<span style="color:red">Username or password is wrong</span><form method="post" action="request_pw_reset.php"><table><tr><td>Email : </td><td><input type="email" name="email"  /></td></tr><tr><td colspan="2"><center> <input type="submit" name="pwresetbtn" value="Reset Password" /></td></tr></table></form> '
      );
    }
    else {
      header(
        'location: practice.php?login_error=<span style="color:red">Username or password is wrong</span><form method="post" action="request_pw_reset.php"><table><tr><td>Email : </td><td><input type="email" name="email"  /></td></tr><tr><td colspan="2"><center> <input type="submit" name="pwresetbtn" value="Reset Password" /></td></tr></table></form> '
      );
    }
  }
?>
