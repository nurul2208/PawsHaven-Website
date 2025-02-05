<?php
include '../includes/dbconn.php';
session_start();
// Check if the customer email is provided in the POST data
if (isset($_POST['email']))
{
  $email = $_POST['email'];

    // Prepare the query
  $query = "SELECT * FROM login WHERE role='customer' AND email = ?";
  $stmt = $conn->prepare($query);

  if (!$stmt)
  {
    die("Query Error: " . $conn->error);
  }

    // Bind the parameter
  $stmt->bind_param("s", $email);

    // Execute the query
  if (!$stmt->execute())
  {
    die("Query Execution Error: " . $stmt->error);
  }

    // Get the result
  $result = $stmt->get_result();
  $customer = $result->fetch_assoc();

    // Check if the customer exists
  if (!$customer)
  {
    die("Customer not found");
  }
} 

else
{
  die("Customer email not provided");
}
?>
 

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
        <h1>Update Membership</h1>
          <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="membership.php">Update Membership</a></li>
                <li class="breadcrumb-item active" aria-current="page">Membership</li>
              </ol>
          </nav>
          <br>
          <div class="container">
            <div class="row">
                <!-- Product items using Bootstrap cards -->
                <div class="col-lg-12 col-md-12 mb-20">
                <div class="card">
                <div class="card-body">
            <div>
          <form class="needs-validation" method="POST" action="editMembershipProcess.php" novalidate>
          <div class="form-row">
          <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo isset($customer['name']) ? $customer['name'] : ''; ?>" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a valid name.</div>
                    </div>

                    
                    <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="<?php echo isset($customer['email']) ? $customer['email'] : ''; ?>" required>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please provide a valid email.</div>
                  </div>
                  </div>


                <div class="form-row">
                <div class="col-md-12 mb-3">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="<?php echo isset($customer['address']) ? $customer['address'] : ''; ?>" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a valid address.</div>
                    </div>
                </div>
                <div class="form-row">
                <div class="col-md-12 mb-3">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control" value="<?php echo isset($customer['password']) ? $customer['password'] : ''; ?>" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a valid password.</div>
                    </div>
                </div>

                <div class="form-row">
                <div class="col-md-12 mb-3">
                        <label>Gender</label>
                        <select name="gender" class="custom-select" required>
                        <option value="men" <?php echo (isset($customer['gender']) && $customer['gender'] === 'men') ? 'selected' : ''; ?>>Men</option>
                        <option value="women" <?php echo (isset($customer['gender']) && $customer['gender'] === 'women') ? 'selected' : ''; ?>>Women</option>
                        </select>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a valid gender.</div>
                    </div>
                </div>

                <div class="form-row">
                <div class="col-md-12 mb-3">
                        <label>Plan Member</label>
                        <select name="member" class="custom-select" required>
                        <option value="1" <?php echo (isset($customer['member']) && $customer['member'] == 1) ? 'selected' : ''; ?>>1</option>
                        <option value="2" <?php echo (isset($customer['member']) && $customer['member'] == 2) ? 'selected' : ''; ?>>2</option>
                        </select>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a valid gender.</div>
                    </div>
                </div>

                <div class="form-row">
                <div class="col-md-12 mb-3">
                        <label>PhoneNumber</label>
                        <input type="text" name="phone_no" class="form-control" value="<?php echo isset($customer['phone_no']) ? $customer['phone_no'] : ''; ?>" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please provide a valid phoneno.</div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" required>
                        <label class="form-check-label" for="invalidCheck">
                            Agree to terms and conditions
                        </label>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            You must agree before submitting.
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Update Membership</button>
                <a class="btn btn-info" href="membership.php">Back</a>
            </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                (function() {
                    'use strict';
                    window.addEventListener('load', function() {
                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        var forms = document.getElementsByClassName('needs-validation');
                        // Loop over them and prevent submission
                        var validation = Array.prototype.filter.call(forms, function(form) {
                            form.addEventListener('submit', function(event) {
                                if (form.checkValidity() === false) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }
                                form.classList.add('was-validated');
                            }, false);
                        });
                    }, false);
                })();
            </script>
</div>