<!doctype html>
<html lang="es" dir="ltr">

<head>
    <!-- Meta Tags Básicos -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('app.name') }} - Centro de Conexión para Restaurantes">
    <meta name="author" content="CANTUN SOLUTIONS DEVS">

    <!-- Meta Tags de Seguridad -->
    <meta http-equiv="Content-Security-Policy"
        content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Preload de Recursos Críticos -->
    <link rel="preload" href="{{ asset('assets/css/bootstrap.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('assets/css/app.min.css') }}" as="style">

    <!-- Hojas de Estilo -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet">

    <!-- Estilos Personalizados -->
    <style>
        /* Variables base - Tema claro (default) */
        :root {
            --bg-gradient-start: #f8fafc;
            --bg-gradient-end: #eef2f6;
            --card-bg: rgba(255, 255, 255, 0.95);
            --card-border: rgba(0, 0, 0, 0.05);
            --card-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.02);
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --input-bg: #ffffff;
            --input-border: #e2e8f0;
            --input-focus-border: #6366f1;
            --input-focus-shadow: rgba(99, 102, 241, 0.1);
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --primary-light: #e0e7ff;
            --error-color: #ef4444;
            --success-color: #10b981;
            --gradient-start: #6366f1;
            --gradient-end: #8b5cf6;
            --logo-bg: #ffffff;
            --footer-text: #94a3b8;
            --theme-toggle-bg: #ffffff;
            --theme-toggle-border: #e2e8f0;
            --theme-toggle-color: #64748b;
            --theme-toggle-hover: #6366f1;
        }

        /* Tema oscuro */
        body.dark-mode {
            --bg-gradient-start: #0b1120;
            --bg-gradient-end: #151e2f;
            --card-bg: rgba(21, 30, 47, 0.95);
            --card-border: rgba(255, 255, 255, 0.05);
            --card-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.02);
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --input-bg: #1e293b;
            --input-border: #334155;
            --input-focus-border: #818cf8;
            --input-focus-shadow: rgba(129, 140, 248, 0.1);
            --primary-color: #818cf8;
            --primary-hover: #6366f1;
            --primary-light: #1e293b;
            --error-color: #f87171;
            --success-color: #34d399;
            --gradient-start: #818cf8;
            --gradient-end: #a78bfa;
            --logo-bg: #1e293b;
            --footer-text: #64748b;
            --theme-toggle-bg: #1e293b;
            --theme-toggle-border: #334155;
            --theme-toggle-color: #cbd5e1;
            --theme-toggle-hover: #818cf8;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg-gradient-start) 0%, var(--bg-gradient-end) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
            position: relative;
            overflow-x: hidden;
        }

        /* Elementos decorativos de fondo */
        body::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 90% 50%, rgba(139, 92, 246, 0.05) 0%, transparent 25%),
                radial-gradient(circle at 30% 80%, rgba(99, 102, 241, 0.05) 0%, transparent 30%);
            pointer-events: none;
        }

        .account-pages {
            width: 100%;
            max-width: 480px;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        /* Botón de cambio de tema */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--theme-toggle-bg);
            border: 1px solid var(--theme-toggle-border);
            border-radius: 40px;
            padding: 8px 16px;
            font-size: 14px;
            color: var(--theme-toggle-color);
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: var(--card-shadow);
            z-index: 100;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            border-color: var(--theme-toggle-hover);
            color: var(--theme-toggle-hover);
            transform: translateY(-2px);
        }

        .theme-toggle i {
            font-size: 18px;
        }

        /* Card principal con efecto vidrio */
        .card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--card-border);
            border-radius: 32px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        /* Header minimalista */
        .card-header {
            padding: 40px 40px 20px;
            text-align: center;
        }

        .logo-wrapper {
            margin-bottom: 24px;
        }

        .logo-circle {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            border-radius: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(99, 102, 241, 0.2);
            transition: all 0.3s ease;
        }

        .logo-circle img {
            height: 36px;
            width: auto;
            filter: brightness(0) invert(1);
        }

        .card-header h1 {
            font-size: 28px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 8px;
            letter-spacing: -0.02em;
        }

        .card-header p {
            font-size: 15px;
            color: var(--text-secondary);
            margin: 0;
        }

        /* Cuerpo del card */
        .card-body {
            padding: 20px 40px 30px;
        }

        /* Formulario */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.02em;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            font-size: 15px;
            color: var(--text-primary);
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 16px;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--input-focus-border);
            box-shadow: 0 0 0 4px var(--input-focus-shadow);
        }

        .form-control.is-invalid {
            border-color: var(--error-color);
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        /* Campo de contraseña con toggle */
        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .password-toggle i {
            font-size: 20px;
        }

        /* Checkbox personalizado */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            margin-bottom: 24px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border: 1.5px solid var(--input-border);
            border-radius: 4px;
            background: var(--input-bg);
            cursor: pointer;
            accent-color: var(--primary-color);
        }

        .checkbox-label {
            font-size: 14px;
            color: var(--text-secondary);
            cursor: pointer;
        }

        /* Botón principal */
        .btn-primary {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            border: none;
            border-radius: 16px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Alertas */
        .alert {
            padding: 16px;
            border-radius: 16px;
            font-size: 14px;
            margin-bottom: 24px;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--success-color);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--error-color);
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Spinner */
        .loading-spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Footer */
        .card-footer {
            padding: 30px 40px 40px;
            text-align: center;
        }

        .card-footer p {
            font-size: 14px;
            color: var(--footer-text);
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .account-pages {
                padding: 16px;
            }

            .card-header,
            .card-body,
            .card-footer {
                padding-left: 24px;
                padding-right: 24px;
            }

            .card-header h1 {
                font-size: 24px;
            }

            .theme-toggle {
                top: 10px;
                right: 10px;
                padding: 6px 12px;
                font-size: 12px;
            }
        }

        /* Clases de utilidad */
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
        }

        .invalid-feedback {
            font-size: 12px;
            color: var(--error-color);
            margin-top: 6px;
        }
    </style>

    <title>Nexus - Centro de Conexión para Restaurantes</title>
</head>

<body>
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="themeToggle" aria-label="Cambiar tema">
        <i class="mdi" id="themeIcon"></i>
        <span id="themeText">Modo</span>
    </button>

    <div class="account-pages">
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="logo-wrapper">
                    <div class="logo-circle">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo Nexus">
                    </div>
                </div>
                <h1>Bienvenido a {{ config('app.name') }}</h1>
                <p>Tu centro de conexión para restaurantes</p>
            </div>

            <!-- Body -->
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="needs-validation" action="{{ route('login') }}" method="POST" novalidate>
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <i class="mdi mdi-email-outline input-icon"></i>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="tu@ejemplo.com"
                                required autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="password-wrapper">
                            <i class="mdi mdi-lock-outline input-icon"></i>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="mdi mdi-eye-outline"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="remember" id="remember-check">
                        <span class="checkbox-label">Recordar mi sesión</span>
                    </label>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary" id="loginButton">
                        <span id="buttonText">Iniciar Sesión</span>
                        <span id="buttonSpinner" class="loading-spinner" style="display: none;"></span>
                    </button>

                    <!-- 2FA Section -->
                    @if (session('2fa_required'))
                        <div class="form-group mt-4" id="2fa-section">
                            <label for="2fa_code" class="form-label">Código de Autenticación</label>
                            <input type="text" class="form-control" id="2fa_code" name="2fa_code"
                                placeholder="Ingresa tu código de 6 dígitos" required>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Footer -->
            <div class="card-footer">
                <p>© <span id="currentYear"></span> Nexus. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos del tema
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const themeText = document.getElementById('themeText');

            // Función para aplicar tema
            function setTheme(theme) {
                if (theme === 'dark') {
                    document.body.classList.add('dark-mode');
                    themeIcon.className = 'mdi mdi-weather-night';
                    themeText.textContent = 'Modo oscuro';
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.body.classList.remove('dark-mode');
                    themeIcon.className = 'mdi mdi-weather-sunny';
                    themeText.textContent = 'Modo claro';
                    localStorage.setItem('theme', 'light');
                }
            }

            // Función para determinar tema basado en hora
            function getThemeByTime() {
                const hour = new Date().getHours();
                return (hour >= 19 || hour < 7) ? 'dark' : 'light';
            }

            // Inicializar tema
            function initializeTheme() {
                const savedTheme = localStorage.getItem('theme');

                if (savedTheme) {
                    // Si hay tema guardado, usar ese
                    setTheme(savedTheme);
                } else {
                    // Si no, usar el tema basado en la hora
                    const timeBasedTheme = getThemeByTime();
                    setTheme(timeBasedTheme);
                }
            }

            // Toggle manual de tema
            themeToggle.addEventListener('click', function() {
                const isDark = document.body.classList.contains('dark-mode');
                setTheme(isDark ? 'light' : 'dark');
            });

            // Toggle de contraseña
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;

                    const icon = this.querySelector('i');
                    if (type === 'text') {
                        icon.classList.remove('mdi-eye-outline');
                        icon.classList.add('mdi-eye-off-outline');
                    } else {
                        icon.classList.remove('mdi-eye-off-outline');
                        icon.classList.add('mdi-eye-outline');
                    }
                });
            }

            // Validación de formulario y spinner
            const form = document.querySelector('.needs-validation');
            const loginButton = document.getElementById('loginButton');
            const buttonText = document.getElementById('buttonText');
            const buttonSpinner = document.getElementById('buttonSpinner');

            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!this.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                        this.classList.add('was-validated');
                    } else {
                        if (loginButton && buttonText && buttonSpinner) {
                            loginButton.disabled = true;
                            buttonText.textContent = 'Procesando...';
                            buttonSpinner.style.display = 'inline-block';
                        }
                    }
                });
            }

            // Auto-focus en el primer campo con error
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.focus();
            } else {
                document.getElementById('email')?.focus();
            }

            // Año actual en el footer
            document.getElementById('currentYear').textContent = new Date().getFullYear();

            // Inicializar tema
            initializeTheme();
        });
    </script>

    <!-- Scripts externos -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}" defer></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/app.js') }}" defer></script>
</body>

</html>
