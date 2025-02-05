<?php
include '../includes/dbconn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM product WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        header('Location: product.php?deletemessagesuccess=Product deleted successfully.');
    } else {
        header('Location: product.php?deletemessagefailed=Error deleting product: ' . $conn->error);
    }

    // Close the prepared statement and the connection
    $stmt->close();
    $conn->close();
} else {
    header('Location: product.php');
}
?>