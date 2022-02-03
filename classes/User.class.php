<?php

  class User  {
    
    private $db;
    public $errors = [];

    function __construct() {
      $this->db = new Dbh;
    }

    public function login(string $email, string $password) : bool {

      $sql = "SELECT * FROM users WHERE email='$email';";

      $result = $this->db->query($sql);

      if ($result->rowCount() > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        $stored_password = $row[0]['password'];

        if (password_verify($password, $stored_password)) {
          $_SESSION['email'] = $email;
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }

    public function register(string $email, string $password) {

      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $sql = "INSERT INTO users(email, password)VALUES('$email', '$hashedPassword');";
      $result = $this->db->query($sql);

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

      $result = $this->db->query($sql);

      if ($result->rowCount() > 0) {
        $_SESSION['email'] = $email;
        $errors[] = '<p>This email is already registered. If you have an account already, please login.</p>';
      }

      return $errors;
    }
  }