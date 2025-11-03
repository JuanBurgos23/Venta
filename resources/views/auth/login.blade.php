<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - EmpresaPro</title>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #1e293b;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            display: flex;
            box-shadow: var(--shadow-lg);
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        .brand-section {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .brand-section::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .brand-section::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .brand-logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .brand-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
        }

        .brand-description {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
            position: relative;
            z-index: 1;
            margin-bottom: 30px;
        }

        .brand-features {
            list-style: none;
            position: relative;
            z-index: 1;
        }

        .brand-features li {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .feature-icon {
            margin-right: 10px;
            font-size: 16px;
        }

        .form-section {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .form-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: var(--secondary);
            font-size: 16px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-icon {
            margin-right: 10px;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
            font-size: 14px;
        }

        .required::after {
            content: '*';
            color: var(--danger);
            margin-left: 4px;
        }

        .input-with-icon {
            position: relative;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        input.error {
            border-color: var(--danger);
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary);
        }

        .input-with-icon input {
            padding-right: 50px;
        }

        .error-message {
            color: var(--danger);
            font-size: 12px;
            margin-top: 5px;
        }

        .server-errors {
            color: var(--danger);
            font-size: 12px;
            margin-top: 5px;
        }

        .server-errors ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .server-errors li {
            margin-bottom: 4px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .checkbox-container input {
            width: auto;
            margin-right: 8px;
        }

        .checkbox-label {
            margin: 0;
            font-size: 14px;
            color: var(--secondary);
        }

        .forgot-password {
            font-size: 14px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn {
            padding: 14px 24px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 16px;
            width: 100%;
            text-align: center;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-google {
            background: white;
            color: var(--dark);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
        }

        .btn-google:hover {
            background: #f8fafc;
        }

        .google-icon {
            margin-right: 10px;
            font-size: 18px;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider-text {
            padding: 0 15px;
            color: var(--secondary);
            font-size: 14px;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: var(--secondary);
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .brand-section {
                padding: 30px;
            }
            
            .form-section {
                padding: 30px;
            }
            
            .form-options {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .forgot-password {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="brand-section">
            <div class="brand-logo">Tuxon Entherprise</div>
            <h1 class="brand-title">Bienvenido de nuevo</h1>
            <p class="brand-description">
                Accede a tu cuenta para gestionar tu empresa de manera eficiente. 
                Continúa donde lo dejaste y aprovecha todas nuestras herramientas profesionales.
            </p>
            <ul class="brand-features">
                <li><span class="feature-icon">✅</span> Gestiona tus proyectos empresariales</li>
                <li><span class="feature-icon">✅</span> Accede a reportes y análisis</li>
                <li><span class="feature-icon">✅</span> Colabora con tu equipo</li>
                <li><span class="feature-icon">✅</span> Controla tus recursos</li>
            </ul>
        </div>
        
        <div class="form-section">
            <div class="form-header">
                <h2 class="form-title">Iniciar Sesión</h2>
                <p class="form-subtitle">Ingresa a tu cuenta para continuar</p>
            </div>
            
            <!-- Session Status -->
            @if(session('status'))
                <div class="alert alert-success">
                    <span class="alert-icon">ℹ️</span>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="required">Correo electrónico</label>
                    <div class="input-with-icon">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="tu@empresa.com">
                        <div class="input-icon">✉️</div>
                    </div>
                    <div class="server-errors">
                        @foreach($errors->get('email') as $error)
                            <div class="error-message">{{ $error }}</div>
                        @endforeach
                    </div>
                    <div class="error-message" id="email-error"></div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="required">Contraseña</label>
                    <div class="input-with-icon">
                        <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña">
                        <div class="input-icon">🔒</div>
                    </div>
                    <div class="server-errors">
                        @foreach($errors->get('password') as $error)
                            <div class="error-message">{{ $error }}</div>
                        @endforeach
                    </div>
                    <div class="error-message" id="password-error"></div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="form-options">
                    <div class="checkbox-container">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me" class="checkbox-label">Recordar sesión</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">
                    Iniciar Sesión
                </button>

                <div class="divider">
                    <div class="divider-line"></div>
                    <div class="divider-text">o continuar con</div>
                    <div class="divider-line"></div>
                </div>

                <button type="button" class="btn btn-google">
                    <span class="google-icon">🔍</span>
                    Google
                </button>
            </form>
            
            <div class="register-link">
                ¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            // Mostrar errores existentes del servidor
            const serverEmailErrors = document.querySelectorAll('.server-errors .error-message');
            if (serverEmailErrors.length > 0) {
                emailInput.classList.add('error');
            }

            const serverPasswordErrors = document.querySelectorAll('.server-errors .error-message');
            if (serverPasswordErrors.length > 0) {
                passwordInput.classList.add('error');
            }

            // Validación en tiempo real
            emailInput.addEventListener('blur', validateEmail);
            passwordInput.addEventListener('blur', validatePassword);

            function validateEmail() {
                const email = emailInput.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (email === '') {
                    showError('email', 'El correo electrónico es obligatorio');
                    return false;
                } else if (!emailRegex.test(email)) {
                    showError('email', 'Ingresa un correo electrónico válido');
                    return false;
                } else {
                    hideError('email');
                    return true;
                }
            }

            function validatePassword() {
                const password = passwordInput.value;
                
                if (password === '') {
                    showError('password', 'La contraseña es obligatoria');
                    return false;
                } else {
                    hideError('password');
                    return true;
                }
            }

            function showError(fieldId, message) {
                const errorElement = document.getElementById(`${fieldId}-error`);
                errorElement.textContent = message;
                errorElement.style.display = 'block';
                document.getElementById(fieldId).classList.add('error');
            }

            function hideError(fieldId) {
                const errorElement = document.getElementById(`${fieldId}-error`);
                errorElement.style.display = 'none';
                document.getElementById(fieldId).classList.remove('error');
            }

            // Validación antes del envío
            loginForm.addEventListener('submit', function(e) {
                const isEmailValid = validateEmail();
                const isPasswordValid = validatePassword();
                
                if (!isEmailValid || !isPasswordValid) {
                    e.preventDefault();
                    
                    // Mostrar todos los errores
                    if (!isEmailValid) validateEmail();
                    if (!isPasswordValid) validatePassword();
                    
                    // Enfocar el primer campo con error
                    if (!isEmailValid) {
                        emailInput.focus();
                    } else if (!isPasswordValid) {
                        passwordInput.focus();
                    }
                }
            });

            // Efecto de carga en el botón de enviar
            const submitButton = loginForm.querySelector('button[type="submit"]');
            loginForm.addEventListener('submit', function() {
                submitButton.innerHTML = 'Iniciando sesión...';
                submitButton.disabled = true;
            });

            // Simulación de login con Google
            document.querySelector('.btn-google').addEventListener('click', function() {
                alert('Funcionalidad de login con Google en desarrollo');
            });
        });
    </script>
</body>
</html>