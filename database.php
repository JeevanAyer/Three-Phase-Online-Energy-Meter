<?php
$hostname="localhost";
$dbUser="root";
$dbPassword="";
$dbName="sem";
$conn = mysqli_connect($hostname, $dbUser, $dbPassword, $dbName);
if (!$conn){
    die("Something went wrong;");
}
