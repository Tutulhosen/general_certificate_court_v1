<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (isset($page_title))
        <title>{{ $page_title }}</title>
    @else
        <title>{{ __('সার্টিফিকেট আদালত') }}</title>
    @endif

    <link rel="shortcut icon" href="{{ asset(App\Models\SiteSetting::first()->fevicon) }}" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/brand/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/aside/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/aside/light.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/landing/custom.css') }}" rel="stylesheet" type="text/css" />


    <style>
        #pagePreLoader {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #fff url('https://teamphotousa.com/assets/images/teamphoto-loading.gif') no-repeat center;
            z-index: 9999999;
        }
        
    </style>
    <style>
        .input_bangla {
            font-family: boishakhi !important;
            font-size: 14px !important;
        }

        @font-face {
            font-family: 'boishakhi';
            src: url('/fonts/Boishkhi/Boishkhi.ttf') format('truetype');
        }

      
    </style>
    @yield('style')
</head>
<div class="header-fixed header-mobile-fixed aside-fixed aside-minimize-hoverable page-loading">
    <div class="" onload="pagePreLoaderOff()" id="pagePreLoader"></div>
    @include('layouts.landing._header_mobile')
    <div class="" id="kt_wrapper">
        @php
            $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        @endphp

        @include('layouts.landing._header')

        <div class="container" style="margin-top:90px; margin-bottom:25px">

            @yield('landing')

            <div class="container2" style="margin-top:90px; margin-bottom:25px">
                @if (request()->is('dashboard'))
                    @yield('content')
                @else
                    <div class="row2">
                        @if (isset($users) && $users != null)
                            <!-- <div class="custom-col-12"> -->
                            @yield('content')
                            <!-- </div> -->
                        @elseif(isset($court_page) && $court_page != null)
                            <!-- <div class="custom-col-12"> -->
                            @yield('content')
                            <!-- </div> -->
                        @else
                            <!-- <div class="col-md-12 test"> -->
                            @yield('content')
                            <!-- </div> -->
                        @endif
                    </div>
                @endif
            </div>

        </div>

    </div>
    @if (!Auth::check())
        @include('layouts.landing._footer')
    @endif



    <script>
        /*var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview"; */
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1400
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#E4E6EF",
                        "dark": "#181C32"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#EBEDF3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#3F4254",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#EBEDF3",
                    "gray-300": "#E4E6EF",
                    "gray-400": "#D1D3E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#7E8299",
                    "gray-700": "#5E6278",
                    "gray-800": "#3F4254",
                    "gray-900": "#181C32"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>
    <!--end::Global Theme Bundle-->

    {{-- csrf Token --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <!--begin::Page Vendors(used by this page)-->
    {{-- Includable JS Related Page --}}
    {{-- Toster Alert --}}
    <script src="{{ asset('js/pages/features/miscellaneous/toastr.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#pagePreLoader").addClass('d-none');
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            @if (Session::has('success'))
                toastr.success("{{ session('success') }}", "Success");
            @endif
            @if (Session::has('error'))
                toastr.error("{{ session('error') }}", "Error");
            @endif
            @if (Session::has('info'))
                toastr.info("{{ session('info') }}", "Info");
            @endif
            @if (Session::has('warning'))
                toastr.warning("{{ session('warning') }}", "Warning");
            @endif
        });
    </script>

    @yield('scripts')

    </body>

</html>
