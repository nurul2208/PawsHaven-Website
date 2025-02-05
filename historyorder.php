<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pet Haven - Order History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>


<?php
include 'header.php';
include 'includes/dbconn.php';

// Assuming 'email' is stored in the session in your 'header.php'
$userEmail = $_SESSION['email'];

// Fetch user's order history based on email with JOIN to get product details
$query = "SELECT o.*, p.product_image FROM `order` o
          INNER JOIN `product` p ON o.product_id = p.product_id
          WHERE o.`email` = '$userEmail'
          ORDER BY o.`order_date` DESC";

$result = mysqli_query($conn, $query);

?>


<main>
<section>
    <div class="container h-50">
        <div class="card-header px-4 py-5">
            <h3 class="text-muted mb-0 text-center ">Order <span style="color: #a8729a;">History </span>!</h3>
        </div>

        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card shadow-0 border mb-4">';
                echo '<div class="card-body">';
                echo '<div class="row align-items-center">';
                echo '<div class="col-md-2 text-center">';
                echo '<img src="' . $row['product_image'] . '" alt="' . $row['product'] . '" class="img-fluid">';
                echo '</div>';

                // Display order details (modify as needed)
                echo '<div class="col-md-2 text-center">';
                echo '<h5 class="text-muted mb-0">Order ID: ' . $row['order_id'] . '</h5></div>';
                echo '<div class="col-md-2 text-center">';
                echo '<p class="text-muted mb-0 small">Order Date: ' . $row['order_date'] . '</p></div>';
                echo '<div class="col-md-2 text-center">';
                echo '<p class="text-muted mb-0 small">Product: ' . $row['product'] . '</p></div>';
                echo '<div class="col-md-2 text-center">';
                echo '<p class="text-muted mb-0 small">Quantity: ' . $row['quantity'] . '</p></div>';
                echo '<div class="col-md-2 text-center">';
                echo '<p class="text-muted mb-0 small">Total Price: RM' . $row['total_price'] . '</p></div>';
                echo '</div>';

                echo '<div class="col-md-12 py-5">';
                echo '<div class="d-flex justify-content-center">';
                
                // Check the status and set the badge color accordingly
                $badgeColor = '';
                switch ($row['status']) {
                    case 'Pending':
                        $badgeColor = 'btn-primary';
                        break;
                    case 'Cancelled':
                        $badgeColor = 'btn-danger';
                        break;
                    case 'Success':
                        $badgeColor = 'btn-success';
                        break;
                }

                echo '<span class="badge ' . $badgeColor . '" >Status: ' . $row['status'] . '</span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No order history found.</p>';
        }
        ?>
    </div>
</section>
</main>


    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://kit.fontawesome.com/0994c13037.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

