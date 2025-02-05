<?php
include '../includes/dbconn.php';
session_start();

// Check if the order ID is provided via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Fetch the order details from the database
    $query = "SELECT * FROM `order` WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Order ID not provided");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shop - Pet Products</title>
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
            <h1>Update Order</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="product.php">Update </a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product</li>
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
            <form class="needs-validation" method="POST" action="editOrderProcess.php" novalidate>
            <div class="form-row">
            <div class="col-md-6 mb-3">
                    <label>order_id</label>
                    <input type="text" name="order_id" class="form-control" value="<?php echo isset($order['order_id']) ? $order['order_id'] : ''; ?>" required>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please provide a valid order_id.</div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>product_id</label>
                    <input type="text" name="product_id" class="form-control" value="<?php echo isset($order['product_id']) ? $order['product_id'] : ''; ?>" required>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please provide a valid product_id.</div>
                </div>
                <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label>Product</label>
                    <input type="text" name="product" class="form-control" value="<?php echo isset($order['product']) ? $order['product'] : ''; ?>" required>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please provide a valid product.</div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label>quantity</label>
                        <input type="text" name="quantity" class="form-control" value="<?php echo isset($order['quantity']) ? $order['quantity'] : ''; ?>" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a valid quantity.</div>
                    </div>
                </div>
                <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="<?php echo isset($order['email']) ? $order['email'] : ''; ?>" required>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please provide a valid email.</div>
                  </div>
                  </div>
                <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label>Total Price</label>
                    <input type="text" name="total_price" class="form-control" value="<?php echo isset($order['total_price']) ? $order['total_price'] : ''; ?>" required>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please provide a valid total_price.</div>
                </div>
            </div>

                <div class="form-row">
                <div class="col-md-12 mb-3">
                        <label>order_date</label>
                        <input type="text" name="order_date" class="form-control" value="<?php echo isset($order['order_date']) ? $order['order_date'] : ''; ?>" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a valid  order_date.</div>
                    </div>
                </div>

                <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label>Status</label>
                    <select name="status" class="custom-select" required>
                        <option value="Select" <?php echo (isset($order['status']) && $order['status'] == 'Select') ? 'selected' : ''; ?>>Select</option>
                        <option value="Cancelled" <?php echo (isset($order['status']) && $order['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                        <option value="Success" <?php echo (isset($order['status']) && $order['status'] == 'Success') ? 'selected' : ''; ?>>Success</option>
                        <option value="Pending" <?php echo (isset($order['status']) && $order['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    </select>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please provide a valid status.</div>
                </div>
            </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" required>
                        <label class="form-check-label" for="invalidCheck">
                            Agree to terms and conditions
                        </label>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Update</button>
                <a class="btn btn-info" href="order.php">Back</a>
            </form>

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
        </div>
    </main>
</body>

</html>
