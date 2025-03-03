<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset(setting_option('favicon')) }}" />
  <meta name="robots" content="noindex">
  <meta name="googlebot" content="noindex">

  @yield('seo')
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet"
  />

  <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
  <link rel="stylesheet" id="fontawesome-css" href="https://use.fontawesome.com/releases/v5.0.1/css/all.css?ver=4.9.1" type="text/css" media="all">

  <link rel="stylesheet" href="{{ asset('assets/plugins/datetimepicker/jquery.datetimepicker.min.css')  }}">
  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('assets/css/demo.css?ver=1.00') }}" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

  <script src="{{ asset('js/axios.min.js') }}"></script>
  <!-- Helpers -->
  <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

  <script src="{{ asset('assets/js/config.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
  
  <script type="text/javascript">
    var admin_url = '{{route('admin.dashboard')}}';
  </script>
  @stack('styles')
</head>
<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      
      @include('admin.layouts.sidebar')
      <div class="layout-page">
        @include('admin.layouts.header')
        <div class="content-wrapper">
          <div class="container-fluid flex-grow-1">
            @yield('content')
          </div>
          @include('admin.layouts.footer')
        </div>
      </div>

      
    </div>
  </div>
   

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  
  <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

  <script src="{{ asset('assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>

  <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
  <!-- endbuild -->

  {{-- sweetalert2 --}}
  <script src="{{ sc_file('assets/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
  {{-- select2 --}}
  <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>


  <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
  <script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script>

  <!-- Main JS -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script src="{{ asset('assets/js/js_admin.js?ver=1.00') }}"></script>

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  @stack('scripts')
</body>
</html>