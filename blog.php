<?php
  $page_title = "All Blog Posts";
  include("includes/header.php");

  $posts = new Post();
  $posts->getPosts();

  include("includes/footer.php");