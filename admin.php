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

    // If new post form is submitted
    if (isset($_POST['title'])) {
      // Get POST data
      $title = $_POST['title'];
      $postContent = $_POST['postcontent'];

      // Create new Post Object
      $post = new Post();

      // Get any form validation errors
      $errors = $post->validate($title, $postContent);

      // If there are errors write them to the DOM
      if (count($errors) > 0) {
        for ($i=0; $i < count($errors); $i++) { 
          echo $errors[$i];
        }
        // If there are no errors, run $post->post() and give success message
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

  // If delete button is pressed
  if (isset($_GET['postid'])) {
    // Get GET data
    $id = $_GET['postid'];

    // New Post Object
    $post = new Post();
    // Delete post by id
    $post->deletePost($id);
  }

  // Create new Post Object
  $posts = new Post();
  // Get all posts with mode admin to add delete button
  $posts->getPosts('all', 'admin');

include('includes/footer.php');