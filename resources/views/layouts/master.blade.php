<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8" />
  <title> @yield('title') Softconnect_ERP </title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset('/skote/assets/images/favicon.ico') }}">

  <!-- DataTables -->
  <link href="{{ asset('/skote/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
  <link href="{{ asset('/skote/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
    rel="stylesheet" type="text/css" />

  <!-- Bootstrap Css -->
  <link href="{{ asset('/skote/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
    type="text/css" />
  <!-- Icons Css -->
  <link href="{{ asset('/skote/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- App Css-->
  <link href="{{ asset('/skote/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
  @vite(['resources/js/app.js'])
</head>

<body data-sidebar="dark">

  <!-- <body data-layout="horizontal" data-topbar="dark"> -->

  <!-- Begin page -->
  <div id="layout-wrapper">
    @include('layouts.partials.header')
    @include('layouts.partials.sidebar')

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

  @include('layouts.partials.right-sidebar')

  <!-- JAVASCRIPT -->
  <script src="{{ asset('./skote/assets/libs/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('./skote/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('./skote/assets/libs/metismenu/metisMenu.min.js') }}"></script>
  <script src="{{ asset('./skote/assets/libs/simplebar/simplebar.min.js') }}"></script>
  <script src="{{ asset('./skote/assets/libs/node-waves/waves.min.js') }}"></script>

  <script src="{{ asset('/skote/assets/js/app.js') }}"></script>

  <!-- Datatables -->
  <script src="{{ asset('/skote/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('/skote/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('/skote/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('/skote/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
  @yield('js')
</body>

</html>
