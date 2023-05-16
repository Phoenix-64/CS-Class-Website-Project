<?php
session_start();
require_once 'config.php';
if (isset($_SESSION["email"])) {
    $sql  = "UPDATE user SET user_status='0' WHERE user_email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION["email"]);
    $stmt->execute();
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">

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
        <a href="index.php">Home</a>
        <a href="Klettern.php" class="active">Klettern</a>
        <a href="Amateurfunk.php">Amaterufunk</a>
        <a href="Samariter.php">Samariter</a>
        <a href="Feuerwehr.php">Feuerwehr</a>
        <a href="Pfadi.php">Pfadi</a>
        <a href="Operateur.php">Operateur</a>
        <a href="practice.php">Chat</a>

        <div class="darkmode_button">
            <input type="checkbox" id="darkmode" name="darkmode" value="darkmode" oninput="setDarkmodeCookie()" checked>
            <label for="darkmode"> Enable Darkmode</label>
        </div>
    </div>


    

    <div class="container">
        <div class="item">
            <h1> Outdoor Aktivitäten</h1>
            <hr>
        </div>

        <div class="item"> <script type="text/javascript">cookie_notice();</script> </div>

        <div class="item">
            <h2> Wildstrubel Tour</h2>
            <p>
                Im rahmen der Projektwoche sind wir von der Lämmerenhütte Hütte aus auf den Wildstrubel gelaufen. 
                Obwohl zeitlich nicht notwendig sind wir im Dunkeln gestartet um den Wunderschönen Sonnenaufgang mitzuerleben. 
                Beim ersten Sonnenschein gelangten wir dann an den rand des gletschers und wir bereiteten uns auf desen überquerung vor.
                Für viele war das die erste Tour über einen Gletscher, und auch das Laufen mit Steigeisen am Seil musste erst noch geübt werden.
                Der Sommer hatte dem Gletscher sehr zugesetzt, es entstanden sehr viele spalten so das unser Bergführer entschied einen neuen Weg zu wählen welcher den schweirigsten teil des Gletschers über eine bereits freigelegte Felspartie umgieng.
                Etwas später stellte sich das als sehr vorausschauend aus den etwwas weiter oben stiessen wir erneut auf grosse spalten die uns einige Probleme bereiteten.
                Doch schon nach drei Stunden gelangten wir zum Gipfel und genosen die Aussicht von Frankreich bis nach Italien, der Bergfühere hatte uns perfektes Wetter ohne ein einziges Wölkchen organisiert.
                Und nach kurzer Mittagspause begann der Abstieg. Hier wurde dann vermehrt sichtbar das dies die erste solche Tour vieler war,
                einige hatten nasse Schuhe, kalte Finger, und auch das steile Bergablaufen auf dem Gletscher stellte sich für einige als mental schweirig heraus da hier einfach auf die Steigeisen vertraut werden muss.
                Doch nach insgesamt etwa fünfeinhalb Stunden waren wir glücklich und munter wieder bei der Hütte und hatten sogar noch einen Adler sowie Steinböcke und Geissen gesehen. 
                Dann hörten wier noch wie sich die dortige Schulgruppe welche zum Alpenlernen auch auf der Hütte residierte darüber nörgelte das sie einen 30 minütigen Spaziergang machen müssen, wir konnten nur noch darüber lachen. 
            </p>
            <iframe src='https://map.geo.admin.ch/embed.html?lang=de&topic=ech&bgLayer=ch.swisstopo.pixelkarte-farbe&layers=ch.swisstopo.zeitreihen,ch.bfs.gebaeude_wohnungs_register,ch.bav.haltestellen-oev,ch.swisstopo.swisstlm3d-wanderwege,ch.astra.wanderland-sperrungen_umleitungen,KML%7C%7Chttps:%2F%2Fpublic.geo.admin.ch%2Fapi%2Fkml%2Ffiles%2FmZRXB7ukS_W0OlHU6Pol5A&layers_opacity=1,1,1,0.8,0.8,1&layers_visibility=false,false,false,false,false,true&layers_timestamp=18641231,,,,,&E=2608681.90&N=1139273.30&zoom=8'  frameborder='0' style='border:0' allow='geolocation'></iframe>
            
            <div class="flex-container">
                <div class="flex-item">
                    <img src="pictures/IMG_7719.png" alt="Wir ziehen die Steigeisen an" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/IMG_7733.png" alt="Gut angekommen auf dem Gipfel" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/Wildstrubel2.png" alt="Aussicht vom Gipfel" >
                </div> 
            </div>
            
        </div>

        <div class="item"><hr></div>

        <div class="item">
            <h2> Aréttes des Sommetres Tour</h2>
            <p>
                Da ich mich für einen Jugend und Sprot Bergsteigerkurs im Frühling angemeldet habe brauche ich noch ein paar Bergtouren.
                Im November lag jedoch fast überall in den ALpen bereits Schnee so das wir auf eine kleine gemischte Tour im Jura aussgewichen sind,
                welche wir mit der JO des SAC Biel schon oft gemacht hatten. Mit 4 grad Celsius und einem fast wolkenfreien Himmel war das Wetter wesentlich besser als vorhergesagt
                und wir wurden nur von einem ganz Kleinen Niselregen unterbrochen. Das Panorama war herlich und wir sind am kuzen Seil sehr gut vorangekommen. 
                Doch nach etwa einem drittel der Tour kahmen wir zu einem leicht überhängendem etwa zwei meter horen absatz, leider entschieden wir uns herunterzuspriengen.
                Da jedoch alles voller nassen Blettern war rutschten wir aus und mein Kolege verstauchte sich die Zehen. 
                Dies führte leider dazu das wir ab etwa der hälfte den rest der Tour an der nord west Seite umgiengen und auch das schlusstück nciht mehr machten.
                Wir wahren sehr froh eine Tour gewählt zu haben welche dieses umgehen einfach zulässt, und werden nächsten fühling sicher wieder zurück kommen um die Tour ganz zu machen.
                Denn der herliche Jura fels welcher in diesem bereich noch nicht abgegriffen ist hatt wiedermal ein kleines Feuer in uns erweckt.
            </p>
            <iframe src='https://map.geo.admin.ch/embed.html?lang=de&topic=ech&bgLayer=ch.swisstopo.pixelkarte-farbe&layers=ch.swisstopo.zeitreihen,ch.bfs.gebaeude_wohnungs_register,ch.bav.haltestellen-oev,ch.swisstopo.swisstlm3d-wanderwege,ch.astra.wanderland-sperrungen_umleitungen,KML%7C%7Chttps:%2F%2Fpublic.geo.admin.ch%2Fapi%2Fkml%2Ffiles%2FrG2ddPdlTrW-bIIDYqv7nQ&layers_opacity=1,1,1,0.8,0.8,1&layers_visibility=false,false,false,false,false,true&layers_timestamp=18641231,,,,,&E=2563807.88&N=1231791.80&zoom=9'  frameborder='0' style='border:0' allow='geolocation'></iframe>
            <div class="flex-container">
                <div class="flex-item">
                    <img src="pictures/1670347103834.jpg" alt="Den bereits zurückgelegten weg" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1670347103892.jpg" alt="Ich und mein Kolege beim mittagesen" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1670347103900.jpg" alt="Aussicht nach Frankreich" >
                </div> 
            </div>
        
        </div>
        
        <div class="item"><hr></div>
        <div class="item">
            <h2> Herbstlager 2022 Engelhörner</h2>
            <p>
                Danke JO Biel, und ganz vorallem den Leitern, für dieses unvergessliche Herbstlager in einer für mich schweren Zeit.
            </p>
/           <div class="flex-container">
                <div class="flex-item">
                    <img src="pictures/1672311533823.JPG" alt="Auf dem Weg zur Hütte" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533768.jpeg" alt="Sonnenuntergang von der Hütte aus" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533774.jpeg" alt="Berg dürch den Berg" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533780.JPG" alt="Mal wieder eine Merseillänge vorsteigen" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533785.jpg" alt="Gruppenfoto Chaos" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533791.jpg" alt="Gruppenfoto normal" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533795.jpg" alt="Scetchy stand" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533802.jpg" alt="Rucksack nächstesmal nicht so voll machen okay" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533808.JPG" alt="Go du schaffst das" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533813.JPG" alt="Hier oben ist es schön" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533817.jpg" alt="Was ein SOnnenuntergang" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533832.jpg" alt="Abseilen mit Karabinernern 1" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533841.jpeg" alt="Abseilen mit Karabinernern 2" >
                </div> 
            </div>
        </div>
        <div class="item"><hr></div>
    </div> 

</body>
</html>

