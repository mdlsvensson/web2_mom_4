<?php

class Dbh {

  private $host;
  private $username;
  private $password;
  private $dbname;
  private $port;

  public function query($sql) {
    $this->host = '127.0.0.1';
    $this->username = 'root';
    $this->password = '';
    $this->dbname = 'blogdb';
    $this->port = '3306';

    try {
      $dsn = 'mysql:dbname=' . $this->dbname . ';host=' . $this->host . ';port=' . $this->port;
      $pdo = new PDO($dsn, $this->username, $this->password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $result = $pdo->query($sql);
      return $result;
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }
}