<?php

session_start();

// Include the config file.
require_once 'config.php';

// Check if the chat form was submitted.
if (isset($_POST['activ_user']) === TRUE) {
  $active_user   = $_POST['activ_user'];
  $accepted_user = $_POST['accepted_user'];
  $N_public      = $_POST['N_public'];
  $key_enc       = $_POST['key_enc'];
  $iv_enc        = $_POST['iv_enc'];

  $stmt = $db->prepare("SELECT * FROM user WHERE user_id = ?");
  $stmt->bind_param("i", $active_user);
  $stmt->execute();
  $result = $stmt->get_result();
  $result = $result->fetch_assoc();

  // Get current requests and remove old one
  $current_request = $result['requests'];
  $new_requests    = str_replace(";".$accepted_user.":".$N_public, 
                                  "", $current_request);

  // Get and change availabelchats
  $current_availabel = $result['availabel_chats'];
  $new_availabel     = $current_availabel.";".$accepted_user;

  // Update users requests and add to availabel chats
  $sql      = "UPDATE user SET requests=?, availabel_chats=? WHERE user_id=?";
  $stmt_upd = $conn->prepare($sql);
  $stmt_upd->bind_param("ssi", $new_requests, $new_availabel, $active_user);
  $stmt_upd->execute();


  // Generate new avialabel for accepted:
  $stmt->bind_param("i", $accepted_user);
  $stmt->execute();
  $result            = $stmt->get_result();
  $result            = $result->fetch_assoc();
  $current_availabel = $result['availabel_chats'];
  $new_availabel     = $current_availabel.";".$active_user;


  $sql      = "UPDATE user SET availabel_chats=? WHERE user_id=?";
  $stmt_upd = $conn->prepare($sql);
  $stmt_upd->bind_param("si", $new_availabel, $accepted_user);
  $stmt_upd->execute();


  // Create new chat by first computing name and then creating:
  // Compute chat name based on participating user_ids
  if ($active_user < $accepted_user) {
      $chat_name_id = mysqli_real_escape_string($conn, 
                                                $active_user.$accepted_user);
  } else {
      $chat_name_id = mysqli_real_escape_string($conn, 
                                                $accepted_user.$active_user);
  }

    echo("$chat_name_id");

    $query  = "CREATE TABLE IF NOT EXISTS `$chat_name_id` (
      `chat_id` INT(11) NOT NULL AUTO_INCREMENT,
      `chat_person_name` varchar(100) NOT NULL,
      `chat_value` varchar(100) NOT NULL,
      `chat_time` time DEFAULT NULL,
      `message_type` INT(11) NOT NULL DEFAULT 0,
      `image_file` varchar(100) NOT NULL,
      `read`  BOOLEAN NOT NULL DEFAULT FALSE,
      PRIMARY KEY (`chat_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $result = mysqli_query($conn, $query);

    // set first message to iv and key
  $stmt = $db->prepare(
      "INSERT INTO `$chat_name_id` 
      (chat_id, chat_person_name, chat_value, chat_time, message_type) 
      VALUES (NULL,?, ?, NOW(), ?)"
  );
  $type = 2;
  $stmt->bind_param("ssi", $_SESSION["name"], $key_enc, $type);
  $stmt->execute();
  $type = 3;
  $stmt->bind_param("ssi", $_SESSION["name"], $iv_enc, $type);
  $stmt->execute();
}//end if
