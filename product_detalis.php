<?php
include 'db.php'; // Asigură-te că calea este corectă
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Preia ID-ul și validează-l

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "Produsul nu a fost găsit.";
    exit;
}
$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
    <p><?php echo htmlspecialchars($product['description']); ?></p>
    <p>Preț: <?php echo htmlspecialchars($product['price']); ?> RON</p>
    <a href="welcome.php">Înapoi la lista de produse</a>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
