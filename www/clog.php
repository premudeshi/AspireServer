<?php
require "login/loginheader.php"; 
include "ftp.php"; 
$user = $_SESSION['username'];
require "vendor/autoload.php"; 
include 'dbconf.php';
$start = $_POST["start"];
$stop = $_POST["stop"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $number = test_input($_POST["number"]);
  $desc = test_input($_POST["description"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO logs (user, number, start, stop, description)
VALUES ('$user', '$number', '$start' , '$stop', '$desc') ";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
header('Location: todo.php');
?>