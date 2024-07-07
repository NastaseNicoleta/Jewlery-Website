<?php
session_start();
include 'db.php'; // Include conexiunea la baza de date

if (!isset($_SESSION['userId'])) {
    header('Location: login.php'); // Asigură-te că utilizatorul este logat
    exit();
}

// Logica pentru finalizarea comenzii
// Aici ai putea adăuga comanda în baza de date, scădea stocurile etc.
// Presupunem că toate acțiunile necesare sunt completate cu succes

// Redirecționează utilizatorul către o pagină de confirmare
header('Location: confirmare_comanda.php');
exit();
?>
