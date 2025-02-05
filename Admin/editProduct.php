<?php

include '../includes/dbconn.php';
session_start();


// Retrieve the product details for pre-filling the form
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = "SELECT * FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product_name = $row['product_name'];
            $product_dec = $row['product_dec'];
            $product_fec = $row['product_fec'];
            $product_price = $row['product_price'];
            $product_image = $row['product_image'];
        } else {
            // Handle product not found
            $_SESSION['editproductmessagefailed'] = "Product not found!";
            header("Location: product.php");
            exit();
        }

        $stmt->close();
    } else {
        // Handle query preparation error
        die("Query Error: " . $conn->error);
    }
} else {
    // Handle missing product_id
    $_SESSION['editproductmessagefailed'] = "Product ID is missing!";
    header("Location: product.php");
    exit();
}

// Check if the form is submitted for product update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the form
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $product_dec = isset($_POST['product_dec']) ? $_POST['product_dec'] : '';
    $product_fec = isset($_POST['product_fec']) ? $_POST['product_fec'] : '';
    $product_price = isset($_POST['product_price']) ? $_POST['product_price'] : '';
    $existing_product_image = isset($_POST['existing_product_image']) ? $_POST['existing_product_image'] : '';

    // Handle file upload
    $existing_product_image = null;
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'assets/images';
        $new_image_path = $uploadDir . '/' . $_FILES['product_image']['name'];
        move_uploaded_file($_FILES['product_image']['tmp_name'], $new_image_path);
        $product_image = $new_image_path;
    }

    // Prepare the update query
    if ($existing_product_image === null) {
    // No new image uploaded, update without changing the image
    $query = "UPDATE product SET product_name=?, product_dec=?, product_fec=?, product_price=? WHERE product_id=?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }
}


    // Prepare the update query
    $query = "UPDATE product SET product_name=?, product_dec=?, product_fec=?, product_price=?, product_image=? WHERE product_id=?";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $stmt->bind_param("sssssi", $product_name, $product_dec, $product_fec, $product_price, $product_image, $product_id);
    // Execute the update query
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        $_SESSION['editproductmessagesuccess'] = "Product update successfully!";
        header("Location: product.php");
        exit();
    } else {
        $_SESSION['editproductmessagefailed'] = "Failed to update product! Error: " . $stmt->error;
        header("Location: product.php");
        exit();
    }
}
?>


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
                <a href="login.php" class="btn btn-primary" onclick="openLoginPopup()">Logout</a>
            </nav>
        </div>
 
    </header>

    <main>
        <div class="container">
            <h1>Edit Product</h1>
            <br><br>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="header.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="product.php">Product</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
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
               
            <!-- Form for updating a product -->
            <form class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>

                <!-- Input fields with pre-filled values -->
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Product Name</label>
                        <input type="text" name="product_name" class="form-control" value="<?php echo $product_name; ?>" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a product name.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Product Description</label>
                        <input type="text" name="product_dec" class="form-control" value="<?php echo $product_dec; ?>" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a product description.</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Product Features</label>
                        <input type="text" name="product_fec" class="form-control" value="<?php echo $product_fec; ?>" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide product features.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Product Price</label>
                        <input type="text" name="product_price" class="form-control" value="<?php echo $product_price; ?>" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a product price.</div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                  <label>Product Image</label><br>
                  <img src="<?php echo '../' . $product_image; ?>" alt="Product Image" width="200" hight="200">
                  <input type="file" name="product_image" class="form-control">
                  <div class="valid-feedback">Looks good!</div>
                  <div class="invalid-feedback">Please provide a product image file.</div>
                </div>
                <button class="btn btn-primary" type="submit">Update Product</button>
                
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
