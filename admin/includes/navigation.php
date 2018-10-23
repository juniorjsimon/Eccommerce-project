
<!--Admin navigation bar-->
 <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a href="index.php" class="navbar-brand">88riot Admin</a>
                <ul class="nav navbar-nav" >
            <!-- Menu Items -->
                    <li><a href="brands.php">Brands</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="products.php">Products</a></li>
                    <?php if(has_permission('admin')): ?>
                    <li><a href="users.php">Users</a></li>
                    <?php endif; ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account Settings
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="change_password.php">Change Password</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
