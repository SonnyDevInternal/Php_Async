<?php 
require_once "databaseconnection.php";
$dbconn = new DatabaseConnection();

if($_SERVER["REQUEST_METHOD"] !== "POST") return;

$username = "";
$password = "";
$hashed_password = "";

$username = $_POST["username"];
$password = $_POST["password"];


setcookie("password", $password);
//^ DONT DO THIS ^


$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO user (name, hashed_password) VALUES ('$username', '$hashed_password')";

if ($dbconn->conn->query($sql) === TRUE){
    echo "Succesfully added User";
    header("Location: /index.php");
}
else {
    echo "Error: " . $dbconn->conn->error;
}


?>