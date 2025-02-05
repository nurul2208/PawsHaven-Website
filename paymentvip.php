<?php
session_start();
include 'includes/dbconn.php';

// Check if the form is submitted
if (isset($_POST['process_payment'])) {
    // Perform payment processing logic here

    // Assuming the payment is successful, set this flag
    $paymentSuccessful = true;

    if ($paymentSuccessful) {
        // Update the login table to set the user as a VIP member
        if (isset($_SESSION['email'])) {
            $userEmail = $_SESSION['email'];

            // Assuming your database connection is stored in $conn
            $updateQuery = "UPDATE login SET member = 2 WHERE email = ?";
            $updateStatement = $conn->prepare($updateQuery);

            if ($updateStatement) {
                $updateStatement->bind_param("s", $userEmail);

                if ($updateStatement->execute()) {
                    // Display the VIP message using JavaScript
                    echo '<script>showVipPopup();</script>';
                    header("Location: index.php");
        exit();
                } else {
                    // Handle database update failure
                    $errorMsg = "Failed to update user status. Please try again.";
                    header("Location: login.php");
        exit();
                }

                $updateStatement->close();
            } else {
                // Handle database connection failure
                $errorMsg = "Database connection error. Please try again.";
                header("Location: login.php");
        exit();
            }
        } else {
            // Handle the case where the user is not logged in
            $errorMsg = "User not logged in.";
            header("Location: login.php");
        exit();
        }
    } else {
        // Handle unsuccessful payment
        $errorMsg = "Payment failed. Please try again.";
        header("Location: login.php");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pet Haven - Payment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/payment.css">
</head>

<body>

    <div class="container">
        <div class="payment-container">
            <h2>Payment Details</h2>
            <form action="paymentvip.php" method="post">


                <!-- Card Information Section -->
                <div class="section" id="card-fields">
                    <label for="card-number">Card Number</label>
                    <input type="text" id="card-number" name="card_number" placeholder="1234 5678 9012 3456" value="" required>

                    <label for="expiry-date">Expiry Date</label>
                    <input type="text" id="expiry-date" name="expiry_date" placeholder="MM/YY" value="" required>

                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="123" value="" required>
                </div>

                <!-- Display Total Amount Section -->
                <div class="section">
                    <label style="font-size: 20px; font-weight: bold;">Total Amount to Pay:</label>
                    <span style="font-size: 24px; font-weight: bold; color: #007bff;">RM 50</span>
                </div>

                <!-- Button to Process Payment -->
                <button type="submit" name="process_payment" style="display: block; margin: 0 auto;">Pay</button>
            </form>

            <!-- Popup Container -->
            <div id="popup" style="display: none;"></div>
        </div>
    </div>

    <script>
        function showVipPopup() {
            var popup = document.getElementById('popup');
            popup.innerHTML = 'Enjoy your VIP privilege';
            popup.style.display = 'block';
            setTimeout(function () {
                popup.style.display = 'none';
                window.location.href = 'index.php';
            }, 3000);
        }
    </script>

</body>

</html>
