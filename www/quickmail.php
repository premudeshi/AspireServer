<?php
require "login/loginheader.php"; 
include 'dbconf.php';

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
$user = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $number = test_input($_POST["number"]);


}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$subject = "Claim Number " . $number . "Quick Stats";

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

$sql1 = "SELECT * FROM members WHERE username = '$user'";
$result1 = $conn->query($sql1);

if ($result1->num_rows > 0) {
    // output data of each row
    while($row1 = $result1->fetch_assoc()) {
        $email = $row1["email"];
               

    }
} else {
    echo "0 results";
}


//Create a new PHPMailer instance
$mail = new PHPMailer;

$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Set the hostname of the mail server
$mail->Host = 'mail.claims.co.tz';
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = 'web@claims.co.tz';
//Password to use for SMTP authentication
$mail->Password = 'Aspireglobal4321!';

//Set who the message is to be sent from
$mail->setFrom('web@claims.co.tz', 'Web System');
//Set an alternative reply-to address
//Set who the message is to be sent to
$mail->addAddress($email, $user);
//Set the subject line
$mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->Body = '
	<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
</style>
<h1>The quick stats of the claim have been listed below. </h1><br>
<table class="tg">
  <tr>
    <th class="tg-yw4l" colspan="2">Claim Information</th>
  </tr>
  <tr>
    <td class="tg-yw4l">Insured</td>
    <td class="tg-yw4l">' . $ins . '</td>
  </tr>
  <tr>
    <td class="tg-yw4l">Insurance Company</td>
    <td class="tg-yw4l">' . $company . '</td>
  </tr>
  <tr>
    <td class="tg-yw4l">Broker</td>
    <td class="tg-yw4l">'. $broker .'</td>
  </tr>
  <tr>
    <td class="tg-yw4l">Claim Number</td>
    <td class="tg-yw4l">'.$number.'</td>
  </tr>
  <tr>
    <td class="tg-yw4l">Status</td>
    <td class="tg-yw4l">'.$status.'</td>
  </tr>
  <tr>
    <td class="tg-yw4l">Date Started</td>
    <td class="tg-yw4l">'.$date.'</td>
  </tr>
  <tr>
    <td class="tg-yw4l">Address of Claim</td>
    <td class="tg-yw4l">'.$address.'</td>
  </tr>
</table>
';
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}

?>