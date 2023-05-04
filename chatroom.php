<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include_once('config.php');
if (isset($_GET['logout'])) {
  $sql = "UPDATE user SET user_status='0' WHERE user_email=?";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param("s", $_SESSION["email"]);
  $stmt->execute();
  session_destroy();
  header('location: practice.php?logout_successfully=<span style="color:green">You have successfully Logged Out.</span>');
}
?>
<script src="RSA_PRogramm/ras_example.js"></script>
<script src="chacha-js/chacha.js"></script>
<script>
  function changeActive(element) {
    element.style.backgroundColor = "red";
    document.getElementById('user').dataset.activ = element.dataset.user
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'changeActiveChat.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user + '&active_chat=' + element.dataset.user);
    xhr.onreadystatechange = function() {}

  }


  function changeRequest(element) {
    element.style.backgroundColor = "red";
    console.log("Requested: " + element.dataset.user);
    //Compute chat Id whee to save local key
    let activ_user = document.getElementById('user').dataset.user
    let requested_user = element.dataset.user
    let chat_id = "" + activ_user + requested_user
    if (activ_user > requested_user) {
      chat_id = "" + requested_user + activ_user 
    }

    //Generate RSA Keys:
    let n = 53
    let p = findPrim(n); //Prim Number
    let q = findPrim(n); //Prim number

    let N = p * q
    let Nphi = euler(p, q);

    // e and N are the public key
    // d is the privat key

    let d = egcd(e, Nphi);
    while (d == 1n) {
        p = findPrim(n); //Prim Number
        q = findPrim(n); //Prim number
        N = p * q
        Nphi = euler(p, q);
        d = egcd(e, Nphi);
    } 

    //and make sure its positiv
    d = d % Nphi
    if (d < 0n) {
        d = d + Nphi
    } 

    //save d in local sotrage
    localStorage.setItem(chat_id + "d", d);
    localStorage.setItem(chat_id + "N", N);


    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'requestChat.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user + '&requested_user=' + element.dataset.user + '&N_public=' + N);
    xhr.onreadystatechange = function() {console.log(xhr.responseText)}
  }
  
  
  function acceptRequest(element) {
    element.style.backgroundColor = "red";
    //Compute chat Id whee to save local key
    let activ_user = document.getElementById('user').dataset.user
    let requested_user = element.dataset.user
    let chat_id = "" + activ_user + requested_user
    if (activ_user > requested_user) {
      chat_id = "" + requested_user + activ_user 
    }



    //Generate symetrich CHACH20 key and IV and save them:
    let key = new Array(CHACHA_KEYSIZE).fill().map(() => Math.floor(65535 * Math.random()))
    let iv = new Array(CHACHA_IVSIZE).fill().map(() => Math.floor(65535 * Math.random()))
    localStorage.removeItem(chat_id);
    localStorage.setItem(chat_id + "key", key)
    localStorage.setItem(chat_id + "iv", iv)

  

    //get public RSA N key:
    var N_public 
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'getKeys.php', false);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user + '&accepted_user=' + element.dataset.user);
    N_public = BigInt(xhr.responseText)

    //encrypt key and iv with RSA
    console.log(N_public)
    console.log(key)
    console.log("HERE")



    for (i in key) {
      //add pad to message 
      let padd = "" + pad_seperator + nBitRandom(8)
      key[i] = BigInt("" + key[i] + padd)

      //encrypt
      
      key[i] = power(key[i], e, N_public).toString()
    }
    console.log("Key enc: " + key)
    console.log("Iv raw: " + iv)

    for (i in iv) {
      //add pad to message 
      let padd = "" + pad_seperator + nBitRandom(8)
      iv[i] = BigInt("" + iv[i] + padd)

      //encrypt
      iv[i] = power(iv[i], e, N_public).toString()
    }
    console.log("Iv enc: " + iv)



    
    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'acceptChat.php', true);
    xhr1.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr1.send('activ_user=' + document.getElementById('user').dataset.user + '&N_public=' + N_public + '&accepted_user=' + element.dataset.user + '&key_enc=' + JSON.stringify(key) + '&iv_enc=' + JSON.stringify(iv));
    xhr1.onreadystatechange = function() {console.log(xhr1.responseText)}
  }


  function declineRequest(element) {
    element.style.backgroundColor = "red";
    var xhr = new XMLHttpRequest();
    console.log("activ_user: " + document.getElementById('user').dataset.user + "  declined_user: " + element.dataset.user)
    xhr.open('POST', 'declineChat.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user + '&declined_user=' + element.dataset.user);
    xhr.onreadystatechange = function() {console.log(xhr.responseText)}
  }


  function crypt_chach(chat_id, msg) {
    let key = Uint16Array.from(localStorage.getItem(chat_id + "key").split(",")).buffer
    let iv = Uint16Array.from(localStorage.getItem(chat_id + "iv").split(",")).buffer
    let g    = new ChaCha(key, iv)
    let v = new Uint8Array(g())
    for (i in msg) {
      if (i > v.byteLength) {
        v = new Uint8Array(g())
      }
      msg[i] = msg[i] ^ v[i]
      }
    return msg
  }

  function decrypt_rsa(chat_id, msg) {

    let d = localStorage.getItem(chat_id + "d")
    let N_Public = localStorage.getItem(chat_id + "N")
    for (i in msg) {
      msg[i] = power(BigInt(msg[i]), d, N_public)
      msg[i] = Number(msg[i].toString().split(pad_seperator)[0])
    }

    return msg
  }

  function getText() {
    var text = document.getElementById('text').value;
	  document.getElementById('text').value = "";

    let activ_user = document.getElementById('user').dataset.user
    let requested_user = document.getElementById('user').dataset.activ
    var chat_id = "" + activ_user + requested_user
    if (activ_user > requested_user) {
      chat_id = "" + requested_user + activ_user 
    }
    let enc = new TextEncoder();

    text = enc.encode(text)
    text = crypt_chach(chat_id, text)
    text = JSON.stringify(Array.from(text))

    var xhr = new XMLHttpRequest(); 
    xhr.open('POST', 'chatdb.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('chat=' + text + '&activ_user=' + document.getElementById('user').dataset.user);
    xhr.onreadystatechange = function() {
    }
  }

  function setText() {
    let activ_user = document.getElementById('user').dataset.user
    let requested_user = document.getElementById('user').dataset.activ
    var chat_id = "" + activ_user + requested_user
    if (activ_user > requested_user) {
      chat_id = "" + requested_user + activ_user 
    }
    var dec = new TextDecoder("utf-8");

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'chatFetch.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user);
    xhr.onreadystatechange = function() { all_echo = xhr.responseText
      
      if (!(typeof all_echo === 'string' && all_echo.length === 0)) {
        all_echo = all_echo.split(":::")
        let display = []
        for (i in all_echo) {
          respons = all_echo[i]
          if (respons.includes("\r\n")) {
            break;
          }

          if(respons.includes("key1241242:")) {
            let key = respons.split(":")[1]
            key = JSON.parse(key)
            key = decrypt_rsa(chat_id, key)
            localStorage.setItem(chat_id + "key", JSON.stringify(key))
            }

          else if(respons.includes("iv1241242:")) {
            let iv = respons.split(":")[1]
            iv = JSON.parse(iv)
            iv = decrypt_rsa(chat_id, iv)
            localStorage.setItem(chat_id + "iv", JSON.stringify(iv))
            }

          else if(respons.includes("Select or request a Chat")) {
            document.getElementById('chatarea').innerHTML = "Select or request a Chat"
            }

          else {
            
            respons = respons.split(";")
            msg = respons[4]
            
            if (respons.length == 6){
              msg = respons[5]
              }

            msg = Uint8Array.from(JSON.parse(msg)) 
            msg = crypt_chach(chat_id, msg)
            
            msg = dec.decode(msg);
            display.push("<div><span style='color: " + respons[0] + "; float: " + respons[1] + ";'> " + respons[2] + " " + respons[3] + ": " + msg + " </span></div><br>")
            if (respons.length == 6){
              display.push("<div><img src='uploads/" + msg + "' class='chat_image' style='float: " + respons[1] + "; width: 30vw; padding-left: 1vw; padding-bottom: .5vw;'></div><br>")
              }
            }
          }
        document.getElementById('chatarea').innerHTML = display.join("")
        }
      }
  }


  
  function fileUpload() {
    let file_name = document.getElementById("fileInput").value
    let activ_user = document.getElementById('user').dataset.user
    let requested_user = document.getElementById('user').dataset.activ
    var chat_id = "" + activ_user + requested_user
    if (activ_user > requested_user) {
      chat_id = "" + requested_user + activ_user 
    }
    let enc = new TextEncoder();

    file_name = file_name.split("\\").slice(-1)
    
    file_name = enc.encode(file_name)
    file_name = crypt_chach(chat_id, file_name)
    file_name = JSON.stringify(Array.from(file_name))
    document.getElementById("fileNameEnc").value = file_name
    console.log(file_name)
    return true

  }
  setInterval(setText, 500);

  setInterval(users, 500);



  function users() {
    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'userFetch.php', true);
    xhr1.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr1.send('activ_user=' + document.getElementById('user').dataset.user);
    xhr1.onreadystatechange = function() {
      // alert(xhr.responseText);
      document.getElementById('loginperson').innerHTML = xhr1.responseText;
    }
  }
</script>


<head>
    <meta charset="UTF-8">
    <link id="pagestyle" rel="stylesheet" href="styles_dark.css" />
    <link id="pagestyle" rel="stylesheet" href="chat_style.css" />
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
  <a href="index.html">Home</a>
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



<div> 
  <h1> Chat</h1>
  <hr>
  <script type="text/javascript">cookie_notice();</script>
  <?php
  $name = $_SESSION['name'];

  $stmt = $db->prepare("SELECT * FROM user WHERE user_email = ?");
  $stmt->bind_param("s", $_SESSION["email"]);
  $stmt->execute();
  $result = $stmt->get_result();
  $result = $result->fetch_assoc();

  $user_id = $result['user_id'];
  $activ_chat = $result['active_chat'];
  echo "Aktueller Benutzer: <span id='user' data-activ='$activ_chat' data-user='$user_id'>$name</span>";
  ?>

  <form action="">
    <input type="submit" name="logout" value="logout">
  </form>
</div>
<div class="chat_container">
  <div id="chatbox">
    <div id="chatarea"></div>

    <div id="textbox">
      <form>
        <textarea rows="4" cols="100" id="text" onkeyup="if(event.keyCode==13) {getText()}"></textarea>
        <input type="button" value="send" onclick="getText()" />
      </form>




      <form action="uploadHandler.php" onSubmit="return fileUpload()"
      method="post"
      enctype="multipart/form-data">

        Select Image to upload:
        <input type="file" id="fileInput" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
        <input type='hidden' id='activ_user' name='activ_user' value="Default">
        <input type='hidden' id='fileNameEnc' name='fileNameEnc' value="Default">

      </form>
      <?php if( isset($_GET['error'])){ ?><?php echo $_GET['error']; }?>

       <!--Script changes input field with id of active user  -->
       <script>
            document.getElementById('activ_user').value = document.getElementById('user').dataset.user;
      </script>


    </div>
  </div>
  <div id="loginperson"> </div>
</div>
<div><hr></div>

<?php
if (!isset($_SESSION['email']) && !isset($_SESSION['password'])) {
  session_destroy();
  header('location: practice.php');
}
?>
</body>
</html>