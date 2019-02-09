<?php
require "login/loginheader.php"; 
include 'dbconf.php';

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
$user = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sendto = test_input($_POST["sendto"]);
  $post = test_input($_POST["post"]);
  $title = test_input($_POST["title"]);
  $claimnumber = test_input($_POST["claimnumber"]);


}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

    $subject = "You have got a new Post!";

    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                        
                    } 

                    $sql = "SELECT * FROM members WHERE id = '$sendto' ";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            $semail = $row["email"];
                            $username = $row["username"];

                        }
                    } else {
                        $semail = "aspireinsurance@googlegroups.com";
                        $username = "public";

                    }
                    $sql1 = "INSERT INTO tasks (sender, recipeient, title, description, claim)
                    VALUES ('$user', '$username', '$title', '$post', '$claimnumber')";
                    
                    if ($conn->query($sql1) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
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
                    $mail->addAddress($semail, $user);
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
                    <h1>You have got a New post! </h1><br>
                    <table class="tg">
                      <tr>
                        <th class="tg-yw4l" colspan="2">Claim Information</th>
                      </tr>
                      <tr>
                        <td class="tg-yw4l">From</td>
                        <td class="tg-yw4l">' . $user . '</td>
                      </tr>
                      <tr>
                        <td class="tg-yw4l">Title of Post</td>
                        <td class="tg-yw4l">' . $title . '</td>
                      </tr>
                      <tr>
                        <td class="tg-yw4l">Post</td>
                        <td class="tg-yw4l">'. $post .'</td>
                      </tr>
                      <tr>
                        <td class="tg-yw4l">Claim Number</td>
                        <td class="tg-yw4l">'.$claimnumber.'</td>
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


                    $conn->close();






?>