<nav>
                <ul>
                    <li><a href="index.php">Latest blog posts</a></li>
                    <li><a href="blog.php">All blog posts</a></li>
                    <?php
                        if (!isset($_SESSION['email'])) {
                            echo '<li><a href="login.php">Log in</a></li>';
                            echo '<li><a href="register.php">Register</a></li>';
                        } else {
                            echo '<li><a href="logout.php">Log out</a></li>';
                        }
                    ?>
                </ul>
            </nav>