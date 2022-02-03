<?php

// Post class, creating new posts, validating post form input, getting posts and deleting posts
  class Post  {
    
    // Database connection
    private $db;
    // Potential errors
    public $errors = [];

    // New DBH object
    function __construct() {
      $this->db = new Dbh;
    }

    // Creating new post function, taking title and content arguments
    public function post(string $title, string $postcontent) {

      // Insert data with sql
      $sql = "INSERT INTO blog(title, content)VALUES('$title', '$postcontent');";
      $result = $this->db->query($sql);

      return $result;
    }

    // New post creation form validation
    public function validate(string $title, string $postcontent) {
      $errors = [];

      // Checking for max length for title
      if (strlen($title) > 128) {
        $errors[] = '<p>Your post title is too long.</p>';
      }

      // Checking max characters for the post content
      if (strlen($postcontent) > 10000) {
        $errors[] = '<p>Your post content is too long. Maximum 5000 characters.</p>';
      }

      // Checking for minimum title length
      if (strlen($title) < 6) {
        $errors[] = '<p>Your post title is too short. It needs to be at least 6 characters.</p>';
      }

      // Checking minimum post content length
      if (strlen($postcontent) < 10) {
        $errors[] = '<p>Your post content is too short. Minimum 10 characters.</p>';
      }
    
      // Return any errors
      return $errors;
    }

    // Get posts function with default arguments set to get all posts and to display posts with "read more" button
    public function getPosts($num = 'all', $mode = 'default') {
      
      // Get all posts
      $result = $this->db->query("SELECT * FROM blog;");

      // If there are any posts
      if ($result->rowCount() > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);

        // If number of post is set to the default value, get all posts available
        if ($num === 'all') {
          $num = count($row); 
        }

        // Write posts to DOM with loop
        for ($i=0; $i < $num; $i++) {
    
          // If requested index isn't set, skip iteration. Fix if there are only one post and you want to get 2 posts for the index page
          if (!isset($row[$i])) continue;

          echo '<h2>' . $row[$i]['title'] . '</h2>';
          echo '<small>' . $row[$i]['postdate'] . '</small>';
      
          // Convert newline characters to html linebreaks
          $linebreaked = nl2br($row[$i]['content']);
      
          // Cut content at read more button, length depending on the mode set in function arguments
          if ($mode === 'default') {
            if (strlen(strip_tags($linebreaked)) > 500) {
              $cutContent = substr($linebreaked, 0, 500);
            } else {
                $cutContent = $linebreaked;
            }
          }

          if ($mode === 'admin') {
            if (strlen(strip_tags($linebreaked)) > 200) {
              $cutContent = substr($linebreaked, 0, 200);
            } else {
                $cutContent = $linebreaked;
            }
          }

          echo '<p>' . $cutContent . '...</p>';
          
          // Write either read more or delete button to DOM
          if ($mode === 'default') {
            echo '<form action="post.php" method="get"><button type="submit" name="postid" value="' . $row[$i]['id'] . '">Read more</button></form>';
          }
          
          if ($mode === 'admin') {
            echo '<form action="admin.php" method="get"><button type="submit" name="postid" value="' . $row[$i]['id'] . '">Delete</button></form>';
          }
        }

      } else {
        // Message if there are no available posts
        echo '<p>There are no posts yet. Please register/log in and create a post.</p>';
      }
    }

    // Get specific post by id
    public function getPostById($id) {
      // Search posts by id
      $result = $this->db->query("SELECT * FROM blog WHERE id = '$id';");

      $row = $result->fetchAll(PDO::FETCH_ASSOC);

      echo '<h2>' . $row[0]['title'] . '</h2>';
      echo '<small>' . $row[0]['postdate'] . '</small>';

      // Convert newline characters to html linebreaks
      $linebreaked = nl2br($row[0]['content']);

      echo '<p>' . $linebreaked . '</p>';
    }

    // Delete post by id
    public function deletePost($id) {
      $this->db->query("DELETE FROM blog WHERE id = '$id';");
    }
  }