<?php
session_start();

$registration_success = isset($_SESSION['registration_success']) ? $_SESSION['registration_success'] : '';

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';

unset($_SESSION['registration_success']);
unset($_SESSION['error']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h2 class="card-title text-center">Login</h2>

                <?php if (!empty($registration_success)) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $registration_success; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="includes/login.inc.php" method="post">
                    <div class="mb-3">
                        <label for="emailAddress" class="form-label">Email Address:</label>
                        <input type="email" class="form-control" id="emailAddress" name="emailAddress" value="<?= isset($_SESSION['tempEmail']) ? $_SESSION['tempEmail'] : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <a href="register.php">Create an Account</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php
    unset($_SESSION['tempEmail']);
?>
</html>
