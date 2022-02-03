<?php
  $page_title = "Login";
  include("includes/header.php");
?>

<h2>Login</h2>
<form action="login.php" method='post'>

  <?php

    if (isset($_GET['error'])) {
      echo '<p>' . $_GET['error'] . '</p>';
    };

    if (isset($_POST['email'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];

      $user = new User();

      if ($user->login($email, $password)) {
        echo '<p>You are now logged in.</p>';
      } else {
        echo '<p>Invalid email/password.</p>';
      }
    }

    if (isset($_SESSION['email'])) {
      header('Location: admin.php');
    }
    
  ?>

  <input type="email" name="email" id="email" placeholder="email">
  <input type="password" name="password" id="password" placeholder="password">
  <button type="submit">Login</button>
</form>

<?php
include("includes/footer.php");