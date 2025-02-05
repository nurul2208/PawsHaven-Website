<?php
// Include the database connection file
require_once 'includes/dbconn.php';
include 'header.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the user's data from the database
$sql = "SELECT l.*, m.type AS member_type FROM login l
        LEFT JOIN member m ON l.member = m.id
        WHERE l.email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists in the database
if ($result->num_rows == 1) {
    $userData = $result->fetch_assoc();
} else {
    // Handle the case where the user does not exist
    echo "User not found!";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Paw Haven - VIP Payment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dash.css">

</head>
<body>
    <main>

    <div class="container rounded bg-white mt-4 mb-4">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-c text-c p-3 py-5">
                <img class="rounded-circle mt-5" width="80%" src="<?php echo $userData['image']; ?>">
                <span class="font-weight-bold"><?php echo $userData['name']; ?></span>
                <span class="text-black-50"><?php echo $userData['email']; ?></span>
                <!-- Add other user details here -->
            </div>

        </div>
        <div class="col-md-9 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-c mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Username</label><input type="text" class="form-control" value="<?php echo $userData['name']; ?>" readonly></div>

                    <div class="col-md-12"><label class="labels">Email</label><input type="text" class="form-control" value="<?php echo $userData['email']; ?>" readonly></div>
                    <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text" class="form-control" value="<?php echo $userData['phone_no']; ?>" readonly></div>
                    <div class="col-md-12"><label class="labels">Address</label><input type="text" class="form-control" value="<?php echo $userData['address']; ?>" readonly></div>
                    <div class="col-md-12"><label class="labels">Postcode</label><input type="text" class="form-control" value="<?php echo $userData['postcode']; ?>" readonly></div>
                    
                </div>
                <div class="row mt-3">
                    <div class="col-md-6"><label class="labels">Birthday</label><input type="text" class="form-control" value="<?php echo $userData['birthday']; ?>" readonly></div>
                    <div class="col-md-6"><label class="labels">Member Type</label><input type="text" class="form-control" value="<?php echo ($userData['member'] == 1) ? 'Basic' : 'VIP'; ?>" readonly></div>
                </div>
                <div class="mt-5 text-right">
                    <!-- Link to the page where you can edit the profile -->
                    <a href="editprofile.php" class="btn btn-danger profile-button">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/0994c13037.js" crossorigin="anonymous"></script>

<script>
    // JavaScript function to update the header dynamically
    function updateHeader(newName) {
        // Assuming you have an element with ID "username" in your header to display the username
        $('#username').text(newName);
    }
</script>
</body>
</html>
