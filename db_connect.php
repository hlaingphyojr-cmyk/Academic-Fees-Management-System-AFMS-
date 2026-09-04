<?php
// $servername = "localhost";
// $username = "root";
// $password = "";

// try {
//   $conn = new PDO("mysql:host=$servername;dbname=sfps_db", $username, $password);
//   // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
// } catch(PDOException $e) {
//   echo "Connection failed: " . $e->getMessage();
// }


 $conn= new mysqli('localhost','root','','sfps_db') or die("Could not connect to mysql".mysqli_error($conn));

?>