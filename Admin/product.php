<?php
include '../includes/dbconn.php';
session_start();

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$recordsPerPage = isset($_GET['show']) ? $_GET['show'] : 5;
$startRecord = ($page - 1) * $recordsPerPage;

$totalRecordsQuery = "SELECT COUNT(*) as total FROM product";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

$totalPages = ceil($totalRecords / $recordsPerPage);

$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

// Update the SQL query to include the search condition
$sql = "SELECT * FROM product WHERE product_id LIKE '%$searchKeyword%' OR product_id LIKE '%$searchKeyword%' LIMIT $startRecord, $recordsPerPage";

$result = $conn->query($sql);

$product = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $product[] = $row;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>

<!-- Rest of your HTML and PHP code remains unchanged -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shop - Pet Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>
    <header class="bg-light">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="header.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="membership.php">Membership</a></li>
                    <li class="nav-item"><a class="nav-link" href="product.php">Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="order.php">Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="../profile.php">Profile</a></li>
                </ul>
                <a href="../controller/logout.php" class="btn btn-primary" onclick="openLoginPopup()">Logout</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h1>Pet Shop- Product</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="header.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product</li>
                </ol>
            </nav>
            <?php if (!empty($deletemessagesuccess)) : ?>
                <div class="alert alert-success alert-dismissible fade show"><?php echo $deletemessagesuccess; ?></div>
            <?php endif; ?>

            <?php if (!empty($deletemessagefailed)) : ?>
                <div class="alert alert-danger alert-dismissible fade show"><?php echo $deletemessagefailed; ?></div>
            <?php endif; ?>

            <?php if (!empty($updatemessagesuccess)) : ?>
                <div class="alert alert-success alert-dismissible fade show"><?php echo $updatemessagesuccess; ?></div>
            <?php endif; ?>

            <?php if (!empty($updatemessagefailed)) : ?>
                <div class="alert alert-danger alert-dismissible fade show"><?php echo $updatemessagefailed; ?></div>
            <?php endif; ?>

            <?php if (!empty($loginmessagesuccess)) : ?>
                <div class="alert alert-success alert-dismissible fade show"><?php echo $loginmessagesuccess; ?></div>
            <?php endif; ?>

            <?php if (!empty($loginmessagefailed)) : ?>
                <div class="alert alert-danger alert-dismissible fade show"><?php echo $loginmessagefailed; ?></div>
            <?php endif; ?>

            <?php if (!empty($signupmessagesuccess)) : ?>
                <div class="alert alert-success alert-dismissible fade show"><?php echo $signupmessagesuccess; ?></div>
            <?php endif; ?>

            <?php if (!empty($signupmessagefailed)) : ?>
                <div class="alert alert-danger alert-dismissible fade show"><?php echo $signupmessagefailed; ?></div>
            <?php endif; ?>

            <div class="form-row" style="justify-content: center;">
                <button class="btn btn-success" onclick="goToAddProduct()">Add Product</button>
            </div>

            <div class="form-row">
                <div class="col-md-1 mb-3">
                    <label>Show entries :</label>
                    <select id="showEntries" class="custom-select" onchange="changeShowEntries(this)">
                        <option value="5" <?php echo ($recordsPerPage == 5) ? 'selected' : ''; ?>>5</option>
                        <option value="15" <?php echo ($recordsPerPage == 15) ? 'selected' : ''; ?>>15</option>
                        <option value="35" <?php echo ($recordsPerPage == 35) ? 'selected' : ''; ?>>35</option>
                        <option value="50" <?php echo ($recordsPerPage == 50) ? 'selected' : ''; ?>>50</option>
                    </select>
                </div>
                <div class="col-md-11 mb-3">
                    <label>Search :</label>
                    <form method="GET" action="">
                        <div class="input-group">
                            <input type="text" id="searchInput" name="search" placeholder="Search..." class="form-control" value="<?php echo isset($searchKeyword) ? $searchKeyword : ''; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">product_id</th>
                        <th scope="col">product_name</th>
                        <th scope="col">product_dec</th>
                        <th scope="col">product_fec</th>
                        <th scope="col">product_price</th>
                        <th scope="col">product_image</th>
                        <th scope="col">Actions</th>
                        <th scope="col"></th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Table data will be dynamically populated here -->
                    <?php $rowNumber = ($page - 1) * $recordsPerPage + 1; ?>
                    <?php foreach ($product as $product) : ?>
                        <tr>
                            < <tr>
                                <td><?php echo $product['product_id']; ?></td>
                                <td><?php echo $product['product_name']; ?></td>
                                <td><?php echo $product['product_dec']; ?></td>
                                <td><?php echo $product['product_fec']; ?></td>
                                <td><?php echo $product['product_price']; ?></td>
                                <td><?php echo $product['product_image']; ?></td>
                                <td>
                                <td>
                                <form method="POST" action="deleteProductProcess.php" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>

                                </td>
                                <td>
                                <form method="POST" action="editProduct.php">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <a href="editProduct.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-primary">Edit</a>                                    </form>

                                </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="row">
                <div class="col">
                    <?php
                    $startRecord = ($page - 1) * $recordsPerPage + 1;
                    $endRecord = min($startRecord + $recordsPerPage - 1, $totalRecords);
                    echo "Showing $startRecord to $endRecord of $totalRecords entries";
                    ?>
                </div>
            </div>

            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>&show=<?php echo $recordsPerPage; ?>&search=<?php echo $searchKeyword; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Add other pages links here -->

                    <?php if ($page < $totalPages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>&show=<?php echo $recordsPerPage; ?>&search=<?php echo $searchKeyword; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        </div>
    </main>
    <?php
    include 'footer.php';
    ?>
    <script>
        function goToAddProduct() {
            window.location.href = "addProduct.php";
        }

        function changeShowEntries(select) {
            var show = select.value;
            var urlParams = new URLSearchParams(window.location.search);
            urlParams.set('show', show);
            window.location.search = urlParams.toString();
        }
    </script>
</body>

</html>