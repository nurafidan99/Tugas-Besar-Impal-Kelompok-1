<?php
$conn = new mysqli("localhost", "root", "", "db_tugasimpal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connection successful!";
?>