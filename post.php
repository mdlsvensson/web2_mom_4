<?php
  $page_title = "Post Title";
  include("includes/header.php");

  if (isset($_GET['postid'])) {
    // Get GET data
    $id = $_GET['postid'];

    // Create new Post Obeject
    $post = new Post();
    // Get post by id
    $post->getPostById($id);
  } else {
    // If no GET data, redirect to index
    header('Location: index.php');
  }

  include("includes/footer.php");