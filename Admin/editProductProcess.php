<?php
include '../includes/dbconn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $productName = $_POST['product_name'];
    $productDec = $_POST['product_dec'];
    $productFec = $_POST['product_fec'];
    $productPrice = $_POST['product_price'];
    $productType = $_POST['product_type'];

    // Validate and sanitize input data as needed
    if (empty($productName) || empty($productDec) || empty($productFec) || empty($productPrice) || empty($productType)) {
        echo "All fields are required. Please fill in the form completely.";
        exit();
    }

    // Perform database insert
    $query = "INSERT INTO products (product_name, product_dec, product_fec, product_price, product_type) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssss', $productName, $productDec, $productFec, $productPrice, $productType);
    $stmt->execute();

   // Check if the query was successful
   if ($stmt->affected_rows > 0)
   {
       // Create account successful
       $_SESSION['productmessagesuccess'] = "Add Product Successfully!";
       header("Location: pet.php"); // Redirect back to the login page
   } 

   else 
   {
       // Create account failed
       $_SESSION['productmessagefailed'] = "Add product Failed!";
       header("Location: pet.php"); // Redirect back to the form page
   }

   $stmt->close();
   $conn->close();
}
?>