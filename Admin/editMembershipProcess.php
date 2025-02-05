<?php
include '../includes/dbconn.php';
session_start();

// Ensure that the form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure that the key names match the form field names
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $member = isset($_POST['member']) ? $_POST['member'] : '';
    $phone_no = isset($_POST['phone_no']) ? $_POST['phone_no'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Prepare the update query
    $query = "UPDATE login SET name=?, address=?, password=?, gender=?, member=?, phone_no=?, email=? WHERE email=?";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $stmt->bind_param("ssssssss", $name, $address, $password, $gender, $member, $phone_no, $email, $email);

    // Execute the update query
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        $_SESSION['updateaccountmessagesuccess'] = "Update Account Successfully!";
        header("Location: membership.php");
    } else {
        // Check for SQL errors
        $_SESSION['updateaccountmessagefailed'] = "Update Account Failed! Error: " . $stmt->error;
        header("Location: membership.php");
    }
} else {
    // If the form is not submitted using POST, redirect to the form page
    header("Location: membership.php");
}
?>
