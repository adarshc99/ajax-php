<?php

$student_id = $_POST["id"];
$firstName = $_POST["f_name"];
$lastName = $_POST["l_name"];

$conn = mysqli_connect("localhost","root","","test") or die("Connection Failed");

$sql = "UPDATE students SET first_name = '{$firstName}',last_name = '{$lastName}' WHERE id = {$student_id}";

if(mysqli_query($conn, $sql)){
  echo 1;
}else{
  echo 0;
}

?>
