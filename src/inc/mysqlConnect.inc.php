<?php
$mysqlusername = "root";
$mysqlpassword = "";
$mysqlhostname = "localhost";
$mysqldb = "ppuzzle";
//connection to the database
$conn = new mysqli($mysqlhostname, $mysqlusername, $mysqlpassword, $mysqldb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("SET NAMES 'utf8'");

?>
