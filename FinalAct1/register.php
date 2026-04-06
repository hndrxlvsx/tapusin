<?php
session_start();
require 'db.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Username already taken.";
        } else {
            // Hash the password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $insert_stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($insert_stmt->execute([$username, $hashed_password])) {
                $success = "Registration successful! You can now <a href='login.php'>log in</a>.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - NeuralChat</title>
    <style>
        body { font-family: Arial; background: #0d0f14; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: #111318; padding: 30px; border-radius: 8px; text-align: center; width: 300px; }
        input { width: 90%; padding: 10px; margin: 10px 0; background: #181b22; border: 1px solid #333; color: white; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #4f8ef7; border: none; color: white; border-radius: 4px; cursor: pointer; margin-top: 10px; }
        a { color: #4f8ef7; text-decoration: none; }
        .error { color: #e74c3c; font-size: 14px; }
        .success { color: #2ecc71; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
        <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
        
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Create Account</button>
        </form>
        <p style="font-size: 14px; margin-top: 20px;">Already have an account? <a href="login.php">Log in</a></p>
    </div>
</body>
</html>
