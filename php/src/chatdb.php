<?php
session_start();

// Include the config file
require_once 'config.php';

// Check if the chat form was submitted
if (!$_POST['chat'] == null) {
    $activ_user = $_POST['activ_user'];

    $stmt = $db->prepare("SELECT * FROM user WHERE user_id=?");
    $stmt->bind_param("i", $activ_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $active_user_result = $result->fetch_assoc();
    $active_chat_id     = $active_user_result['active_chat'];


    // Compute chat name based on participating user_ids
    if ($activ_user < $active_chat_id) {
        $chat_name_id = mysqli_real_escape_string($conn, 
                                                $activ_user.$active_chat_id);
    } else {
        $chat_name_id = mysqli_real_escape_string($conn, 
                                                $active_chat_id.$activ_user);
    }

    if ($active_chat_id < 0) {
        $chat_name_id = "group_chat".$active_chat_id;
    }

    // Insert the new chat message into the database
    $result = mysqli_query(
        $conn,
        "INSERT INTO `$chat_name_id` 
        (`chat_id`, `chat_person_name`, `chat_value`, `chat_time`)
        VALUES (NULL, '$_SESSION[name]', '$_POST[chat]', NOW())"
    );
    $stmt   = $db->prepare("INSERT INTO $chat_name_id 
                            (chat_id, chat_person_name, chat_value, chat_time) 
                            VALUES (NULL,?,?,NOW())");
    $stmt->bind_param("ss", $_SESSION["name"], $_post["chat"]);
    $stmt->execute();
}//end if
