<!DOCTYPE html>
<html lang="en">

<script>





// This function sends an HTTP GET request to the test.php file and updates the city_display element with the response
function getCity(id) {
  // Initialize new XMLHttpRequest object
  const xhr = new XMLHttpRequest();
  // Set the HTTP method to GET and the url to test.php with the idd query parameter set to the passed id
  xhr.open('GET', `test.php?idd=${id}`, true);
  // Send the request
  xhr.send();
  // Set the onreadystatechange event handler to update the city_display element with the response when the request is complete
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      document.getElementById('city_display').innerHTML = xhr.responseText;
    }
  };
}

// This function sends an HTTP GET request to the test2.php file and updates the emailDiv element with the response
function getEmail(emailId) {
  // Initialize new XMLHttpRequest object
  const emailXhr = new XMLHttpRequest();
  // Set the HTTP method to GET and the url to test2.php with the email query parameter set to the passed emailId
  emailXhr.open('GET', `test2.php?email=${emailId}`, true);
  // Send the request
  emailXhr.send();
  // Set the onreadystatechange event handler to update the emailDiv element with the response when the request is complete
  emailXhr.onreadystatechange = function() {
    if (emailXhr.readyState === 4 && emailXhr.status === 200) {

      document.getElementById('emailDiv').innerHTML = emailXhr.responseText;

      if (emailId.length < 3) {
        document.getElementById('emailDiv').innerHTML =  "<font color='#FF0000'>Email zu kurz</font>"
      }
        

      }

    };
  
  if (document.getElementById('emailDiv').textContent.includes("Email frei")) {
    return true;
  }
  return false;
  
}
  


// This function compares the values of the pass1 and pass2 elements and updates the cnfrmpass element with the result
function checkPasswordMatch() {
  // Get the values of the pass1 and pass2 elements
  const pass1 = document.getElementById('pass1').value;
  const pass2 = document.getElementById('pass2').value;
  // Check if the values are equal
  if (pass1 === pass2) {
    // Update the cnfrmpass element with a message indicating the passwords match
    document.getElementById('cnfrmpass').innerHTML = '<font color="#00CC00">Passwörter stimmen</font>';

    if (pass1.length < 6) {
      document.getElementById('cnfrmpass').innerHTML = '<font color="red">Passwort zu kurz</font>';
      return false;
    }
    return true;
  } 
  else {
    // Update the cnfrmpass element with a message indicating the passwords do not match
    document.getElementById('cnfrmpass').innerHTML = '<font color="red">Passwörter stimmen nicht überein</font>';
    return false;
  }
}

function checkColor(color) {
  //const color = document.getElementById('color').value;
  var pattern = /([g-z])/i;
  if (color.length == 7 && color[0] == "#" && false == pattern.test(color)) {
    // Update the cnfrmcol element with a message indicating the color is valid 
    document.getElementById('cnfrmcol').innerHTML = '<font color="#00CC00">Farbe erkannt</font>';
    return true;
  } 
  else {
    // Update the cnfrmcol element with a message indicating the color is invalid
    document.getElementById('cnfrmcol').innerHTML = '<font color="red">Farbe nicht erkannt</font>';
    return false;
  }
}

function checkName(name) {
  // Initialize new XMLHttpRequest object
  const nameXhr = new XMLHttpRequest();
  // Set the HTTP method to GET and the url to check_name.php with the name query parameter set to the passed name
  nameXhr.open('GET', `check_name.php?name=${name}`, true);
  // Send the request
  nameXhr.send();
  // Set the onreadystatechange event handler to update the nameDiv element with the response when the request is complete
  nameXhr.onreadystatechange = function() {
    if (nameXhr.readyState === 4 && nameXhr.status === 200) {

      document.getElementById('nameDiv').innerHTML = nameXhr.responseText;



      if (name.length < 3) {
        document.getElementById('nameDiv').innerHTML =  "<font color='#FF0000'>Name zu kurz</font>"
      }

    }
    
  };
  if (document.getElementById('nameDiv').textContent.includes("Name frei")) {
    return true;
  }
  return false;
}


function validate(value) {

  var name = checkName(document.getElementById('name').value);
  var email = getEmail(document.getElementById('email').value);
  var pw = checkPasswordMatch();
  var color = checkColor(document.getElementById('color').value);
  console.log(name);
  console.log(email);
  console.log(pw);
  console.log(color);
  if (name && email && pw && color) {
    document.getElementById("submit").disabled = false;
  }
  else {
    document.getElementById("submit").disabled = true;
  }
}



</script>



<!-- styling and navbar -->
<head>
    <meta charset="UTF-8">
    <link id="pagestyle" rel="stylesheet" href="styles_dark.css" />
    <script type="text/javascript" src="sticky_navbar.js"></script>
    <script type="text/javascript" src="darkmode_cookie.js"></script>
    <script type="text/javascript" src="cookie_notice.js"></script>
    <title>Homepage | Phönix 64</title>
    <meta name="description" content="Homepage">
    <meta name="author" content="Phönix 64">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div id="navbar">
  <a href="index.html" >Home</a>
  <a href="Klettern.html">Klettern</a>
  <a href="Amateurfunk.html">Amaterufunk</a>
  <a href="Samariter.html">Samariter</a>
  <a href="Feuerwehr.html">Feuerwehr</a>
  <a href="Pfadi.html">Pfadi</a>
  <a href="Operateur.html">Operateur</a>
  <a href="practice.php" class="active">Chat</a>

  <div class="darkmode_button">
    <input type="checkbox" id="darkmode" name="darkmode" value="darkmode" oninput="setDarkmodeCookie()" checked>
    <label for="darkmode"> Enable Darkmode</label>
  </div>
        
</div>
<div class="container">
<h1> Chat login</h1>
<hr>

<script type="text/javascript">cookie_notice();</script>

<?php if( isset($_GET['logout_successfully'])){ ?><?php echo $_GET['logout_successfully']; ?>
<?php } ?>
<?php if( isset($_GET['registeration_successfull'])){ ?><?php echo $_GET['registeration_successfull']; ?>
<?php } ?>

<div class="flex-container" style="flex-direction: row;"> 
<div style="margin-right: 5vw;">
<?php
include_once('config.php');
$result = mysqli_query($conn , 'select * from country');
if(!$result){
	echo 'query failed';}
?>



<table><tr>
<td colspan="2"><center><h2>Registrieren</h2></td></tr><tr>
<form method="post" action="insert.php">
<td>Name : </td><td><input type="text" name="name" onblur="validate(this.value)" id="name"/></td><td><div id="nameDiv"></div></td></tr><tr>
<td>Email : </td><td><input type="email" name="email" onblur="validate(this.value)" id="email" /></td><td><div id="emailDiv"></div></td>
</tr><tr>



<td>Kanton : </td><td><select name="country">
<?php while($row = mysqli_fetch_assoc($result)){?>
<option value="<?php echo $row['country_id']; ?>"> <?php echo $row['country_name']; ?>
</option>

<?php } ?>
</select></td><td><div id="city_display"></div>
</td></tr><tr>


<td>Farbe in Hex: </td><td><input type="text" name="color" id="color" onblur="validate(this.value)"/></td><td> <!-- Farbe wird nicht richtig gespeichert -->
<div id="cnfrmcol"></div></td></tr><tr>


<td>Password : </td><td><input type="password" name="pass1" id="pass1" onblur="validate()" /></td></tr><tr>
<td>Password bestätigen : </td><td><input type="password" name="pass2" id="pass2" onblur="validate()" /></td><td>
<div id="cnfrmpass"></div></td></tr><tr>
<td colspan="2"><center><input type="submit" name="sbt" id="submit" disabled/></td></table></form> 


</div>
<div style="margin-left: 5vw;">


<form method="post" action="process.php">
<table><tr>
<td colspan="2"><center> <h2>Login</h2></td>
</tr>

<tr>
<td>
Email : </td><td><input type="text" name="email"  /></td></tr><tr>
<td> Password : </td><td><input type="password" name="password" /></td></tr>
<tr><td colspan="2"><center> <input type="submit" name="loginbtn" /></td></tr></table>
<input type='hidden' name='page' value='chat' />
<?php if( isset($_GET['login_error'])){ ?><?php echo $_GET['login_error']; ?>
<?php } ?>
</form> 

</div>
</div>
<div><hr></div>

</div>
</body>
</html>
