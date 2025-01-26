@extends('layouts.citizen.citizen')
@yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
@section('content')
    @include('dashboard.inc.citizen_icon_card')
    @include('dashboard.citizen.cause_list')
    
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
   
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/widgets.js') }}"></script>
    <script>
        $('.Count').each(function () {
            var en2bnnumbers = {
                0 : '০',
                1 : '১',
                2 : '২',
                3 : '৩',
                4 : '৪',
                5 : '৫',
                6 : '৬',
                7 : '৭',
                8 : '৮',
                9 : '৯'
            };
            var bn2ennumbers = {
                '০': 0,
                '১': 1,
                '২': 2,
                '৩': 3,
                '৪': 4,
                '৫': 5,
                '৬': 6,
                '৭': 7,
                '৮': 8,
                '৯': 9
            };
            function replaceEn2BnNumbers(input) {
                var output = [];
                for (var i = 0; i < input.length; ++i) {
                    if (en2bnnumbers.hasOwnProperty(input[i])) {
                    output.push(en2bnnumbers[input[i]]);
                    } else {
                    output.push(input[i]);
                    }
                }
                return output.join('');
            }
            function replaceBn2EnNumbers(input) {
                var output = [];
                for (var i = 0; i < input.length; ++i) {
                    if (bn2ennumbers.hasOwnProperty(input[i])) {
                    output.push(bn2ennumbers[input[i]]);
                    } else {
                    output.push(input[i]);
                    }
                }
                return output.join('');
            }
            var $this = $(this);
            var nubmer = replaceBn2EnNumbers($this.text());
            jQuery({ Counter: 0 }).animate({ Counter: nubmer }, {
                duration: 2000,
                easing: 'swing',
                step: function () {
                    var nn =  Math.ceil(this.Counter).toString();
                    // console.log(replaceEn2BnNumbers(nn));
                    $this.text(replaceEn2BnNumbers(nn));
                }
            });
        });
    </script>
    @if(in_array(globalUserInfo()->role_id,[36]) && globalUserInfo()->is_cdap_user == 1)
    <script>
        let token = '{{ Session::get('access_token_cdap') }}'
        let widgets_id = '{{ mygov_client_id()}}'
    </script>
    <script src="{{ mygov_endpoint() }}/js/mygov-widgets-plugin.js"></script>
    @endif
    
@endsection
