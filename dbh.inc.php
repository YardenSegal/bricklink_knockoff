<?php

 $servername = "localhost";
 $dBUsername = "testuser";
 $dBPassword = "";
 $dBname = "testdb";

 $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBname);

if(!$conn){
 	die("Failed to connect".mysqli_connect_error());
}