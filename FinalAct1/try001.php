<?php
session_start();

// Protect the page: Redirect to login if the session isn't set
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$app_name = "NeuralChat";
// Safely grab the logged-in user's name
$current_user = htmlspecialchars($_SESSION['username']); 
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $app_name ?></title>
    <style>
        body { font-family: Arial; background: #0d0f14; color: white; margin: 0; display: flex; height: 100vh; }
        .app { display: flex; width: 100%; }
        .sidebar {
            display: flex;
            flex-direction: column;
            width: 220px;
            background: #111318;
            padding: 15px;
            border-right: 1px solid #333;
        }
        .user-greeting {
            font-size: 14px;
            color: #888;
            margin-bottom: 20px;
        }
        button { padding: 10px; background: #4f8ef7; border: none; color: white; border-radius: 4px; cursor: pointer; margin-bottom: 10px;}
        .logout-btn {
            background: #e74c3c !important; 
            margin-top: auto; /* Pushes it to the bottom of the sidebar */
        }
        .main-chat {
            flex-grow: 1;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #555;
        }
    </style>
</head>

<body>

<div class="app">

    <div class="sidebar">
        <h2><?= $app_name ?></h2>
        <div class="user-greeting">Welcome, <?= $current_user ?>!</div>
        
        <button onclick="alert('Start a new chat!')">+ New Chat</button>
        
        <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    </div>
    
    <div class="main-chat">
        <h2>Select or start a chat to begin.</h2>
    </div>

</div>

</body>
</html>
