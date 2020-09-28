<?php
  $servername = "localhost";
  $username = "filip"; // Korisnicko ime za pristup bazi
  $password = "test1234"; // Lozinka baze
  $dbname = "cfs"; // Naziv baze podataka
  $port = "3306"; // Naziv baze podataka

  $conn = new mysqli($servername, $username, $password, $dbname, $port);

  if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }
?>
