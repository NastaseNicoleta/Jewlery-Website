<?php
session_start();
include 'db.php';

// Verifică dacă coșul de cumpărături există în sesiune
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Golește coșul dacă utilizatorul dorește
if (isset($_GET['action']) && $_GET['action'] == 'empty') {
    $_SESSION['cart'] = array();
    header("Location: cart.php");
    exit;
}

// Calculul totalului coșului
$total = 0;
if (count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "SELECT name, price FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $total += $row['price'] * $quantity;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coșul tău de cumpărături</title>
    <link rel="stylesheet" href="style.css">
    <script>
function showConfirmation() {
    alert('Comanda ta a fost înregistrată cu succes și va porni către tine în cel mai scurt timp!');
    // Optional: Redirecționează către o altă pagină sau reîncarcă pagina pentru a golirea coșului vizual
    window.location.href = 'welcome.php'; // Redirecționează utilizatorul către pagina principală sau altă pagină de confirmare
}
</script>

</head>
<body>
    <header>
    <a href="welcome.php">
        <img src="logo.png" alt="Glamour Gems Logo" style="width: 100px;">
    </a>
        <h1>Coșul de Cumpărături</h1>
        <nav>
            <ul>
                <li><a href="welcome.php">Înapoi la magazin</a></li>
                <li><a href="cart.php?action=empty">Golește coșul</a></li>
                <li><button onclick="showConfirmation()">Finalizează comanda</button>
</li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="products">
            <?php
            if (count($_SESSION['cart']) > 0) {
                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    $sql = "SELECT name, price FROM products WHERE id = $product_id";
                    $result = $conn->query($sql);
                    if ($row = $result->fetch_assoc()) {
                        echo '<div class="product">';
                        echo '<p>' . $row['name'] . ' - ' . $quantity . ' x ' . $row['price'] . ' RON</p>';
                        echo '<form action="remove_from_cart.php" method="post">';
                        echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
                        echo '<button type="submit">Șterge</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                }
                echo '<h2>Total: ' . $total . ' RON</h2>';
            } else {
                echo '<p>Coșul tău este gol.</p>';
            }
            ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Glamour Gems. Toate drepturile rezervate.</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>
