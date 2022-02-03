<?php

  // User class. Login users, register new users, check for active session, restrict non-users, logout users, validate login and registration form input
  class User  {
    
    // Database connection
    private $db;
    // Potential errors
    public $errors = [];

    // New DBH object
    function __construct() {
      $this->db = new Dbh;
    }

    // Login user function, email and password strings as arguments
    public function login(string $email, string $password) : bool {

      // Search users by email
      $sql = "SELECT * FROM users WHERE email='$email';";

      // Send query
      $result = $this->db->query($sql);

      // If user email is registered
      if ($result->rowCount() > 0) {

        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        // Get stored password
        $stored_password = $row[0]['password'];

        // Verify password input vs hashed password, if true, log in
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

    // Register new user
    public function register(string $email, string $password) {

      // Create hashed password
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Create user
      $sql = "INSERT INTO users(email, password)VALUES('$email', '$hashedPassword');";
      // Send query
      $result = $this->db->query($sql);

      return $result;
    }

    // Check if user is logged in
    public function isLoggedIn() : bool {
      if (isset($_SESSION['email'])) {
        return true;
      } else {
        return false;
      }
    }

    // Redirect user if not logged in
    public function restrictPage() {
      if (!isset($_SESSION['email'])) {
        header('Location: login.php?error=Du måste vara inloggad.');
        exit;
      }
    }

    // Logout user and redirect
    public function logout() {
      session_destroy();
      header('Location: login.php');
      exit;
    }

    // Validate register and login form input
    public function validate(string $email, string $password) {
      $errors = [];

      // Check for max email length
      if (strlen($email) > 128) {
        $errors[] = '<p>Your email address is too long.</p>';
      }
      
      //Check max password length
      if (strlen($password) > 256) {
        $errors[] = '<p>Your password is too long.</p>';
      }

      // Check for min password length
      if (strlen($password) < 6) {
        $errors[] = '<p>Your password needs to be at least 6 characters.</p>';
      }

      // Search users by email input
      $sql = "SELECT * FROM users WHERE email='$email';";
      // Send query
      $result = $this->db->query($sql);

      // If any user exists, add error
      if ($result->rowCount() > 0) {
        $_SESSION['email'] = $email;
        $errors[] = '<p>This email is already registered. If you have an account already, please login.</p>';
      }

      // Return any errors
      return $errors;
    }
  }