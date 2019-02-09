<?php
require "login/loginheader.php"; 

require 'vendor/autoload.php';
$user = $_SESSION['username'];
include 'dbconf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $number = test_input($_POST["number"]);
  $update = test_input($_POST["update"]);


}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
} 

$sql = "SELECT * FROM claims WHERE number = '$number'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $ins = $row["insured"];
        $number = $row["number"];
        $type = $row["type"];
        $status = $row["status"];
        $company = $row["insurer"];
        $date = $row["date"];
        $broker = $row["broker"];
        $address = $row["location"];
    }
} else {
    echo "0 results";
}

?>



<!DOCTYPE html>
<html>
<title>Vital Water Gateway</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/google.css">
<link rel="stylesheet" href="css/font-awesome.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right">Aspire Gateway</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
       <img src="images/logo2.png" alt="Vital Water" style="width:75px;height:75px;" class="w3-circle w3-margin-right">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong><?php echo $user;?></strong></span><br>
      <a href="notifyemail.php" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="login/logout.php" class="w3-bar-item w3-button"><i class="fa fa-caret-square-o-right"></i></a>
      <a href="settings.php" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="index.php" class="w3-bar-item w3-button w3-padding "><i class="fa fa-users fa-fw"></i>  Overview</a>
    <a href="claims.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-gavel fa-fw"></i>  Claims</a>
    <a href="company.php" class="w3-bar-item w3-button w3-padding "><i class="fa fa-plus fa-fw"></i>  Register Company</a>
    <a href="document.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-paperclip fa-fw"></i>  Documents</a>
    <a href="todo.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-th-list fa-fw"></i>  To-Do</a>
    <a href="news.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bell fa-fw"></i>  News</a>
  </div>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h2><b><i class="fa fa-folder-open"></i> Status</b></h2>
  </header>
 <div class="w3-container">
<?php

$link = mysqli_connect($servername, $username, $password, $dbname);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt update query execution
$sql = "UPDATE claims SET status ='$update' WHERE number = '$number'";
if(mysqli_query($link, $sql)){
    echo "Records were updated successfully.";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$t=time();
$cd = date("Y-m-d",$t);
$desc = "Claim status updated to " . $status;

$sql3 = "INSERT INTO logs (user, number, start, stop, description)
VALUES ('$user', '$number', '$cd' , '$cd', '$desc') ";


if ($conn->query($sql3) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql3 . "<br>" . $conn->error;
}


?>

</div>
</html>