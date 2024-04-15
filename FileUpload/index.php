<?php 
session_start();

include_once "includes/dbc.inc.php";

if (isset($_SESSION['userId']) && isset($_SESSION['firstName'])) 
{
    include 'includes/User.php';
    $user = getUserById($_SESSION['userId'], $conn);
}

else 
{ 
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>
    <?php if ($user) {?>
    <div class="d-flex justify-content-center align-items-center vh-100">
 
    <div class="shadow w-350 p-3 text-center">
    <div style="width: 150px; height: 150px; overflow: hidden; border-radius: 50%; margin: 0 auto;">
        <img src="upload/<?=$user['profilePicture']?>" class="img-fluid" style="width: auto; height: 100%; object-fit: cover;" alt="Profile Picture">
    </div>
    <h3 class="display-4"><?=$user['firstName']?> <?=$user['middleName']?> <?=$user['lastName']?> <?=$user['suffix']?></h3>
    <p><strong>Birthday:</strong> <u><?=$user['birthday']?></u></p>
    <p><strong>Address:</strong> <u><?=$user['address']?></u></p>
    <p><strong>Contact Number:</strong> <u><?=$user['contactNumber']?></u></p>
    <p><strong>Email Address:</strong> <u><?=$user['emailAddress']?></u></p>
    <a href="logout.php" class="btn btn-warning">Logout</a>
</div>
</div>
</body>
</html>
<?php 
} 
else 
{
    header("Location: login.php");
    exit;
} 
?>
