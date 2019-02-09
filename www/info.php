<?php
include 'dbconf.php';
require "login/loginheader.php"; 
$user = $_SESSION['username'];
require "vendor/autoload.php"; 

$police = "Police";
$policy = "Policy";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $number = test_input($_POST["choose"]);


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


$sql1 = "SELECT * FROM documents WHERE number = '$number'";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
    // output data of each row
    while($row1 = $result1->fetch_assoc()) {
        $police = $row1["PoliceReport"];
        $Policy = $row1["Policy"];
        $policereport = $row1["PoliceReport"];
        $policy = $row1["Policy"];
        $fire = $row1["FireReport"];
            

    }
} else {
    echo "0 results";
}


$conn->close();


if ($type == 'Buglary' ) {
  $info = array("Police Report"=>$policereport, "Policy"=>$policy);
}elseif ($type == 'Fire') {
  $info = array("Police Report"=>$policereport, "Policy"=>$policy, "Fire Report"=>$fire);
}



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
    <h5><b><i class="fa fa-info"></i> Claim Info</b></h5>
  </header>
 <div class="w3-container">
<h5>Overview:</h5>
<form action="quickmail.php" method="post"><button name="number" type="submit" value="<?php echo $number; ?>"><a class="w3-bar-item w3-button"><i class="fa fa-share-square-o"></i></a></button></form>

    <ul class="w3-ul w3-card-4 w3-white">
      <li class="w3-padding-16">
        <span class="w3-xlarge">Claim Number:</span><br>
        <span class="w3-xlarge"><i><?php echo $number; ?></i></span><br>
      </li>
      <li class="w3-padding-16">
        <span class="w3-xlarge">Type:</span><br>
        <span class="w3-xlarge"><i><?php echo $type; ?></i></span><br>
      </li>
      <li class="w3-padding-16">
        <span class="w3-xlarge">Status:</span><br>
<form action="status.php" method="post"><button name="number" type="submit" value="<?php echo $number; ?>"><a class="w3-bar-item w3-button"><i class="fa fa-pencil-square-o"></i></a></button></form><br>
          <?php
if ($status == 'Started') {
echo '<div class="w3-grey"><div class="w3-container w3-center w3-padding w3-green w3-text-black" style="width:5%">Started</div></div></div>';
}elseif ($status == 'Awaiting Documents') {
echo '<div class="w3-grey"><div class="w3-container w3-center w3-padding w3-yellow" style="width:25%">Awaiting Documents</div></div>';
}elseif ($status == 'Writing Report') {
echo '<div class="w3-grey"><div class="w3-container w3-center w3-padding w3-green" style="width:50%">Writing Report</div></div>';
}elseif ($status == 'Completed Soft Copy') {
echo '<div class="w3-grey"><div class="w3-container w3-center w3-padding w3-green" style="width:75%">Completed Soft-Copy, Yet to deliver</div></div>';
}elseif ($status == 'Claim Completed') {
echo '<div class="w3-grey"><div class="w3-container w3-center w3-padding w3-green" style="width:100%">Completed Soft-Copy, Yet to deliver</div></div>';
}elseif ($status == 'Claim Closed') {
echo '<div class="w3-grey"><div class="w3-container w3-center w3-padding w3-red" style="width:100%">Claim Closed</div></div>';
}
?>

</li>
</ul>
<div class="w3-container">
<h5>Information</h5>
        <table class="w3-table w3-striped w3-white">
          <tr>
            <td>Insured <i class="fa fa-university w3-text-blue w3-large"></i></td>
            <td><?php echo $ins; ?></td>
            <td><i>See Information</i></td>
          </tr>
          <tr>
            <td>Insurance Company <i class="fa fa-university w3-text-red w3-large"></i></td>
            <td><?php echo $company; ?></td>
            <td><i>See Information</i></td>
          </tr>
          <tr>
            <td>Broker <i class="fa fa-university w3-text-orange w3-large"></i></td>
            <td><?php echo $broker; ?></td>
            <td><i>See Information</i></td>
          </tr>
          <tr>
            <td>Claim Date <i class="fa fa-calendar w3-text-green w3-large"></i></td>
            <td><?php echo $date; ?></td>
            <td><i>
            <?php $now = time(); // or your date as well
			$your_date = strtotime($date);
			$datediff = $now - $your_date;

			echo floor($datediff / (60 * 60 * 24));
			echo " days since Begining"; ?></i></td>
          </tr>
          
          <tr>
            <td>Location <i class="fa fa-map-marker w3-text-blue w3-large"></i></td>
            <td><?php echo $address; ?></td>
          </tr>

        </table>

    <h5>Documents</h5>
  <form action="upload.php" method="post">
<table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
<?php

foreach($info as $x => $x_value) {
    echo "<td>". $x . "</td><td>";
    
    if ($x_value == '0') {
      echo '<i class="fa fa-times" aria-hidden="true"></i>';
      } 
      else {

      echo '<i class="fa fa-check" aria-hidden="true"></i>';
    }
echo '</td><td><button name="upload" type="submit" value="'. $number .' '.$x. '">Submit</button></td></tr>';

}


?>
</table>
<br>
<br>
<h2>Logs</h2>
<table id="claim">
  <tr>
    <th>Claim Number</th>
    <th>User</th>
    <th>Date Logged</th>
    <th>Started</th>
    <th>Stopped</th>
    <th>Description</th>
  </tr>
  <?php





// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
} 

$sql = "SELECT * FROM logs WHERE number = '$number'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["number"]. "</td>";
        echo "<td>" . $row["user"]. "</td>";
        echo "<td>" . $row["datelog"]. "</td>";
        echo "<td>" . $row["start"]. "</td>";
        echo "<td>" . $row["stop"]. "</td>";
        echo "<td>" . $row["description"]. "</td>";
        echo "</tr>";
    }
} else {
    echo "None for this claim";
}


$conn->close();

  ?>

</table>


</form>
  
  
  
  </div>

</div>
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

