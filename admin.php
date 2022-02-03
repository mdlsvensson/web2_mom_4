<?php
  include_once('includes/config.php');
  $user = new User();

  $user->restrictPage();

  $page_title = 'Backend';
  include('includes/header.php');
?>

<h2>Backend</h2>
<p>
  You are logged in as: <?= $_SESSION['email']; ?>
</p>

<form action="admin.php" method="post">

  <?php

    if (isset($_POST['title'])) {
      $title = $_POST['title'];
      $postContent = $_POST['postcontent'];

      $post = new Post();

      $errors = $post->validate($title, $postContent);

      if (count($errors) > 0) {
        for ($i=0; $i < count($errors); $i++) { 
          echo $errors[$i];
        }
      } elseif ($post->post($title, $postContent)) {
        echo '<p>Post successful.</p>';
      } 
      
    }

  ?>

  <p><input type="text" name="title" placeholder="Title" id="blog-title-input"></p>
  
  <p><textarea name="postcontent" id="postcontent" placeholder="Post content"></textarea></p>
  <button type="submit">Post</button>
</form>

<h1>Manage posts</h1>

<?php

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

    if (strlen(strip_tags($linebreaked)) > 200) {
      $cutContent = substr($linebreaked, 0, 200);
    } else {
      $cutContent = $linebreaked;
    }

    echo '<p>' . $cutContent . '...</p>';
    echo '<form action="admin.php" method="get"><button type="submit" name="postid" value="' . $post['id'] . '">Delete</button></form>';
  }

} else {
  echo '<p>There are no posts yet. Please register/log in and create a post.</p>';
}

if (isset($_GET['postid'])) {
  $id = $_GET['postid'];

  $sql = "DELETE FROM blog WHERE id = '$id';";

  $result = $conn->query($sql);
}

include('includes/footer.php');