<?php
include 'includes/dbconn.php';
include 'header.php';
include 'slide.php';


// Check if the user is logged in
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Adjust the query based on the login status
if (!empty($userEmail)) {
    $query = "SELECT DISTINCT p.*, l.member, l.birthday FROM product p INNER JOIN login l ON l.email = '$userEmail'";
} else {
    $query = "SELECT * FROM product";
}

$productQuery = $conn->prepare($query);
$productQuery->execute();

$result = $productQuery->get_result();

$product = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product[] = $row;
    }
}

$productQuery->close();
?>

<main>
    <div class="container mt-5">
        <h1>PRODUCT</h1>
        <div class="row">
            <?php
            // Initialize the counter variable
            $counter = 0;
            $today = new DateTime('today');
            foreach ($product as $productItem) {
                if ($counter < 6) {
                    echo '<div class="col-lg-4 col-md-6 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="' . $productItem['product_image'] . '" class="card-img-top" alt="' . $productItem['product_name'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $productItem['product_name'] . '</h5>';
                    echo '<p class="card-text">' . $productItem['product_dec'] . '</p>';

                    // Check if the "member" key exists
                    $isVipMember = isset($productItem['member']) && $productItem['member'] == 2;

                    // Check if the "birthday" key exists
                    $birthday = isset($productItem['birthday']) ? new DateTime($productItem['birthday']) : null;

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
                        $displayedPrice = $productItem['product_price'] * $discountPercentage;
                        echo '<p class="card-text vip-price"><i class="fa-solid ' . $icon . '"></i> ' . $label . ': RM' . number_format($displayedPrice, 2) . '</p>';
                    } else {
                        $displayedPrice = $productItem['product_price'];
                        echo '<p class="card-text price">Price: RM' . number_format($displayedPrice, 2) . '</p>';
                    }




                     if (isset($_SESSION['email'])) {

                    echo '<form action="cart.php" method="post">';
                    echo '<input type="hidden" name="product_id_' . $productItem['product_id'] . '" value="' . $productItem['product_id'] . '">';
                    echo '<input type="hidden" name="product_name_' . $productItem['product_id'] . '" value="' . $productItem['product_name'] . '">';
                    echo '<input type="hidden" name="product_price_' . $productItem['product_id'] . '" value="' . $displayedPrice . '">';
                    echo '<input type="hidden" name="product_image_' . $productItem['product_id'] . '" value="' . $productItem['product_image'] . '">';
                    echo '<input type="hidden" name="product_quantity_' . $productItem['product_id'] . '" value="1">';
                    echo '<button type="submit" name="add_to_cart_' . $productItem['product_id'] . '" class="btn btn-success btn-block">';
                    echo '<i class="fas fa-shopping-cart"></i> Add to Cart';
                    echo '</button>';
                    echo '</form>';
                    } else {

                    echo '<form action="login.php" method="post">';
                    echo '<button type="submit" name="" class="btn btn-success btn-block">';
                    echo '<i class="fas fa-shopping-cart"></i> Add to Cart';
                    echo '</button>';
                    echo '</form>';
                    }

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $counter++;
                } else {
                    break; // Exit the loop after displaying 6 products
                }
            }
            ?>
        </div>
    </div>
</main>

<!-- Membership VIP Promotion Container -->
<!-- Membership VIP Promotion Container -->
<div class="row">
    <div class="col-lg-12 text-center mt-4">
        <h2>Pet Shop Membership Packages</h2>
        <p>Unlock exclusive benefits and rewards with our membership plans.</p>
    </div>
    <div class="col-md-10 offset-md-1 mb-5 mt-1">
        <div class="card membership-card ">
            <div class="card-header membership-card-header">
                <h4>VIP Membership Benefits</h4>
            </div>
            <div class="card-body text-visible">
                <ul class="list-group text-left">
                    <li class="list-group-item">
                        <i class="fas fa-percent"></i> 5% Daily Savings on regular-priced items .
                    </li>
                    <li class="list-group-item">
                        <i class="fas fa-birthday-cake"></i> 10% Birthday Month Savings on regular-priced items and services .
                    </li>
                    <li class="list-group-item">
                        <i class="fas fa-handshake"></i> Enjoy exclusive promotions and benefits with our partners under the Friends of PLC programme.
                    </li>
                    <li class="list-group-item">
                        <i class="fa-solid fa-money-bill"></i> Price $50/month.
                    </li>
                </ul>
                                <p class="card-text mt-3 text-center">
                    <?php
                    if (isset($_SESSION['email'])) {
                        // User is logged in
                        if ($_SESSION['member'] == 1) {
                            // Normal member
                            echo 'Upgrade to VIP membership now to unlock these amazing benefits!';
                            echo '<a href="paymentvip.php" class="btn btn-primary btn-block">Upgrade to VIP</a>';
                        } elseif ($_SESSION['member'] == 2) {
                            // VIP member
                            echo 'You are already a VIP member! Enjoy';
                        }
                    } else {
                        // User is not logged in
                        echo 'Login to upgrade to VIP membership and unlock these amazing benefits!';
                        echo '<a href="login.php" class="btn btn-primary btn-block">Register Now!</a>';
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
