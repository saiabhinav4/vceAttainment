<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "multicoattainments";
$con = new mysqli($servername, $username, $password, $dbname);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}



function get_department($dep){
    global $con;
   $retrive_dept="SELECT sname from department where dname=?";
   $stmt=$con->prepare($retrive_dept);
   $stmt->bind_param("s",$dep);
   $stmt->execute();
   $result=$stmt->get_result();
   $row=$result->fetch_row();
   return $row[0];
}












?>