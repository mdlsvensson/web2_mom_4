<nav>
                <ul>
                    <li><a href="index.php">Latest blog posts</a></li>
                    <li><a href="blog.php">All blog posts</a></li>
                    <?php
                        // Show login and register links if there is no logged in user
                        if (!isset($_SESSION['email'])) {
                            echo '<li><a href="login.php">Log in</a></li>';
                            echo '<li><a href="register.php">Register</a></li>';
                        } else {
                            // Show admin and logout links if there is a logged in user.
                            echo '<li><a href="admin.php">Admin</a></li>';
                            echo '<li><a href="logout.php">Log out</a></li>';
                        }
                    ?>
                </ul>
            </nav>