<?php

  class User  {
    
    private $conn;
    public $errors = [];

    function __construct() {
      $db = new Dbh;
      $this->conn = $db->connect();
    }

    public function login(string $email, string $password) : bool {

      $sql = "SELECT * FROM users WHERE email='$email' AND password='$password';";

      $result = $this->conn->query($sql);

      if ($result->rowCount() > 0) {
        $_SESSION['email'] = $email;
        return true;
      } else {
        return false;
      }
    }

    public function register(string $email, string $password) {

      $sql = "INSERT INTO users(email, password)VALUES('$email', '$password');";
      $result = $this->conn->query($sql);

      return $result;
    }

    public function isLoggedIn() : bool {
      if (isset($_SESSION['email'])) {
        return true;
      } else {
        return false;
      }
    }

    

    public function restrictPage() {
      if (!isset($_SESSION['email'])) {
        header('Location: login.php?error=Du måste vara inloggad.');
        exit;
      }
    }

    public function logout() {
      session_destroy();
      header('Location: login.php');
      exit;
    }

    public function validate(string $email, string $password) {
      $errors = [];

      if (strlen($email) > 128) {
        $errors[] = '<p>Your email address is too long.</p>';
      }
      if (strlen($password) > 256) {
        $errors[] = '<p>Your password is too long.</p>';
      }
      if (strlen($password) < 6) {
        $errors[] = '<p>Your password needs to be at least 6 characters.</p>';
      }

      $sql = "SELECT * FROM users WHERE email='$email';";

      $result = $this->conn->query($sql);

      if ($result->rowCount() > 0) {
        $_SESSION['email'] = $email;
        $errors[] = '<p>This email is already registered. If you have an account already, please login.</p>';
      }

      return $errors;
    }
  }