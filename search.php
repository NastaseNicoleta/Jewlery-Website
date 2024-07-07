<?php
include 'db.php';

$query = $_GET['query'] ?? ''; // Preluăm query-ul trimis
$query = $conn->real_escape_string($query);

$sql = "SELECT id, name, description, price, image FROM products WHERE name LIKE '%$query%'";
$result = $conn->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

header('Content-Type: application/json');
echo json_encode($products);
$conn->close();
?>
