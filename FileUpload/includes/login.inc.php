<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    include_once "dbc.inc.php";

    $emailAddress = $_POST['emailAddress'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE emailAddress = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$emailAddress]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if ($user) {

        if (password_verify($password, $user['password']))
         {
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['emailAddress'] = $user['emailAddress'];
            header("Location: ../index.php");
            exit;
        } 
        else 
        {
            $_SESSION['error'] = "Incorrect password";
            $_SESSION['tempEmail'] = $_POST['emailAddress'];
            header("Location: ../login.php");
            exit;
        }

    } 
    else 
    {
        $_SESSION['error'] = "No email address found";
        header("Location: ../login.php");
        exit;
    }
} 
else 
{
    header("Location: ../login.php");
    exit;
}
?>
