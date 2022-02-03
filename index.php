<?php
  $page_title = "Startsida";
  include("includes/header.php");

  $posts = new Post();
  $posts->getPosts(2);

  include("includes/footer.php");