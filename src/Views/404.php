<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            line-height: 1.6;
        }

        .container {
            text-align: center;
            max-width: 600px;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .error-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .astronaut {
            font-size: 4rem;
            margin-bottom: 2rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            color: white;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .search-box {
            margin-top: 2rem;
            position: relative;
        }

        .search-input {
            width: 100%;
            max-width: 400px;
            padding: 15px 20px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            background: white;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
        }

        .search-input::placeholder {
            color: #666;
        }

        .helpful-links {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .helpful-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .helpful-links a:hover {
            color: white;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 6rem;
            }
            
            .error-title {
                font-size: 2rem;
            }
            
            .container {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .actions {
                flex-direction: column;
                align-items: center;
            }
            
            .helpful-links {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="astronaut">🚀</div>
        <div class="error-code">404</div>
        <h1 class="error-title">Oops! Page Not Found</h1>
        <p class="error-message">
            Looks like you've ventured into uncharted space! The page you're looking for seems to have drifted away into the digital cosmos.
        </p>
        
        <div class="actions">
            <a href="/" class="btn btn-primary">Take Me Home</a>
            <a href="javascript:history.back()" class="btn btn-secondary">Go Back</a>
        </div>
        
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search for what you need..." onkeypress="handleSearch(event)">
        </div>
        
       
    </div>

    <script>
        function handleSearch(event) {
            if (event.key === 'Enter') {
                const query = event.target.value;
                if (query.trim()) {
                    // Redirect to search page or handle search
                    window.location.href = `/search?q=${encodeURIComponent(query)}`;
                }
            }
        }

        // Add some interactive sparkle effect
        document.addEventListener('mousemove', function(e) {
            if (Math.random() > 0.95) {
                createSparkle(e.clientX, e.clientY);
            }
        });

        function createSparkle(x, y) {
            const sparkle = document.createElement('div');
            sparkle.style.position = 'fixed';
            sparkle.style.left = x + 'px';
            sparkle.style.top = y + 'px';
            sparkle.style.width = '4px';
            sparkle.style.height = '4px';
            sparkle.style.background = 'white';
            sparkle.style.borderRadius = '50%';
            sparkle.style.pointerEvents = 'none';
            sparkle.style.zIndex = '9999';
            sparkle.style.animation = 'sparkle 1s ease-out forwards';
            
            document.body.appendChild(sparkle);
            
            setTimeout(() => {
                sparkle.remove();
            }, 1000);
        }

        // Add sparkle animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes sparkle {
                0% { opacity: 1; transform: scale(0); }
                50% { opacity: 1; transform: scale(1); }
                100% { opacity: 0; transform: scale(0); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>