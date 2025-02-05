<?php
// fetch_login_data.php

$hostdb = "localhost";
$usernamedb = "root";
$passworddb = "";
$databasedb = "paw_shop";

$conn = new mysqli($hostdb, $usernamedb, $passworddb, $databasedb);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $query = "SELECT firstname, lastname, address, poscode, city, state, phonenumber, email FROM user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
    echo json_encode($userData);
}

$stmt->close();
$conn->close();
?>
