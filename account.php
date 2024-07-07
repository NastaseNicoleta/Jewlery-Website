<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $new_password = $conn->real_escape_string($_POST['new_password']);
        $user_id = $_SESSION['user_id'];

        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET username = '$username', email = '$email', password = '$hashed_password' WHERE id = $user_id";
        } else {
            $sql = "UPDATE users SET username = '$username', email = '$email' WHERE id = $user_id";
        }

        if ($conn->query($sql) === TRUE) {
            echo "Account updated successfully.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $user_id = $_SESSION['user_id'];
        $sql = "DELETE FROM users WHERE id = $user_id";
        if ($conn->query($sql) === TRUE) {
            session_destroy();
            header('Location: login.html');
            exit();
        } else {
            echo "Error deleting account: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contul Meu</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
</head>
<body>
    <h1>Editare Cont</h1>
    <form action="account.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required value="<?php echo $_SESSION['username']; ?>"><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value="<?php echo $_SESSION['email']; ?>"><br>
        <label for="new_password">New Password (leave blank to not change):</label>
        <input type="password" id="new_password" name="new_password"><br>
        <input type="submit" name="update" value="Update Account">
        <input type="submit" name="delete" value="Delete Account" onclick="return confirm('Are you sure?');">
    </form>
</body>
<footer>
        <p>&copy; 2024 Glamour Gems. Toate drepturile rezervate.</p>
    </footer>
</html>
<?php $conn->close(); ?>
