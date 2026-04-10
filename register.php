<?php
session_start();
require 'db.php'; 

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $mi = trim($_POST['mi']); // Middle initial/name
    $email = trim($_POST['email']);

    if (empty($username) || empty($password) || empty($first_name) || empty($last_name) || empty($email)) {
        $error = "Please fill in all required fields.";
    } else {
        // Check if username or email is already taken
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Username or Email already taken.";
        } else {
            // Hash the password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert into the database using 'middle_name' as the column name
            $insert_stmt = $pdo->prepare("INSERT INTO users (username, password, first_name, last_name, middle_name, email) VALUES (?, ?, ?, ?, ?, ?)");
            
            if ($insert_stmt->execute([$username, $hashed_password, $first_name, $last_name, $mi, $email])) {
                header("Location: login.php?registered=success");
                exit();
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - NeuralChat</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0d0f14; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: #111318; padding: 40px; border-radius: 12px; text-align: center; width: 350px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8), 0 0 20px rgba(79, 142, 247, 0.1); border: 1px solid rgba(255, 255, 255, 0.05); }
        h2 { margin-top: 0; margin-bottom: 20px; font-weight: 600; letter-spacing: 1px; }
        .name-row { display: flex; gap: 10px; justify-content: space-between; }
        .name-row input { width: 48%; }
        input { width: 90%; padding: 12px; margin: 8px 0; background: #181b22; border: 1px solid #333; color: white; border-radius: 6px; outline: none; transition: border-color 0.3s; box-sizing: border-box; }
        input:focus { border-color: #4f8ef7; }
        button { width: 100%; padding: 12px; background: linear-gradient(135deg, #4f8ef7, #2662d9); border: none; color: white; border-radius: 6px; cursor: pointer; margin-top: 15px; font-weight: bold; font-size: 16px; transition: transform 0.2s, box-shadow 0.2s; }
        button:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(79, 142, 247, 0.4); }
        a { color: #4f8ef7; text-decoration: none; transition: color 0.3s; }
        a:hover { color: #6b9fff; }
        .error { color: #e74c3c; font-size: 14px; background: rgba(231, 76, 60, 0.1); padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
        
        <form method="POST" action="">
            <div class="name-row">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="mi" placeholder="M.I. (Optional)">
            </div>
            <input type="text" name="last_name" placeholder="Last Name" required style="width: 100%;">
            <input type="email" name="email" placeholder="Email Address" required style="width: 100%;">
            <input type="text" name="username" placeholder="Username" required style="width: 100%;">
            <input type="password" name="password" placeholder="Password" required style="width: 100%;">
            <button type="submit">Create Account</button>
        </form>
        <p style="font-size: 14px; margin-top: 25px; color: #888;">Already have an account? <a href="login.php">Log in</a></p>
    </div>
</body>
</html>