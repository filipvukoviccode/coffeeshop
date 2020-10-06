<?php
  $servername = "localhost";
  $username = "filip"; // Username for database access
  $password = "test123"; // Database password
  $dbname = "cfs"; // Database name
  $port = "3306"; // Port number

  $conn = new mysqli($servername, $username, $password, $dbname, $port);

  if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }
?>
