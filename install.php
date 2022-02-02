<?php
  include('includes/config.php');
  // Anslut
  $db = new Dbh;
  $conn = $db->connect();

  // Skapa tabell
  $sql = 'CREATE TABLE users(
    email VARCHAR(128) NOT NULL PRIMARY KEY,
    password VARCHAR(256) NOT NULL,
    created_date timestamp NOT NULL DEFAULT current_timestamp()
  );';

  // Skicka
  echo '<pre>';
  var_dump($conn);
  echo '</pre>';
  if($conn->query($sql)) {
    echo 'Table installed.';
  } else {
    echo 'Table installation error.';
  }
?>