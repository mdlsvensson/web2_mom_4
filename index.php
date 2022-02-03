<?php
  $page_title = "Startsida";
  include("includes/header.php");

  // Create new post Object
  $posts = new Post();
  // Get the latest 2 posts
  $posts->getPosts(2);

  include("includes/footer.php");