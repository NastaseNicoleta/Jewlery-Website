<?php
session_start(); // Start sau continuă o sesiune
include 'db.php'; // Include scriptul de conectare la baza de date

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Setează variabilele de sesiune
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email']; // Asigură-te că această linie există și este corectă
            // Redirecționează la pagina welcome.php după autentificarea cu succes
            header("Location: welcome.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "Username does not exist!";
    }

    $conn->close();
}
?>
