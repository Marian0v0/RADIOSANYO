<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGIES - Radio Sanyo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #000000;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Efectos de partículas en el fondo */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .welcome-container {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
        }

        .logo {
            max-width: 400px;
            width: 100%;
            height: auto;
            margin-bottom: 3rem;
            filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.3));
            animation: pulse 2s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .system-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #ffffff, #cccccc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
        }

        .system-subtitle {
            font-size: 1.2rem;
            color: #cccccc;
            margin-bottom: 3rem;
            font-weight: 300;
            letter-spacing: 0.1em;
        }

        .enter-btn {
            background: linear-gradient(135deg, #6e6e6d, #a8a8a8);
            color: white;
            border: none;
            padding: 1.2rem 3rem;
            font-size: 1.3rem;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.4s ease;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.4);
            position: relative;
            overflow: hidden;
        }

        .enter-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .enter-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 40px rgba(255, 107, 53, 0.6);
            color: white;
            text-decoration: none;
        }

        .enter-btn:hover::before {
            left: 100%;
        }

        .btn-icon {
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .enter-btn:hover .btn-icon {
            transform: translateX(5px);
        }

        .version {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            color: #666;
            font-size: 0.9rem;
            z-index: 2;
        }

        /* Efectos de brillo */
        .glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 107, 53, 0.1) 0%, rgba(255, 107, 53, 0) 70%);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            animation: glowPulse 4s infinite ease-in-out;
        }

        @keyframes glowPulse {
            0%, 100% { opacity: 0.3; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 0.6; transform: translate(-50%, -50%) scale(1.1); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .logo {
                max-width: 300px;
                margin-bottom: 2rem;
            }
            
            .system-title {
                font-size: 2rem;
            }
            
            .system-subtitle {
                font-size: 1rem;
            }
            
            .enter-btn {
                padding: 1rem 2.5rem;
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .logo {
                max-width: 250px;
            }
            
            .system-title {
                font-size: 1.8rem;
            }
            
            .enter-btn {
                padding: 0.9rem 2rem;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Efecto de partículas -->
    <div class="particles" id="particles"></div>
    
    <!-- Efecto de brillo -->
    <div class="glow"></div>

    <!-- Contenido principal -->
    <div class="welcome-container">
        <!-- Logo -->
        <img src="{{ asset('RadioSanyo.png') }}" 
             alt="Radio Sanyo" class="logo">
        
        <!-- Título del sistema -->
        <h1 class="system-title">SGIES</h1>
        <p class="system-subtitle">SISTEMA DE GESTIÓN INTEGRAL</p>

        <!-- Botón de ingreso -->
        <a href="{{ route('bodegas.index') }}" class="enter-btn">
            <span class="btn-icon">
                <i class="bi bi-box-arrow-in-right"></i>
            </span>
            INGRESAR AL SISTEMA
        </a>
    </div>

    <!-- Versión -->
    <div class="version">
        Radio Sanyo Pasto &copy; 2024
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Crear partículas dinámicas
        document.addEventListener('DOMContentLoaded', function() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 15;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                
                // Tamaño aleatorio
                const size = Math.random() * 6 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Posición aleatoria
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;
                
                // Retraso de animación aleatorio
                particle.style.animationDelay = `${Math.random() * 6}s`;
                
                particlesContainer.appendChild(particle);
            }

            // Efecto de tecleo para el subtítulo
            const subtitle = document.querySelector('.system-subtitle');
            const originalText = subtitle.textContent;
            subtitle.textContent = '';
            
            let i = 0;
            const typeWriter = () => {
                if (i < originalText.length) {
                    subtitle.textContent += originalText.charAt(i);
                    i++;
                    setTimeout(typeWriter, 100);
                }
            };
            
            // Iniciar efecto de tecleo después de un breve delay
            setTimeout(typeWriter, 1000);
        });
    </script>
</body>
</html>