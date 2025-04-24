<!doctype html>
<html lang="es" dir="ltr">

<head>
    <!-- Meta Tags Básicos -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema ERP Softconnect - Panel de administración">
    <meta name="author" content="Softconnect">

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

    <!-- Estilos Personalizados -->
    <style>
        :root {
            --primary-color: #006FB3;
            --primary-hover: #005a92;
            --error-color: #dc3545;
        }

        body {
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .account-pages {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .bg-primary.bg-soft {
            background-color: rgba(0, 42, 91, 0.5) !important;
        }

        .text-primary {
            color: #fff !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: var(--primary-hover) !important;
            border-color: var(--primary-hover) !important;
            color: #fff !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .auth-pass-inputgroup .input-group-text {
            cursor: pointer;
        }

        .invalid-feedback {
            color: var(--error-color);
            display: block;
        }

        .is-invalid {
            border-color: var(--error-color) !important;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
            vertical-align: middle;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

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

    <title>Softconnect ERP - Inicio de Sesión</title>
</head>

<body>
    <div class="account-pages my-4 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">¡Bienvenido de nuevo!</h5>
                                        <p>Inicia sesión para continuar.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ asset('assets/images/login-illustration.svg') }}" alt=""
                                        class="img-fluid d-none d-md-block">
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="{{ route('login') }}" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo Softconnect ERP"
                                                class="rounded-circle" height="34">
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

                                    <!-- En la sección del formulario -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input name="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            value="{{ old('email') }}" placeholder="Ingresa tu correo electrónico"
                                            required autofocus autocomplete="username">
                                        @error('email')
                                            <div class="invalid-feedback" id="email-error">{{ $message }}</div>
                                        @enderror
                                        <div class="valid-feedback" id="email-valid" style="display: none;">
                                            ✓ Correo electrónico válido
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password">Contraseña</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input name="password" type="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Ingresa tu contraseña" required
                                                autocomplete="current-password">
                                            <button class="btn btn-light" type="button" id="password-addon">
                                                <i class="mdi mdi-eye-outline"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback" id="password-error">{{ $message }}</div>
                                        @enderror
                                        <div class="valid-feedback" id="password-valid" style="display: none;">
                                            ✓ Contraseña válida
                                        </div>
                                    </div>

                                    <!-- Recordar sesión -->
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="remember-check"
                                            name="remember">
                                        <label class="form-check-label" for="remember-check">Recordar sesión</label>
                                    </div>

                                    <!-- Botón de Submit -->
                                    <div class="mt-3 d-grid">
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
                        <div class="card-footer bg-transparent text-center py-3">
                            <p class="mb-0">¿No tienes una cuenta? <a href="{{ route('register') }}"
                                    class="text-primary">Regístrate</a></p>
                        </div>
                    </div>

                    <!-- Footer de la página -->
                    <div class="mt-5 text-center">
                        <p>©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Softconnect ERP. Todos los derechos reservados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}" defer></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}" defer></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}" defer></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}" defer></script>
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
                    this.querySelector('i').classList.toggle('mdi-eye-outline');
                    this.querySelector('i').classList.toggle('mdi-eye-off-outline');
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
        });
    </script>
</body>

</html>
