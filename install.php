<?php
  include('includes/config.php');
  // Anslut
  $db = new Dbh;

  // Skapa tabell
  $sql = 'CREATE TABLE users(
    email VARCHAR(128) NOT NULL PRIMARY KEY,
    password VARCHAR(256) NOT NULL,
    created_date timestamp NOT NULL DEFAULT current_timestamp()
  );
  CREATE TABLE blog(
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title TEXT NOT NULL,
    content TEXT NOT NULL,
    postdate timestamp NOT NULL DEFAULT current_timestamp()
  );';

  // Skicka
  if($db->query($sql)) {
    echo 'Table installed.';
  } else {
    echo 'Table installation error.';
  }
?>