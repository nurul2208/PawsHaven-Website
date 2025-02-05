<?php
// Start or resume the session
session_start();

// Include the database connection file
include '../includes/dbconn.php';

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // User is logged in, display logout button
    echo "<script>function logout() {
            window.location.href = '../controller/logout.php';
        }</script>";
}

// Fetch recent product orders from the database
$order_query = "SELECT * FROM `order` ORDER BY order_date DESC LIMIT 5"; // Adjust the query as needed
$order_result = mysqli_query($conn, $order_query);

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
                <a href="../controller/logout.php" class="btn btn-primary" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
            </nav>
        </div>
    </header>

    <main>
     <!-- Breadcrumb -->
    <div class="container">
    <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
    </div>
    <div class="container">
    <div class="row">
        <!-- Product items using Bootstrap cards -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Membership/Total</h5>
                    <?php
                        $dash_login_query = "SELECT * FROM login";
                        $dash_login_query_run = mysqli_query($conn, $dash_login_query);

                        if ($login_total = mysqli_num_rows($dash_login_query_run)) {
                            echo '<h4 class="mb-0"> ' . $login_total . ' </h4>';
                        } else {
                            echo '<h4 class="mb-0"> No Data </h4>';
                        }
                    ?>
                    <p class="card-text">Membership plan</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Product/Total</h5>
                    <?php
                        $dash_product_query = "SELECT * FROM product";
                        $dash_product_query_run = mysqli_query($conn, $dash_product_query);

                        if ($product_total = mysqli_num_rows($dash_product_query_run)) {
                            echo '<h4 class="mb-0"> ' . $product_total . ' </h4>';
                        } else {
                            echo '<h4 class="mb-0"> No Data </h4>';
                        }
                    ?>
                    <p class="card-text">Product Available</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
            <div class="card-body">
            <h5 class="card-title">Order/Total</h5>
            <?php
            $dash_order_id_query = "SELECT * FROM `order`";
            $dash_order_id_query_run = mysqli_query($conn, $dash_order_id_query);

            if ($order_id_total = mysqli_num_rows($dash_order_id_query_run)) {
                echo '<h4 class="mb-0"> ' . $order_id_total . ' </h4>';
            } else {
                echo '<h4 class="mb-0"> No Data </h4>';
            }
            ?>
            <p class="card-text">Order Available</p>
        </div>
    </div>
</div>

        </div>
    </div>
    <div class="col-12">
          <div class="card recent-sales overflow-auto">

            <div class="card-body">
              <h5 class="card-title">Recent Product Order</h5>

              <table class="table table-bordered">
                <thead>
                  <tr>
                    
                    <th scope="col">Product name</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total Price</th>
                  </tr>
                </thead>
                <tbody>

                <?php
                if ($order_result) {
                    while ($row = mysqli_fetch_assoc($order_result)) {
                        echo "<tr>";
                        echo "<td>" . $row['product'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['total_price'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }
                ?>

      </table>
      </div>
    </div>
  </div>
</div>

</main>
<?php
include 'footer.php';
?>
    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Function to logout (for the logout button)
        function logout() {
            window.location.href = '../controller/logout.php'; // Redirect to logout page
        }
    </script>
</body>
</html>