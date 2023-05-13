<?php
  // Start a new session
  session_start();

  // Include the config file
  include_once('config.php');

  // Check if the chat form was submitted
  if (isset($_POST['requested_user'])) {
    $active_user = $_SESSION['user_id'];
    $requested_user = $_POST['requested_user'];
    $chat_id = $_POST['chat_id'];
    $key_enc =  $requested_user . ";" . $_POST['key_enc'];
    $iv_enc =  $requested_user . ";" . $_POST['iv_enc'];
    $name = $_SESSION["name"];
    
    //echo($key_enc);
    //echo($_SESSION["name"]);

    $chat_name_id = "group_chat-" . $chat_id;
    $query = "CREATE TABLE IF NOT EXISTS `$chat_name_id` (
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

    //set first message to iv and key
    $stmt = $db->prepare("INSERT INTO `$chat_name_id` (chat_id, chat_person_name, chat_value, chat_time, message_type) 
                          VALUES (NULL,?, ?, NOW(), ?)");
    $type = 2;
    $stmt->bind_param("ssi", $name, $key_enc, $type);
    $stmt->execute();
    $type = 3;
    $stmt->bind_param("ssi", $name, $iv_enc, $type);
    $stmt->execute();
    

    $stmt = $db->prepare("SELECT * FROM groupchats WHERE groupchat_id = ?");
    $stmt->bind_param("i", $chat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    //Get current requests and remove old one
    $current_request = $result['groupchat_Npublic'];
    $new_requests = str_replace(";" . $_POST["value"] ,"", $current_request);


    $stmt = $db->prepare("UPDATE groupchats SET groupchat_Npublic=? WHERE groupchat_id = ?");
    $stmt->bind_param("si", $new_requests, $chat_id);
    $stmt->execute();
    


  }
?>
