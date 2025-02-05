<?php
session_start();

// Include the database connection file
require_once 'includes/dbconn.php';

// Initialize variables
$usernameErr = $emailErr = $passwordErr = $addressErr = $postcodeErr = $phoneErr = $genderErr = '';

$username = $email = $password = $address = $postcode = $phone = $gender = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input fields
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = $_POST["username"];
        if (!preg_match("/^[a-zA-Z]+$/", $username)) {
            $usernameErr = "Only alphabets are allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters";
        }
    }

    if (empty($_POST["birthday"])) {
    $birthdayErr = "Birthday is required";
    } else {
        $rawBirthday = $_POST["birthday"];
        $formattedBirthday = date('d-m-Y', strtotime($rawBirthday));

        // Validate the formatted date if needed
        // Example: Check if the formatted date is valid
        $parsedDate = date_parse_from_format('d-m-Y', $formattedBirthday);
        if ($parsedDate['error_count'] === 0 && $parsedDate['warning_count'] === 0) {
            $birthday = $formattedBirthday;
        } else {
            $birthdayErr = "Invalid birthday format. Please use DD-M-YYYY.";
        }
    }


    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
    } else {
        $address = $_POST["address"];
    }

    if (empty($_POST["postcode"])) {
        $postcodeErr = "Postcode is required";
    } else {
        $postcode = $_POST["postcode"];
        if (!preg_match("/^\d{5}$/", $postcode)) {
            $postcodeErr = "Postcode must be 5 digits";
        }
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = $_POST["phone"];
        if (!is_numeric($phone)) {
            $phoneErr = "Phone number must be numeric";
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = $_POST["gender"];
    }

    // Check if the checkbox is checked for VIP membership
    $isVipMember = isset($_POST['vip_membership']) ? 1 : 0;

    // If there are no validation errors, proceed with signup
    if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($addressErr) && empty($postcodeErr) && empty($phoneErr) && empty($genderErr)) {
        // Use a prepared statement to prevent SQL injection
        $query = "INSERT INTO login (name, email, password, birthday, address, postcode, phone_no, gender, member, role, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        $memberType = $isVipMember ? 2 : 1; // 1 represents normal member
        $role = "Customer";
        $image = "assets/images/profile.png";

        $stmt->bind_param("sssssississ", $username, $email, $password, $birthday, $address, $postcode, $phone, $gender, $memberType, $role, $image);
        $stmt->execute();
        $stmt->close();

        // Redirect to VIP payment page if the user is a VIP member
        if ($isVipMember) {
            header("Location: paymentvip.php");
            exit();
        }

        // Redirect to login page after successful signup for non-VIP members
        header("Location: login.php");
        exit();
    }

    // Check if the email already exists in the database
    $checkQuery = "SELECT COUNT(*) FROM login WHERE email = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        // Email already exists, display an error message
        $_SESSION['error_message'] = "Email already exists. Please use a different email.";
    }
}

// Close the database connection
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Paw Haven - Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/signup.css">
</head>

<body>
    <main>
        <div class="custom-container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="signup-box">
                        <h2 class="text-center">Create an Account</h2>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return updateFormAction();">
                        <div class="form-group">
                            <label for="username"><b>Username</b></label>
                            <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" required>
                            <span style="color: red"><?php if(isset($usernameErr)) echo $usernameErr; ?></span>
                        </div>

                            <div class="form-group">
                                <label for="email"><b>Email</b></label>
                                <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                                <span style="color: red"><?php if(isset($emailErr)) echo $emailErr; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="password"><b>Password</b></label>
                                <input type="password" class="form-control" name="password" required>
                                <span style="color: red"><?php if(isset($passwordErr)) echo $passwordErr; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="birthday"><b>Birthday</b></label>
                                <input type="date" class="form-control" name="birthday" required>
                                <span style="color: red"><?php if(isset($birthdayErr)) echo $birthdayErr; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="address"><b>Address</b></label>
                                <input type="text" class="form-control" name="address" value="<?php echo $address; ?>"required>
                                <span style="color: red"><?php echo $addressErr; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="postcode"><b>Postcode</b></label>
                                <input type="text" class="form-control" name="postcode" value="<?php echo $postcode; ?>" required>
                                <span style="color: red"><?php echo $postcodeErr; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="phone"><b>Phone Number</b></label>
                                <input type="tel" class="form-control" name="phone" value="<?php echo $phone; ?>" required>
                                <span style="color: red"><?php echo $phoneErr; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="gender"><b>Gender</b></label>
                                <select class="form-control" name="gender">
                                    <option value="Male" <?php if($gender == 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if($gender == 'Female') echo 'selected'; ?>>Female</option>
                                </select>
                                <span style="color: red"><?php echo $genderErr; ?></span>
                            </div>


    <label for="membership_package"><b>Membership Package</b></label>
    <div class="membership-container row">
        <div class="col-md-4">
            <div class="custom-control custom-radio">
                <input type="checkbox" id="vip_membership" name="vip_membership" class="custom-control-input" value="basic">
                <label class="custom-control-label" for="vip_membership">
                    <div class="card membership-card">
                        <div class="card-header membership-card-header">
                            <h4>Vip Package</h4>
                        </div>
                        <div class="card-body text-visible">
                            <p class="card-text">Access to member-only discounts</p>
                            <p class="card-text">Price: $30/month</p>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group mt-3">
        <input type="submit" class="btn btn-primary btn-block" name="signup" value="Sign Up">
    </div>
</form>
                        <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>



    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>
