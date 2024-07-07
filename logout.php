<?php
session_start();
session_unset(); // Elimină toate variabilele de sesiune
session_destroy(); // Distruge sesiunea
header("Location: login.html"); // Redirecționează utilizatorul către pagina de login
exit();
?>
