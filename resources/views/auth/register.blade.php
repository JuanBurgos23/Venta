<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Empresarial</title>
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
            max-width: 900px;
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
            padding: 40px;
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
            font-size: 28px;
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
        }

        .form-section {
            flex: 1.5;
            padding: 40px;
            overflow-y: auto;
            max-height: 90vh;
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: var(--secondary);
            font-size: 14px;
        }

        .form-step-indicator {
            display: flex;
            margin-bottom: 30px;
            position: relative;
        }

        .step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 15px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: var(--border);
            z-index: 1;
        }

        .step.active:not(:last-child)::after {
            background: var(--primary);
        }

        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--border);
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
        }

        .step.active .step-number {
            background: var(--primary);
            color: white;
        }

        .step.completed .step-number {
            background: var(--success);
            color: white;
        }

        .step-label {
            font-size: 12px;
            color: var(--secondary);
            text-align: center;
        }

        .step.active .step-label {
            color: var(--primary);
            font-weight: 600;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
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

        input {
            width: 100%;
            padding: 12px 16px;
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

        .error-message {
            color: var(--danger);
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary);
        }

        .input-with-icon input {
            padding-right: 40px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin: 30px 0 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 14px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-secondary:hover {
            background: #f0f7ff;
        }

        .btn-link {
            background: none;
            color: var(--primary);
            text-decoration: underline;
            padding: 12px 0;
        }

        .btn-link:hover {
            color: var(--primary-dark);
        }

        .password-strength {
            margin-top: 8px;
            height: 4px;
            border-radius: 2px;
            background: var(--border);
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background 0.3s ease;
        }

        .password-strength.weak .password-strength-bar {
            width: 33%;
            background: var(--danger);
        }

        .password-strength.medium .password-strength-bar {
            width: 66%;
            background: #f59e0b;
        }

        .password-strength.strong .password-strength-bar {
            width: 100%;
            background: var(--success);
        }

        .password-requirements {
            margin-top: 8px;
            font-size: 12px;
            color: var(--secondary);
        }

        .password-requirement {
            display: flex;
            align-items: center;
            margin-bottom: 4px;
        }

        .requirement-icon {
            margin-right: 6px;
            font-size: 10px;
        }

        .requirement-met {
            color: var(--success);
        }

        .requirement-not-met {
            color: var(--secondary);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--secondary);
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
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
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="brand-section">
            <div class="brand-logo">Tuxon Entherprise</div>
            <h1 class="brand-title">Registro Empresarial</h1>
            <p class="brand-description">
                Crea una cuenta para gestionar tu empresa de manera eficiente. 
                Accede a herramientas profesionales que optimizarán tus procesos.
            </p>
        </div>
        
        <div class="form-section">
            <div class="form-header">
                <h2 class="form-title">Crear Cuenta</h2>
                <p class="form-subtitle">Completa la información para registrar tu empresa</p>
            </div>
            
            <div class="form-step-indicator">
                <div class="step active" data-step="1">
                    <div class="step-number">1</div>
                    <div class="step-label">Usuario</div>
                </div>
                <div class="step" data-step="2">
                    <div class="step-number">2</div>
                    <div class="step-label">Empresa</div>
                </div>
                <div class="step" data-step="3">
                    <div class="step-number">3</div>
                    <div class="step-label">Confirmar</div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('register') }}" id="registrationForm">
                @csrf
                
                <!-- Paso 1: Información del Usuario -->
                <div class="form-step active" id="step-1">
                    <div class="form-group">
                        <label for="name" class="required">Nombre completo</label>
                        <div class="input-with-icon">
                            <input type="text" id="name" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ingresa tu nombre completo">
                            <div class="input-icon">👤</div>
                        </div>
                        <div class="error-message" id="name-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="required">Correo electrónico</label>
                        <div class="input-with-icon">
                            <input type="email" id="email" name="email" :value="old('email')" required autocomplete="username" placeholder="ejemplo@empresa.com">
                            <div class="input-icon">✉️</div>
                        </div>
                        <div class="error-message" id="email-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="required">Contraseña</label>
                        <div class="input-with-icon">
                            <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Crea una contraseña segura">
                            <div class="input-icon">🔒</div>
                        </div>
                        <div class="password-strength" id="password-strength">
                            <div class="password-strength-bar"></div>
                        </div>
                        <div class="password-requirements">
                            <div class="password-requirement">
                                <span class="requirement-icon" id="length-icon">●</span>
                                <span>Mínimo 8 caracteres</span>
                            </div>
                            <div class="password-requirement">
                                <span class="requirement-icon" id="uppercase-icon">●</span>
                                <span>Al menos una mayúscula</span>
                            </div>
                            <div class="password-requirement">
                                <span class="requirement-icon" id="number-icon">●</span>
                                <span>Al menos un número</span>
                            </div>
                        </div>
                        <div class="error-message" id="password-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="required">Confirmar contraseña</label>
                        <div class="input-with-icon">
                            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Repite tu contraseña">
                            <div class="input-icon">🔒</div>
                        </div>
                        <div class="error-message" id="password_confirmation-error"></div>
                    </div>
                    
                    <div class="form-actions">
                        <div></div> <!-- Espaciador -->
                        <button type="button" class="btn btn-primary" id="next-step-1">Siguiente</button>
                    </div>
                </div>
                
                <!-- Paso 2: Información de la Empresa -->
                <div class="form-step" id="step-2">
                    <h3 class="section-title">Datos de la empresa</h3>
                    
                    <div class="form-group">
                        <label for="empresa_nombre" class="required">Nombre de la empresa</label>
                        <div class="input-with-icon">
                            <input type="text" id="empresa_nombre" name="empresa_nombre" :value="old('empresa_nombre')" required placeholder="Nombre oficial de la empresa">
                            <div class="input-icon">🏢</div>
                        </div>
                        <div class="error-message" id="empresa_nombre-error"></div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="empresa_nit">NIT</label>
                            <div class="input-with-icon">
                                <input type="text" id="empresa_nit" name="empresa_nit" :value="old('empresa_nit')" placeholder="Número de Identificación Tributaria">
                                <div class="input-icon">📋</div>
                            </div>
                            <div class="error-message" id="empresa_nit-error"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="empresa_telefono">Teléfono</label>
                            <div class="input-with-icon">
                                <input type="text" id="empresa_telefono" name="empresa_telefono" :value="old('empresa_telefono')" placeholder="Teléfono de contacto">
                                <div class="input-icon">📞</div>
                            </div>
                            <div class="error-message" id="empresa_telefono-error"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="empresa_correo">Correo de la empresa</label>
                        <div class="input-with-icon">
                            <input type="email" id="empresa_correo" name="empresa_correo" :value="old('empresa_correo', old('email'))" placeholder="correo@empresa.com">
                            <div class="input-icon">✉️</div>
                        </div>
                        <div class="error-message" id="empresa_correo-error"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="empresa_direccion">Dirección</label>
                        <div class="input-with-icon">
                            <input type="text" id="empresa_direccion" name="empresa_direccion" :value="old('empresa_direccion')" placeholder="Dirección completa de la empresa">
                            <div class="input-icon">📍</div>
                        </div>
                        <div class="error-message" id="empresa_direccion-error"></div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" id="prev-step-2">Atrás</button>
                        <button type="button" class="btn btn-primary" id="next-step-2">Siguiente</button>
                    </div>
                </div>
                
                <!-- Paso 3: Confirmación -->
                <div class="form-step" id="step-3">
                    <h3 class="section-title">Resumen de registro</h3>
                    
                    <div class="summary-section">
                        <h4>Información del usuario</h4>
                        <div class="summary-item">
                            <span class="summary-label">Nombre:</span>
                            <span id="summary-name"></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Email:</span>
                            <span id="summary-email"></span>
                        </div>
                    </div>
                    
                    <div class="summary-section">
                        <h4>Información de la empresa</h4>
                        <div class="summary-item">
                            <span class="summary-label">Nombre:</span>
                            <span id="summary-empresa-nombre"></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">NIT:</span>
                            <span id="summary-empresa-nit"></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Teléfono:</span>
                            <span id="summary-empresa-telefono"></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Correo:</span>
                            <span id="summary-empresa-correo"></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Dirección:</span>
                            <span id="summary-empresa-direccion"></span>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" id="prev-step-3">Atrás</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </form>
            
            <div class="login-link">
                ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos del DOM
            const steps = document.querySelectorAll('.step');
            const formSteps = document.querySelectorAll('.form-step');
            const nextButtons = document.querySelectorAll('[id^="next-step-"]');
            const prevButtons = document.querySelectorAll('[id^="prev-step-"]');
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('password-strength');
            const passwordStrengthBar = passwordStrength.querySelector('.password-strength-bar');
            const requirementIcons = {
                length: document.getElementById('length-icon'),
                uppercase: document.getElementById('uppercase-icon'),
                number: document.getElementById('number-icon')
            };
            
            // Navegación entre pasos
            function goToStep(stepNumber) {
                // Actualizar indicador de pasos
                steps.forEach((step, index) => {
                    if (index + 1 === stepNumber) {
                        step.classList.add('active');
                    } else if (index + 1 < stepNumber) {
                        step.classList.remove('active');
                        step.classList.add('completed');
                    } else {
                        step.classList.remove('active', 'completed');
                    }
                });
                
                // Mostrar paso correspondiente
                formSteps.forEach((formStep, index) => {
                    if (index + 1 === stepNumber) {
                        formStep.classList.add('active');
                    } else {
                        formStep.classList.remove('active');
                    }
                });
            }
            
            // Validación del paso 1
            function validateStep1() {
                let isValid = true;
                
                // Validar nombre
                const name = document.getElementById('name').value.trim();
                if (name === '') {
                    showError('name', 'El nombre es obligatorio');
                    isValid = false;
                } else {
                    hideError('name');
                }
                
                // Validar email
                const email = document.getElementById('email').value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email === '') {
                    showError('email', 'El correo electrónico es obligatorio');
                    isValid = false;
                } else if (!emailRegex.test(email)) {
                    showError('email', 'Ingresa un correo electrónico válido');
                    isValid = false;
                } else {
                    hideError('email');
                }
                
                return isValid;
            }
            
            // Validación del paso 2
            function validateStep2() {
                let isValid = true;
                
                // Validar nombre de empresa
                const empresaNombre = document.getElementById('empresa_nombre').value.trim();
                if (empresaNombre === '') {
                    showError('empresa_nombre', 'El nombre de la empresa es obligatorio');
                    isValid = false;
                } else {
                    hideError('empresa_nombre');
                }
                
                return isValid;
            }
            
            // Mostrar errores
            function showError(fieldId, message) {
                const errorElement = document.getElementById(`${fieldId}-error`);
                errorElement.textContent = message;
                errorElement.style.display = 'block';
                document.getElementById(fieldId).classList.add('error');
            }
            
            // Ocultar errores
            function hideError(fieldId) {
                const errorElement = document.getElementById(`${fieldId}-error`);
                errorElement.style.display = 'none';
                document.getElementById(fieldId).classList.remove('error');
            }
            
            // Evaluar fortaleza de la contraseña
            function evaluatePasswordStrength(password) {
                let strength = 0;
                
                // Longitud mínima
                if (password.length >= 8) strength++;
                
                // Contiene mayúsculas
                if (/[A-Z]/.test(password)) strength++;
                
                // Contiene números
                if (/[0-9]/.test(password)) strength++;
                
                // Contiene caracteres especiales
                if (/[^A-Za-z0-9]/.test(password)) strength++;
                
                // Actualizar indicador visual
                passwordStrength.className = 'password-strength';
                if (strength <= 1) {
                    passwordStrength.classList.add('weak');
                } else if (strength <= 3) {
                    passwordStrength.classList.add('medium');
                } else {
                    passwordStrength.classList.add('strong');
                }
                
                // Actualizar iconos de requisitos
                requirementIcons.length.className = password.length >= 8 ? 
                    'requirement-icon requirement-met' : 'requirement-icon requirement-not-met';
                    
                requirementIcons.uppercase.className = /[A-Z]/.test(password) ? 
                    'requirement-icon requirement-met' : 'requirement-icon requirement-not-met';
                    
                requirementIcons.number.className = /[0-9]/.test(password) ? 
                    'requirement-icon requirement-met' : 'requirement-icon requirement-not-met';
            }
            
            // Actualizar resumen en el paso 3
            function updateSummary() {
                document.getElementById('summary-name').textContent = document.getElementById('name').value;
                document.getElementById('summary-email').textContent = document.getElementById('email').value;
                document.getElementById('summary-empresa-nombre').textContent = document.getElementById('empresa_nombre').value;
                document.getElementById('summary-empresa-nit').textContent = document.getElementById('empresa_nit').value || 'No proporcionado';
                document.getElementById('summary-empresa-telefono').textContent = document.getElementById('empresa_telefono').value || 'No proporcionado';
                document.getElementById('summary-empresa-correo').textContent = document.getElementById('empresa_correo').value || document.getElementById('email').value;
                document.getElementById('summary-empresa-direccion').textContent = document.getElementById('empresa_direccion').value || 'No proporcionada';
            }
            
            // Event Listeners
            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = parseInt(this.id.split('-')[2]);
                    
                    if (currentStep === 1 && !validateStep1()) return;
                    if (currentStep === 2 && !validateStep2()) return;
                    
                    if (currentStep === 2) updateSummary();
                    
                    goToStep(currentStep + 1);
                });
            });
            
            prevButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentStep = parseInt(this.id.split('-')[2]);
                    goToStep(currentStep - 1);
                });
            });
            
            // Evaluar contraseña en tiempo real
            passwordInput.addEventListener('input', function() {
                evaluatePasswordStrength(this.value);
            });
            
            // Prevenir envío del formulario si hay errores
            document.getElementById('registrationForm').addEventListener('submit', function(e) {
                if (!validateStep1() || !validateStep2()) {
                    e.preventDefault();
                    goToStep(1);
                }
            });
        });
    </script>
</body>
</html>
