<!DOCTYPE html>
<html lang="en">



<?php
session_start();
include_once(dirname(__FILE__)."/../config.php");
$poste_name = "test_poste";

$query = "CREATE TABLE IF NOT EXISTS `$poste_name` (
    `comment_id` int(11) NOT NULL AUTO_INCREMENT,
    `comment_person_name` varchar(100) NOT NULL,
    `comment_value` varchar(100) NOT NULL,
    `comment_location` int(11) NOT NULL, 
    `comment_time` time DEFAULT NULL,
    PRIMARY KEY (`comment_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$result = mysqli_query($conn, $query);

if (isset($_GET['logout'])) {
    $result = mysqli_query($conn, "UPDATE user SET user_status = '0' WHERE user_email = '$_SESSION[email]';");
    session_destroy();
    header('location: practice.php?logout_successfully=<span style="color:green">You have successfully Logged Out.</span>');
  } 

?>

<script>

function getText(location) {
    var text = document.getElementById('text').value;
    document.getElementById('text').value = "";
    console.log(location);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'comments_poste.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('chat=' + text +
        '&poste_name=' + document.getElementById('poste_name').textContent)+
        '&location=' + location;
    xhr.onreadystatechange = function() {
        if (xhr.responseText) {
        // document.getElementById('chatarea').innerHTML=xhr.responseText;
        }
    }
}


function setText() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'comments_fetch.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').textContent + 
        '&poste_name=' + document.getElementById('poste_name').textContent );
    xhr.onreadystatechange = function() {
        // alert(xhr.responseText);
        document.getElementById('comments').innerHTML = xhr.responseText;
    }
}

setInterval(setText, 500);

</script>


<head>
    <meta charset="UTF-8">
    <link id="pagestyle" rel="stylesheet" href="../styles_dark.css" />
    <link id="pagestyle" rel="stylesheet" href="blog_style.css" />
    <script type="text/javascript" src="../sticky_navbar.js"></script>
    <script type="text/javascript" src="../darkmode_cookie.js"></script>
    <script type="text/javascript" src="../cookie_notice.js"></script>
    <title>Homepage | Phönix 64</title>
    <meta name="description" content="Homepage">
    <meta name="author" content="Phönix 64">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <div class="item">
            <h1>Benjamins Blog</h1>
            <hr>
        </div>
        <div class="item"> <script type="text/javascript">cookie_notice();</script> </div>

        <div calss="item">
            <?php
                $name = $_SESSION['name'];
                echo "Aktueller Benutzer: <span id='user'>$name</span>";
            ?>
            <form action="">
                <input type="submit" name="logout" value="logout">
            </form>
        </div>
        <div class="item">
            <?php

                echo "Poste Name: <span id='poste_name'>$poste_name</span>";
            ?>
        </div>
        <div class="item">
            <p>
            Blog poste entery bla bla
            </p>

        </div>
        <div class="item"> 
            <div class="item" id="comments"></div>
            
            <div id="textbox">
                <form>
                    <textarea rows="4" cols="100" id="text" onkeyup="if(event.keyCode==13) {getText(0)}"></textarea>
                    <input type="button" value="send" onclick="getText(0)" />
                </form>
            </div>
        </div>
        <div class="item"> 
            <form method="post" action="../process.php">
                <table>
                    <tr>
                        <td colspan="2"><center> <h2>Login</h2></td>
                    </tr>
                    <tr>
                        <td>Name : </td>
                        <td><input type="text" name="email"  /></td>
                    </tr>
                    <tr>
                        <td> Password : </td>
                        <td><input type="password" name="password" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><center> <input type="submit" name="loginbtn" /></td>
                    </tr>
                </table>
                <input type='hidden' name='page' value='poste' />

                <?php if( isset($_GET['login_error'])){ ?><?php echo $_GET['login_error']; ?>
                <?php } ?>
            </form> 
        </div>
    
    </div>

</body>
</html>
