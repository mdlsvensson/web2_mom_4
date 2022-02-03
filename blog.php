<?php
  $page_title = "All Blog Posts";
  include("includes/header.php");

  // New Post Object
  $posts = new Post();
  // Get all posts
  $posts->getPosts();

  include("includes/footer.php");