<?php

  class Post  {
    
    private $conn;
    public $errors = [];

    function __construct() {
      $db = new Dbh;
      $this->conn = $db->connect();
    }

    public function post(string $title, string $postcontent) {

      $sql = "INSERT INTO blog(title, content)VALUES('$title', '$postcontent');";
      $result = $this->conn->query($sql);

      return $result;
    }

    public function validate(string $title, string $postcontent) {
      $errors = [];

      if (strlen($title) > 128) {
        $errors[] = '<p>Your post title is too long.</p>';
      }
      if (strlen($postcontent) > 10000) {
        $errors[] = '<p>your post content is too long. Maximum 5000 characters.</p>';
      }
      if (strlen($title) < 6) {
        $errors[] = '<p>Your post title is too short. It needs to be at least 6 characters.</p>';
      }
    
      return $errors;
    }

    public function latestPosts() {

    }
  }