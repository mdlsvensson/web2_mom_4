<?php
  $page_title = "Register";
  include("includes/header.php");
?>

<h2>Register</h2>
<form action="register.php" method="post">

  <?php

    if (isset($_POST['email'])) {
      // Get POST data
      $email = $_POST['email'];
      $password = $_POST['password'];

      // New User Object
      $user = new User();
      // Get any errors from form input
      $errors = $user->validate($email, $password);

      // If there are any errors, write them to the DOM
      if (count($errors) > 0) {
        for ($i=0; $i < count($errors); $i++) { 
          echo $errors[$i];
        }
        // If there are no errors and reg is successful, print message to DOM
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