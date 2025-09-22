<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to CodeNova Framework</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --background: #ffffff;
            --foreground: #475569;
            --primary: #059669;
            --primary-foreground: #ffffff;
            --accent: #10b981;
            --muted: #f1f5f9;
            --border: #d1d5db;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--background) 0%, var(--muted) 100%);
            color: var(--foreground);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Animated background shapes */
        .bg-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--accent));
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 70%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            top: 30%;
            right: 20%;
            animation-delay: 4s;
        }

        .shape:nth-child(4) {
            width: 120px;
            height: 120px;
            bottom: 20%;
            left: 20%;
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        /* Main content container */
        .container {
            text-align: center;
            z-index: 10;
            position: relative;
            max-width: 800px;
            padding: 2rem;
        }

        /* Welcome text styling */
        .welcome-text {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: slideInUp 1s ease-out;
        }

        .framework-text {
            font-size: clamp(1.2rem, 4vw, 2rem);
            font-weight: 400;
            color: var(--foreground);
            margin-bottom: 2rem;
            opacity: 0.8;
            animation: slideInUp 1s ease-out 0.2s both;
        }

        .description {
            font-size: 1.1rem;
            color: var(--foreground);
            opacity: 0.7;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
            animation: slideInUp 1s ease-out 0.4s both;
        }

        /* Call to action button */
        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary);
            color: var(--primary-foreground);
            padding: 1rem 2rem;
            border: none;
            border-radius: 0.75rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            animation: slideInUp 1s ease-out 0.6s both;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .cta-button:hover {
            background: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
        }

        .cta-button::after {
            content: '→';
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }

        .cta-button:hover::after {
            transform: translateX(4px);
        }

        /* Feature cards */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 4rem;
            animation: slideInUp 1s ease-out 0.8s both;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 1.5rem;
        }

        .feature-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--foreground);
        }

        .feature-description {
            font-size: 0.9rem;
            color: var(--foreground);
            opacity: 0.7;
            line-height: 1.4;
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .features {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .shape {
                display: none;
            }
        }

        /* Code-like decorative elements */
        .code-decoration {
            position: absolute;
            font-family: 'Courier New', monospace;
            font-size: 0.8rem;
            color: var(--accent);
            opacity: 0.3;
            z-index: 2;
            animation: pulse 3s ease-in-out infinite;
        }

        .code-decoration:nth-child(1) {
            top: 15%;
            left: 5%;
            animation-delay: 0s;
        }

        .code-decoration:nth-child(2) {
            bottom: 25%;
            right: 8%;
            animation-delay: 1.5s;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 0.3;
            }
            50% {
                opacity: 0.6;
            }
        }
    </style>
</head>
<body>
    <!-- Animated background shapes -->
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Code decorations -->
    <div class="code-decoration">const framework = 'CodeNova';</div>
    <div class="code-decoration">export { innovation };</div>

    <!-- Main content -->
    <div class="container">
        <h1 class="welcome-text">Welcome in CodeNova Framework</h1>
        <p class="description">
            Experience the future of development with our innovative framework designed for modern applications. 
            Build faster, scale better, and create amazing user experiences.
        </p>
        
        <a href="https://github.com/ahmedali-dev/Webnova" target="blank" class="cta-button">Get Started</a>

        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3 class="feature-title">Lightning Fast</h3>
                <p class="feature-description">Optimized performance for rapid development and deployment</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🛠️</div>
                <h3 class="feature-title">Developer Friendly</h3>
                <p class="feature-description">Intuitive APIs and comprehensive documentation</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🚀</div>
                <h3 class="feature-title">Scalable</h3>
                <p class="feature-description">Built to grow with your project from prototype to production</p>
            </div>
        </div>
    </div>
</body>
</html>