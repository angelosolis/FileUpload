<?php
    include_once "dbc.inc.php";
    session_start();
try {
    if (isset($_POST['firstName'], $_POST['middleName'], $_POST['lastName'], $_POST['suffix'], $_POST['birthday'], $_POST['address'], $_POST['contactNumber'], $_FILES['profilePicture'], $_POST['emailAddressReg'], $_POST['passwordReg'])) 
    {
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $lastName = $_POST['lastName'];
        $suffix = $_POST['suffix'];
        $birthday = $_POST['birthday'];
        $address = $_POST['address'];
        $contactNumber = $_POST['contactNumber'];
        $emailAddress = $_POST['emailAddressReg'];
        $password = $_POST['passwordReg'];
        $confirmPassword = $_POST['confirmPasswordReg'];

        $_SESSION['firstName'] = $firstName;
        $_SESSION['middleName'] = $middleName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['suffix'] = $suffix;
        $_SESSION['birthday'] = $birthday;
        $_SESSION['address'] = $address;
        $_SESSION['contactNumber'] = $contactNumber;
        $_SESSION['emailAddressReg'] = $emailAddress;
        $_SESSION['passwordReg'] = $password;

        // Unset session variables if there are no errors
        unset($_SESSION['firstName_error'], $_SESSION['middleName_error'], $_SESSION['lastName_error'], $_SESSION['suffix_error'], $_SESSION['birthday_error'], $_SESSION['address_error'], $_SESSION['contactNumber_error'], $_SESSION['emailAddressReg_error'], $_SESSION['passwordReg_error'], $_SESSION['confirmPasswordReg_error']);


        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email address format.";
            header("Location: ../register.php");
            exit;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: ../register.php");
            exit;
        }

        if (strlen($password) < 8) {
            $_SESSION['error'] = "Password should be at least 8 characters long.";
            header("Location: ../register.php");
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE emailAddress = ?");
        $stmt->execute([$emailAddress]);
        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Email address already exists. Please use a different email address.";
            header("Location: ../register.php");
            exit;
        }

        $profilePicture = ''; // Initialize profile picture variable
        if (isset($_FILES['profilePicture']['name']) && !empty($_FILES['profilePicture']['name'])) {
            $img_name = $_FILES['profilePicture']['name'];
            $tmp_name = $_FILES['profilePicture']['tmp_name'];
            $error = $_FILES['profilePicture']['error'];
            $file_size = $_FILES['profilePicture']['size'];

            // Set maximum file size (in bytes)
            $max_file_size = 5 * 1024 * 1024; // 5 MB

            if ($error === 0) {
                if ($file_size <= $max_file_size) { // Check if file size is within the limit
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_to_lc = strtolower($img_ex);

                    $allowed_exs = array('jpg', 'jpeg', 'png');
                    if (in_array($img_ex_to_lc, $allowed_exs)) 
                    {
                        $new_img_name = uniqid('profile', true) . '.' . $img_ex_to_lc;
                        $img_upload_path = '../upload/' . $new_img_name; // Directory where profile pictures will be stored

                        // Move the uploaded file to the target directory
                        if (move_uploaded_file($tmp_name, $img_upload_path)) 
                        {
                            // File uploaded successfully
                            $profilePicture = $img_upload_path;
                        } 
                        else 
                        {
                            throw new Exception("Error uploading profile picture.");
                        }
                    } 
                    else 
                    {
                        throw new Exception("Invalid file format. Allowed formats: JPG, JPEG, PNG.");
                    }
                } 
                else 
                {
                    throw new Exception("Profile picture size exceeds the maximum limit of 5MB.");
                }
            } 
            else 
            {
                throw new Exception("Error uploading profile picture: $error");
            }
        } 
        else 
        {
            throw new Exception("Profile picture is required.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (firstName, middleName, lastName, suffix, birthday, address, contactNumber, profilePicture, emailAddress, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->execute([$firstName, $middleName, $lastName, $suffix, $birthday, $address, $contactNumber, $profilePicture, $emailAddress, $hashedPassword]);

        if ($stmt->rowCount() > 0) 
        {
            session_start();
            $_SESSION['registration_success'] = "You have succesfully registered!"; 
            header("Location: ../login.php"); 
            exit;
        } 
        else 
        {
            throw new Exception("Registration failed. Please try again.");
        }
    } 
    else 
    {
        $_SESSION['missing_fields_error'] = "Missing required fields.";

        // Store form values in session
        $_SESSION['firstName'] = $_POST['firstName'];
        $_SESSION['middleName'] = $_POST['middleName'];
        $_SESSION['lastName'] = $_POST['lastName'];
        $_SESSION['suffix'] = $_POST['suffix'];
        $_SESSION['birthday'] = $_POST['birthday'];
        $_SESSION['address'] = $_POST['address'];
        $_SESSION['contactNumber'] = $_POST['contactNumber'];
        $_SESSION['emailAddressReg'] = $_POST['emailAddressReg'];
        $_SESSION['passwordReg'] = $_POST['passwordReg'];
        $_SESSION['confirmPasswordReg'] = $_POST['confirmPasswordReg'];

        header("Location: ../register.php");
        exit;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();

    unset($_SESSION['firstName'], $_SESSION['middleName'], $_SESSION['lastName'], $_SESSION['suffix'], $_SESSION['birthday'], $_SESSION['address'], $_SESSION['contactNumber']);
}
?>
