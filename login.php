<?php
// Start or resume the session
session_start();
include 'includes/dbconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $loginQuery = $conn->prepare("SELECT * FROM login WHERE email = ? AND password = ?");
    $loginQuery->bind_param("ss", $email, $password);
    $loginQuery->execute();
    $loginResult = $loginQuery->get_result();

    if ($loginResult->num_rows == 1) {
        // Login successful
        $userRow = $loginResult->fetch_assoc();

        // Set session variables
        $_SESSION['email'] = $userRow['email'];
        $_SESSION['role'] = $userRow['role'];
        $_SESSION['username'] = $userRow['name'];

        // Determine the membership status and set 'member' accordingly
        $isVipMember = $userRow['member'] == 2;
        $_SESSION['member'] = $isVipMember ? 2 : 1;

        // Redirect based on role
        if ($userRow['role'] == 'Admin') {
            header("Location: Admin/header.php");
        } elseif ($userRow['role'] == 'Customer') {
            header("Location: index.php");
        }
        exit();
    } else {
        // Invalid credentials
        $error_message = "Invalid email or password. Please try again.";
    }

    // Close the prepared statement
    $loginQuery->close();
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Paw Haven - Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <div class="container mt-4 ">
        <div class="card p-4 login-container bg-light">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="text-center">Welcome to Paws Haven!</h1><br><br>

                    <p class="text-center">Register and explore a plethora of exciting new possibilities!</p>
                    <p class="text-center">Don't have an account yet? <a href="signup.php">Sign Up</a></p>
                </div>
                <div class="col-md-6">
                    <h1 class="text-center">Login</h1>
                    <?php
                if (isset($error_message)) {
                    echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
                }
                ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block ">Login</button>
                </form>
                </div>
            </div>
            <div class="text-left mt-4">
                <a href="index.php" class="btn btn-secondary btn-lg">Back</a>
            </div>
        </div>
    </div>




    <div class="container text-center mt-5">
        <h2>Discover Paws Haven Petshop:</h2>
        <div class="row mt-4">
            <!-- Existing creative elements with updated styles -->
            <div class="col-md-4 animate-element">
                <img src="assets/images/Qualityproduct.png" alt="Quality Products" class="img-fluid">
                <h4 class="mt-3">Quality Products</h4>
                <p>Explore our wide range of premium pet supplies and products that ensure the health and happiness of your furry friends.</p>
            </div>
            <div class="col-md-4 animate-element">
                <img src="assets/images/Expertservice.png" alt="Expert Services" class="img-fluid">
                <h4 class="mt-3">Expert Services</h4>
                <p>Our team of experienced pet care professionals offers grooming, training, and veterinary services to keep your pets in top condition.</p>
            </div>
            <div class="col-md-4 animate-element">
                <img src="assets/images/ComEngage.png" alt="Community Engagement" class="img-fluid">
                <h4 class="mt-3">Community Engagement</h4>
                <p>Join our vibrant community of pet lovers! Participate in events, workshops, and adoption drives aimed at supporting animal welfare.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
