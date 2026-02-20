<!doctype html>
<html lang="en">

<head>
    <meta name="base-url" content="{{ asset('') }}">
    <meta charset="utf-8" />
    <title> @yield('title') {{ config('app.name') }} </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Dashboard Template" name="description" />
    <meta content="CANTUN SOLUTIONS DEVS" name="author" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <!-- Icons CSS -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- DataTables CSS -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Bootstrap Select CSS (compatible con Bootstrap 5) -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

    <!-- Bootstrap TouchSpin CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-touchspin/4.5.0/jquery.bootstrap-touchspin.css"
        integrity="sha512-zU+NsCDkOTnkeNKLLQq1dM4Ejiel2O23ZuuE2amJA0g8aLZyE3sEds8L5lzjh3va2fP8CMVHKirev2d0S4aT9g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- App CSS -->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    @vite(['resources/js/app.js'])
    <style>
        body[data-sidebar=dark] .navbar-brand-box {
            background: #01081d;
        }

        body[data-sidebar=dark] .vertical-menu {
            background: #01081d;
        }

        .apexcharts-datalabel-label,
        .apexcharts-datalabel-value {
            fill: #FFFFFF !important;
            /* Forzar el texto de los dataLabels a blanco */
            color: #FFFFFF !important;
        }

        /* Estilos para el esqueleto */
        .skeleton {
            width: 100%;
        }

        .skeleton-line {
            background-color: #e0e0e0;
            margin-bottom: 10px;
            border-radius: 4px;
            animation: shimmer 1.5s infinite linear;
        }

        /* Animación de shimmer (efecto de brillo) */
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-danger ul {
            margin-bottom: 0;
        }

        .alert-danger li {
            list-style-type: none;
        }
    </style>
</head>

<body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.partials.header')
        {{-- @include('layouts.partials.sidebar') --}}
        <x-left-sidebar />

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('layouts.partials.footer')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    {{-- @include('layouts.partials.right-sidebar') --}}

    <!-- JAVASCRIPT -->

    <!-- Tailwind (requerido para muchos plugins) -->
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    <!-- jQuery (requerido para muchos plugins) -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 5 (incluye Popper.js) -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Plugins adicionales -->
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Flatpickr y ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Datatables -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- AutoNumeric -->
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>

    <!-- Bootstrap Select (compatible con Bootstrap 5) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

    <!-- Bootstrap TouchSpin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-touchspin/4.3.0/jquery.bootstrap-touchspin.min.js">
    </script>
    <!-- Cleave JS -->
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/addons/cleave-phone.mx.js"></script>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Aplicación principal -->
    <script src="{{ asset('assets/js/app2.min.js') }}"></script>
    <script>
        const phoneElements = new Cleave('.phone', {
            phone: true,
            phoneRegionCode: 'MX'
        });
    </script>
    <script>
        // Selecciona el elemento h5 con la clase "price"
        const priceElements = document.querySelectorAll('.price');

        // Usa AutoNumeric para formatear el número
        priceElements.forEach(element => {
            const rawValue = parseFloat(element.textContent); // Obtén el valor del texto de la etiqueta
            if (!isNaN(rawValue)) {
                new AutoNumeric(element, {
                    currencySymbol: '$',
                    decimalPlaces: 2,
                    digitGroupSeparator: ',',
                    currencySymbolPlacement: 'p', // "p" coloca el símbolo antes del número
                    decimalCharacter: '.',
                    unformatOnSubmit: true, // Elimina el formato al enviar el formulario
                }).set(rawValue); // Establece el valor formateado en el elemento
            }
        });
    </script>
    <script>
        // Selecciona el elemento h5 con la clase "percentage"
        const percentageElements = document.querySelectorAll('.percentage');

        // Usa AutoNumeric para formatear como porcentaje
        percentageElements.forEach(element => {
            const rawValue = parseFloat(element.textContent); // Obtén el valor del texto de la etiqueta
            if (!isNaN(rawValue)) {
                new AutoNumeric(element, {
                    currencySymbol: '%', // El símbolo es el de porcentaje
                    decimalPlaces: 1, // Establece dos decimales
                    //   digitGrkoupSeparator: ',', // Si lo necesitas, puedes agregar separador de miles
                    percentage: true, // Activa la opción de porcentaje
                    scaleDecimalPlaces: 2, // Controla la cantidad de decimales
                    unformatOnSubmit: true, // Elimina el formato al enviar el formulario
                    decimalCharacter: '.', // Caracter decimal
                    currencySymbolPlacement: 's' // El símbolo del porcentaje va al final
                }).set(rawValue * 1); // Multiplica por 100 para obtener el valor en porcentaje
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Simula una carga de datos (puedes reemplazar esto con una llamada AJAX)
            setTimeout(function() {
                // Itera sobre cada restaurante
                document.querySelectorAll('.row').forEach((row, index) => {
                    // Oculta el skeleton
                    const skeleton = document.getElementById(`skeleton-${index}`);
                    if (skeleton) {
                        skeleton.style.display = 'none';
                    }

                    // Muestra el contenido real
                    const realContent = document.getElementById(`real-content-${index}`);
                    if (realContent) {
                        realContent.style.display = 'block';
                    }

                    // Verifica si hay errores
                    const errorAlert = document.getElementById(`error-content-${index}`);
                    if (errorAlert && errorAlert.querySelector('li')) {
                        // Si hay errores, muestra el div de errores
                        errorAlert.style.display = 'block';
                    } else {
                        // Si no hay errores, muestra el contenido normal
                        const dataContent = document.getElementById(`data-content-${index}`);
                        if (dataContent) {
                            dataContent.style.display = 'block';
                        }
                    }
                });
            }, 2000); // Simula un retraso de 2 segundos
            const errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.style.display = 'none';
                }, 5000); // Oculta el alert después de 5 segundos

                // Ocultar el alert al hacer clic en él
                errorAlert.addEventListener('click', function() {
                    errorAlert.style.display = 'none';
                });
            }
        });
    </script>
    <script>
         document.addEventListener("DOMContentLoaded", function() {
            // Simula una carga de datos (puedes reemplazar esto con una llamada AJAX)
            setTimeout(function() {
                // Itera sobre cada restaurante
                document.querySelectorAll('.row').forEach((row, index) => {
                    // Oculta el skeleton
                    const skeletonTotal = document.getElementById(`skeleton-total`);
                    if (skeletonTotal) {
                        skeletonTotal.style.display = 'none';
                    }

                    // Muestra el contenido real
                    const realContentTotal = document.getElementById(`real-content-total`);
                    if (realContentTotal) {
                        realContentTotal.style.display = 'block';
                    }                    
                        // Si no hay errores, muestra el contenido normal
                        const dataContentTotal = document.getElementById(`data-content-total`);
                        if (dataContentTotal) {
                            dataContentTotal.style.display = 'block';
                     }
                });
            }, 2000); // Simula un retraso de 2 segundos
            const errorAlertTotal = document.getElementById('error-alert');
        });
    </script>
    @yield('js')
</body>

</html>
