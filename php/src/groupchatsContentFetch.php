<?php


function groupchatContent($active_user_result)
{
    include 'config.php';
    $chat_name = "group_chat".$active_user_result['active_chat'];
    $state     = mysqli_query($conn, "SHOW TABLES LIKE '$chat_name'");
    if (mysqli_fetch_assoc($state) == null) {
        echo("Select or request a Chat");
        exit();
    }

    $active_user_name = $active_user_result["user_name"];
    $update           = mysqli_query($conn, "UPDATE `$chat_name` SET `read`= TRUE WHERE `chat_person_name` != '$active_user_name'");

    // Select all chat records from the 'chat' table
    $result = mysqli_query($conn, "SELECT * FROM `$chat_name`");
    $stmt   = $db->prepare("SELECT * FROM user WHERE user_name = ?");
    // Loop through each chat record
    while ($row = mysqli_fetch_assoc($result)) {
        // Extract the name and message from the current record
        $name    = $row['chat_person_name'];
        $message = $row['chat_value'];
        $time    = $row['chat_time'];
        $read    = $row['read'];

        $stmt->bind_param("s", $name);
        $stmt->execute();
        $user     = $stmt->get_result();
        $user_row = $user->fetch_assoc();
        $color    = $user_row['user_color'];

        $align = "left";
        if ($name == $active_user_result["user_name"]) {
            $align = "right";
        }

        // Print the name and message
        switch ($row['message_type']) {
        case 0:
            echo "$color;$align;$time;$name;$message;$read:::";
            break;
        case 1:
            $file_name = $row['image_file'];
            echo "$color;$align;$time;$name;$message;$read;$file_name:::";
            break;
        case 2:
            // key
            echo "key1241242:$chat_name:$message";
            $remove = mysqli_query($conn, "DELETE FROM `$chat_name` WHERE `message_type` = 2");
            break;
        case 3:
            // iv
            echo "iv1241242:$chat_name:$message";
            $remove = mysqli_query($conn, "DELETE FROM `$chat_name` WHERE `message_type` = 3");
            break;
        }
    }//end while

}//end groupchatContent()
