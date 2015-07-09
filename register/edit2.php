<?php
/*
  Script, um Knoten des Stormarner Freifunk Gateways zu editieren.
  arnim wiezer (arnim@posteo.de) 03/2014
*/

require('include.php');

echo "<html><head><title>Freifunk Stormarn</title></head><body>";
echo "<img src='ffod.png'><hr><p>";


if (empty($_POST) or empty($_POST['key'])) {
  $_POST['key'] = "";
  echo "<table>";
  echo "<form action='edit2.php' method='post'>
    <tr><td>Router Schl&uuml;ssel:</td><td><input type='text' size='65' name='key' value='", $_POST['key'], "' /></td></tr>
    <tr><td><input type='submit' name='submit' value='OK' /></td></tr>
    </form></table>";
} elseif ($_POST['submit'] == "OK" and !empty($_POST['key'])) {
  
  $data = get_node_by_key(htmlspecialchars($_POST['key']));
  if (empty($data['knoten_id'])) {
     echo "Leider konnte dem eingegebenen key kein Knoten zugeordnet werden.<p>";
     echo "Unter <a href='http://register.stormarn.freifunk.net/meine_knoten.php'>diesem link</a> kannst Du eine List der auf Dich registrierten Knoten anfordern.<p>";
     exit;
  }

  echo "<table>";
  echo "<form action='edit2.php' method='post'>
  <tr><td>Name des Knotens:</td><td><input type='text' size='35' name='name' value='", $data['name'], "'/></td></tr>
  <tr><td>Vorname:</td><td><input type='text' size='20' name='firstname' value='", $data['firstname'], "' /></td><td></tr>
  <tr><td>Nachname:</td><td><input type='text' size='20' name='lastname' value='", $data['lastname'], "' /></td><td></tr>
  <tr><td>E-Mail:</td><td><input type='text' size='40' name='email' value='", $data['email'], "' /></td><td></tr>
  <tr><td>Router Schl&uuml;ssel:</td><td>", $data['key'], "</td></tr>
  <tr><td>Standort des Knotens:</td><td><input type='text' size='65' name='location' value='", $data['location'], "' /></td></tr>
  <tr><td><input type='submit' name='submit' value='&Auml;nderungen speichern' /></td><td>", errortext("Achtung: Es gibt keine weiter Nachfrage. Die Daten werden so geschrieben."), "</td></tr>
  <input type='hidden' name='key' value='", $data['key'], "'>
  <input type='hidden' name='knoten_id' value='", $data['knoten_id'], "'>
  </form></table>";
} elseif ($_POST['submit'] == "&Auml;nderungen speichern") {

  if (update_key($_POST)) {
    echo "Die Daten wurden erfolgreich ge&auml;ndert.";
  } else {
    echo "Es ist ein Fehler aufgetreten. Mehr Details stehen leider nicht zur Verf&uuml;gung.";
  }
}

foot();
?>