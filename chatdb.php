<?php
  // Start a new session
  session_start();

  // Include the config file
  include_once('config.php');
echo("Chat poste triggered");
  // Check if the chat form was submitted
  if (!$_POST['chat'] == NULL) {
    $activ_user = $_POST['activ_user'];

    $active_user_result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE user.user_id ='$activ_user'"));
    $active_chat_id = $active_user_result['active_chat'];
    

    // Compute chat name based on participating user_ids
    if ($activ_user < $active_chat_id) {
      $chat_name_id = $activ_user . $active_chat_id;
      }
    else {
      $chat_name_id = $active_chat_id . $activ_user;
      }
    echo("Intersting: " . $_SESSION['name']. $_POST['chat'] . "   Chat name id" . $chat_name_id);
      
    // Insert the new chat message into the database
    $result = mysqli_query(
      $conn,
      "INSERT INTO `$chat_name_id` (`chat_id`, `chat_person_name`, `chat_value`, `chat_time`)
       VALUES (NULL, '$_SESSION[name]', '$_POST[chat]', NOW())"
    );
  }
?>
