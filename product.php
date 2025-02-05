<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Paw Haven - Product</title>

<?php
include 'header.php';
include 'slide.php';
include 'includes/dbconn.php'; // Assuming this file contains your database connection code

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
                $today = new DateTime('today');

                foreach ($product as $productItem) {
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
                    }
            
            ?>
            </div>
        </div>
    </main>

    <?php
    include 'footer.php';
    ?>


 <!-- <p id="myId"></p>-->
    <script>
        var date = new Date();
        var dd = date.getDate();
        var mm = date.getMonth() + 1;
        var newDate = dd + "-" + mm;
        var p = document.getElementById("myId");
        p.innerHTML = newDate;
    </script>
</html>

<!---debug
    // Add this after the check for VIP birthday
echo 'User Birthday: ' . $birthday->format('Y-m-d') . '<br>';
echo 'Today: ' . $today->format('Y-m-d') . '<br>';
echo 'Is VIP Birthday: ' . ($isVipBirthday ? 'Yes' : 'No') . '<br>';-->
