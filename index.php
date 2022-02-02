<?php
  $page_title = "Startsida";
  include("includes/header.php");

  $db = new Dbh();
  $conn = $db->connect();

  $sql = "SELECT * FROM blog;";

  $result = $conn->query($sql);

  if ($result->rowCount() > 0) {
    $row = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($row as $post) {
      echo '<h2>' . $post['title'] . '</h2>';
      echo '<small>' . $post['postdate'] . '</small>';

      $linebreaked = nl2br($post['content']);

      if (strlen(strip_tags($linebreaked)) > 500) {
      $cutContent = substr($linebreaked, 0, 500);

      }

      echo '<p>' . $cutContent . '...</p>';
      echo '<form action="post.php" method="get"><button type="submit" name="postid" value="' . $post['id'] . '">Read more</button></form>';
    }

  } else {
    echo '<p>There are no posts yet. Please register/log in and create a post.</p>';
  }

  include("includes/footer.php");
?>

<?php