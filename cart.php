<?php
echo '<div>';
include 'header.php';
echo '</div>';
include 'includes/dbconn.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to handle adding a product to the cart
    function addToCart($product_id, $product_name, $product_price, $product_image, $product_quantity)
    {
        // Initialize the cart if not already set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Add the product to the cart
        $_SESSION['cart'][$product_id] = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'product_quantity' => $product_quantity,
        );
    }

    // Process each submitted item
    foreach ($_POST as $key => $value) {
    // Check if the submitted data is related to adding a product to the cart
    if (strpos($key, 'add_to_cart_') !== false) {
        $product_id = str_replace('add_to_cart_', '', $key);
        $product_name = $_POST['product_name_' . $product_id];
        $product_price = $_POST['product_price_' . $product_id];
        $product_image = $_POST['product_image_' . $product_id];
        $product_quantity = $_POST['product_quantity_' . $product_id];

        addToCart($product_id, $product_name, $product_price, $product_image, $product_quantity);
    }

    }

    // Check if the form is submitted to update the cart
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['product_quantity'] as $product_id => $quantity) {
            // Update the quantity in the cart session
            $_SESSION['cart'][$product_id]['product_quantity'] = $quantity;
        }
    }

    // Check if the form is submitted to remove an item from the cart
    if (isset($_POST['remove_item'])) {
        $product_id_to_remove = $_POST['remove_item'];

        // Check if the product ID to remove exists in the cart
        if (is_numeric($product_id_to_remove) && isset($_SESSION['cart'][$product_id_to_remove])) {
            // Remove the item from the cart session
            unset($_SESSION['cart'][$product_id_to_remove]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pet Haven - Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/cart.css">
</head>

<body>
    <main>

        <div class="container mt-4">
            <div class="cart-container">
                <h2>Shopping Cart</h2>
                <?php
                // Check if cart is not empty
                if (!empty($_SESSION['cart'])) {
                    echo '<form method="post" action="cart.php">';
                    $total = 0;
                    $today = new DateTime('today');

                    foreach ($_SESSION['cart'] as $product_id => $item) {
                        echo '<div class="cart-item">';
                        echo '<img src="' . $item['product_image'] . '" alt="Product Image">';
                        echo '<div class="cart-details">';
                        echo '<h3 style="font-size: 18px; font-weight: bold;">' . $item['product_name'] . '</h3>';
                        $isVipMember = isset($item['member']) && $item['member'] == 2;

                        // Check if the "birthday" key exists
                        $birthday = isset($item['birthday']) ? new DateTime($item['birthday']) : null;

                        // Check if it's the user's birthday (only consider month and day)
                        $isBirthday = $birthday && $today->format('m-d') === $birthday->format('m-d');

                        $discountPercentage = 1; // Default discount percentage

                        if ($isVipMember) {
                            switch (true) {
                                case $isBirthday:
                                    $discountPercentage = 0.90;
                                    $label = 'Birthday Price';
                                    $icon = 'fa-cake-candles';
                                    break;
                                default:
                                    $discountPercentage = 0.95;
                                    $label = 'VIP Price';
                                    $icon = 'fa-star';
                                    break;
                            }
                        }

                        if ($isVipMember) {
                            $displayedPrice = $item['product_price'] * $discountPercentage;
                            echo '<p class="card-text vip-price"><i class="fa-solid ' . $icon . '"></i> ' . $label . ': RM' . number_format($displayedPrice, 2) . '</p>';
                        } else {
                            $displayedPrice = $item['product_price'];
                            echo '<p class="card-text price">Price: RM' . number_format($displayedPrice, 2) . '</p>';
                        }
                        echo '<label>Quantity: ';
                        echo '<input type="number" name="product_quantity[' . $product_id . ']" value="' . $item['product_quantity'] . '" min="1">';
                        echo '</label>';
                        echo '</div>';
                        echo '<div class="button-group">';
                        echo '<button type="submit" name="update_cart" class="update-btn">Update</button>';
                        echo '<button type="submit" name="remove_item" value="' . $product_id . '" class="delete-btn">Remove</button>';
                        echo '</div>';
                        echo '</div>';

                        // Calculate the total for each item and add to the overall total
                        $itemTotal = $displayedPrice * $item['product_quantity'];
                        $total += $itemTotal;
                    }

                    echo '<p class="cart-total" style="font-size: 22px; font-weight: bold;">Total: RM' . number_format($total,2) . '</p>';

                    // Add the Checkout button
                    echo '<div class="checkout-container">';
                    echo '<a href="payment.php?total=' . number_format($total,2) . '" class="checkout-btn">Proceed to Checkout</a>';
                    echo '</div>';

                    echo '</form>';
                } else {
                    echo '<p>Your cart is empty. Start shopping now!</p>';
                }
                ?>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>
