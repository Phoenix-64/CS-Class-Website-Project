<?php
include_once('config.php');


$activ_user = $_POST['activ_user'];
$active_user_result =mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE user.user_id ='$activ_user'"));
$active_chat_id = $active_user_result['active_chat'];

if ($activ_user < $active_chat_id) {
    $chat_name_id = $activ_user . $active_chat_id;
    }
else {
    $chat_name_id = $active_chat_id . $activ_user;
    }



// Select all chat records from the 'chat' table
$result = mysqli_query($conn, "SELECT * FROM `$chat_name_id`");

// Loop through each chat record
while ($row = mysqli_fetch_assoc($result)) {
    // Extract the name and message from the current record
    $name = $row['chat_person_name'];
    $message = $row['chat_value'];
    $time = $row['chat_time'];

    $user = mysqli_query($conn, "SELECT *FROM user WHERE user.user_name='$name'"
    );
    $color = mysqli_fetch_assoc($user)['user_color'];
    
    $align = "left";
    if ($name == $active_user_result["user_name"]) {
        $align = "right";
    }
    // Print the name and message
    echo "<span style='color: $color; float: $align;'> $time $name: $message </span><br>";

}
?>


