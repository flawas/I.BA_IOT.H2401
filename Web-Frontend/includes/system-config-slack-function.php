
<?php 

require '../config.php';

// Create connection
$db_connect = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

$slackThreesholdTemp = $_POST['slackThreesholdTemp'];
$slackThreesholdHum = $_POST['slackThreesholdHum'];

if (!isset($_POST['slackEnabled'])) {
  $sql = ("UPDATE config SET value = '0'  WHERE configname = 'SlackEnabled';");
} else {
  $sql = ("UPDATE config SET value = '1' WHERE configname = 'SlackEnabled';");
}

$sql .= ("UPDATE config SET value = '$slackThreesholdTemp' WHERE configname = 'SlackThreesholdTemp';");
$sql .= ("UPDATE config SET value = '$slackThreesholdHum' WHERE configname = 'SlackThreesholdHum';");

echo $sql;

if (mysqli_multi_query($db_connect, $sql)) {
  do {
    // Store first result set
    if ($result = mysqli_store_result($db_connect)) {
      while ($row = mysqli_fetch_row($result)) {
        printf("%s\n", $row[0]);
      }
      mysqli_free_result($result);
    }
    // if there are more result-sets, the print a divider
    if (mysqli_more_results($db_connect)) {
      printf("-------------\n");
    }
     //Prepare next result set
  } while (mysqli_next_result($db_connect));
    header('Location: ../configuration.php?text=Einstellungen gespeichert!&status=success');
} else {
  
  header('Location: ../configuration.php?text=Einstellungen nicht gespeichert!&status=error');
} 

?>
