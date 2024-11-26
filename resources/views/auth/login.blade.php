{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>
        

        <div class="flex items-center justify-start mt-4">
            <x-primary-button>
                    {{ __('Log in') }}
            </x-primary-button>
            
            @if (Route::has('register'))
                 <a class="underline text-sm m-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            @endif
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

          
        </div>
    </form>
</x-guest-layout> --}}

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <title>Softconnect_ERP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset('/skote/assets/images/favicon.ico') }}">

  <!-- Bootstrap Css -->
  <link href="{{ asset('/skote/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
    type="text/css" />
  <!-- Icons Css -->
  <link href="{{ asset('/skote/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- App Css-->
  <link href="{{ asset('/skote/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
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
                  <img src="{{ asset('/skote/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                </div>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="auth-logo">
                <a href="{{ route('login') }}" class="auth-logo-light">
                  <div class="avatar-md profile-user-wid mb-4">
                    <span class="avatar-title rounded-circle bg-light">
                      <img src="{{ asset('/skote/assets/images/logo-light.svg') }}" alt="" class="rounded-circle" height="34">
                    </span>
                  </div>
                </a>

                <a href="{{ route('login') }}" class="auth-logo-dark">
                  <div class="avatar-md profile-user-wid mb-4">
                    <span class="avatar-title rounded-circle bg-light">
                      <img src="{{ asset('/skote/assets/images/logo.svg') }}" alt="" class="rounded-circle"
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
                    <input name="email" type="email" class="form-control" id="email" value="{{ old('email') }}"
                      placeholder="Ingresa tu correo electrónico" required autofocus autocomplete="username">
                  </div>

                  <div class="mb-3">
                    <label class="form-label" for="password">{{ __('Password') }}</label>
                    <div class="input-group auth-pass-inputgroup">
                      <input name="password" type="password" id="password" class="form-control" aria-label="Password"
                        aria-describedby="password-addon" placeholder="Ingresa tu contraseña" required autocomplete="current-password">
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
  <script src="{{ asset('/skote/assets/libs/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('/skote/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('/skote/assets/libs/metismenu/metisMenu.min.js') }}"></script>
  <script src="{{ asset('/skote/assets/libs/simplebar/simplebar.min.js') }}"></script>
  <script src="{{ asset('/skote/assets/libs/node-waves/waves.min.js') }}"></script>

  <!-- App js -->
  <script src="{{ asset('/skote/assets/js/app.js') }}"></script>
</body>

</html>
