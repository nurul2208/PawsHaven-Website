<?php
include '../includes/dbconn.php';
session_start();

$conn = new mysqli($hostdb, $usernamedb, $passworddb, $databasedb);

if ($conn->connect_error) {
  die("Connection Failed: " . $conn->connect_error);
}

$email = $_POST['email']; // Get the selected email


$query = "SELECT product_id, product_name, product_dec, product_price FROM products WHERE product = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

$productIDs = array();
while ($row = $result->fetch_assoc()) {
  $productIDs[] = $row['product_id'];
}

$stmt->close();
$conn->close();


header('Content-Type: application/json');
echo json_encode($productIDs);
?>
