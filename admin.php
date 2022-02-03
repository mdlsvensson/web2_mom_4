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

  if (isset($_GET['postid'])) {
    $id = $_GET['postid'];
    $post = new Post();
    $post->deletePost($id);
  }

  $posts = new Post();
  $posts->getPosts('all', 'admin');

include('includes/footer.php');