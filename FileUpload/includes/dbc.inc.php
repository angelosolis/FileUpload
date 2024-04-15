<?php
$dsn = "mysql:host=localhost;dbname=activity";
$dbusername = "root";
$dbpassword = "";

try 
{
    $conn = new PDO($dsn, $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) 
{
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
