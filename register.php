<?php
include 'db.php'; // Include scriptul de conectare la baza de date

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        echo "New user registered successfully!";
        header("Location: index.html"); // Redirecționează la pagina principală
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Înregistrare</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
</head>
<body>
    <h2>Înregistrare</h2>
    <form id="registrationForm" action="register.php" method="post">
        <label for="username">Nume utilizator:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="email">Adresă de email:</label>
        <input type="email" id="email" name="email" required><span id="emailValid"></span><br>
        <label for="password">Parolă:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Înregistrare">
    </form>
</body>
</html>
