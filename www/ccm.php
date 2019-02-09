<?php
require "login/loginheader.php"; 
include "ftp.php"; 
$user = $_SESSION['username'];
require "vendor/autoload.php"; 
include 'dbconf.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $number = test_input($_POST["number"]);
  $type = test_input($_POST["type"]);
  $insured = test_input($_POST["insured"]);
  $inscompany = test_input($_POST["insurancecompany"]);
  $broker = test_input($_POST["broker"]);
  $address = test_input($_POST["add"]);
  $ins = test_input($_POST["ins"]);


}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$date = $_POST["date"];
$mysqltime = $date;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO claims (number, type, date, status, insured, insurer, broker, location )
VALUES ('$number', '$type', '$mysqldate' , 'Started', '$insured', '$ins', '$broker', '$address') ";

$sql1 = "INSERT INTO documents (number, `PoliceReport`, `Policy`, `FireReport`)
VALUES ('$number', '0', '0', '0') ";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

if ($conn->query($sql1) === TRUE) {
    echo "New record created successfully";

} else {
    echo "Error: " . $sql1 . "<br>" . $conn->error;
}

$sql3 = "INSERT INTO claims (number, type, date, status, insured, insurer, broker, location )
VALUES ('$number', '$type', '$date' , 'Started', '$insured', '$ins', '$broker', '$address') ";
if ($conn->query($sql3) === TRUE) {
  echo "New record created successfully";

} else {
  echo "Error: " . $sql3 . "<br>" . $conn->error;
}

$t=time();
$cd = date("Y-m-d",$t);



$folder = $home . $number; 

// connect and login to FTP server

$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

$dir = $folder;

// try to create directory $dir
if (ftp_mkdir($ftp_conn, $dir))
  {
  echo "Successfully created $dir";
  }
else
  {
  echo "Error while creating $dir";
  }

// close connection
ftp_close($ftp_conn);


?>

<!DOCTYPE html>
<html>
<title>Aspire Gateway</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/google.css">
<link rel="stylesheet" href="css/font-awesome.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}

#claim {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#claim td, #claim th {
    border: 1px solid #ddd;
    padding: 8px;
}

#claim tr:nth-child(even){background-color: #f2f2f2;}

#claim tr:hover {background-color: #ddd;}

#claim th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}

/* The alert message box */
.alert {
    padding: 20px;
    background-color: green; /* Red */
    color: white;
    margin-bottom: 15px;
}

/* The close button */
.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

/* When moving the mouse over the close button */
.closebtn:hover {
    color: black;
}
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
    <a href="company.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-plus fa-fw"></i>  Register Company</a>
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
    <h5><b><i class="fa fa-gavel"></i> Claims</b></h5>
        <a href="createclaim.php" class="w3-bar-item w3-button"><i class="fa fa-plus"></i></a>

  </header>

<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  Claim Created Sucsessfully!
</div>

<div class="w3-container">
<form action="info.php" method="post">
<table id="claim">
  <tr>
    <th>Claim Number</th>
    <th>Type</th>
    <th>Date</th>
    <th>Status</th>
    <th>Insured</th>
    <th>Insurance Company</th>
    <th>Broker</th>
    <th>Location</th>
    <th></th>
  </tr>
  <?php

echo $number;
echo $type;
echo $insured;
echo $inscompany;
echo $broker;
echo $address;
echo $ins;
echo $date;



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
} 

$sql = "SELECT * FROM claims";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["number"]. "</td>";
        echo "<td>" . $row["type"]. "</td>";
        echo "<td>" . $row["date"]. "</td>";
        echo "<td>" . $row["status"]. "</td>";
        echo "<td>" . $row["insured"]. "</td>";
        echo "<td>" . $row["insurer"]. "</td>";
        echo "<td>" . $row["broker"]. "</td>";
        echo "<td>" . $row["location"]. "</td>";
        echo '<td><button name="choose" value=' . $row["number"] .' type="submit" class="btn btn-default">
                    <i class="fa fa-info-circle"></i></button></td>';

        
        echo "</tr>";
    }
} else {
    echo "0 results";
}





$conn->close();

  ?>


</table>
</form>
</div>

  <!-- End page content -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>


