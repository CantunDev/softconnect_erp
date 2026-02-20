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

    <!-- Preload de Recursos Críticos -->
    <link rel="preload" href="{{ asset('assets/css/bootstrap.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('assets/css/app.min.css') }}" as="style">

    <!-- Hojas de Estilo -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet">

    <!-- Estilos Personalizados para Nexus -->
    <style>
        :root {
            /* Paleta Nexus - Vía Láctea Tecnológica */
            --primary-dark: #0A0F1F;      /* Fondo principal */
            --secondary-dark: #1A1F33;     /* Fondo secundario (tarjetas) */
            --primary-blue: #4A6FA5;       /* Azul acero elegante */
            --primary-hover: #5D5FEF;       /* Azul violáceo para hover */
            --accent-violet: #9F7AEA;       /* Violeta lavanda para acentos */
            --accent-light: #B794F4;        /* Lila claro para detalles */
            --text-primary: #E0E0E0;        /* Texto principal */
            --text-secondary: #A0A0A0;       /* Texto secundario */
            --error-color: #FF6B6B;          /* Rojo suave para errores */
            --success-color: #51D0A0;        /* Verde menta para éxito */
            --border-color: rgba(159, 122, 234, 0.2); /* Borde sutil */
        }

        body {
            background-color: var(--primary-dark);
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(90, 95, 239, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 90% 50%, rgba(159, 122, 234, 0.05) 0%, transparent 25%),
                radial-gradient(circle at 30% 80%, rgba(74, 111, 165, 0.05) 0%, transparent 30%);
            background-attachment: fixed;
        }

        .account-pages {
            flex: 1;
            display: flex;
            align-items: center;
        }

        /* Card principal con efecto vidrio */
        .card {
            background-color: var(--secondary-dark);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(159, 122, 234, 0.1);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        /* Header del card con gradiente */
        .bg-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-violet) 100%) !important;
            padding: 2rem 1.5rem !important;
        }

        .bg-primary .text-primary {
            color: white !important;
        }

        .bg-primary h5 {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .bg-primary p {
            opacity: 0.95;
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        /* Logo y avatar */
        .auth-logo {
            position: relative;
            margin-top: -30px;
        }

        .avatar-title {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-violet) 100%) !important;
            border: 3px solid var(--secondary-dark);
            width: 70px;
            height: 70px;
            border-radius: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .avatar-title img {
            filter: brightness(0) invert(1);
            height: 36px;
            width: auto;
        }

        /* Formulario */
        .card-body {
            padding: 2rem 2rem 1.5rem;
        }

        .form-label {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            margin-bottom: 0.35rem;
        }

        .form-control {
            background-color: rgba(10, 15, 31, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: rgba(10, 15, 31, 0.8);
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.2);
            color: var(--text-primary);
        }

        .form-control.is-invalid {
            border-color: var(--error-color);
            background-image: none;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2);
        }

        /* Grupo de input con botón */
        .input-group-text {
            background-color: rgba(10, 15, 31, 0.6);
            border: 1px solid var(--border-color);
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: var(--text-secondary);
            padding: 0.75rem 1rem;
        }

        .input-group-text:hover {
            color: var(--accent-violet);
            background-color: rgba(159, 122, 234, 0.1);
        }

        /* Checkbox personalizado */
        .form-check-input {
            background-color: rgba(10, 15, 31, 0.6);
            border-color: var(--border-color);
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.2);
            border-color: var(--primary-blue);
        }

        .form-check-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Botón principal */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-violet) 100%);
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.02em;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(74, 111, 165, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(159, 122, 234, 0.4);
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--accent-violet) 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(74, 111, 165, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            transform: none;
        }

        /* Alertas */
        .alert-success {
            background-color: rgba(81, 208, 160, 0.1);
            border: 1px solid rgba(81, 208, 160, 0.2);
            border-radius: 12px;
            color: var(--success-color);
        }

        .alert-danger {
            background-color: rgba(255, 107, 107, 0.1);
            border: 1px solid rgba(255, 107, 107, 0.2);
            border-radius: 12px;
            color: var(--error-color);
        }

        .alert-danger ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        /* Validación feedback */
        .invalid-feedback {
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .valid-feedback {
            color: var(--success-color);
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        /* Footer del card */
        .card-footer {
            background-color: rgba(10, 15, 31, 0.4);
            border-top: 1px solid var(--border-color);
            padding: 1.25rem;
        }

        .card-footer p {
            color: var(--text-secondary);
            margin-bottom: 0;
        }

        .card-footer a {
            color: var(--accent-violet);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .card-footer a:hover {
            color: var(--accent-light);
            text-decoration: underline;
        }

        /* Spinner personalizado */
        .loading-spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
            margin-right: 8px;
            vertical-align: middle;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Footer de página */
        .mt-5.text-center p {
            color: var(--text-secondary);
            font-size: 0.85rem;
            opacity: 0.7;
        }

        /* Clases de utilidad */
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
    </style>

    <title>Nexus - Centro de Conexión para Restaurantes</title>
</head>

<body>
    <div class="account-pages my-4 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <!-- Header con gradiente -->
                        <div class="bg-primary">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <div class="text-primary">
                                        <h5 class="text-primary">Bienvenido a {{config('app.name')}}</h5>
                                        <p>Tu centro de conexión para restaurantes</p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <img src="{{ asset('assets/images/login-illustration.svg') }}" alt="Ilustración {{config('app.name')}}"
                                        class="img-fluid" style="max-height: 80px; opacity: 0.9;">
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <!-- Logo -->
                            <div class="auth-logo">
                                <a href="{{ route('login') }}" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle">
                                            <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo Nexus">
                                        </span>
                                    </div>
                                </a>
                            </div>

                            <div class="p-2">
                                <form class="form-horizontal needs-validation" action="{{ route('login') }}"
                                    method="POST" novalidate aria-labelledby="loginHeading">
                                    <h2 id="loginHeading" class="visually-hidden">Formulario de inicio de sesión</h2>
                                    @csrf

                                    @if (session('status'))
                                        <div class="alert alert-success mb-3" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger mb-3" role="alert">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Campo Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input name="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            value="{{ old('email') }}" placeholder="tu@ejemplo.com"
                                            required autofocus autocomplete="username">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Campo Contraseña -->
                                    <div class="mb-3">
                                        <label class="form-label" for="password">Contraseña</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input name="password" type="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="••••••••" required autocomplete="current-password">
                                            <button class="btn input-group-text" type="button" id="password-addon">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Recordar sesión -->
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="remember-check"
                                            name="remember">
                                        <label class="form-check-label" for="remember-check">
                                            Recordar sesión
                                        </label>
                                    </div>

                                    <!-- Botón de Submit -->
                                    <div class="mt-4 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit"
                                            id="login-button">
                                            <span id="button-text">Iniciar Sesión</span>
                                            <span id="button-spinner" class="loading-spinner d-none"></span>
                                        </button>
                                    </div>

                                    <!-- 2FA (si está habilitado) -->
                                    @if (session('2fa_required'))
                                        <div class="mb-3 mt-3" id="2fa-section">
                                            <label for="2fa_code" class="form-label">Código de Autenticación</label>
                                            <input type="text" class="form-control" id="2fa_code"
                                                name="2fa_code" placeholder="Ingresa tu código de 6 dígitos" required>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>

                        <!-- Footer del Card -->
                        <div class="card-footer text-center">
                            <p class="mb-0">¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
                        </div>
                    </div>

                    <!-- Footer de la página -->
                    <div class="mt-5 text-center">
                        <p>© <script>document.write(new Date().getFullYear())</script> Nexus. Todos los derechos reservados.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}" defer></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/app.js') }}" defer></script>

    <!-- Scripts Personalizados -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle de contraseña
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('password-addon');

            if (toggleButton && passwordInput) {
                toggleButton.addEventListener('click', function() {
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;
                    this.setAttribute('aria-pressed', type === 'text');
                    
                    // Cambiar icono
                    const icon = this.querySelector('i');
                    if (icon) {
                        if (type === 'text') {
                            icon.classList.remove('mdi-eye-outline');
                            icon.classList.add('mdi-eye-off-outline');
                        } else {
                            icon.classList.remove('mdi-eye-off-outline');
                            icon.classList.add('mdi-eye-outline');
                        }
                    }
                });
            }

            // Validación de formulario
            const form = document.querySelector('.needs-validation');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!this.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                        this.classList.add('was-validated');
                    } else {
                        // Mostrar spinner de carga
                        const button = document.getElementById('login-button');
                        const buttonText = document.getElementById('button-text');
                        const buttonSpinner = document.getElementById('button-spinner');

                        if (button && buttonText && buttonSpinner) {
                            button.disabled = true;
                            buttonText.textContent = 'Procesando...';
                            buttonSpinner.classList.remove('d-none');
                        }
                    }
                }, false);
            }

            // Auto-focus en el primer campo con error
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.focus();
            } else {
                const emailInput = document.getElementById('email');
                if (emailInput) emailInput.focus();
            }

            // Validación en tiempo real para email (opcional)
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.addEventListener('input', function() {
                    if (this.validity.valid) {
                        this.classList.remove('is-invalid');
                    }
                });
            }
        });
    </script>
</body>

</html>