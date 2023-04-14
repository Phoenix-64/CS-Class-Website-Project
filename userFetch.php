<?php
include_once('config.php');
$result= mysqli_query($conn , "SELECT * FROM user");

$active_user = $_POST["activ_user"];


$result_current = mysqli_query($conn , "SELECT * FROM user WHERE user.user_id='$active_user'");
$current_user = mysqli_fetch_assoc(mysqli_query($conn , "SELECT * FROM user WHERE user.user_id='$active_user'"));


$new_requests = $current_user['requests'] . ";" . $active_user;

if (isset($_POST['activ_user'])) {
echo($new_requests);
echo($current_user['requests']);


//$update = mysqli_query(
//	$conn,
//	"UPDATE `user` SET `requests`= '$new_requests' WHERE `user_id`='$active_user'" 
//  );
//echo($update);

}


$active_chat = $current_user['active_chat'];
//Fetch availabel chats and requests that other users made to the active ones
$availabel_chats = explode(";",$current_user['availabel_chats']);
$requests_for_active = $current_user['requests'];

//If array is NULL initialize to [];
if($availabel_chats == NULL) {
	$availabel_chats = [];
}

while ($row = mysqli_fetch_assoc($result)){
	$user_id = $row['user_id'];
	$requests = $row['requests'];
	//skip if active user
	if($active_user == $user_id) {
		continue;
	}
	
	if(in_array($user_id, $availabel_chats)) {

		//Check if user is Online and the one with the active chat
		if($row['user_status'] == 1 && $user_id == $active_chat){
			echo "<div id='user'>
					<font color='#0099FF'>".$row['user_name']." (Online)"."</font> 
				</div>";
			}
		//Chek if user is Online and not the one with the active chat		
		elseif($row['user_status'] == 1 && $user_id != $active_chat){
			echo "<div id='user'>
					<font color='#009900'>".$row['user_name']." (Online)"."</font> 
					<button data-user='$user_id' onclick='changeActive(this)'> Open Chat </button>
				</div>";
			}
		// Check if offline user is the one with the active chat
		elseif($user_id == $active_chat) {
			echo "<div id='user'>
					<font color='#FF00FF'>".$row['user_name']." (Offline)"."</font> 
				</div>";
			}
		// Remaining offline non active
		else {
			echo "<div id='user'>
				<font color='#FF0000'>".$row['user_name']." (Offline)"."</font> 
				<button data-user='$user_id' onclick='changeActive(this)'> Open Chat </button>
				</div>";
			}
			
		}
	//If there is already a request dont show reauest button
	elseif(str_contains($requests, ";" . $active_user)) {
		//Check if user is Online
		if($row['user_status'] == 1){
			echo "<div id='user'>
					<font color='#009933'>".$row['user_name']." (Online) Already Requested"."</font> 
				</div>";
			}
		// Remaining offline
		else {
			echo "<div id='user'>
				<font color='#FF0033'>".$row['user_name']." (Offline) Already Requested"."</font> 
				</div>";
			}
		}
	//If the current user has a request from this id display butons
	elseif(str_contains($requests_for_active, ";" . $user_id)) {
		//Check if user is Online
		if($row['user_status'] == 1){
			echo "<div id='user'>
					<font color='#009900'>".$row['user_name']." (Online)"."</font> 
					<button data-user='$user_id' onclick='acceptRequest(this)'> Accept Request </button>
					<button data-user='$user_id' onclick='declineRequest(this)'> Decline Request </button>
				</div>";
			}
		// Remaining offline
		else {
			echo "<div id='user'>
				<font color='#FF0000'>".$row['user_name']." (Offline)"."</font> 
				<button data-user='$user_id' onclick='acceptRequest(this)'> Accept Request </button>
				<button data-user='$user_id' onclick='declineRequest(this)'> Decline Request </button>
				</div>";
			}
		}			
	else {
		//Check if user is Online
		if($row['user_status'] == 1){
			echo "<div id='user'>
					<font color='#009900'>".$row['user_name']." (Online)"."</font> 
					<button data-user='$user_id' onclick='changeRequest(this)'> Request Chat </button>
				</div>";
			}
		// Remaining offline
		else {
			echo "<div id='user'>
				<font color='#FF0000'>".$row['user_name']." (Offline)"."</font> 
				<button data-user='$user_id' onclick='changeRequest(this)'> Request Chat </button>
				</div>";
			}		
	}
	}

?>