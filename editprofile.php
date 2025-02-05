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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated data from the form
    $newName = $_POST['newName'];
    $newPhone = $_POST['newPhone'];
    $newAddress = $_POST['newAddress'];
    $newPostcode = $_POST['newPostcode'];
    $newBirthday = $_POST['newBirthday'];

    // Check if the user wants to cancel VIP membership
   $cancelVIP = isset($_POST['cancelVIP']) ? true : false;

    // Check if a new image has been uploaded
    if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] == UPLOAD_ERR_OK) {
        // Handle file upload
        $uploadDir = 'assets/images';
        $newImagePath = $uploadDir . '/' . $_FILES['newImage']['name'];
        move_uploaded_file($_FILES['newImage']['tmp_name'], $newImagePath);
        $newImage = $newImagePath;

        // Update user data in the database for non-cancellation case
        if (!$cancelVIP) {
            $updateSql = "UPDATE login SET name=?, phone_no=?, address=?, postcode=?, birthday=?, image=? WHERE email=?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("sssssss", $newName, $newPhone, $newAddress, $newPostcode, $newBirthday, $newImage, $_SESSION['email']);
            $updateStmt->execute();
            $updateStmt->close();

            // Update session variables
            $_SESSION['name'] = $newName;
            $_SESSION['phone_no'] = $newPhone;
        }
    } else {
        // Update user data in the database for non-cancellation case
        if (!$cancelVIP) {
            $updateSql = "UPDATE login SET name=?, phone_no=?, address=?, postcode=?, birthday=? WHERE email=?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ssssss", $newName, $newPhone, $newAddress, $newPostcode, $newBirthday, $_SESSION['email']);
            $updateStmt->execute();
            $updateStmt->close();
        }
    }

    // Check if the user wants to cancel VIP membership
    if ($cancelVIP) {
        // Update user data in the database, setting member status to 1 (Basic)
        $updateSql = "UPDATE login SET name=?, phone_no=?, address=?, postcode=?, birthday=?, member=1 WHERE email=?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssssss", $newName, $newPhone, $newAddress, $newPostcode, $newBirthday, $_SESSION['email']);
        $updateStmt->execute();
        $updateStmt->close();

        // Update session variables
        $_SESSION['name'] = $newName;
        $_SESSION['phone_no'] = $newPhone;
        $_SESSION['member'] = 1; // Update the session variable to reflect the new member status
    }

    // JavaScript code to dynamically update the header
    echo '<script>updateHeader("' . $newName . '");</script>';
    echo '<script>window.location.href = "profile.php";</script>';
    exit();
}

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
                    <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <img class="rounded-circle mt-5" width="80%" src="<?php echo $userData['image']; ?>">
                        <input type="file" class="mt-3" name="newImage">
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
                            <div class="col-md-12">
                                <label class="labels">Username</label>
                                <input type="text" class="form-control" name="newName" value="<?php echo $userData['name']; ?>">
                            </div>
                            <div class="col-md-12"><label class="labels">Email</label><input type="text" class="form-control" value="<?php echo $userData['email']; ?>" readonly></div>
                            <div class="col-md-12">
                                <label class="labels">Mobile Number</label>
                                <input type="text" class="form-control" name="newPhone" value="<?php echo $userData['phone_no']; ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Address</label>
                                <input type="text" class="form-control" name="newAddress" value="<?php echo $userData['address']; ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Postcode</label>
                                <input type="text" class="form-control" name="newPostcode" value="<?php echo $userData['postcode']; ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="labels">Birthday</label>
                                <input type="date" class="form-control" name="newBirthday" value="<?php echo $userData['birthday']; ?>"readonly>
                            </div>
                            
                            <div class="col-md-6">
                                    <label class="labels">Member Type</label>
                                    <input type="text" class="form-control" value="<?php echo ($userData['member'] == 1) ? 'Basic' : 'VIP'; ?>" readonly><br>
                                    <label class="labels">Cancel VIP Membership</label>
                                    <input type="checkbox" name="cancelVIP"></div>
                            
                        </div>
                        <div class="mt-5 text-right">
                            <a href="profile.php" class="btn btn-secondary profile-button">Back</a>
                            <button class="btn btn-success profile-button" type="submit">Save Profile</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</main>


    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://kit.fontawesome.com/0994c13037.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
