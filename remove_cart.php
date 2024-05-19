<?php
include 'connect.php';
session_start();
$user_id = $_SESSION['id'];
$product_id = $_POST['product_id'];

$stmt = $con->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $_SESSION['id'], $_POST['product_id']); 
$stmt->execute();
$result = $stmt->get_result();
?>