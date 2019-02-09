<?php
include 'dbconf.php';
require "login/loginheader.php"; 

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
$user = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $value = test_input($_POST["data"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$val = explode(" ", $value);


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE tasks SET priority='1' WHERE id='$val[0]'";



if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();

header('Location: profile.php');
?>