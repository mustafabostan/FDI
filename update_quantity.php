<?php
include 'connect.php';

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

$stmt = $con->prepare("UPDATE cart SET quantity = ? WHERE product_id = ?");
$stmt->bind_param("ii", $_POST['quantity'], $_POST['product_id']); 
$stmt->execute();

$stmt = $con->prepare("SELECT * FROM product WHERE id = ?");
$stmt->bind_param("i", $_POST['product_id']); 
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$total_price = $product['price'] * $quantity;

echo json_encode(['total_price' => $total_price]);
?>