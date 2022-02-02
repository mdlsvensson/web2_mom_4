<?php
  $page_title = "Post Title";
  include("includes/header.php");

  if (isset($_GET['postid'])) {
    $id = $_GET['postid'];

    $db = new Dbh();
    $conn = $db->connect();

    $sql = "SELECT * FROM blog WHERE id = '$id';";

    $result = $conn->query($sql);

    $row = $result->fetchAll(PDO::FETCH_ASSOC);

    echo '<h2>' . $row[0]['title'] . '</h2>';
    echo '<small>' . $row[0]['postdate'] . '</small>';

    $linebreaked = nl2br($row[0]['content']);

    echo '<p>' . $linebreaked . '</p>';

  } else {
    header('Location: index.php');
  }

  include("includes/footer.php");