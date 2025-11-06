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

        /* Canvas para las burbujas */
        #bubblesCanvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
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

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .login-container:hover::before {
            left: 100%;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-label {
            color: #ffffff;
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .bodega-select-wrapper {
            position: relative;
            margin-bottom: 2rem;
        }

        .bodega-select-wrapper::before {
            content: '\F4FE';
            font-family: 'bootstrap-icons';
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
            z-index: 2;
            pointer-events: none;
        }

        .bodega-select {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            font-weight: 400;
            width: 100%;
            transition: all 0.3s ease;
            appearance: none;
            cursor: pointer;
            position: relative;
        }

        .bodega-select:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.6);
            color: white;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
            outline: none;
        }

        .bodega-select:hover {
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.12);
        }

        .bodega-select option {
            background: #2a2a2a;
            color: white;
            padding: 0.5rem;
        }

        .bodega-select option:first-child {
            color: rgba(255, 255, 255, 0.6);
        }

        .password-input-wrapper {
            position: relative;
            margin-bottom: 2rem;
        }

        .password-input-wrapper::before {
            content: '\F47A';
            font-family: 'bootstrap-icons';
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
            z-index: 2;
            pointer-events: none;
        }

        .password-input {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            font-weight: 400;
            width: 100%;
            transition: all 0.3s ease;
        }

        .password-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .password-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.6);
            color: white;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
            outline: none;
        }

        .password-input:hover {
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.12);
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
            box-shadow: 0 10px 30px rgba(219, 219, 219, 0.6);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            width: 100%;
            justify-content: center;
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
            box-shadow: 0 15px 40px rgba(219, 219, 219, 0.8);
            color: white;
            text-decoration: none;
            background: linear-gradient(135deg, #8a8a89, #b8b8b8);
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

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            color: #ff6b7a;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            color: #6aff87;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .floating-label {
            position: absolute;
            top: -10px;
            left: 15px;
            background: rgba(0, 0, 0, 0.8);
            padding: 0 8px;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
            z-index: 3;
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

            .login-container {
                padding: 2rem;
            }

            .bodega-select,
            .password-input {
                padding: 0.875rem 0.875rem 0.875rem 2.5rem;
                font-size: 0.9rem;
            }

            .bodega-select-wrapper::before,
            .password-input-wrapper::before {
                left: 0.875rem;
                font-size: 1rem;
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

            .login-container {
                padding: 1.5rem;
            }

            .bodega-select,
            .password-input {
                padding: 0.75rem 0.75rem 0.75rem 2.25rem;
            }

            .bodega-select-wrapper::before,
            .password-input-wrapper::before {
                left: 0.75rem;
            }
        }

        /* Efectos de animación para los inputs */
        @keyframes inputGlow {
            0%, 100% { border-color: rgba(255, 255, 255, 0.3); }
            50% { border-color: rgba(255, 255, 255, 0.6); }
        }

        .bodega-select:focus,
        .password-input:focus {
            animation: inputGlow 2s infinite;
        }
    </style>
</head>
<body>
    <!-- Canvas para burbujas -->
    <canvas id="bubblesCanvas"></canvas>
    
    <!-- Efecto de brillo -->
    <div class="glow"></div>

    <!-- Contenido principal -->
    <div class="welcome-container">
        <!-- Logo -->
        <div style="max-width: 400px; width: 100%; height: 150px; margin: 0 auto 3rem; display: flex; align-items: center; justify-content: center; filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.3));">
             <img src="{{ asset('RadioSanyo.png') }}" 
             alt="Radio Sanyo" class="logo">
        </div>
        
        <!-- Título del sistema -->
        <h1 class="system-title">SGIES</h1>
        <p class="system-subtitle">SISTEMA DE GESTIÓN INTEGRAL</p>

        <!-- Formulario de Login -->
        <div class="login-container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <div class="bodega-select-wrapper">
                        <label class="floating-label">Bodega</label>
                        <select class="bodega-select" id="bodega" name="bodega" required>
                            <option value="">Seleccione una bodega</option>
                            @foreach($bodegas as $bodega)
                                <option value="{{ $bodega->nombre }}" {{ old('bodega') == $bodega->nombre ? 'selected' : '' }}>
                                    {{ $bodega->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="password-input-wrapper">
                        <label class="floating-label">Contraseña</label>
                        <input type="password" 
                               class="password-input" 
                               id="password" 
                               name="password" 
                               placeholder="Ingrese su contraseña" 
                               required>
                    </div>
                </div>

                <button type="submit" class="enter-btn">
                    <span class="btn-icon">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </span>
                    INGRESAR AL SISTEMA
                </button>
            </form>
        </div>
    </div>

    <!-- Versión -->
    <div class="version">
        Radio Sanyo Pasto &copy; 2025
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sistema de burbujas interactivas tipo Hollow Knight
        class Bubble {
            constructor(canvas) {
                this.canvas = canvas;
                this.reset();
                this.y = Math.random() * canvas.height;
                this.baseVelocity = this.velocity;
            }

            reset() {
                this.x = Math.random() * this.canvas.width;
                this.y = -50;
                this.radius = Math.random() * 30 + 10;
                this.velocity = Math.random() * 0.5 + 0.2;
                this.opacity = Math.random() * 0.3 + 0.1;
                this.wobble = Math.random() * 0.02 + 0.01;
                this.wobbleOffset = Math.random() * Math.PI * 2;
                this.baseVelocity = this.velocity;
            }

            update(mouseX, mouseY) {
                // Movimiento hacia abajo con wobble
                this.y += this.velocity;
                this.x += Math.sin(this.y * this.wobble + this.wobbleOffset) * 0.5;

                // Interacción con el mouse
                const dx = mouseX - this.x;
                const dy = mouseY - this.y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                const interactionRadius = 150;

                if (distance < interactionRadius) {
                    const force = (interactionRadius - distance) / interactionRadius;
                    const angle = Math.atan2(dy, dx);
                    
                    // Empujar burbujas suavemente
                    this.x -= Math.cos(angle) * force * 2;
                    this.y -= Math.sin(angle) * force * 2;
                    
                    // Hacer burbujas más visibles cerca del mouse
                    this.opacity = Math.min(0.5, this.opacity + force * 0.2);
                } else {
                    // Restaurar opacidad gradualmente
                    this.opacity = Math.max(Math.random() * 0.3 + 0.1, this.opacity - 0.01);
                }

                // Reset cuando sale de la pantalla
                if (this.y > this.canvas.height + 50 || 
                    this.x < -50 || 
                    this.x > this.canvas.width + 50) {
                    this.reset();
                }
            }

            draw(ctx) {
                // Burbuja principal con gradiente
                const gradient = ctx.createRadialGradient(
                    this.x - this.radius * 0.3,
                    this.y - this.radius * 0.3,
                    0,
                    this.x,
                    this.y,
                    this.radius
                );
                
                gradient.addColorStop(0, `rgba(255, 255, 255, ${this.opacity * 0.8})`);
                gradient.addColorStop(0.4, `rgba(200, 200, 200, ${this.opacity * 0.4})`);
                gradient.addColorStop(1, `rgba(150, 150, 150, ${this.opacity * 0.1})`);

                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = gradient;
                ctx.fill();

                // Borde sutil
                ctx.strokeStyle = `rgba(255, 255, 255, ${this.opacity * 0.3})`;
                ctx.lineWidth = 1;
                ctx.stroke();

                // Brillo interno
                ctx.beginPath();
                ctx.arc(
                    this.x - this.radius * 0.3,
                    this.y - this.radius * 0.3,
                    this.radius * 0.3,
                    0,
                    Math.PI * 2
                );
                ctx.fillStyle = `rgba(255, 255, 255, ${this.opacity * 0.6})`;
                ctx.fill();
            }
        }

        class BubbleSystem {
            constructor() {
                this.canvas = document.getElementById('bubblesCanvas');
                this.ctx = this.canvas.getContext('2d');
                this.bubbles = [];
                this.mouseX = 0;
                this.mouseY = 0;
                this.bubbleCount = 25;

                this.init();
            }

            init() {
                this.resize();
                window.addEventListener('resize', () => this.resize());
                window.addEventListener('mousemove', (e) => this.handleMouse(e));
                
                // Crear burbujas
                for (let i = 0; i < this.bubbleCount; i++) {
                    this.bubbles.push(new Bubble(this.canvas));
                }

                this.animate();
            }

            resize() {
                this.canvas.width = window.innerWidth;
                this.canvas.height = window.innerHeight;
            }

            handleMouse(e) {
                this.mouseX = e.clientX;
                this.mouseY = e.clientY;
            }

            animate() {
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

                this.bubbles.forEach(bubble => {
                    bubble.update(this.mouseX, this.mouseY);
                    bubble.draw(this.ctx);
                });

                requestAnimationFrame(() => this.animate());
            }
        }

        // Inicializar sistema de burbujas
        document.addEventListener('DOMContentLoaded', function() {
            new BubbleSystem();

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
            
            setTimeout(typeWriter, 1000);

            // Efectos interactivos para los inputs
            const bodegaSelect = document.querySelector('.bodega-select');
            const passwordInput = document.querySelector('.password-input');

            bodegaSelect.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            bodegaSelect.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });

            passwordInput.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            passwordInput.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>