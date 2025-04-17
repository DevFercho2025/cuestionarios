<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../../assets/"
    data-template="vertical-menu-template"
    data-style="light">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/fonts/remixicon/remixicon.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/fonts/flag-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/node-waves/node-waves.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('/assets/css/demo.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/flatpickr/flatpickr.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/swiper/swiper.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/pages/cards-statistics.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/pages/cards-analytics.css')}}" />
    <script src="{{asset('/assets/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('/assets/vendor/js/template-customizer.js')}}"></script>
    <script src="{{asset('/assets/js/config.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</head>
<body>
<style>
    #template-customizer .template-customizer-open-btn{
        display: none !important;
    }
</style>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @include('partials.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include('partials.header')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            @yield('content')
            <!-- Content wrapper -->

            @include('partials.footer')
        </div>
        <!-- / Layout page -->
    </div>


</div>
<!-- / Layout wrapper -->


<script src="{{asset('/assets/vendor/libs/jquery/jquery.js')}}"></script>

<script src="{{asset('/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>


<script src="{{asset('/assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('/assets/vendor/js/bootstrap.js')}}"></script>

<script src="{{asset('/assets/vendor/libs/node-waves/node-waves.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/i18n/i18n.js')}}"></script>

<script src="{{asset('/assets/vendor/js/menu.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('/assets/js/main.js')}}"></script>

<script src="{{asset('/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/swiper/swiper.js')}}"></script>
<script src="{{asset('/assets/js/dashboards-analytics.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('/assets/js/tables-datatables-advanced.js')}}"></script>

@stack('scripts')

</body>
</html>
