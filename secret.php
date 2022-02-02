<?php
  include_once('includes/config.php');
  $user = new User();

  $user->restrictPage();

  $page_title = 'Secret page';
  include('includes/header.php');
?>

<h2>Secret Page</h2>
<p>
  This page is only for logged in users.
</p>

<p>
  You are logged in as: <?= $_SESSION['email']; ?>
</p>

<?php
include('includes/footer.php');