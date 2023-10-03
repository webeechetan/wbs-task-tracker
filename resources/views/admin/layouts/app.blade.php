<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
      <title> @yield('title')</title>
      <meta name="description" content="" />
      <link rel="icon" type="image/x-icon" href="{{ asset('admin') }}/img/favicon/favicon.ico" />
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
      <link rel="stylesheet" href="{{ asset('admin') }}/vendor/fonts/boxicons.css" />
      <link rel="stylesheet" href="{{ asset('admin') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
      <!-- Select2 -->
      <link rel="stylesheet" href="{{ asset('admin') }}/vendor/libs/select2/select2.css" />
      <link rel="stylesheet" href="{{ asset('admin') }}/vendor/css/core.css" class="template-customizer-core-css" />
      <link rel="stylesheet" href="{{ asset('admin') }}/vendor/css/theme-default.css" class="template-customizer-theme-css" />
      <link rel="stylesheet" href="{{ asset('admin') }}/css/demo.css" />
      <script src="{{ asset('admin') }}/vendor/js/helpers.js"></script>
      <script src="{{ asset('admin') }}/js/config.js"></script>
      @yield('styles')
   </head>
   <body>
      <!-- Layout wrapper -->
      <div class="layout-wrapper layout-content-navbar">
         <div class="layout-container">
            <x-admin.sidebar />
            <div class="layout-page">
               <x-admin.navbar />
               <!-- Content wrapper -->
               <div class="content-wrapper">
                  <div class="container-xxl flex-grow-1 container-p-y">
                     @yield('content')
                  </div>
                  <x-admin.footer />
                  <div class="content-backdrop fade"></div>
               </div>
            </div>
         </div>
         <div class="layout-overlay layout-menu-toggle"></div>
         <div>
            <div class="bs-toast toast toast-placement-ex m-2 fade  top-0 end-0 hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold" id="toastHead"></div>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body" id="toastBody"></div>
            </div>
          </div>
      </div>
      <script src="{{ asset('admin') }}/vendor/libs/jquery/jquery.js"></script>
      <script src="{{ asset('admin') }}/vendor/libs/popper/popper.js"></script>
      <script src="{{ asset('admin') }}/vendor/js/bootstrap.js"></script>
      <script src="{{ asset('admin') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
      <script src="{{ asset('admin') }}/vendor/libs/select2/select2.js"></script>
      <script src="{{ asset('admin') }}/vendor/js/menu.js"></script>
      <script src="{{ asset('admin') }}/vendor/libs/apex-charts/apexcharts.js"></script>
      <script src="{{ asset('admin') }}/js/main.js"></script>
      <script src="{{ asset('admin') }}/js/dashboards-analytics.js"></script>
      <script src="{{ asset('admin') }}/js/ui-toasts.js"></script>
      @if(session()->has('alert'))
        @php
            $alert = Session::get('alert');
            $toastHead = $alert['msg'];
            $toastBody = $alert['body'];
            $toastType = $alert['type'];
        @endphp
        <script>
          $(document).ready(function() {
            toast('{{ $toastHead }}','{{ $toastBody }}','{{ $toastType }}');
          });
        </script>
      @endif
      @yield('scripts')
   </body>
</html>