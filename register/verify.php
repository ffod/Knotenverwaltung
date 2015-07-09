<?

require('include.php');

if (empty($_GET['email']) or empty($_GET['hash']) or empty($_GET['node'])) {
  echo "No input no cry.";
  exit;
}

echo "<html><head><title>Freifunk Stormarn</title></head><body>";
echo "<img src='ffod.png'><hr><p>";


$tmp = get_node_by_name($_GET['node']);

// Hash mit DB vergleichen
if ($tmp['email'] == $_GET['email'] and $tmp['delhash'] == $_GET['hash'] and $tmp['name'] == $_GET['node']) {
  if (del_node($tmp['knoten_id']) == 1) {
    echo "Danke. Der Knoten wurde gel&ouml;scht und wird in den n&auml;chsten 10 Minuten automatisch aus dem Netz entfernt.";
  } else {
    echo "Leider ist ein Fehler aufgetreten. Der Knoten wurde nicht gel&ouml;scht. Wende Dich bitte an info@stormarn.freifunk.net";
  }
} else {
  echo "Tut mir leid.";
  echo "</body></html>";
  exit;
}

echo "</body></html>";

?>