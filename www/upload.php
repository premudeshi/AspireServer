<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $str = test_input($_POST["upload"]);


}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


$values = explode(" ", $str);


$number = $values[0]; // piece1

$upload = $values[1];


echo $number . " number<br>";
echo $upload . " Upload<br>";

?>
<html>


<form action="ud.php" method="POST" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="file" />

       <input id="number" name="number" type="hidden" value="<?php echo $number ?>">
       <input id="upload" name="upload" type="hidden" value="<?php echo $upload ?>">
       
     <input type="submit" value="Upload File" />

</form>


</html>