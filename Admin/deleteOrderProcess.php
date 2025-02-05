<?php
include '../includes/dbconn.php';
session_start();

// Debugging - check the submitted POST data
var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';

    // Prepare the delete query
    $query = "DELETE FROM `order` WHERE order_id=?";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $stmt->bind_param("i", $order_id);

    // Execute the delete query
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        $_SESSION['deleteaccountmessagesuccess'] = "Delete Successfully!";
        header("Location: order.php");
    } else {
        $_SESSION['deleteaccountmessagefailed'] = "Delete  Failed: " . $stmt->error;
        header("Location: order.php");
    }
} else {
    $_SESSION['deleteaccountmessagefailed'] = "Invalid Request!";
    header("Location: order.php");
}
?>
