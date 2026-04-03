<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>404 | Page on Leave - EliteHR</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('asset/images/logo2.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-bg: #060818;
            --accent-glow: rgba(67, 97, 238, 0.4);
            --text-main: #e0e6ed;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: var(--primary-bg);
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Animated Mesh Background */
        .mesh-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: 
                radial-gradient(circle at 20% 20%, rgba(67, 97, 238, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(214, 51, 132, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(0, 212, 255, 0.05) 0%, transparent 50%);
            filter: blur(80px);
            animation: pulseBg 15s ease infinite alternate;
        }

        @keyframes pulseBg {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.1); opacity: 1; }
        }

        .error-container {
            text-align: center;
            padding: 3rem;
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            max-width: 600px;
            width: 90%;
            position: relative;
            z-index: 10;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .error-code {
            font-size: 10rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
            background: linear-gradient(135deg, #4361ee 0%, #d63384 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            display: inline-block;
            filter: drop-shadow(0 0 15px var(--accent-glow));
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .error-title {
            font-size: 2rem;
            font-weight: 700;
            margin-top: 1rem;
            color: #fff;
        }

        .error-msg {
            font-size: 1.1rem;
            opacity: 0.8;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }

        .btn-elite {
            background: linear-gradient(135deg, #4361ee 0%, #1e3a8a 100%);
            color: white;
            border: none;
            padding: 14px 35px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 20px -5px rgba(67, 97, 238, 0.4);
        }

        .btn-elite:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 30px -10px rgba(67, 97, 238, 0.6);
            color: white;
        }

        /* Micro-interactions */
        .status-badge {
            background: rgba(255, 255, 255, 0.1);
            color: #ffd700;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-block;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 215, 0, 0.2);
            animation: wiggle 2.5s infinite;
        }

        @keyframes wiggle {
            0%, 7% { transform: rotateZ(0); }
            15% { transform: rotateZ(-15deg); }
            20% { transform: rotateZ(10deg); }
            25% { transform: rotateZ(-10deg); }
            30% { transform: rotateZ(6deg); }
            35% { transform: rotateZ(-4deg); }
            40%, 100% { transform: rotateZ(0); }
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: white;
            border-radius: 50%;
            opacity: 0.1;
            animation: moveParticle linear infinite;
        }

        @keyframes moveParticle {
            from { transform: translateY(0); }
            to { transform: translateY(-100vh); }
        }
    </style>
</head>

<body>
    <div class="mesh-bg"></div>
    
    <!-- Floating Particles -->
    <div class="particles" id="particles"></div>

    <div class="error-container">
        <div class="status-badge">
            <i class="bi bi-person-workspace me-2"></i> Employee Status: Not Found
        </div>
        <h1 class="error-code">404</h1>
        <h2 class="error-title">This Page is currently on Leave.</h2>
        <p class="error-msg">
            It seems the department you're looking for has taken a temporary leave of absence. 
            Don't worry, even our pages need a break sometimes.
        </p>
        
        <a href="{{ url('/') }}" class="btn-elite">
            <i class="bi bi-house-door-fill"></i> Return to Dashboard
        </a>
    </div>

    <script>
        // Generate minor particles for atmosphere
        const particlesContainer = document.getElementById('particles');
        for(let i = 0; i < 30; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            const size = Math.random() * 4 + 2 + 'px';
            particle.style.width = size;
            particle.style.height = size;
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            particle.style.animationDelay = Math.random() * 10 + 's';
            particlesContainer.appendChild(particle);
        }
    </script>
</body>

</html>
