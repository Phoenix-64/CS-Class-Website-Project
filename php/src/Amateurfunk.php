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
        <a href="Klettern.php">Klettern</a>
        <a href="Amateurfunk.php" class="active">Amaterufunk</a>
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
            <h1> Amateurfunk</h1>
            <hr>
        </div>
        <div class="item"><script type="text/javascript">cookie_notice();</script></div>
        
        <div class="item">
            <h2>SSB Transciever Projekt</h2>
            <p>
                Mich faszinierte am Amateurfunk schon immer der praktische Teil am meisten. Deshalb beschloss ich kurz nach der HB3 Prüfung das Upgrade auf HB9 zu machen damit ich so richtig anfangen kann mit Basteln. Die Maturaarbeit bot mir die Gelegenheit, die Theorie in die Praxis umzusetzen und ein Funkgerät selbst zu bauen. Dies stellte sich als wesentlich ambitionierter heraus als gedacht. Ich fing im Dezember 2021 an mir Gedanken zu machen wie ich mein noch sehr limitiertes und theoretisches Wissen erweitern und endlich Hardware aufbauen könnte. Es stellte sich mit der Zeit heraus dass Theorie und Praxis ganz und gar nicht deckungsgleich sind. Das Zeichnen der Schaltungen war schnell gemacht, doch was im "Moltrecht" fehlte waren konkrete Berechnungen. Deshalb machte ich mich auf die Suche im Internet und merkte schnell, dass jeder etwas anderes erzählt, aber niemand wirklich alles von Grund auf erklärt. Doch mit etwas Hilfe vom Verein HB9CL gelangen nach einiger Zeit die ersten Versuche und alles begann sich ineinander zu fügen. 
            </p><p>
                Mikrofoneingang und Mischer waren nach einigen Versuchen und Rückschlägen dann funktionsfähig.
                Aber vorallem der Oszillator wehrte sich noch widerspenstig. Das Signal wurde begleitet von unzähligen Nebenspitzen. Es stellte sich heraus dass ich den Kupplungskondensator zwischen dem Collpits- Quarz-Oszillator und dem Puffertransistor vergessen hatte. Dies führte dazu das über den Quarz ein DC Strom zur Erde floss. Das erzeugte die Verzerrungen. Außerdem ließ ich zur Vereinfachung die Impedanzanpassung der einzelnen Komponenten weg. Im Nachhinein zeigte sich das unteranderem dadurch, dass die Leistung zu gering für eine effektive Abstrahlung war. Dabei half nicht, dass ich keine IF Verstärker verwendete. Durch diese geringen Leistungen entstanden außerdem Probleme im Double Balanced Mixer welchen ich zur Modulation verwendete. Die dortigen Dioden benötigen durch ihre relativ hohe Vorwärtsspannung von 0.7 Volt eine stärkere Ansteuerung, da sie sonst nicht korrekt schalten und weitere Verzerrungen erzeugen. Dies war vorallem problematisch beim Empfangsteil da ich hier erst nach der Demodulation verstärkt habe. Im Nachhinein wäre ein Aufbau mit einem IF Verstärker jeweils vor und hinter dem Crystal Ladder Filter wesentlichen effektiver. Diesen Filter versuchte ich zuerst mithilfe einer Webseite zu berechnen, was jedoch nicht funktionierte. Deshalb entschied ich mich, einfach für alle Kondensatoren 68pF zu verwenden. Das funktionierte auf Anhieb, lieferte jedoch eine etwas zu geringe Bandbreite. Diese könnte jedoch durch Vergrößern der Kondensatoren noch ohne Probleme angepasst werden.  
            </p><p>
                Diese und viele weiter Verbesserungen möchte ich im Laufe der nächsten Zeit noch umsetzen um hoffentlich bald schon mein erstes erfolgreiches QSO mit meinem eigenen Transceiver halten zu können. Denn durch diese Maturaarbeit habe ich erst gemerkt was wir Amateurfunker alles machen dürfen und vorallem können, und freue mich schon auf all die Projekte die noch vor mir liegen. An Möglichkeiten und Ideen mangelt es sicher nicht. Ich kann allen nur empfehlen einmal diese Seite unseres Hobbys zu erkunden und einen Bausatz aufzubauen, oder sogar einen selbst zu entwickeln. Das bietet ganz neue Einsichten, ist ein wichtiger Teil unserer Möglichkeiten und darf nicht vergessen gehen. So wünsche ich allen ein schönes Basteln und Funken und freue mich auf ein weiteres Jahr voller  QSOs.
            </p>
            <br>
            <form method="get" action="Benjamin-Maturaarbeit.pdf">
                <button type="submit">Maturaarbeit Herunterladen</button>
            </form>
            <br>
            <div class="flex-container">
                <div class="flex-item">
                    <img src="pictures/IMG-20220522-WA0000.jpg" alt="FFT Diagramm eines Oszillator versuches mit vielen Nebenspitzen" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/IMG_20220414_172528_2.jpg" alt="Erster Mikrofohn verstärker aufbau." >
                </div>
                <div class="flex-item">
                    <img src="pictures/IMG_20220426_220953_1.jpg" alt="12V China Powersupply Board" >
                </div>
                <div class="flex-item">
                    <img src="pictures/IMG_20220516_082638.jpg" alt="LC OpAmp Oszillator" >
                </div>
                <div class="flex-item">
                    <img src="pictures/IMG_20220527_165817.jpg" alt="Tiny Tiney SMD Kondensatoren" >
                </div>
                <div class="flex-item">
                    <img src="pictures/IMG_20220530_225609_1.jpg" alt="Mein Arbeitsplatz" >
                </div>
                <div class="flex-item">
                    <img src="pictures/IMG_20220618_000001_1.jpg" alt="Signal generator Board mit Arduino" >
                </div>
                <div class="flex-item">
                    <img src="pictures/IMG_20220618_211142_1.jpg" alt="Quarz Mess aufsatz für nanoVNA" >
                </div>
                <div class="flex-item">
                    <img src="pictures/IMG_20220712_110231_1.jpg" alt="Wir ziehen die Steigeisen an" >
                </div>
                <div class="flex-item">
                    <img src="pictures/1670006601822.jpg" alt="Fertiger Transciever" >
                </div>
                <div class="flex-item">
                    <img src="pictures/recieve.png" alt="Empfänger ausgang eines 1kHz signals" >
                </div>
            </div>
            <hr>
        </div>    
        <div class="item">
            <h2>Sonstige Aktivitäten</h2>
            <div class="flex-container">
                <div class="flex-item">
                    <img src="pictures/1672311533961.jpg" alt="Nacht aktivität" >
                </div> 
                <div class="flex-item">
                    <img src="pictures/1672311533874.jpg" alt="Fieldday Camping" >
                </div> 
            </div>
            <hr>
        </div> 
        <div class="item">
            <h2>Hilfreiche Links</h2>

            <a href="https://www.hamqsl.com/solar.html" title="Click to add Solar-Terrestrial Data to your website!"><img src="https://www.hamqsl.com/solar101vhfpic.php" style="width: 50vw;"></a>
            <!--Integraton of QRZ Lookup-->
            <script type="text/javascript">
                function searchQRZ() {
                    var cs = document.getElementById('call').value;
                    window.open('https://www.qrz.com/lookup/' + cs,'','height=800,width=700',true);
                    document.getElementById('call').value = '';
                
                }
            </script>
            <table cellpadding="9" border="0" cellspacing="0" style="border:solid 1px #000;background-color:#333">
                <tr><td valign="center">
                <b>QRZ callsign lookup:</b>
                <input type="text" id="call" size="8" />
                <button onClick="searchQRZ();">Search<button>
                <div style="text-align:right;font-size:0.7em">
                Callsign lookups provided by <a href="https://www.qrz.com">qrz.com</a>
                </div>
                </td></tr>
            </table>
        </div>
        <div class="item"><hr></div>
    </div>
</body>
</html>

