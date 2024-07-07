<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: login.php'); // Asigură-te că utilizatorul este logat
    exit();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmare Comandă</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Confirmare Comandă</h1>
    </header>
    <main>
        <p>Comanda ta a fost înregistrată cu succes și va porni către tine în cel mai scurt timp!</p>
        <a href="index.php">Înapoi la pagina principală</a>
    </main>
</body>
</html>
