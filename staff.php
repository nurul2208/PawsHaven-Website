<?php
include 'header.php';
include 'slide.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Directory - Shop Membership System PETSHOP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/staff.css">

</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6"><br><br><br><br><br>
                <div class="staff-category">
                    <h3>Management</h3>
                </div>
                <div class="staff-item">
                    <img src="assets/images/shazwani.jpeg" alt="Staff 1">
                    <h3>NURUL SHAZWANI</h3>
                    <p>Manager</p>
                </div>
                <div class="staff-item">
                    <img src="assets/images/staff2.jpg" alt="Staff 2">
                    <h3>ANIS SYUHADA</h3>
                    <p>Assistant Manager</p>
                </div>
            </div>
            <div class="col-md-6"><br><br><br><br><br>
                <div class="staff-category">
                    <h3>Sales</h3>
                </div>
                <div class="staff-item">
                    <img src="assets/images/wais.jpeg" alt="Staff 3">
                    <h3>UWAIS NAFISHA</h3>
                    <p>Sales Representative</p>
                </div>
                <div class="staff-item">
                    <img src="assets/images/qis.jpg" alt="Staff 4">
                    <h3>NURUL QISTINA</h3>
                    <p>Accountant</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-3">
            <div class="staff-category">
                    <h3>Human Resources</h3>
                </div>
                <div class="staff-item">
                    <img src="assets/images/alif.jpg" alt="Staff 5">
                    <h3>ALIF HAIKAL</h3>
                    <p>Human Resources</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <?php
    include 'footer.php'; 
    ?>
</body>

</html>