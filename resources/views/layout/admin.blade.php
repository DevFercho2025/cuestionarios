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

    <title>Dashboard - Alobri</title>

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
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/apex-charts/apex-charts.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/libs/swiper/swiper.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/pages/cards-statistics.css')}}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/css/pages/cards-analytics.css')}}" />
    <script src="{{asset('/assets/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('/assets/vendor/js/template-customizer.js')}}"></script>
    <script src="{{asset('/assets/js/config.js')}}"></script>
</head>
<body>
<div class="container" id="contenidoPagina">
    @yield('content')

    @include('partials.footer')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('/assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('/assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/node-waves/node-waves.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('/assets/vendor/js/menu.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="{{asset('/assets/vendor/libs/swiper/swiper.js')}}"></script>
<script src="{{asset('/assets/js/main.js')}}"></script>
<script src="{{asset('/assets/js/dashboards-analytics.js')}}"></script>

@yield('scripts')

</body>
</html>
