<?php
  // Start a new session
  session_start();

  // Include the config file
  include_once('config.php');

  // Check if the chat form was submitted
  if (isset($_POST['activ_user'])) {
    $active_user = $_POST['activ_user'];
    $accepted_user = $_POST['accepted_user'];

    $result = mysqli_fetch_assoc(mysqli_query($conn , "SELECT * FROM user WHERE user.user_id='$active_user'"));

    //Get current requests and remove old one
    $current_request = $result['requests'];
    $new_requests = str_replace(";" . $accepted_user,"", $current_request);

    //Get and change availabelchats
    $current_availabel = $result['availabel_chats'];
    $new_availabel = $current_availabel . ";" . $accepted_user;

    // Update users requests and add to availabel chats
    $update = mysqli_query(
      $conn,
      "UPDATE `user` SET `requests`= '$new_requests', `availabel_chats`='$new_availabel' WHERE `user_id`='$active_user'" 
    );


    //Generate new avialabel for accepted:
    $result = mysqli_fetch_assoc(mysqli_query($conn , "SELECT * FROM user WHERE user.user_id='$accepted_user'"));
    $current_availabel = $result['availabel_chats'];
    $new_availabel = $current_availabel . ";" . $active_user;
    $update = mysqli_query(
        $conn,
        "UPDATE `user` SET  `availabel_chats`='$new_availabel' WHERE `user_id`='$accepted_user'" 
      );


    //Create new chat by first computing name and then creating:

    // Compute chat name based on participating user_ids
    if ($active_user < $accepted_user) {
        $chat_name_id = $active_user . $accepted_user;
        }
        else {
        $chat_name_id = $accepted_user . $active_user;
        }

    $query = "CREATE TABLE IF NOT EXISTS `$chat_name_id` (
        `chat_id` INT(11) NOT NULL AUTO_INCREMENT,
        `chat_person_name` varchar(100) NOT NULL,
        `chat_value` varchar(100) NOT NULL,
        `chat_time` time DEFAULT NULL,
        `message_type` INT(11) NOT NULL DEFAULT 0,
        `image_file` varchar(100) NOT NULL,
        PRIMARY KEY (`chat_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $result = mysqli_query($conn, $query);
  }
?>
