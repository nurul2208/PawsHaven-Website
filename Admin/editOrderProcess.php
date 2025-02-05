<?php
include '../includes/dbconn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $product_id = $_POST['product_id'];
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $order_date = $_POST['order_date'];
    $email = $_POST['email'];
    $status = $_POST['status'];

// Prepare the update query
$query = "UPDATE `order` SET order_id = ?, product_id = ?, product = ?, quantity = ?, total_price = ?, order_date = ?, email = ?, status = ? WHERE order_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Query Error: " . $conn->error);
}

// Bind the parameters
$stmt->bind_param("sssssssss", $order_id, $product_id, $product, $quantity, $total_price, $order_date, $email, $status, $order_id);
// Execute the update query
if ($stmt->execute()) {
    // Redirect to a success page or display a success message
    $_SESSION['updatemessagesuccess'] = "Update Successfully!";
    header("Location: order.php");
} else {
    $_SESSION['updatemessagefailed'] = "Update Failed!";
    header("Location: order.php");
}
}

include 'footer.php';
?>