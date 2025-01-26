@extends('layouts.default')
@yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

@section('content')
    @include('dashboard.inc.icon_card_appeal')

    <style type="text/css">
        /*highchart css*/

        .highcharts-figure,
        .highcharts-data-table table {
            /*min-width: 310px; */
            /*max-width: 1000px;*/
            /*margin: 1em auto;*/
        }

        #container {
            /*height: 400px;*/
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            /*max-width: 500px;*/
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }


        /*Pie chart*/
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 1030px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }


        input[type="number"] {
            min-width: 50px;
        }
    </style>

    <style type="text/css">
        fieldset {
            border: 1px solid #ddd !important;
            margin: 0;
            xmin-width: 0;
            padding: 10px;
            position: relative;
            border-radius: 4px;
            background-color: #d5f7d5;
            padding-left: 10px !important;
        }

        fieldset .form-label {
            color: black;
        }

        legend {
            font-size: 14px;
            font-weight: bold;
            width: 45%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #5cb85c;
        }

        .list-group-flush>.list-group-item {
            padding-left: 0;
        }
    </style>


    <form action="javascript:void(0)" class="form" method="POST">
        @csrf



        <fieldset class="mb-6">
            <legend>ফিল্টারিং ফিল্ড সমূহ</legend>

            <div class="row">
                <div class="col-lg-2 mb-5">
                    <select name="division" id="division_id" class="form-control form-control-sm">
                        <option value="">-বিভাগ নির্বাচন করুন-</option>
                        @foreach ($divisions as $value)
                            <option value="{{ $value->id }}"> {{ $value->division_name_bn }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 mb-5">
                    <!-- <label>জেলা <span class="text-danger">*</span></label> -->
                    <select name="district" id="district_id" class="form-control form-control-sm">
                        <option value="">-জেলা নির্বাচন করুন-</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-5">
                    <!-- <label>উপজেলা </label> -->
                    <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                        <option value="">-উপজেলা নির্বাচন করুন-</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-5">
                    <input type="text" name="date_from" id="date_from"
                        class="form-control form-control-sm common_datepicker" placeholder="তারিখ হতে" autocomplete="off">
                </div>
                <div class="col-lg-2 mb-5">
                    <input type="text" name="date_to" id="date_to"
                        class="form-control form-control-sm common_datepicker" placeholder="তারিখ পর্যন্ত"
                        autocomplete="off">
                </div>
            </div>
        </fieldset>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title ">
                            <h3 class="card-label font-weight-bolder text-dark h3">আদালত ভিত্তিক মামলার পরিসংখ্যান</h3>
                        </div>
                        <div class="card-toolbar">
                            <button class="report-case-status btn btn-success spinner spinner-darker-white spinner-left"
                                onclick="case_status_statistic()">অনুসন্ধান করুন</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="font-weight-boldest text-center h5 text-success" id="caseStatusMsg"></p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item font-weight-bolder h6"> <i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>জেনারেল সার্টিফিকেট অফিসারের আদালতে
                                বিচারাধীন মামলা
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="ON_TRIAL">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>অতিরিক্ত জেলা প্রশাসক (রাজস্ব) এর আদালতে
                                বিচারাধীন আপীল মামলা
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="ON_TRIAL_DC">0</span>
                            </li>
                            <li class="list-group-item"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>
                                    <span class="font-weight-bolder h5">অতিরিক্ত বিভাগীয় কমিশনার (রাজস্ব) এর আদালতে বিচারাধীন আপীল 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; মামলা</span>
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="ON_TRIAL_DIV_COM">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>ভূমি আপিল বোর্ড চেয়ারম্যানের আদালতে
                                বিচারাধীন আপীল মামলা
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="ON_TRIAL_LAB_CM">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>সার্টিফিকেট অফিসারের আদালতে গ্রহণের
                                জন্য
                                অপেক্ষমান রিকুইজিশন
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="SEND_TO_GCO">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>সার্টিফিকেট সহকারীর গ্রহণের জন্য
                                অপেক্ষমান রিকুইজিশন
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="SEND_TO_ASST_GCO">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>ভূমি আপীল বোর্ড চেয়ারম্যানের আদালতে
                                নিষ্পত্তিকৃত আপীল মামলা
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="SEND_TO_DC">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>
                                    <span class="font-weight-bolder h5">অতিরিক্ত বিভাগীয় কমিশনার (রাজস্ব) এর  আদালতে নিষ্পত্তিকৃত &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;আপীল মামলা</span>
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="SEND_TO_DIV_COM">0</span>
                            </li>

                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>অতিরিক্ত জেলা প্রশাসক (রাজস্ব) এর আদালতে
                                নিষ্পত্তিকৃত আপীল মামলা
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="SEND_TO_DC">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>জেনারেল সার্টিফিকেট আদালতে নিষ্পত্তিকৃত মোট মামলা
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="CLOSED">0</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title ">
                            <h3 class="card-label font-weight-bolder text-dark h3">অর্থ আদায়</h3>
                        </div>
                        <div class="card-toolbar">
                            <button class="report-payment btn btn-success spinner spinner-darker-white spinner-left"
                                onclick="payment_statistic()">অনুসন্ধান করুন</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="font-weight-boldest text-center h5 text-success" id="paymentMsg"></p>
                        <div id="result_table"></div>
                    </div>

                </div>
            </div>
        </div> <!-- /row -->
    </form>


    <div class="row">
        <div class="col-xl-12">
            <div class="card card-custom card-stretch gutter-b">
                <figure class="highcharts-figure" style="width: 100%">
                    <div id="container"></div>
                </figure>
            </div>
        </div>
    </div>
@endsection


{{-- Includable CSS Related Page --}}
@section('styles')
    <link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
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
        $('.Count').each(function() {
            var en2bnnumbers = {
                0: '০',
                1: '১',
                2: '২',
                3: '৩',
                4: '৪',
                5: '৫',
                6: '৬',
                7: '৭',
                8: '৮',
                9: '৯'
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
            jQuery({
                Counter: 0
            }).animate({
                Counter: nubmer
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    var nn = Math.ceil(this.Counter).toString();
                    // console.log(replaceEn2BnNumbers(nn));
                    $this.text(replaceEn2BnNumbers(nn));
                }
            });
        });
    </script>

    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'বিভাগ ও জেলা ভিত্তিক মামলা'
            },
            subtitle: {
                text: 'মামলা'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Number of Case'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            },

            series: [{
                name: "Division",
                colorByPoint: true,
                data: <?= json_encode($divisiondata) ?>
            }],

            drilldown: {
                series: <?= json_encode($dis_upa_data) ?>
            }
        });
    </script>

    <script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
    <script>
        // common datepicker
        $('.common_datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            orientation: "bottom left"
        });
    </script>

    <script type="text/javascript">
        // Case Status Statistics
        function case_status_statistic() {
            // console.log('submitted!');
            // Variable
            let division = $("#division_id").val();
            let district = $("#district_id").val();
            let upazila = $("#upazila_id").val();
            let dateFrom = $("#date_from").val();
            let dateTo = $("#date_to").val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            // console.log(division);

            // Loader
            $('.report-case-status').addClass('spinner');

            // AJAX Request
            $.ajax({
                url: "{{ route('dashboard.case-status-report') }}",
                type: "POST",
                data: {
                    division: division,
                    district: district,
                    upazila: upazila,
                    dateFrom: dateFrom,
                    dateTo: dateTo,
                    _token: _token
                },
                success: function(response) {
                    console.log(response);
                    if (response) {
                        $('#ON_TRIAL').html(response.data['ON_TRIAL']);
                        $('#SEND_TO_GCO').html(response.data['SEND_TO_GCO']);
                        $('#SEND_TO_ASST_GCO').html(response.data['SEND_TO_ASST_GCO']);
                        $('#SEND_TO_DC').html(response.data['SEND_TO_DC']);
                        $('#SEND_TO_NBR_CM').html(response.data['SEND_TO_NBR_CM']);
                        $('#CLOSED').html(response.data['CLOSED']);
                        $('#REJECTED').html(response.data['REJECTED']);
                        $('#ON_TRIAL_DC').html(response.data['ON_TRIAL_DC']);
                        $('#ON_TRIAL_DIV_COM').html(response.data['ON_TRIAL_DIV_COM']);
                        $('#ON_TRIAL_NBR_CM').html(response.data['ON_TRIAL_NBR_CM']);

                        $('#caseStatusMsg').text(response.msg).show();
                        // $("#ajaxform")[0].reset();
                        // $('.spinner').hide();
                        $('.report-case-status').removeClass('spinner');

                    }
                },
                error: function(error) {
                    console.log(error);
                    // $('#nameError').text(response.responseJSON.errors.division);
                }
            });
        }

        function payment_statistic() {
            // console.log('submitted!');
            // Variable
            let division = $("#division_id").val();
            let district = $("#district_id").val();
            let upazila = $("#upazila_id").val();
            let dateFrom = $("#date_from").val();
            let dateTo = $("#date_to").val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            // console.log(division);

            // Loader
            $('.report-payment').addClass('spinner');

            // AJAX Request
            $.ajax({
                url: "{{ route('dashboard.payment-report') }}",
                type: "POST",
                data: {
                    division: division,
                    district: district,
                    upazila: upazila,
                    dateFrom: dateFrom,
                    dateTo: dateTo,
                    _token: _token
                },
                success: function(response) {
                    // console.log(response);
                    if (response) {
                        $('#result_table').html(response.data);

                        $('#paymentMsg').text(response.msg).show();
                        // $("#ajaxform")[0].reset();
                        // $('.spinner').hide();
                        $('.report-payment').removeClass('spinner');

                    }
                },
                error: function(error) {
                    console.log(error);
                    // $('#nameError').text(response.responseJSON.errors.division);
                }
            });
        }

        // jQuery
        jQuery(document).ready(function() {
            // Load Function
            // crpc_statistic();
            case_status_statistic();
            payment_statistic();
            // case_statistics_area();
            // statistics4();

            // District Dropdown
            jQuery('select[name="division"]').on('change', function() {
                var dataID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#district_id").after('<div class="loadersmall"></div>');

                if (dataID !== undefined) {
                    jQuery.ajax({
                        url: '{{ url('/') }}/case/dropdownlist/getdependentdistrict/' + dataID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="district"]').html(
                                '<div class="loadersmall"></div>');
                            //console.log(data);
                            // jQuery('#mouja_id').removeAttr('disabled');
                            // jQuery('#mouja_id option').remove();

                            jQuery('select[name="district"]').html(
                                '<option value="">-- নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                jQuery('select[name="district"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                            jQuery('.loadersmall').remove();
                            // $('select[name="mouja"] .overlay').remove();
                            // $("#loading").hide();
                        }
                    });
                } else {
                    $('select[name="district"]').empty();
                }
            });

            // Upazila Dropdown
            jQuery('select[name="district"]').on('change', function() {
                var dataID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#upazila_id").after('<div class="loadersmall"></div>');
                // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
                // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
                // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
                // jQuery('.loadersmall').remove();
                /*if(dataID)
                {*/
                jQuery.ajax({
                    url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentupazila/' +
                        dataID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="upazila"]').html(
                            '<div class="loadersmall"></div>');
                        //console.log(data);
                        // jQuery('#mouja_id').removeAttr('disabled');
                        // jQuery('#mouja_id option').remove();

                        jQuery('select[name="upazila"]').html(
                            '<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="upazila"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                        jQuery('.loadersmall').remove();
                        // $('select[name="mouja"] .overlay').remove();
                        // $("#loading").hide();
                    }
                });
                //}

                // Load Court
                var courtID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#court_id").after('<div class="loadersmall"></div>');
                // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
                // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
                // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
                // jQuery('.loadersmall').remove();
                // if(courtID)
                // {
                jQuery.ajax({
                    url: '{{ url('/') }}/court/dropdownlist/getdependentcourt/' + courtID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="court"]').html('<div class="loadersmall"></div>');
                        //console.log(data);
                        // jQuery('#mouja_id').removeAttr('disabled');
                        // jQuery('#mouja_id option').remove();

                        jQuery('select[name="court"]').html(
                            '<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="court"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                        jQuery('.loadersmall').remove();
                        // $('select[name="mouja"] .overlay').remove();
                        // $("#loading").hide();
                    }
                });
                //}
                /*else
                 {
                    $('select[name="upazila"]').empty();
                    $('select[name="court"]').empty();
                }*/
            });

        });
    </script>
@endsection
