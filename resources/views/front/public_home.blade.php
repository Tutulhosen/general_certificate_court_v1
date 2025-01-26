<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <!-- <title>@yield('title', $page_title ?? 'Page Title') | {{ config('app.name') }}</title> -->
    <title>@yield('title', $page_title ?? 'Page Title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <meta name="_token" content="{{ csrf_token() }}" /> -->
    <meta name="description" content="Civil Suit Judiciary of Bangladesh" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    {{-- <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" /> --}}
    <link rel="shortcut icon" href="{{ asset(App\Models\SiteSetting::first()->fevicon) }}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/brand/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/themes/layout/aside/light.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->

    <!--begin::Page Vendors Styles(used by this page)-->
    {{-- Includable CSS Related Page --}}
    @yield('styles')

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-mobile-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    {{-- @if (Auth::user()->role_id == 2) --}}
    <div>
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        Basic Calendar
                    </h3>
                </div>
                <div class="card-toolbar">
                    <a href="#" class="btn btn-light-primary font-weight-bold">
                        <i class="ki ki-plus "></i> Add Event
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="kt_calendar"></div>
            </div>
        </div>
    </div>
    {{-- @endif --}}

    <!--begin::Header Mobile-->
    {{-- @include('layouts.base.header-mobile') --}}
    <!--end::Header Mobile-->

    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            {{-- @include('layouts.base.aside') --}}
            <!--end::Aside-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                {{-- @include('layouts.base.header') --}}
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Subheader-->

                    <!--end::Subheader-->

                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        @include('layouts.base.content')
                        <!--end::Container-->
                    </div>
                    <!--end::Entry-->
                </div>
                <!--end::Content-->

            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->

    <!-- begin::User Panel-->
    {{-- @include('layouts.partials.user_panel') --}}
    <!-- end::User Panel-->

    <!--begin::Quick Panel -->
    {{-- @include('layouts.partials.quick_panel') --}}
    <!--end::Quick Panel-->

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop">
        <span class="svg-icon">
            <!--begin::Svg Icon | path:media/svg/icons/Navigation/Up-2.svg-->
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <polygon points="0 0 24 0 24 24 0 24" />
                    <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                    <path
                        d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                        fill="#000000" fill-rule="nonzero" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
    </div>
    <!--end::Scrolltop-->

    <!--begin::Sticky Toolbar-->
    <!--end::Sticky Toolbar-->

    <!--begin::Demo Panel-->
    <!--end::Demo Panel-->

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
    <script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    {{-- <script src="{{ asset('js/pages/features/calendar/basic.js') }}"></script> --}}

    <!--begin::Page Vendors(used by this page)-->
    {{-- Includable JS Related Page --}}
    {{-- Toster Alert --}}
    <script src="{{ asset('js/pages/features/miscellaneous/toastr.js') }}"></script>

    <script>
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
    </script>
    <script>
        // console.log('Minar');
        // var js_json_obt = [@json($data ?? '')];
        // console.log(js_json_obt);

        "use strict";

        var KTCalendarBasic = function() {
            // var mk =
            //     $.ajax({
            // 	url: "https://reqres.in/api/products",
            // 	success: function(data){
            // 	    // $('#data').text(data);
            //         return data;
            //         // console.log(data.data);
            // 	},
            // 	error: function(){
            // 		alert("There was an error.");
            // 	}
            // });
            const mk = null;
            async function getUserAsync(name) {
                try {
                    let response = await fetch(`https://reqres.in/api/products`);
                    return await response.json();
                } catch (err) {
                    console.error(err);
                    // Handle errors here
                }
            }

            const minar = getUserAsync('yourUsernameHere').then(data => {
                // console.log(data.data);
                // const mk = data.data;
                return data;

                // Object.keys(minar).map((key) => {
                //     console.log(minar[key]);
                //     return {
                //         // title:  key,
                //         // start: YM + '-14T13:30:00',
                //         // description:  key,
                //         // end: YM + '-14',
                //         // className: "fc-event-success"

                //         // name: key,
                //         // data: minar[key],
                //         title: 'All Day Event',
                //         start: YM + '-01',
                //         description: 'Toto lorem ipsum dolor sit incid idunt ut',
                //         className: "fc-event-danger fc-event-solid-warning"
                //     }
                // })

            });
            // console.log(minar.data);



            // console.log(mk);
            return {
                //main function to initiate the module
                init: function() {
                    var todayDate = moment().startOf('day');
                    var YM = todayDate.format('YYYY-MM');
                    var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
                    var TODAY = todayDate.format('YYYY-MM-DD');
                    var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

                    var calendarEl = document.getElementById('kt_calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
                        themeSystem: 'bootstrap',

                        isRTL: KTUtil.isRTL(),

                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },

                        height: 800,
                        contentHeight: 780,
                        aspectRatio: 3, // see: https://fullcalendar.io/docs/aspectRatio

                        nowIndicator: true,
                        now: TODAY + 'T09:25:00', // just for demo

                        views: {
                            dayGridMonth: {
                                buttonText: 'month'
                            },
                            timeGridWeek: {
                                buttonText: 'week'
                            },
                            timeGridDay: {
                                buttonText: 'day'
                            }
                        },

                        defaultView: 'dayGridMonth',
                        defaultDate: TODAY,

                        editable: true,
                        eventLimit: true, // allow "more" link when too many events
                        navLinks: true,

                        events: @json($data['case'] ?? '').concat(@json($data['rm_case'] ?? '')),

                        // events: [
                        //     {
                        //         title: 'All Day Event',
                        //         start: YM + '-01',
                        //         description: 'Toto lorem ipsum dolor sit incid idunt ut',
                        //         className: "fc-event-danger fc-event-solid-warning"
                        //     },
                        //     {
                        //         title: 'Reporting',
                        //         start: YM + '-14T13:30:00',
                        //         description: 'Lorem ipsum dolor incid idunt ut labore',
                        //         end: YM + '-14',
                        //         className: "fc-event-success"
                        //     }
                        // ],

                        // events: [
                        //     {
                        //         title: 'All Day Event',
                        //         start: YM + '-01',
                        //         description: 'Toto lorem ipsum dolor sit incid idunt ut',
                        //         className: "fc-event-danger fc-event-solid-warning"
                        //     },
                        //     {
                        //         title: 'Reporting',
                        //         start: YM + '-14T13:30:00',
                        //         description: 'Lorem ipsum dolor incid idunt ut labore',
                        //         end: YM + '-14',
                        //         className: "fc-event-success"
                        //     },
                        //     {
                        //         title: 'Company Trip',
                        //         start: YM + '-02',
                        //         description: 'Lorem ipsum dolor sit tempor incid',
                        //         end: YM + '-03',
                        //         className: "fc-event-primary"
                        //     },
                        //     {
                        //         title: 'ICT Expo 2017 - Product Release',
                        //         start: YM + '-03',
                        //         description: 'Lorem ipsum dolor sit tempor inci',
                        //         end: YM + '-05',
                        //         className: "fc-event-light fc-event-solid-primary"
                        //     },
                        //     {
                        //         title: 'Dinner',
                        //         start: YM + '-12',
                        //         description: 'Lorem ipsum dolor sit amet, conse ctetur',
                        //         end: YM + '-10'
                        //     },
                        //     {
                        //         id: 999,
                        //         title: 'Repeating Event',
                        //         start: YM + '-09T16:00:00',
                        //         description: 'Lorem ipsum dolor sit ncididunt ut labore',
                        //         className: "fc-event-danger"
                        //     },
                        //     {
                        //         id: 1000,
                        //         title: 'Repeating Event',
                        //         description: 'Lorem ipsum dolor sit amet, labore',
                        //         start: YM + '-16T16:00:00'
                        //     },
                        //     {
                        //         title: 'Conference',
                        //         start: YESTERDAY,
                        //         end: TOMORROW,
                        //         description: 'Lorem ipsum dolor eius mod tempor labore',
                        //         className: "fc-event-primary"
                        //     },
                        //     {
                        //         title: 'Meeting',
                        //         start: TODAY + 'T10:30:00',
                        //         end: TODAY + 'T12:30:00',
                        //         description: 'Lorem ipsum dolor eiu idunt ut labore'
                        //     },
                        //     {
                        //         title: 'Lunch',
                        //         start: TODAY + 'T12:00:00',
                        //         className: "fc-event-info",
                        //         description: 'Lorem ipsum dolor sit amet, ut labore'
                        //     },
                        //     {
                        //         title: 'Meeting',
                        //         start: TODAY + 'T14:30:00',
                        //         className: "fc-event-warning",
                        //         description: 'Lorem ipsum conse ctetur adipi scing'
                        //     },
                        //     {
                        //         title: 'Happy Hour',
                        //         start: TODAY + 'T17:30:00',
                        //         className: "fc-event-info",
                        //         description: 'Lorem ipsum dolor sit amet, conse ctetur'
                        //     },
                        //     {
                        //         title: 'Dinner',
                        //         start: TOMORROW + 'T05:00:00',
                        //         className: "fc-event-solid-danger fc-event-light",
                        //         description: 'Lorem ipsum dolor sit ctetur adipi scing'
                        //     },
                        //     {
                        //         title: 'Birthday Party',
                        //         start: TOMORROW + 'T07:00:00',
                        //         className: "fc-event-primary",
                        //         description: 'Lorem ipsum dolor sit amet, scing'
                        //     },
                        //     {
                        //         title: 'Click for Google',
                        //         url: 'http://google.com/',
                        //         start: YM + '-28',
                        //         className: "fc-event-solid-info fc-event-light",
                        //         description: 'Lorem ipsum dolor sit amet, labore'
                        //     }
                        // ],

                        eventRender: function(info) {
                            var element = $(info.el);

                            if (info.event.extendedProps && info.event.extendedProps.description) {
                                if (element.hasClass('fc-day-grid-event')) {
                                    element.data('content', info.event.extendedProps.description);
                                    element.data('placement', 'top');
                                    KTApp.initPopover(element);
                                } else if (element.hasClass('fc-time-grid-event')) {
                                    element.find('.fc-title').append('<div class="fc-description">' +
                                        info.event.extendedProps.description + '</div>');
                                } else if (element.find('.fc-list-item-title').lenght !== 0) {
                                    element.find('.fc-list-item-title').append(
                                        '<div class="fc-description">' + info.event.extendedProps
                                        .description + '</div>');
                                }
                            }
                        }
                    });

                    console.log(calendar.state.eventSources[0].meta);
                    calendar.render();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTCalendarBasic.init();
        });
    </script>

    @yield('scripts')
</body>
<!--end::Body-->

</html>
