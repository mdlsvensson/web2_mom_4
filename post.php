<?php
  $page_title = "Post Title";
  include("includes/header.php");

  if (isset($_GET['postid'])) {
    $id = $_GET['postid'];

    $post = new Post();
    $post->getPostById($id);
  } else {
    header('Location: index.php');
  }

  include("includes/footer.php");