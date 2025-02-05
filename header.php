<?php
// Start or resume the session

include 'includes/dbconn.php';
session_start();
// Get the current page
$current_page = basename($_SERVER['PHP_SELF']);
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Paw Haven</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <script>
        function updateHeader(newName) {
            // Update the username in the header
            document.getElementById('username').textContent = newName;
        }
    </script>
</head>

<body>

    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <ul class="left-info">
                        <li><a href="#"><i class="fa fa-envelope"></i>PawHaven@company.com</a></li>
                        <li><a href="#"><i class="fa fa-phone"></i>+6012-4567890</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="right-icons">
                        <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <header class="">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.php"><h2>Paw <em>Haven</em></h2></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                            <a class="nav-link" href="index.php">Home
                                <span class="sr-only <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo ($current_page == 'product.php') ? 'active' : ''; ?>">
                            <a class="nav-link" href="product.php">Product
                                <span class="sr-only <?php echo ($current_page == 'product.php') ? 'active' : ''; ?>">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown <?php echo ($current_page == 'about.php' || $current_page == 'staff.php') ? 'active' : ''; ?>">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown"  role="button" aria-haspopup="true" aria-expanded="false">About</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="about.php">About Us</a>
                                <a class="dropdown-item" href="staff.php">Staff</a>
                            </div>
                            <span class="sr-only <?php echo ($current_page == 'about.php' || $current_page == 'staff.php') ? 'active' : ''; ?>">(current)</span>
                        </li>

                        <li class="nav-item dropdown">
                            <?php
                            $role = (isset($_SESSION['role'])) ? $_SESSION['role'] : '';
                            if (isset($_SESSION['username'])) {
                                if ($role == "Admin") {
                            ?>
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" ><?php echo $_SESSION['username']; ?></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="profile.php">Profile</a>
                                        <a class="dropdown-item" href="Admin/header.php">Dashbord</a>
                                        <a class="dropdown-item" href="controller/logout.php" style="color: red">Logout</a>
                                    </div>
                                <?php } else { ?>

                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" ><?php echo $_SESSION['username']; ?></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="profile.php">Profile</a>
                                        <a class="dropdown-item" href="historyorder.php">Order History</a>
                                        <a class="dropdown-item" href="controller/logout.php" style="color: red">Logout</a>
                                    </div>
                                    <li class="nav-item <?php echo ($current_page == 'cart.php') ? 'active' : ''; ?>">
                                        <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i>
                                            <span class="sr-only <?php echo ($current_page == 'cart.php') ? 'active' : ''; ?>">(current)</span>
                                        </a>
                                    </li>
                            <?php
                                }
                            } else {
                            ?>
                                <a class="nav-link" href="login.php">Sign Up/Log In</a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


