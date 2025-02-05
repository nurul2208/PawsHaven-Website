<?php
session_start();
include 'includes/dbconn.php';

// Initialize error message
$errorMsg = '';

// Check if the form is submitted to process the payment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['process_payment'])) {


    // Additional validation as needed

    // Get user information from the session
    $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

    // Get cart data from the session
    $cart_data = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

    // If the form is valid, store order data in the database
    if (validatePaymentForm($_POST)) {
        storeOrder($user_email, $cart_data);

        // Clear the cart after processing the payment
        $_SESSION['cart'] = array();

        // Redirect to historyorder.php
        header('Location: historyorder.php');
        exit();
    } else {
        // Set an error message
        $errorMsg = 'Payment information is not valid. Please check your details and try again.';
    }
}

// Function to store order data in the database
function storeOrder($user_email, $cart_data)
{
    global $conn;

    // Perform database operations to store order data
    // For demonstration purposes, insert data into the `order` table
    foreach ($cart_data as $product) {
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $quantity = $product['product_quantity'];
        $product_image = $product['product_image'];
        $total_price = $product['product_price'] * $quantity;

        // Insert data into the order table
        $query = "INSERT INTO `order` (product_id, product, quantity, total_price, email, status)
                  VALUES ('$product_id', '$product_name', '$quantity', '$total_price', '$user_email', 'Pending')";

        mysqli_query($conn, $query);
    }
}

// Function to validate payment form data
function validatePaymentForm($formData)
{
    // Add your validation logic here
    // Return true if the form is valid, false otherwise

    // Example validation (you should customize it)
    $cardNumber = trim($formData['card_number']);
    $expiryDate = trim($formData['expiry_date']);
    $cvv = trim($formData['cvv']);

    if (empty($cardNumber) || empty($expiryDate) || empty($cvv)) {
        return false;
    }

    // Add more validation as needed

    return true;
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
        <div class="text-left mt-4">
                <a href="cart.php" class="btn btn-secondary btn-lg">Back</a>
            </div>
        <div class="payment-container">
            <h2>Payment Details</h2>
            <form action="payment.php?cart=<?php echo urlencode(json_encode($_SESSION['cart'])); ?>" method="post">


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
                    <span style="font-size: 24px; font-weight: bold; color: #007bff;">RM <?php echo isset($_GET['total']) ? $_GET['total'] : ''; ?></span>
                </div>

                <!-- Update the hidden input field to use $_GET -->
                <input type="hidden" name="total" value="<?php echo isset($_GET['total']) ? $_GET['total'] : ''; ?>">

                <!-- Button to Process Payment -->
                <button type="submit" name="process_payment" style="display: block; margin: 0 auto;">Place Order</button>
            </form>

            <!-- Display error message if any -->
            <?php if (!empty($errorMsg)) : ?>
                <div class="alert alert-danger mt-3">
                    <?php echo $errorMsg; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="popup" id="popup">
        Your order has been placed successfully!
    </div>

</body>

</html>
