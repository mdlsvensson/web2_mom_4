<?php

// Database handler class with PDO
class Dbh {

  private $host;
  private $username;
  private $password;
  private $dbname;
  private $port;

  // Main query function
  public function query($sql) {
    // Assigning values
    $this->host = '127.0.0.1';
    $this->username = 'root';
    $this->password = '';
    $this->dbname = 'blogdb';
    $this->port = '3306';

    // Database connection
    try {
      // DSN
      $dsn = 'mysql:dbname=' . $this->dbname . ';host=' . $this->host . ';port=' . $this->port;
      // Creating PDO connection
      $pdo = new PDO($dsn, $this->username, $this->password);
      // Setting error mode for PDO to throw exceptions
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // Sending query and returning the result
      $result = $pdo->query($sql);
      return $result;
      // Catch errors and echo to the screen
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }
}