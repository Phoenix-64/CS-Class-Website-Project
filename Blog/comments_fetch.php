<?php
include_once(dirname(__FILE__)."/../config.php");

$poste_name = $_POST["poste_name"];
// Select all chat records from the 'chat' table
$result = mysqli_query($conn, "SELECT * FROM $poste_name");

// Loop through each chat record
while ($row = mysqli_fetch_assoc($result)) {
    // Extract the name and message from the current record
    $name = $row['comment_person_name'];
    $message = $row['comment_value'];
    $time = $row['comment_time'];
    $location = $row['comment_location'];
    $parent_comment = $row['comment_id'];
    $user = mysqli_query($conn, "SELECT * FROM user WHERE user.user_name='$name'"
    );
    $color = mysqli_fetch_assoc($user)['user_color'];
    
    $align = strval($location * 50) . "px";
    //if ($name == $_POST["activ_user"]) {
    //    $align = "50px";
    //}
    // Print the name and message
    echo "<div id='comment' style='margin-left: $align'> <span style='color: $color;'> $time $name: $message </span>
    <input type='button' value='send' onclick='getText($parent_comment)'/></div>";
}
?>



