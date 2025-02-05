<?php
include '../includes/dbconn.php';
session_start();

// Debugging - check the submitted POST data
var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Prepare the delete query
    $query = "DELETE FROM login WHERE email=?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $stmt->bind_param("s", $email);

    // Execute the delete query
    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        $_SESSION['deleteaccountmessagesuccess'] = "Delete Account Successfully!";
        header("Location: membership.php");
    } else {
        $_SESSION['deleteaccountmessagefailed'] = "Delete Account Failed: " . $stmt->error;
        header("Location: membership.php");
    }
} else {
    $_SESSION['deleteaccountmessagefailed'] = "Invalid Request!";
    header("Location: membership.php");
}
?>
