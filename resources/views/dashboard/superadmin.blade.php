@extends('layouts.default')
@yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

@section('content')
    @include('dashboard.inc.icon_card')

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

    <div class="row">
        <div class="col-lg-6">
            <div class="card-title ">
                <h3 class="card-label font-weight-bolder text-dark h3">ফৌজদারি কার্যবিধি আইনের মামলার পাই চার্ট </h3>
            </div>
            <div class="card-toolbar">
                <button class="case-piechart btn btn-success spinner spinner-darker-white spinner-left"
                    onclick="case_pie_chart()">অনুসন্ধান করুন</button>
            </div>
            <div class="card-body" style="margin-top: 245px;">
                <div id="piechart_3d" style="width: 400px; height: 300px;"></div>
            </div>
        </div>
        <div class="col-lg-6">
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

                        $('#caseStatusMsg').text(response.msg).show();
                        // $("#ajaxform")[0].reset();
                        // $('.spinner').hide();
                        $('.report-case-status').removeClass('spinner');

                    }
                },
                error: function(error) {
                    console.log(error);
                    $('#nameError').text(response.responseJSON.errors.division);
                }
            });
        }

        // Case Pie Chart
        function case_pie_chart() {
            // Variable
            let division = $("#division_id").val();
            let district = $("#district_id").val();
            let upazila = $("#upazila_id").val();
            let dateFrom = $("#date_from").val();
            let dateTo = $("#date_to").val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            
            
            
            // if (division == null || division === undefined) {
            //     division = null;
            // } 

            // if (district == null || district === undefined) {
            //     district = null;
            // } 
            // if (upazila == null || upazila === undefined) {
            //     upazila = null;
            // } 

            // if (dateFrom == null || dateFrom === undefined) {
            //     dateFrom = null;
            // } 
            // if (dateTo == null || dateTo === undefined) {
            //     dateTo = null;
            // } 


            var title = "hello";
            var year = "2022";
            var temp_title = title + ' ' + year + '';

            // Loader
            $('.case-piechart').addClass('spinner');

            // Reqpuest
            $.ajax({
                url: "{{ route('dashboard.crpc-pie-chart') }}",
                method: "POST",
                data: {
                    division: division,
                    district: district,
                    upazila: upazila,
                    dateFrom: dateFrom,
                    dateTo: dateTo,
                    _token: _token
                },
                dataType: "JSON",
                success: function(response) {
                    console.log('response', response)
                    if (!response.data) {
                        document.getElementById('piechart_3d').innerHTML =
                            '<p style="margin-left: 178px;margin-top: 134px;font-size: 30px;"> কোন অভিযোগের তথ্য পাওয়া যায় নাই</p>';
                    } else {
                        var data = google.visualization.arrayToDataTable([
                            ['CRPC', 'Case Count'],
                            // ['CRPC 100', response.data[100]],
                            // ['CRPC 107', response.data[107]],
                            // ['CRPC 108', response.data[108]],
                            // ['CRPC 109', response.data[109]],
                            // ['CRPC 110', response.data[110]],
                            // ['CRPC 144', response.data[144]],
                            // ['CRPC 145', response.data[145]]
                        ]);

                        var options = {
                            // title: 'My Daily Activities',
                            is3D: true,
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                        chart.draw(data, options);
                    }


                    $('.case-piechart').removeClass('spinner');
                }
            });
        }

        jQuery(document).ready(function() {
            // Load Function
            // crpc_statistic();
            case_status_statistic();
            // case_statistics_area();
            // statistics4();
            case_pie_chart()

            // District Dropdown
            jQuery('select[name="division"]').on('change', function() {
                var dataID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#district_id").after('<div class="loadersmall"></div>');

                if (dataID) {
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



