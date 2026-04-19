<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeuralChat - Grade Predictor</title>
    <style>

        :root {
            --bg-dark: #0d0f14;
            --bg-panel: #111318;
            --bg-chat: #1a1e29;
            --accent-blue: #4f8ef7;
            --accent-blue-hover: #2662d9;
            --text-light: #ffffff;
            --text-muted: #b0bacf;
            --border-color: rgba(255, 255, 255, 0.05);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            margin: 0;
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        .sidebar {
            width: 260px;
            background-color: var(--bg-panel);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.5);
            z-index: 10;
        }

        .brand {
            font-size: 24px;
            font-weight: 600;
            text-align: center;
            letter-spacing: 1px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
            text-shadow: 0 0 10px rgba(79, 142, 247, 0.3);
        }

        .brand span {
            color: var(--accent-blue);
        }

        .user-info {
            padding: 0 20px;
            margin-bottom: auto;
        }

        .user-info p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .user-info strong {
            color: var(--text-light);
            font-size: 16px;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin: 0 20px;
        }

        .nav-links li {
            margin-bottom: 10px;
        }

        .nav-links a {
            display: block;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-light);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            text-align: center;
        }

        .nav-links a:hover {
            background: rgba(79, 142, 247, 0.1);
            border-color: var(--accent-blue);
            box-shadow: 0 0 15px rgba(79, 142, 247, 0.2);
        }

        .btn-logout {
            background: linear-gradient(135deg, #e74c3c, #c0392b) !important;
            margin-top: 20px;
        }

        .main-chat {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background: var(--bg-chat);
            position: relative;
        }

        .main-chat::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 30px 30px;
            pointer-events: none;
            z-index: 0;
        }

        .chat-header {
            padding: 20px;
            background: rgba(17, 19, 24, 0.8);
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            z-index: 1;
            text-align: center;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .chat-history {
            flex-grow: 1;
            padding: 30px 40px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            z-index: 1;
        }

        .chat-history::-webkit-scrollbar { width: 8px; }
        .chat-history::-webkit-scrollbar-track { background: var(--bg-chat); }
        .chat-history::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        .chat-history::-webkit-scrollbar-thumb:hover { background: var(--accent-blue); }

        .message {
            padding: 15px 20px;
            border-radius: 12px;
            max-width: 60%;
            line-height: 1.6;
            font-size: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .user-msg {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-blue-hover));
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 2px;
        }

        .bot-msg {
            background: #232733;
            color: var(--text-light);
            align-self: flex-start;
            border-bottom-left-radius: 2px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .chat-input-area {
            padding: 20px 40px;
            background: rgba(17, 19, 24, 0.9);
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 15px;
            z-index: 1;
            backdrop-filter: blur(10px);
        }

        .chat-input-area input {
            flex-grow: 1;
            padding: 15px 20px;
            border-radius: 30px;
            border: 1px solid #333;
            background: #181b22;
            color: white;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.5);
        }

        .chat-input-area input:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 15px rgba(79, 142, 247, 0.1), inset 0 2px 5px rgba(0,0,0,0.5);
        }

        .chat-input-area button {
            padding: 0 30px;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-blue-hover));
            border: none;
            color: white;
            border-radius: 30px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 5px 15px rgba(79, 142, 247, 0.3);
        }

        .chat-input-area button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 142, 247, 0.5);
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="brand">Neural<span>Chat</span></div>
        
        <div class="user-info">
            <p>Welcome back,</p>
            <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Student'); ?></strong>
        </div>

        <ul class="nav-links">
            <li><a href="#" onclick="location.reload();">New Prediction</a></li>
            <li><a href="logout.php" class="btn-logout">Log Out</a></li>
        </ul>
    </aside>

    <main class="main-chat">
        <div class="chat-header">
            Predictive Analytics Engine Active
        </div>

        <div class="chat-history" id="chatHistory">
            <div class="message bot-msg">
                Hello <strong><?= htmlspecialchars($_SESSION['username'] ?? ''); ?></strong>! Enter your previous grades consecutively (e.g., "My grades are 82, 85, and 88") and I will use linear regression to predict your final outcome.
            </div>
        </div>
        
        <div class="chat-input-area">
            <input type="text" id="userInput" placeholder="Type your sequence of grades here..." onkeypress="handleEnter(event)">
            <button onclick="sendMessage()">Send Data</button>
        </div>
    </main>

    <script>
        function handleEnter(e) {
            if (e.key === 'Enter') sendMessage();
        }

        function sendMessage() {
            const inputField = document.getElementById('userInput');
            const message = inputField.value.trim();
            if (!message) return;

            appendMessage(message, 'user-msg');
            inputField.value = '';

            const formData = new FormData();
            formData.append('message', message);

            fetch('chat_api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
     
                appendMessage(data.reply, 'bot-msg');
            })
            .catch(error => {
                console.error('Error:', error);
                appendMessage("System error: Unable to connect to the prediction engine.", 'bot-msg');
            });
        }

        function appendMessage(text, className) {
            const history = document.getElementById('chatHistory');
            const msgDiv = document.createElement('div');
            msgDiv.className = 'message ' + className;
            msgDiv.innerHTML = text; 
            history.appendChild(msgDiv);
            
            history.scrollTo({
                top: history.scrollHeight,
                behavior: 'smooth'
            });
        }
    </script>
</body>
</html>