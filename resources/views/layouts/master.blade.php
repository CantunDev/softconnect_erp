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

  <!-- Bootstrap Css -->
  <link href="{{ asset('/skote/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
    type="text/css" />
  <!-- Icons Css -->
  <link href="{{ asset('/skote/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- App Css-->
  <link href="{{ asset('/skote/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

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
</body>

</html>
