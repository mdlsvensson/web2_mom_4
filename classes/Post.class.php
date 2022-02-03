<?php

  class Post  {
    
    private $db;
    public $errors = [];

    function __construct() {
      $this->db = new Dbh;
    }

    public function post(string $title, string $postcontent) {

      $sql = "INSERT INTO blog(title, content)VALUES('$title', '$postcontent');";
      $result = $this->db->query($sql);

      return $result;
    }

    public function validate(string $title, string $postcontent) {
      $errors = [];

      if (strlen($title) > 128) {
        $errors[] = '<p>Your post title is too long.</p>';
      }

      if (strlen($postcontent) > 10000) {
        $errors[] = '<p>Your post content is too long. Maximum 5000 characters.</p>';
      }

      if (strlen($title) < 6) {
        $errors[] = '<p>Your post title is too short. It needs to be at least 6 characters.</p>';
      }

      if (strlen($postcontent) < 10) {
        $errors[] = '<p>your post content is too short. Minimum 10 characters.</p>';
      }
    
      return $errors;
    }

    public function getPosts($num = 'all', $mode = 'default') {
      
      $result = $this->db->query("SELECT * FROM blog;");

      if ($result->rowCount() > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);

        if ($num === 'all') {
          $num = count($row); 
        }

        for ($i=0; $i < $num; $i++) {
    
          if (!isset($row[$i])) continue;
      
          echo '<h2>' . $row[$i]['title'] . '</h2>';
          echo '<small>' . $row[$i]['postdate'] . '</small>';
      
          $linebreaked = nl2br($row[$i]['content']);
      
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

          if ($mode === 'default') {
            echo '<p>' . $cutContent . '...</p>';
            echo '<form action="post.php" method="get"><button type="submit" name="postid" value="' . $row[$i]['id'] . '">Read more</button></form>';
          }
          
          if ($mode === 'admin') {
            echo '<p>' . $cutContent . '...</p>';
            echo '<form action="admin.php" method="get"><button type="submit" name="postid" value="' . $row[$i]['id'] . '">Delete</button></form>';
          }
        }

      } else {
        echo '<p>There are no posts yet. Please register/log in and create a post.</p>';
      }
    }

    public function deletePost($id) {
      $this->db->query("DELETE FROM blog WHERE id = '$id';");
    }
  }