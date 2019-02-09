
<?php

include 'dbconf.php';
include 'ftp.php';
require "login/loginheader.php"; 
$user = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $str = test_input($_POST["confirm"]);
  $number = test_input($_POST["number"]);
  $upload = test_input($_POST["upload"]);


}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


// setup of connection
$conn_id = ftp_connect($ftp_server) or die("could not connect to $ftp_server");

// login
if (@ftp_login($conn_id, $ftp_username, $ftp_userpass))
{
  echo "conectd as $ftp_username@$ftp_server\n";
}
else
{
  echo "could not connect as $ftp_username\n";
}

$file = $_FILES["file"]["name"];
$remote_file_path = "server/". $number. "/" .$file;
ftp_put($conn_id, $remote_file_path, $_FILES["file"]["tmp_name"], FTP_ASCII); // right
ftp_close($conn_id);
echo "\n\nconnection closed";
$folder = "server/". $number; 


$link = mysqli_connect($servername, $username, $password, $dbname);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt update query execution
$sql = "UPDATE documents SET " . $upload . "='1' WHERE number= '$number'";
if(mysqli_query($link, $sql)){
    echo "Records were updated successfully.";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


$t=time();
$cd = date("Y-m-d",$t);
$desc = "Uploaded " . $upload;
$sql3 = "INSERT INTO logs (user, number, start, stop, description)
VALUES ('$user', '$number', '$cd' , '$cd', '$desc') ";


if ($conn->query($sql3) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql3 . "<br>" . $conn->error;
}



// close the FTP stream 
//ftp_close($conn_id);





?>




<?php

?>