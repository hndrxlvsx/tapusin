<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - NeuralChat Grade Predictor</title>
    <style>
        /* Base Styles & Futuristic Background */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: radial-gradient(circle at center, #1a1e29 0%, #0d0f14 100%);
            color: white; 
            margin: 0; 
            height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            overflow: hidden; 
            position: relative;
        }

        /* Subtle Cyber/Data Grid Overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 0;
            pointer-events: none;
        }

        /* Center Content Card */
        .content {
            text-align: center;
            background: rgba(17, 19, 24, 0.7); 
            padding: 55px 40px;
            border-radius: 16px;
            z-index: 10;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.8), 0 0 30px rgba(79, 142, 247, 0.15);
            max-width: 420px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .content:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.9), 0 0 40px rgba(79, 142, 247, 0.25);
        }

        .content h1 {
            margin-top: 0;
            color: #ffffff;
            font-size: 2.5em;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .content p {
            color: #b0bacf;
            margin-bottom: 45px;
            line-height: 1.6;
            font-size: 1.05em;
        }

        /* Get Started Button - Automatically routes to login.php */
        .btn-start {
            display: inline-block;
            padding: 16px 45px;
            background: linear-gradient(135deg, #4f8ef7, #2662d9);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 142, 247, 0.4), inset 0 0 10px rgba(255, 255, 255, 0.2);
            border: 1px solid #6b9fff;
        }

        .btn-start:hover {
            background: linear-gradient(135deg, #6b9fff, #3b74d6);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(79, 142, 247, 0.7), inset 0 0 15px rgba(255, 255, 255, 0.4);
        }

        /* Floating AI Bubbles Container */
        .bubbles-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: auto; /* Changed to auto so hover effects work */
        }

        /* Individual Bubble Base Styling with Aura */
        .bubble {
            position: absolute;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-color);
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            text-shadow: 0 0 5px var(--text-color);
            box-shadow: 0 0 25px var(--glow-color), inset 0 0 20px var(--glow-color);
            backdrop-filter: blur(3px);
            animation: float 10s infinite ease-in-out;
            padding: 10px;
            cursor: default;
            transition: all 0.4s ease;
        }

        /* Interactive Hover effect for Bubbles */
        .bubble:hover {
            transform: scale(1.15) !important;
            box-shadow: 0 0 40px var(--glow-color), inset 0 0 35px var(--glow-color);
            z-index: 20;
            filter: brightness(1.3);
        }

        /* Floating Animation */
        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-25px) scale(1.05); }
            100% { transform: translateY(0px) scale(1); }
        }

        /* Distinct Colors and Aura Settings for each Bubble 
           Using CSS Variables for easy color management 
        */
        
        /* Cyan */
        .b1 { --bg-color: rgba(0, 212, 255, 0.1); --border-color: rgba(0, 212, 255, 0.5); --text-color: #c4f4ff; --glow-color: rgba(0, 212, 255, 0.4); 
              width: 100px; height: 100px; left: 15%; top: 20%; animation-duration: 8s; }
              
        /* Purple */
        .b2 { --bg-color: rgba(157, 0, 255, 0.1); --border-color: rgba(157, 0, 255, 0.5); --text-color: #eed6ff; --glow-color: rgba(157, 0, 255, 0.4); 
              width: 120px; height: 120px; left: 75%; top: 15%; animation-duration: 12s; font-size: 15px; }
              
        /* Neon Green */
        .b3 { --bg-color: rgba(0, 255, 136, 0.1); --border-color: rgba(0, 255, 136, 0.5); --text-color: #ccffe8; --glow-color: rgba(0, 255, 136, 0.4); 
              width: 90px; height: 90px; left: 22%; top: 70%; animation-duration: 9s; animation-delay: 1s; }
              
        /* Hot Pink */
        .b4 { --bg-color: rgba(255, 0, 128, 0.1); --border-color: rgba(255, 0, 128, 0.5); --text-color: #ffcce6; --glow-color: rgba(255, 0, 128, 0.4); 
              width: 140px; height: 140px; left: 68%; top: 65%; animation-duration: 11s; animation-delay: 2s; font-size: 16px; }
              
        /* Orange */
        .b5 { --bg-color: rgba(255, 140, 0, 0.1); --border-color: rgba(255, 140, 0, 0.5); --text-color: #ffe8cc; --glow-color: rgba(255, 140, 0, 0.4); 
              width: 110px; height: 110px; left: 50%; top: 10%; animation-duration: 7s; animation-delay: 0.5s; }
              
        /* Deep Blue */
        .b6 { --bg-color: rgba(0, 102, 255, 0.1); --border-color: rgba(0, 102, 255, 0.5); --text-color: #ccdfff; --glow-color: rgba(0, 102, 255, 0.4); 
              width: 130px; height: 130px; left: 8%; top: 45%; animation-duration: 10s; animation-delay: 1.5s; }
              
        /* Yellow */
        .b7 { --bg-color: rgba(255, 213, 0, 0.1); --border-color: rgba(255, 213, 0, 0.5); --text-color: #fff6cc; --glow-color: rgba(255, 213, 0, 0.4); 
              width: 100px; height: 100px; left: 85%; top: 40%; animation-duration: 9.5s; animation-delay: 0.8s; }
              
        /* Red / Coral */
        .b8 { --bg-color: rgba(255, 80, 80, 0.1); --border-color: rgba(255, 80, 80, 0.5); --text-color: #ffcccc; --glow-color: rgba(255, 80, 80, 0.4); 
              width: 115px; height: 115px; left: 40%; top: 82%; animation-duration: 8.5s; animation-delay: 2.5s; }
    </style>
</head>
<body>

    <div class="bubbles-container">
        <div class="bubble b1">Algorithms</div>
        <div class="bubble b2">GPA Forecast</div>
        <div class="bubble b3">Analytics</div>
        <div class="bubble b4">Neural Nets</div>
        <div class="bubble b5">Data</div>
        <div class="bubble b6">Performance</div>
        <div class="bubble b7">Study Habits</div>
        <div class="bubble b8">Accuracy</div>
    </div>

    <div class="content">
        <h1>NeuralChat</h1>
        <p>Unlock the power of Artificial Intelligence to analyze study habits, track performance, and accurately predict student grades.</p>
        
        <a href="login.php" class="btn-start">Get Started</a>
    </div>

</body>
</html>