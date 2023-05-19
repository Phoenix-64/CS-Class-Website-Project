<?php
session_start();
require_once 'config.php';
if (isset($_GET['logout'])) {
    $sql  = "UPDATE user SET user_status='0' WHERE user_email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION["email"]);
    $stmt->execute();
    session_destroy();
    header('location: practice.php?logout_successfully=<span style="color:green">You have successfully Logged Out.</span>');
}

if (isset($_GET['create_group'])) {
    header('location: create_group.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<script src="RSA_PRogramm/ras_example.js"></script>
<script src="chacha-js/chacha.js"></script>
<script>
  function fullfillNRequest(request, chat_id) {
    let key = (localStorage.getItem("group_chat-" + chat_id + "key") 
                          .split(",").flatMap((x) => Number(x)));
    let iv = (localStorage.getItem("group_chat-" + chat_id + "iv")
                            .split(",").flatMap((x) => Number(x)));
    requests = request.split(";");
    requests.shift();
    requests.forEach(doRequests);

    function doRequests(value, index, array) {
      requested_user = value.split("-")[0];
      N_public = BigInt(value.split("-")[1]);
      
      key_enc = encrypt_RSA(N_public, key);
      iv_enc = encrypt_RSA(N_public, iv);

      let xhr2 = new XMLHttpRequest();
      xhr2.open('POST', 'GroupTransmitCHACHA.php', true);
      xhr2.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
      xhr2.send('requested_user=' + requested_user + '&iv_enc=' + JSON.stringify(iv_enc) 
                + '&key_enc=' + JSON.stringify(key_enc) + '&chat_id=' 
                + chat_id + '&value=' + value);
      xhr2.onload = function() { 
        document.getElementById('loginperson').innerHTML += xhr2.responseText;
      }
    }
  }


  function generateRSA(saveName) {
    //Generate RSA Keys:
    let n = 53;
    let p = findPrim(n); 
    let q = findPrim(n); 

    let N = p * q;
    let Nphi = euler(p, q);

    // e and N are the public key
    // d is the privat key

    let d = egcd(e, Nphi);
    while (d == 1n) {
        p = findPrim(n); 
        q = findPrim(n); 
        N = p * q;
        Nphi = euler(p, q);
        d = egcd(e, Nphi);
    } 

    //and make sure its positiv
    d = d % Nphi;
    if (d < 0n) {
        d = d + Nphi;
    } 

    //save d in local sotrage
    localStorage.setItem(saveName + "d", d);
    localStorage.setItem(saveName + "N", N);

    return N;
  }

  function changeActive(element) {
    document.getElementById('loginperson').innerText = "";
    document.getElementById('chatarea').innerText = "";
    element.style.backgroundColor = "red";
    document.getElementById('user').dataset.activ = element.dataset.user;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'changeActiveChat.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user 
              + '&active_chat=' + element.dataset.user);
    xhr.onload = function() {}
  }


  function changeRequest(element) {
    document.getElementById('loginperson').innerText = "";
    element.style.backgroundColor = "red";
    console.log("Requested: " + element.dataset.user);
    //Compute chat Id wher to save local key
    let activ_user = document.getElementById('user').dataset.user;
    let requested_user = element.dataset.user;
    let chat_id = "" + activ_user + requested_user;
    if (Number(activ_user) > Number(requested_user)) {
      chat_id = "" + requested_user + activ_user;
    }

    let N = generateRSA(chat_id);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'requestChat.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user 
                + '&requested_user=' + element.dataset.user + '&N_public=' + N);
    xhr.onload = function() {console.log(xhr.responseText)}
  }
  
  function acceptGroupRequest(element) {
    element.style.backgroundColor = "red";
    let activ_user = document.getElementById('user').dataset.user;
    let requested_chat = element.dataset.user;

    let N = generateRSA("group_chat" + requested_chat);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'acceptGroup.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user 
              + '&accepted_chat=' + element.dataset.user + '&N_public=' + N);
    xhr.onload = function() {
              console.log(xhr.responseText); 
              document.getElementById('loginperson').innerText = "";
            }
  }
  
  function encrypt_RSA(N_public, data) {
    for (i in data) {
      //add pad to message 
      let padd = "" + pad_seperator + nBitRandom(8);
      data[i] = BigInt("" + data[i] + padd);

      //encrypt
      data[i] = power(data[i], e, N_public).toString();
    }
    return data;
  }

  function acceptRequest(element) {
    element.style.backgroundColor = "red";
    //Compute chat Id whee to save local key
    let activ_user = document.getElementById('user').dataset.user;
    let requested_user = element.dataset.user;
    let chat_id = "" + activ_user + requested_user;
    if (Number(activ_user) > Number(requested_user)) {
      chat_id = "" + requested_user + activ_user;
    }

    //Generate symetrich CHACH20 key and IV and save them:
    let key = (new Array(CHACHA_KEYSIZE).fill().map(() => 
                  Math.floor(65535 * Math.random())));
    let iv = (new Array(CHACHA_IVSIZE).fill().map(() => 
                  Math.floor(65535 * Math.random())));
    localStorage.removeItem(chat_id);
    localStorage.setItem(chat_id + "key", key);
    localStorage.setItem(chat_id + "iv", iv);

    //get public RSA N key:
    var N_public 
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'getKeys.php', false);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user 
            + '&accepted_user=' + element.dataset.user);
    N_public = BigInt(xhr.responseText)

    //encrypt key and iv with RSA
    console.log(N_public)
    console.log(key)
    console.log("HERE")

    key = encrypt_RSA(N_public, key);

    console.log("Key enc: " + key)
    console.log("Iv raw: " + iv)

    iv = encrypt_RSA(N_public, iv);
    console.log("Iv enc: " + iv)

    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'acceptChat.php', true);
    xhr1.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr1.send('activ_user=' + document.getElementById('user').dataset.user 
              + '&N_public=' + N_public + '&accepted_user=' + element.dataset.user 
              + '&key_enc=' + JSON.stringify(key) + '&iv_enc=' + JSON.stringify(iv));
    xhr1.onload = function() {
              console.log(xhr1.responseText); 
              document.getElementById('loginperson').innerText = "";
            }
  }

  function declineRequest(element) {
    element.style.backgroundColor = "red";
    var N_public 
    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'getKeys.php', false);
    xhr1.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr1.send('activ_user=' + document.getElementById('user').dataset.user 
            + '&accepted_user=' + element.dataset.user);
    N_public = BigInt(xhr1.responseText)

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'declineChat.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user 
              + '&declined_user=' + element.dataset.user + '&N_public=' + N_public);
    xhr.onload = function() {
      console.log(xhr.responseText); 
      document.getElementById('loginperson').innerText = "";
    }
  }

  function declineGroupRequest(element) {
    element.style.backgroundColor = "red";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'declineGroupChat.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user 
              + '&declined_user=' + element.dataset.user);
    xhr.onload = function() {
      console.log(xhr.responseText); 
      document.getElementById('loginperson').innerText = "";
    }
  }

  function crypt_chach(chat_id, msg) {
    if (localStorage.getItem(chat_id + "key") === null) {
      return null;
    }
    let key = (Uint16Array.from(localStorage.getItem(
                    chat_id + "key").split(",")).buffer);
    let iv = (Uint16Array.from(localStorage.getItem(
                    chat_id + "iv").split(",")).buffer);
    let g    = new ChaCha(key, iv);
    let v = new Uint8Array(g());
    for (i in msg) {
      if (i > v.byteLength) {
        v = new Uint8Array(g());
      }
      msg[i] = msg[i] ^ v[i];
      }
    return msg;
  }

  function decrypt_rsa(chat_id, msg) {
    var d = localStorage.getItem(chat_id + "d");
    var N_Public = localStorage.getItem(chat_id + "N");
    for (i in msg) {
      msg[i] = power(BigInt(msg[i]), BigInt(d), BigInt(N_Public));
      msg[i] = msg[i].toString().split(pad_seperator)[0];
    }
    return msg;
  }

  function getText() {
    var text = document.getElementById('text').value;
      document.getElementById('text').value = "";

    let activ_user = document.getElementById('user').dataset.user;
    let requested_user = document.getElementById('user').dataset.activ;
    var chat_id = "" + activ_user + requested_user;
    if (Number(activ_user) > Number(requested_user)) {
      chat_id = "" + requested_user + activ_user;
    }
    if (requested_user < 0) {
      chat_id = "group_chat" + requested_user;
    }
    let enc = new TextEncoder();

    text = enc.encode(text);
    text = crypt_chach(chat_id, text);
    if (text === null) {
      document.getElementById("chatarea").innerText = "Encryption keys not found, \
                              wait till other user was active or contact developer";
      return false;
    }

    text = JSON.stringify(Array.from(text));
    var xhr = new XMLHttpRequest(); 
    xhr.open('POST', 'chatdb.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('chat=' + text + '&activ_user=' 
              + document.getElementById('user').dataset.user);
  }

  function setText() {
    let activ_user = document.getElementById('user').dataset.user;
    let requested_user = document.getElementById('user').dataset.activ;
    var chat_id = "" + activ_user + requested_user;
    if (Number(activ_user) > Number(requested_user)) {
      chat_id = "" + requested_user + activ_user ;
    }
    if (requested_user < 0) {
      chat_id = "group_chat" + requested_user;
    }
    var dec = new TextDecoder("utf-8");

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'chatFetch.php', true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send('activ_user=' + document.getElementById('user').dataset.user);
    xhr.onload = function() { 
      all_echo = xhr.responseText;
      if (!(typeof all_echo === 'string' && all_echo.trim().length === 0)) {
        all_echo = all_echo.split(":::");
        let display = [];

        for (i in all_echo) {
          respons = all_echo[i];
          if (respons.includes("\r\n") || respons.trim().length == 0) {
            break;
          }

          if(respons.includes("key1241242:")) {
            let keys = respons.split(":")[2];
            let chat_name_id = respons.split(":")[1]
            keys = JSON.parse(keys);
            keys = decrypt_rsa(chat_name_id, keys);
            localStorage.setItem(chat_name_id + "key", keys);
          }

          else if(respons.includes("iv1241242:")) {
            let ivs = respons.split(":")[2];
            let chat_name_id = respons.split(":")[1]
            ivs = JSON.parse(ivs);
            ivs = decrypt_rsa(chat_name_id, ivs);
            localStorage.setItem(chat_name_id + "iv", ivs);
            }

          else if(respons.includes("Select or request a Chat")) {
            document.getElementById('chatarea').innerText = "Select or request a  \
                                    Chat, if you tried to open a group Chat you \
                                    will need to wait for the group creater to \
                                    send you the keys by loging in himself.";
            }

          else if (respons.includes("msg-!-")){
            respons = respons.replace("msg-!-", "")
            respons = respons.split(";");
            msg = respons[4];
            if (respons.length == 7){
              msg = respons[6];
              }

            msg = Uint8Array.from(JSON.parse(msg));
            msg = crypt_chach(chat_id, msg);
            if (msg === null) {
              document.getElementById("chatarea").innerText = "Encryption keys not \
                                      found, wait till other user was active or \
                                      contact the developer.";
              return false;
            }

            let read;
            if(respons[5] === "1") {
              read = "&#9745;";
            }
            else {
              read = "&#9744;";
            }

            msg = dec.decode(msg);
            display.push("<div><span style='color: " + respons[0] + "; float: " 
                          + respons[1] + ";'> " + read + respons[2] + " " 
                          + respons[3] + ": " + msg + " </span></div><br>");
            if (respons.length == 7){
              display.push("<div><img src='uploads/" + msg 
                        + "' class='chat_image' style='float: " + respons[1] + 
                        "; width: 30vw; padding-left: 1vw; padding-bottom: .5vw;'> \
                        </div><br>");
              }
            document.getElementById('chatarea').innerHTML = display.join("");
            }
          }
        }
      }
  }

  function fileUpload() {
    let file_name = document.getElementById("fileInput").value;
    let activ_user = document.getElementById('user').dataset.user;
    let requested_user = document.getElementById('user').dataset.activ;
    var chat_id = "" + activ_user + requested_user;
    if (Number(activ_user) > Number(requested_user)) {
      chat_id = "" + requested_user + activ_user;
    }
    if (requested_user < 0) {
      chat_id = "group_chat" + requested_user;
    }
    let enc = new TextEncoder();
    file_name = chat_id + ";;" +  file_name.split("\\").slice(-1);
    file_name = enc.encode(file_name);
    file_name = crypt_chach(chat_id, file_name);
    if (file_name === null) {
      document.getElementById("chatarea").innerText = "Encryption keys not found, \
                              wait till other user was active or contact developer";
      return false;
    }
    file_name = JSON.stringify(Array.from(file_name));
    document.getElementById("fileNameEnc").value = file_name;
    console.log(file_name);
    return true;
  }

  setInterval(setText, 500);
  setInterval(users, 500);

  function insert_users(new_div, value) {
    let values = value.split(";");
    let div = document.createElement('div');
    let p = document.createElement('span');
    let button = document.createElement('button');
    let button1 = document.createElement('button');
    div.id = "user";
    p.innerText = values[1];
    button.id = "usr_btn";
    button1.id = "usr_btn";
    button.dataset.user = values[0];
    button1.dataset.user = values[0];
    div.appendChild(p);

    switch(Number(values[2])) {
        case 1:
          p.style.color = "#0099FF";
          p.innerText += " (Online) ";
          break;
        case 2:
          p.style.color = "#009900";
          p.innerText += " (Online) ";
          button.onclick = function() {changeActive(this);};
          button.innerText = "Open Chat";
          div.appendChild(button);
          break;
        case 3:
          p.style.color = "#FF00FF";
          p.innerText += " (Offline) ";
          break;
        case 4:
          p.style.color = "#FF0000";
          p.innerText += " (Offline)";
          button.onclick = function() {changeActive(this);};
          button.innerText = "Open Chat";
          div.appendChild(button);
          break;
        case 5:
          p.style.color = "#009933";
          p.innerText += " (Online) Already Requested ";
          break;
        case 6:
          p.style.color = "#FF0033";
          p.innerText += " (Offline) Already Requested ";
          break;
        case 7:
          p.style.color = "#009900";
          p.innerText += " (Online) ";
          button.onclick = function() {acceptRequest(this);};
          button.innerText = "Accept Request";
          div.appendChild(button);
          button1.onclick = function() {declineRequest(this);};
          button1.innerText = "Decline Request";
          div.appendChild(button1);
          break;
        case 8:
          p.style.color = "#FF0000";
          p.innerText += " (Offline) ";
          button.onclick = function() {acceptRequest(this);};
          button.innerText = "Accept Request";
          div.appendChild(button);
          button1.onclick = function() {declineRequest(this);};
          button1.innerText = "Decline Request";
          div.appendChild(button1);
          break;
        case 9:
          p.style.color = "#009900";
          p.innerText += " (Online) ";
          button.onclick = function() {changeRequest(this);};
          button.innerText = "Request Chat";
          div.appendChild(button);
          break;
        case 10:
          p.style.color = "#FF0000";
          p.innerText += " (Offline) ";
          button.onclick = function() {changeRequest(this);};
          button.innerText = "Request Chat";
          div.appendChild(button);
          break;  
      }
      new_div.appendChild(div);
  }

  function insert_groupchats(new_div, value) {
    let values = value.split("##");
    if (values[3] == "1") {
      fullfillNRequest(values[2], values[0]);
    }

    let div = document.createElement('div');
    let p = document.createElement('span');
    let button = document.createElement('button');
    let button1 = document.createElement('button');
    div.id = "user";
    p.innerText = values[1];
    p.style.color = "#009900";
    button.id = "usr_btn";
    button1.id = "usr_btn";
    button.dataset.user = -1 * Number(values[0]);
    button1.dataset.user = -1 * Number(values[0]);
    
    switch(Number(values[4])) {
      case 0:
        div.appendChild(p);
        button.onclick = function() {acceptGroupRequest(this);};
        button.innerText = "Accept Request";
        div.appendChild(button);
        button1.onclick = function() {declineGroupRequest(this);};
        button1.innerText = "Decline Request";
        div.appendChild(button1);
        break;
      case 1:
        div.appendChild(p);
        button.onclick = function() {changeActive(this);};
        button.innerText = "Open Chat";
        div.appendChild(button);
        break;
      case 2:
        div.appendChild(p);
        p.style.color = "#0099FF";
        break;
      case 3:
        break;
    }
    new_div.appendChild(div);
  }

  function users() {
    


    var text = (document.getElementById('loginperson').innerText
               .replace(/(\r\n|\n|\r)/gm, ""));
    text = "";
    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'userFetch.php', true);
    xhr1.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr1.send('activ_user=' + document.getElementById('user').dataset.user 
              + '&already_fetched=' + text);
    xhr1.onload = function() {
      if (xhr1.responseText) {
        let loginperson_usr = document.getElementById('loginperson_usr');
        var usr_new = document.createElement('div');
        usr_new.id = "loginperson_usr";
        let values = xhr1.responseText.split("::");
        values.shift();
        values.forEach(function (value) {insert_users(usr_new, value)});
        if (usr_new != loginperson_usr && loginperson_usr != null) {
          document.getElementById('loginperson_usr').replaceWith(usr_new);
        }
        else if (loginperson_usr == null) {
          document.getElementById('loginperson').appendChild(usr_new);
        }
      }
    }

    var xhr2 = new XMLHttpRequest();
    xhr2.open('POST', 'groupChatsFetch.php', true);
    xhr2.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr2.send('activ_user=' + document.getElementById('user').dataset.user 
              + '&already_fetched=' + text);
    xhr2.onload = function() { 
      if (xhr2.responseText) {
        let loginperson_groups = document.getElementById('loginperson_groups');
        var groups_new = document.createElement('div');
        groups_new.id = "loginperson_groups";
        let values = xhr2.responseText.split("::");
        values.shift();
        values.forEach(function (value) {insert_groupchats(groups_new, value)});
        if (groups_new != loginperson_groups && loginperson_groups != null) {
          document.getElementById('loginperson_groups').replaceWith(groups_new);
        }
        else if (loginperson_groups == null) {
          document.getElementById('loginperson').appendChild(groups_new);
        }
      }
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
  <a href="index.php">Home</a>
  <a href="Klettern.php">Klettern</a>
  <a href="Amateurfunk.php">Amaterufunk</a>
  <a href="Samariter.php">Samariter</a>
  <a href="Feuerwehr.php">Feuerwehr</a>
  <a href="Pfadi.php">Pfadi</a>
  <a href="Operateur.php">Operateur</a>
  <a href="practice.php" class="active">Chat</a>

  <div class="darkmode_button">
    <input type="checkbox" id="darkmode" name="darkmode" value="darkmode" 
            oninput="setDarkmodeCookie()" checked>
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
    $_SESSION['user_id'] = $user_id;
    $activ_chat          = $result['active_chat'];
    echo "Aktueller Benutzer: <span id='user' data-activ='$activ_chat' 
          data-user='$user_id'>$name</span>";
  ?>
  <form action="">
    <input type="submit" name="logout" value="Logout">
    <br>
    <input type="submit" name="create_group" value="Create new Group">
  </form>
</div>
<div class="chat_container">
  <div id="chatbox">
    <div id="chatarea"></div>

    <div id="textbox">
      <form>
        <textarea rows="4" cols="100" id="text" 
              onkeyup="if(event.keyCode==13) {getText()}"></textarea>
        <input type="button" value="send" onclick="getText()" />
      </form>

      <form action="uploadHandler.php" onSubmit="return fileUpload()"
            method="post" enctype="multipart/form-data">
        Select Image to upload:
        <input type="file" id="fileInput" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
        <input type='hidden' id='activ_user' name='activ_user' value="Default">
        <input type='hidden' id='fileNameEnc' name='fileNameEnc' value="Default">
      </form>
      <?php if (isset($_GET['error'])) {
            ?><?php echo $_GET['error'];
      }?>
       <!--Script changes input field with id of active user  -->
      <script>
        document.getElementById('activ_user').value = (document.
                                            getElementById('user').dataset.user);
      </script>
    </div>
  </div>
  <div id="loginperson"> 
    <div id="loginperson_usr"></div>
    <div id="loginperson_groups"></div>
  </div>
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
