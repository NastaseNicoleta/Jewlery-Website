<?php
include 'db.php'; // Include scriptul de conectare la baza de date

// Verifică dacă formularul a fost trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preluarea datelor de autentificare din formular
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Pregătirea interogării SQL pentru a găsi utilizatorul după nume
    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    // Verifică dacă utilizatorul există
    if ($result->num_rows > 0) {
        // Preluarea hash-ului parolei din baza de date
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verificarea parolei introduse cu hash-ul din baza de date
        if (password_verify($password, $hashed_password)) {
            echo "Login successful!";
            // Odată autentificat, poți redirecționa utilizatorul către o altă pagină
            // header("Location: welcome.php"); // Schimbă 'welcome.php' cu calea paginii dorite
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "Username does not exist!";
    }

    // Închiderea conexiunii la baza de date
    $conn->close();
} else {
    // Dacă formularul nu a fost trimis, afișează formularul de login
    echo '<form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
          </form>';
}
?>
