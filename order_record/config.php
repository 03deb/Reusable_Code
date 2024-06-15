<?php
 // Database connection details
 $servername = "127.0.0.1";
 $username = "root";
 $password = "";
 $dbname = "order_record";

 // Create connection
 $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
 // Set the PDO error mode to exception
 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
