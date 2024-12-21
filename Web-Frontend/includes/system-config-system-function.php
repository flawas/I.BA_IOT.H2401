
<?php 

require '../config.php';

// Create connection
$db_connect = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

if (!isset($_POST['logEnabled'])) {
  $sql = ("UPDATE config SET value = '0' WHERE configname = 'LogEnabled';");
} else {
  $sql = ("UPDATE config SET value = '1' WHERE configname = 'LogEnabled';");
}

if ($db_connect->query($sql) === TRUE) {
  echo "Updated record successfully";
  header('Location: ../configuration.php?text=Einstellungen gespeichert!&status=success');
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  header('Location: ../configuration.php?text=Einstellungen nicht gespeichert!&status=error');
}

?>