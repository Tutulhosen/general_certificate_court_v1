@extends('layouts.app')
@section('styles')
    <link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
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
    <style>
        .carousel-item img {
            max-height: auto !important;
        }
    </style>
@endsection
@section('content')
<div class="container" style="background-color:rgba(192,192,192,0.3);">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img class="d-block w-100" src="{{ asset('media/banner/National-Portal-Card-PM.jpeg') }}" alt="First slide">
                        
                    </div>
                      <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('media/banner/National-Portal-Card-PM.jpeg') }}" alt="Second slide">
                        
                    </div>
                      <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('media/banner/National-Portal-Card-PM.jpeg') }}" alt="Third slide">
                        
                    </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-1">
                  <p class="btn btn-secondary" type="text">নোটিশ:</p>
                </div>
                <div class="col-md-11">
                    <marquee style="font-size: 18px" direction="left" scrollamount="3" onmouseover="this.stop()" onmouseout="this.start()">
                                নাগরিক www.ldtax.gov.bd এ ভিজিট করে অনলাইনে নিবন্ধন এবং ভূমি উন্নয়ন কর প্রদান করতে পারবেন। তাছাড়া এনআইডি নম্বর, জন্ম তারিখ ও খতিয়ানের তথ্য প্রদান করে যে কোনও ইউনিয়ন ডিজিটাল সেন্টারের মাধ্যমে নিবন্ধন ও ভূমি উন্নয়ন কর প্রদান করার সুবিধা চালু করা হয়েছে।
                    </marquee>
                </div>
            </div>
        </div>
    </div>
    
        <div class="row">
            <div class="col-md-3">
                <div class="card card-custom card-stretch gutter-b ">
                                                <!--begin::Body-->
                    <div class="card-body d-flex align-items-center py-0 mt-8">
                        
                        <a href="{{ route('appealCreate') }}">
                        <i class="icon-xl fas fa-file-alt text-success fa-5x mb-5 mr-5"></i></a>
                            <span class="font-weight-bold text-active font-size-lg">আপিল আবেদন</span>
                    </div>
                    <!--end::Body-->
                </div>
            </div>      
            <div class="col-md-3">      
                <div class="card card-custom card-stretch gutter-b ">
                                                <!--begin::Body-->
                    <div class="card-body d-flex align-items-center py-0 mt-8">
                        
                        <a href="">
                        <i class="fa fa-search text-warning mr-5 mb-5 fa-5x"></i></a>
                            <span class="font-weight-bold text-active font-size-lg">আপিলের অবস্থা</span>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            
        </div>
    
        <div class="row">
            <div class="col-md-3">
                <div class="card card-custom card-stretch gutter-b ">
                                                <!--begin::Body-->
                    <div class="card-body d-flex align-items-center py-0 mt-8">
                        <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                           <p class="mt-user-title">সার্টিফিকেট কোর্ট সম্পর্কিত প্রশ্নোত্তর</p>
                        </div>
                        <a class="media-embed" data-asset="true" href="#" data-toggle="modal"data-target="#basicModal1">
                            <div class="mt-widget-1">
                                <div class="mt-icon mb-3">
                                    <i class="fas fa-question-circle fa-5x" aria-hidden="true"></i>
                                </div>
                                <div class="mt-body">
                                    
                                    <!-- <div class="mt-stats">
                                        <div class="btn-group btn-group-justified">
                                            <button style="background-color: #a6489c; color: white;" class="btn a2ipurple">
                                                <span>সচরাচর জিজ্ঞাসা</span>
                                            </button>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </a>
                            <!-- <span class="font-weight-bold text-muted font-size-lg">আপিল আবেদন</span> -->
                    </div>
                    <!--end::Body-->
                </div>
            </div>      
            <div class="col-md-3">      
                <div class="card card-custom card-stretch gutter-b ">
                                                <!--begin::Body-->
                    <div class="card-body d-flex align-items-center py-0 mt-8">
                        <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                            <p class="mt-user-title">সরকারী দাবী আদায় আইন, ১৯১৩</p>
                        </div>
                        <a class="media-embed" data-asset="true" href="#" data-toggle="modal"
                                               data-target="#basicModal2">
                            <div class="mt-widget-1">
                                <div class="mt-icon mb-3">
                                    <i class="icon-xl fas fa-file-alt fa-5x"></i>
                                </div>
                                <div class="mt-body">
                                    
                                    <!-- <div class="mt-stats">
                                        <div class="btn-group btn-group-justified">
                                            <button style="background-color: #a6489c; color: white;" class="btn a2igreen">
                                                <span>ডাউনলোডস</span>
                                            </button>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </a>
                            <!-- <span class="font-weight-bold text-muted font-size-lg">আপিলের অবস্থা</span> -->
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom card-stretch gutter-b ">
                                                <!--begin::Body-->
                    <div class="card-body d-flex align-items-center py-0 mt-8">
                        <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                           <p class="mt-user-title">ল’জ অব বাংলাদেশ</p>
                        </div>
                        <a class="" href="#" data-toggle="modal" data-target="#basicModal3">
                            <div class="mt-widget-1">
                                <div class="mt-icon mb-3">
                                    <i class="fa fa-university fa-5x" aria-hidden="true"></i>
                                </div>
                                <div class="mt-body">
                                    
                                    <!-- <div class="mt-stats">
                                        <div class="btn-group btn-group-justified">
                                            <button style="background-color: #a6489c; color: white;" class="btn a2ipurple">
                                                <span>গুরুত্বপূর্ণ লিঙ্ক</span>
                                            </button>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </a>
                            <!-- <span class="font-weight-bold text-muted font-size-lg">আপিল আবেদন</span> -->
                    </div>
                    <!--end::Body-->
                </div>
            </div>      
            <div class="col-md-3">      
                <div class="card card-custom card-stretch gutter-b ">
                                                <!--begin::Body-->
                    <div class="card-body d-flex align-items-center py-0 mt-8">
                        <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                           <p class="mt-user-title">সিস্টেম ব্যবহারে কোনো সমস্যার সম্মুখীন হলে যোগাযোগ</p>
                        </div>
                        <a href="#" data-toggle="modal" data-target="#basicModal4">
                            <div class="mt-widget-1">
                                <div class="mt-icon mb-3">
                                    <i class="fas fa-phone-alt fa-5x" aria-hidden="true"></i>
                                </div>
                                <div class="mt-body">
                                    
                                    <!-- <div class="mt-stats">
                                        <div class="btn-group btn-group-justified">
                                            <button style="background-color: #a6489c; color: white;" class="btn a2igreen">
                                                <span>যোগাযোগ</span>
                                            </button>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </a>
                            <!-- <span class="font-weight-bold text-muted font-size-lg">আপিলের অবস্থা</span> -->
                    </div>
                    <!--end::Body-->
                </div>
            </div>   
        </div>
    
    
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card card-custom">
                        <div class="card-body row">
                            <div class="modal fade" id="basicModal1" tabindex="-1" role="dialog"aria-labelledby="basicModal"aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h3 class="modal-title" id="myModalLabel">সচরাচর জিজ্ঞাসা</h3>
                                        </div>
                                        <div class="modal-body">
                                            <h4>সার্টিফিকেট কোর্ট ও মামলা পরিচালনা সম্পর্কিত প্রশ্নোত্তর</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"> বন্ধ করুন</button>
                                            {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="basicModal2" tabindex="-1" role="dialog" aria-labelledby="basicModal"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h3 class="modal-title" id="myModalLabel">ডাউনলোডস</h3>
                                        </div>
                                        <div class="modal-body">
                                            <h4>সরকারী দাবী আদায় আইন, ১৯১৩</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"> বন্ধ করুন</button>
                                            {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="basicModal3" tabindex="-1" role="dialog" aria-labelledby="basicModal"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h3 class="modal-title" id="myModalLabel">গুরুত্বপূর্ণ লিঙ্ক</h3>
                                        </div>
                                        <div class="modal-body">
                                            <h4>ল’জ অব বাংলাদেশ</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"> বন্ধ করুন</button>
                                            {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="basicModal4" tabindex="-1" role="dialog" aria-labelledby="basicModal"
                                 aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h3 class="modal-title" id="myModalLabel">যোগাযোগ</h3>
                                        </div>
                                        <div class="modal-body">
                                            <h4>সার্টিফিকেট কোর্ট সিস্টেম ব্যবহারে কোনো সমস্যার সম্মুখীন হলে</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"> বন্ধ করুন</button>
                                            {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                    জেনারেল সার্টিফিকেট কোর্ট
                                </h3>
                            </div>
                            {{-- <div class="card-toolbar">
                                <a href="#" class="btn btn-light-primary font-weight-bold">
                                    <i class="ki ki-plus "></i> Add Event
                                </a>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <p>
                                জেনারেল সার্টিফিকেট কোর্ট পরিচালনার সাথে সম্পৃক্ত জেনারেল সার্টিফিকেট অফিসারের কর্মদক্ষতা বৃদ্ধি, একটি সিস্টেমের মাধ্যমে প্রশিক্ষণ প্রদানে সহায়তাসহ তাৎক্ষণিকভাবে জেনারেল সার্টিফিকেট অফিসারকে আইনী তথ্য সরবরাহ, ঊর্ধ্বতন কর্তৃপক্ষের মাধ্যমে জেনারেল সার্টিফিকেট অফিসারের কার্যক্রম পরিবীক্ষণ, দ্রুততার সাথে কার্যক্রম সম্পাদন, জনগণের হয়রানি লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা প্রদানের বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে।
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script>
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
</script> --}}

@endsection
@section('scripts')
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
<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ asset('js/scripts.bundle.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>

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
    "use strict";
    var KTCalendarBasic = function() {
        const mk = null;
        async function getUserAsync(name) {
            try {
                let response = await fetch(`https://reqres.in/api/products`);
                return await response.json();
            } catch (err) {
                console.error(err);
            }
        }

        const minar = getUserAsync('yourUsernameHere').then(data => {
            return data;
        });



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
                            buttonText: 'Month'
                        },
                        timeGridWeek: {
                            buttonText: 'Week'
                        },
                        timeGridDay: {
                            buttonText: 'Day'
                        }
                    },
                    defaultView: 'dayGridMonth',
                    defaultDate: TODAY,

                    // editable: true,
                    editable: false,
                    eventLimit: true, // allow "more" link when too many events
                    navLinks: true,

                    events: @json($data['case'] ?? '').concat(@json($data['rm_case'] ?? '')),
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
@endsection
