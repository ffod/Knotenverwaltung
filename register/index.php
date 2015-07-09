<?php
/*
  Script, um neue Knoten auf dem Stormarner Freifunk Gateway einzutragen.
  arnim wiezer (arnim@posteo.de) 03/2014
*/

require('include.php');
$firnameErr = $lastnameErr = $mailErr = $keyErr = $locationErr = $nameErr = "";
$firname = $lastname = $mail = $key = $location = $name = "";
$checkOK = true;

echo "<html><head><title>Freifunk Stormarn</title></head><body>";
echo "<a href='index.php'><img src='ffod.png'></a><hr><p>";

if(empty($_POST)) {
  echo "<h2>Willkommen beim Freifunk Stormarn!</h2>";
  echo "Sch&ouml;n, da&szlig; Du mitmachen m&ouml;chtest. Bitte trag Deine Informationen hier ein damit wir Deinen Freifunk-Knoten aktivieren k&ouml;nnen.";
  echo "F&uuml;lle bitte alle Felder aus. Die Informationen bleiben beim Freifunk Stormarn und werden an niemanden weitergegeben.";
  $button = "OK";

} else {  
  $button = "Absenden!";

  // Inhalte &uuml;berpr&uuml;fen
  if (empty($_POST["name"])) {
    $nameErr = errortext("* Der Name des Knoten wird ben&ouml;tigt.");
    $checkOK = false;
  } else {$name = test_input($_POST["name"]);}

  if (preg_match("/[\#\$\%\&]/", $_POST["name"]) or strpos($_POST["name"], " ") != false) {
    $nameErr = errortext("* Der Name darf keine Whitespace-Zeichen (wie z.B. Leerzeichen) oder # enthalten.");
    $checkOK = false;
  }

  if (empty($_POST["firstname"])) {
    $firstnameErr = errortext("* Vorname wird ben&ouml;tigt.");
    $checkOK = false;
  } else {$firstname = test_input($_POST["firstname"]);}

  if (empty($_POST["lastname"])) {
    $lastnameErr = errortext("* Nachname wird ben&ouml;tigt.");
    $checkOK = false;
  } else {$lastname = test_input($_POST["lastname"]);}
  
  if (empty($_POST["mail"])) {
    $mailErr = errortext("* Email wird ben&ouml;tigt.");
    $checkOK = false;
  } else {$mail = test_input($_POST["mail"]);}

  if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $mail)) {
    $mailErr = errortext("* Ung&uuml;ltiges E-Mail Format.");
    $checkOK = false;
  }

  if (empty($_POST["key"])) {
    $keyErr = errortext("* Der &ouml;ffentliche Schl&uuml;ssel des Knoten wird ben&ouml;tigt.");
    $checkOK = false;
  } else {$key = test_input($_POST["key"]);}
  
  if (empty($_POST["location"])) {
    $locationErr = errortext("* Der Standort wird ben&ouml;tigt.");
    $checkOK = false;
  } else {$location = test_input($_POST["location"]);}

}

if ($checkOK == false or empty($_POST['submit']) or $_POST['submit'] == "OK" ) {
  if ($checkOK == false or $_POST['submit'] == "OK") {
    echo "Du hast folgende Informationen eingetragen. Bitte pr&uuml;fe noch mal alles auf Richtigkeit und korrigiere bei Bedarf falls n&ouml;tig!";
  }
  echo "<table>";
  echo "<form action='index.php' method='post'>
    <tr><td>Name des Knotens:</td><td><input type='text' size='35' name='name' value='", $name, "' /> (selbst gew&auml;hlt oder die Vorgabe der Konfigurationsseite. Aber bitte ohne Leerzeichen und #)</td><td>", $nameErr ,"</td></tr>
    <tr><td>Vorname:</td><td><input type='text' size='20' name='firstname' value='", $firstname, "' /></td><td>", $firstnameErr, "</td></tr>
    <tr><td>Nachname:</td><td><input type='text' size='20' name='lastname' value='", $lastname, "' /></td><td>", $lastnameErr, "</td></tr>
    <tr><td>E-Mail:</td><td><input type='text' size='40' name='mail' value='", $mail, "' /></td><td>", $mailErr,"</td></tr>
    <tr><td>Router Schl&uuml;ssel:</td><td><input type='text' size='65' name='key' value='", $key, "' /></td><td>", $keyErr, "</td></tr>
    <tr><td>Standort des Knotens:</td><td><input type='text' size='65' name='location' value='", $location, "' /> (z.B. Stra&szlig;e und Ort. Die GPS-Daten werden nur auf dem Knoten selber eingetragen.)</td><td>", $locationErr ,"</td></tr>
    <tr><td><input type='submit' name='submit' value='", $button, "' /></td></tr>
    </form></table>";
  
} else {

  echo "<h2>Fertig!</h2>";
  echo "Dein neuer Freifunk Knoten wurde mit folgen Informationen registriert und sollte in wenigen Minuten funktionieren.";
  echo "<table>";
  echo "<form action='index.php' method='post'>
    <tr><td>Name des Knotens (wie auf der Konfigurationsseite angegeben!):</td><td>", htmlspecialchars($_POST['name']), "</td></tr>
    <tr><td>Vorname:</td><td>", htmlspecialchars($_POST['firstname']), "</td></tr>
    <tr><td>Nachname:</td><td>", htmlspecialchars($_POST['lastname']), "</td></tr>
    <tr><td>E-Mail:</td><td>", htmlspecialchars($_POST['mail']), "</td></tr>
    <tr><td>Router Schl&uuml;ssel:</td><td>", htmlspecialchars($_POST['key']), "</td></tr>
    <tr><td>Standort des Knotens:</td><td>", htmlspecialchars($_POST['location']), "</td></tr>
  </form></table>";
  if (write_key($_POST) == 0) {
    echo "<p>Knoten wurde erfolgreich eingetragen!<p>";
  } else {
    echo "<p>Leider ist ein Fehler aufgetreten: Es existiert bereits ein andere Knoten mit demselben Schl&uuml;ssel oder Namen.<p>";
  }
} 


foot();
?>
