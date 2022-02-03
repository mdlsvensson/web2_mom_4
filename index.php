<?php
  $page_title = "Startsida";
  include("includes/header.php");

  $db = new Dbh();
  $conn = $db->connect();

  $sql = "SELECT * FROM blog;";

  $result = $conn->query($sql);

  if ($result->rowCount() > 0) {
    $row = $result->fetchAll(PDO::FETCH_ASSOC);

    for ($i=0; $i < 2; $i++) {

      if (!isset($row[$i])) continue;

      echo '<h2>' . $row[$i]['title'] . '</h2>';
      echo '<small>' . $row[$i]['postdate'] . '</small>';

      $linebreaked = nl2br($row[$i]['content']);

      if (strlen(strip_tags($linebreaked)) > 500) {
      $cutContent = substr($linebreaked, 0, 500);
      } else {
        $cutContent = $linebreaked;
      }

      echo '<p>' . $cutContent . '...</p>';
      echo '<form action="post.php" method="get"><button type="submit" name="postid" value="' . $row[$i]['id'] . '">Read more</button></form>';
    }

  } else {
    echo '<p>There are no posts yet. Please register/log in and create a post.</p>';
  }

  include("includes/footer.php");