<?php
  $page_title = "Register";
  include("includes/header.php");
?>

<h2>Register</h2>
<form action="register.php" method="post">

  <?php

    if (isset($_POST['email'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];

      $user = new User();

      $errors = $user->validate($email, $password);

      if (count($errors) > 0) {
        for ($i=0; $i < count($errors); $i++) { 
          echo $errors[$i];
        }
      } elseif ($user->register($email, $password)) {
        echo '<p>Registration successful.</p>';
      } 
      
    }

  ?>

  <input type="email" name="email" id="email" placeholder="email">
  <input type="password" name="password" id="password" placeholder="password">
  <button type="submit">Register</button>
</form>

<?php
include("includes/footer.php");