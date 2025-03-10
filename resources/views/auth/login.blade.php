<!doctype html>
<html lang="es">

<head>
  <meta name="base-url" content="{{ asset('') }}">
  <meta charset="utf-8" />
  <title>Softconnect_ERP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

  <!-- Bootstrap Css -->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
  <!-- Icons Css -->
  <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- App Css-->
  <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
  <style>
    .bg-primary.bg-soft {
        background-color: rgb(0 2 10 / 50%) !important;
    }
    .text-primary{
      color: #fff !important; 
    }
    .btn-primary {
        color: #fff;
        background-color: #006FB3;
        border-color: #006FB3;
    }
    .btn-primary:focus{
      background-color: #006FB3 !important;
      color: #fff !important;
    }
  </style>
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
                  {{-- <img src="{{ asset('assets/images/profile-img.png') }}" alt="" class="img-fluid"> --}}
                </div>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="auth-logo">
                <a href="{{ route('login') }}" class="auth-logo-light">
                  <div class="avatar-md profile-user-wid mb-4">
                    <span class="avatar-title rounded-circle bg-light">
                      <img src="{{ asset('assets/images/logo-light.svg') }}" alt=""
                        class="rounded-circle" height="34">
                    </span>
                  </div>
                </a>

                <a href="{{ route('login') }}" class="auth-logo-dark">
                  <div class="avatar-md profile-user-wid mb-4">
                    <span class="avatar-title rounded-circle bg-light">
                      <img src="{{ asset('assets/images/logo.svg') }}" alt="" class="rounded-circle"
                        height="34">
                    </span>
                  </div>
                </a>
              </div>
              <div class="p-2">
                <form class="form-horizontal" action="{{ route('login') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input name="email" type="email" class="form-control" id="email"
                      value="{{ old('email') }}" placeholder="Ingresa tu correo electrónico" required autofocus
                      autocomplete="username">
                  </div>

                  <div class="mb-3">
                    <label class="form-label" for="password">{{ __('Password') }}</label>
                    <div class="input-group auth-pass-inputgroup">
                      <input name="password" type="password" id="password" class="form-control" aria-label="Password"
                        aria-describedby="password-addon" placeholder="Ingresa tu contraseña" required
                        autocomplete="current-password">
                      <button class="btn btn-light" type="button" id="password-addon"><i
                          class="mdi mdi-eye-outline"></i></button>
                    </div>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-check" name="remember">
                    <label class="form-check-label" for="remember-check">{{ __('Remember me') }}</label>
                  </div>

                  <div class="mt-3 d-grid">
                    <button class="btn btn-primary waves-effect waves-light"
                      type="submit">{{ __('Log in') }}</button>
                  </div>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JAVASCRIPT -->
  <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

  <!-- App js -->
  <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
