<?php
include '../includes/dbconn.php';
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the form
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $product_dec = isset($_POST['product_dec']) ? $_POST['product_dec'] : '';
    $product_fec = isset($_POST['product_fec']) ? $_POST['product_fec'] : '';
    $product_price = isset($_POST['product_price']) ? $_POST['product_price'] : '';

    // Handle image upload
    $uploadDir = 'assets/images'; // Specify the directory where you want to save the images
    $product_image = '';

    if ($_FILES['product_image']['error'] == UPLOAD_ERR_OK) {
        $tempName = $_FILES['product_image']['tmp_name'];
        $originalName = $_FILES['product_image']['name'];
        $product_image = $uploadDir . '/' . $originalName;

        // Move the uploaded file to the destination folder
        move_uploaded_file($tempName, $product_image);
    }

    // Prepare the insert query
    $query = "INSERT INTO product (product_name, product_dec, product_fec, product_price, product_image) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $stmt->bind_param("sssss", $product_name, $product_dec, $product_fec, $product_price, $product_image);

    // Execute the insert query
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        $_SESSION['addproductmessagesuccess'] = "Product added successfully!";
        header("Location: product.php");
    } else {
        $_SESSION['addproductmessagefailed'] = "Failed to add product!";
        header("Location: product.php");
    }
}
?>

<!-- ... your HTML code remains unchanged ... -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Product - Pet Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>
    <header class="bg-light">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="header.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="membership.php">Membership</a></li>
                    <li class="nav-item"><a class="nav-link" href="product.php">Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="order.php">Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="../profile.php">Profile</a></li>
                </ul>
                <a href="../controller/logout.php" class="btn btn-primary" onclick="openLoginPopup()">Logout</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h1>Add Product</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="header.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="product.php">Product</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                </ol>
            </nav>
            <br><br>

            <div class="container">
            <div class="row">
                <!-- Product items using Bootstrap cards -->
                <div class="col-lg-12 col-md-12 mb-20">
                <div class="card">
                <div class="card-body">
            <div>

            <!-- Form for adding a new product -->
            <form class="needs-validation" method="POST" action="" novalidate enctype="multipart/form-data">

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Product Name</label>
                        <input type="text" name="product_name" class="form-control" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a product name.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Product Description</label>
                        <input type="text" name="product_dec" class="form-control" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a product description.</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Product Features</label>
                        <input type="text" name="product_fec" class="form-control" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide product features.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Product Price</label>
                        <input type="text" name="product_price" class="form-control" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a product price.</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label>Product Image</label>
                        <input type="file" name="product_image" class="form-control" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a product image URL.</div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Add Product</button>
                <a class="btn btn-info" href="product.php">Back</a>
            </form>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>
