<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hidden 
        {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow p-3 mb-5 bg-body rounded">
            <div class="card-body">
                <h2 class="card-title text-center">User Registration</h2>
                <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['error']; ?>
                    </div>
                <?php endif; ?>
                <form id="registrationForm" action="includes/register.inc.php" method="post" enctype="multipart/form-data">
                    <div id="page1">
                        <div class="mb-3 user-box">
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required value="<?php echo isset($_SESSION['firstName']) ? $_SESSION['firstName'] : ''; ?>">
                        </div>
                        <div class="mb-3 user-box">
                            <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Middle Name" value="<?php echo isset($_SESSION['middleName']) ? $_SESSION['middleName'] : ''; ?>">
                        </div>
                        <div class="mb-3 user-box">
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required value="<?php echo isset($_SESSION['lastName']) ? $_SESSION['lastName'] : ''; ?>">
                        </div>
                        <div class="mb-3 user-box">
                            <input type="text" class="form-control" id="suffix" name="suffix" placeholder="Suffix" value="<?php echo isset($_SESSION['suffix']) ? $_SESSION['suffix'] : ''; ?>">
                        </div>
                        <div class="mb-3 user-box">
                            <input type="date" class="form-control" id="birthday" name="birthday" required value="<?php echo isset($_SESSION['birthday']) ? $_SESSION['birthday'] : ''; ?>">
                        </div>
                        <div class="mb-3 user-box">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" required value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : ''; ?>">
                        </div>
                        <div class="mb-3 user-box">
                            <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Contact Number" required value="<?php echo isset($_SESSION['contactNumber']) ? $_SESSION['contactNumber'] : ''; ?>">
                        </div>
                        <button type="button" id="nextButton" class="btn btn-primary">Next</button>
                    </div>
                    <div id="page2" class="hidden">
                    <div class="mb-3 user-box">
                        <label class="custom-file-label" for="profilePicture">Profile Picture</label>
                        <input type="file" class="form-control custom-file-input" id="profilePicture" name="profilePicture" accept="image/*" required>
                    </div>
                    <div class="mb-3 user-box">
                        <input type="email" class="form-control" id="emailAddressReg" name="emailAddressReg" placeholder="Email Address" required value="<?php echo isset($_SESSION['emailAddressReg']) ? $_SESSION['emailAddressReg'] : ''; ?>">
                    </div>
                    <div class="mb-3 user-box">
                        <input type="password" class="form-control" id="passwordReg" name="passwordReg" placeholder="Password" required>
                    </div>
                    <div class="mb-3 user-box">
                        <input type="password" class="form-control" id="confirmPasswordReg" name="confirmPasswordReg" placeholder="Confirm Password" required>
                    </div>
                    <button type="button" id="backButton" class="btn btn-secondary">Back</button>
                    <button type="submit" id="registerButton" class="btn btn-primary">Register</button>
                </div>

                </form>
                <div class="text-end mt-3">
                <a href="login.php" class="card-link" onclick="unsetSessionError()">I already have an account</a> 
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('nextButton').addEventListener('click', function() {
            document.getElementById('page1').classList.add('hidden');
            document.getElementById('page2').classList.remove('hidden');
        });

        document.getElementById('backButton').addEventListener('click', function() {
            document.getElementById('page1').classList.remove('hidden');
            document.getElementById('page2').classList.add('hidden');
        });
        function unsetSessionError() {
            <?php if(isset($_SESSION['error'])) : ?>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        }
    </script>

<?php unset($_SESSION['firstName'], $_SESSION['middleName'], $_SESSION['lastName'], $_SESSION['suffix'], $_SESSION['birthday'], $_SESSION['address'], $_SESSION['contactNumber'], $_SESSION['emailAddressReg']); ?>
</body>
</html>
