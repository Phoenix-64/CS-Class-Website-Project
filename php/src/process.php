<?php
  // Start a new session
  session_start();

  // Include the config file
  require_once 'config.php';

  // Get the email and password from the POST request
  $user_email    = $_POST['email'];
  $user_password = $_POST['hashed_pw_2'];



  // Select the user with the matching email
  $stmt = $db->prepare("SELECT * FROM user WHERE user.user_email = ?");
  $stmt->bind_param("s", $user_email);
  $stmt->execute();
  $result = $stmt->get_result();

  // Fetch the name of the user and its password hash
  $row           = $result->fetch_assoc();
  $name          = $row['user_name'];
  $password_hash = $row['user_password'];
  $verified = $row['verified'];
  
if(!$verified) {
    header(
        'location: practice.php?login_error=<span style="color:red">Your email is not yet verified you should have reciewd an email if not contact the developer.</span>'
    );
}

  // Check if a user was found
if ($result->num_rows > 0 && $user_password === $password_hash) {
    // If a user was found and password is corect, set session variables and redirect to the chatroom
    echo "success";
    $_SESSION['email']    = $user_email;
    $_SESSION['password'] = $password_hash;
    $_SESSION['name']     = $name;

    // Update the user's status to "online"
    $query = mysqli_query(
        $conn,
        "UPDATE user SET user_status='1' WHERE user_email='$user_email'"
    );
    $stmt  = $conn->prepare("UPDATE user SET user_status='1' WHERE user_email=?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    header('location: chatroom.php');
    
} else {
    // If no user was found or password is incorect, redirect back to the login page with an error message
    echo "failed";
    header(
        'location: practice.php?login_error=<span style="color:red">Username or password is wrong</span><form method="post" action="request_pw_reset.php"><table><tr><td>Email : </td><td><input type="email" name="email"  /></td></tr><tr><td colspan="2"><center> <input type="submit" name="pwresetbtn" value="Reset Password" /></td></tr></table></form> '
    );
    
}//end if
