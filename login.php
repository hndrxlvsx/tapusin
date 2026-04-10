<?php
session_start();
require 'db.php'; // Connect to the database

$error = '';
$success = '';

// Check if they just came from a successful registration
if (isset($_GET['registered']) && $_GET['registered'] == 'success') {
    $success = "Registration successful! You can now log in.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        // Find the user by username
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Log the user in by setting session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Redirect to the main app
            header("Location: try001.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - NeuralChat</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0d0f14; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: #111318; padding: 40px; border-radius: 12px; text-align: center; width: 320px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8), 0 0 20px rgba(79, 142, 247, 0.1); border: 1px solid rgba(255, 255, 255, 0.05); }
        h2 { margin-top: 0; margin-bottom: 25px; font-weight: 600; letter-spacing: 1px; }
        input { width: 90%; padding: 12px; margin: 10px 0; background: #181b22; border: 1px solid #333; color: white; border-radius: 6px; outline: none; transition: border-color 0.3s; }
        input:focus { border-color: #4f8ef7; }
        button { width: 100%; padding: 12px; background: linear-gradient(135deg, #4f8ef7, #2662d9); border: none; color: white; border-radius: 6px; cursor: pointer; margin-top: 15px; font-weight: bold; font-size: 16px; transition: transform 0.2s, box-shadow 0.2s; }
        button:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(79, 142, 247, 0.4); }
        a { color: #4f8ef7; text-decoration: none; transition: color 0.3s; }
        a:hover { color: #6b9fff; }
        .error { color: #e74c3c; font-size: 14px; background: rgba(231, 76, 60, 0.1); padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .success { color: #2ecc71; font-size: 14px; background: rgba(46, 204, 113, 0.1); padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Log In</h2>
        <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
        <?php if ($success): ?><div class="success"><?= $success ?></div><?php endif; ?>
        
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Access NeuralChat</button>
        </form>
        <p style="font-size: 14px; margin-top: 25px; color: #888;">New here? <a href="register.php">Create an account</a></p>
    </div>
</body>
</html>