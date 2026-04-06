<?php
session_start();
require 'db.php';

// If user is already logged in, redirect to the chat app
if (isset($_SESSION['user_id'])) {
    header("Location: try001.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password against the hashed password in the database
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            header("Location: try001.php"); // Redirect to your main app
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - NeuralChat</title>
    <style>
        /* Reusing the same styles from register.php for consistency */
        body { font-family: Arial; background: #0d0f14; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: #111318; padding: 30px; border-radius: 8px; text-align: center; width: 300px; }
        input { width: 90%; padding: 10px; margin: 10px 0; background: #181b22; border: 1px solid #333; color: white; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #4f8ef7; border: none; color: white; border-radius: 4px; cursor: pointer; margin-top: 10px; }
        a { color: #4f8ef7; text-decoration: none; }
        .error { color: #e74c3c; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
        
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p style="font-size: 14px; margin-top: 20px;">Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
