@extends('layouts.default')

@section('content')

@php
$new=$running=$finished=$applied=0;
foreach ($cases as $val)
{
   if($val->status == 1){
   $new++;
}
if($val->status == 2){
$running++;
}
if($val->status == 3){
$applied++;
}
if($val->status == 4){
$finished++;
}
}

@endphp


@php

$status = case_status(1);
$email = user_email();

@endphp

{{-- $status --}}
{{-- $email --}}
{{-- en2bn(25) --}}

<!--begin::Dashboard-->

<style type="text/css">
   .highcharts-figure, .highcharts-data-table table {
   /* min-width: 310px;
    max-width: 800px;*/
    margin: 1em auto;
 }

 #container {
    height: 400px;
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
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
 padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
 background: #f8f8f8;
}
.highcharts-data-table tr:hover {
 background: #f1f7ff;
}
</style>

<div class="row mb-5">
   <div class="col-md-3">
      <div class="card-counter primary">
         <a href="{{ route('case') }}"><i class="fa fas fa-layer-group text-white"></i></a>
         <span class="count-numbers"><a href="{{ route('case') }}"><?=en2bn($total_case)?></a></span>
         <span class="count-name"><a href="{{ route('case') }}">মোট মামলা</a></span>
      </div>
   </div>

   <div class="col-md-3">
      <div class="card-counter danger">
         <a href="{{ route('case.running') }}"><i class="fa fas fa-layer-group text-white"></i></a>
         <span class="count-numbers"><a href="{{ route('case.running') }}"><?=en2bn($running_case)?></a></span>
         <span class="count-name"><a href="{{ route('case.running') }}">চলমান মামলা</a></span>
      </div>
   </div>

   <div class="col-md-3">
      <div class="card-counter info">
         <a href="{{ route('case.appeal') }}"><i class="fa fas fa-layer-group text-white"></i></a>
         <span class="count-numbers"><a href="{{ route('case.appeal') }}"><?=en2bn($appeal_case)?></a></span>
         <span class="count-name"><a href="{{ route('case.appeal') }}">আপিল মামলা</a></span>
      </div>
   </div>

   <div class="col-md-3">
      <div class="card-counter success">
         <a href="{{ route('case.complete') }}"><i class="fa fas fa-layer-group text-white"></i></a>
         <span class="count-numbers"><a href="{{ route('case.complete') }}"><?=en2bn($completed_case)?></a></span>
         <span class="count-name"><a href="{{ route('case.complete') }}">সম্পাদিত মামলা</a></span>
      </div>
   </div>
</div>

<div class="row mb-5">
   <div class="col-md-3">
      <div class="card-counter warning">
         <a href="{{ route('office') }}"><i class="fa fas fa-archway text-white"></i></a>
         <span class="count-numbers"><a href="{{ route('office') }}"><?=en2bn($total_office)?></a></span>
         <span class="count-name"><a href="{{ route('office') }}">মোট অফিস</a></span>
      </div>
   </div>

   <div class="col-md-3">
      <div class="card-counter violet">
         <a href="{{ route('user-management.index') }}"><i class="fa fas fa-users text-white"></i></a>
         <span class="count-numbers"><a href="{{ route('user-management.index') }}"><?=en2bn($total_user)?></a></span>
         <span class="count-name"><a href="{{ route('user-management.index') }}">মোট ইউজার</a></span>
      </div>
   </div>

   <div class="col-md-3">
      <div class="card-counter submarine">
         <a href="{{ route('court') }}"><i class="fa fas fa-balance-scale text-white"></i></a>
         <span class="count-numbers"><a href="{{ route('court') }}"><?=en2bn($total_court)?></a></span>
         <span class="count-name"><a href="{{ route('court') }}">মোট আদালত</a></span>
      </div>
   </div>

   <div class="col-md-3">
      <div class="card-counter lightgreen">
         <a href="{{ route('case-type') }}"><i class="fa fas fa-database text-white"></i></a>
         <span class="count-numbers"><a href="{{ route('case-type') }}"><?=en2bn($total_ct)?></a></span>
         <span class="count-name"><a href="{{ route('case-type') }}">মামলার ধরণ</a></span>
      </div>
   </div>
</div>
<div class="row mb-5">
   <div class="col-md-3">
      <div class="card-counter success">
         <a href="{{ route('atcase.index') }}"><i class="fa fas fa-layer-group text-white"></i></a>
         <span class="count-numbers"><a href="{{ route('rmcase.index') }}"><?=en2bn($total_rm_case)?></a></span>
         <span class="count-name"><a href="{{ route('rmcase.index') }}">মোট রাজস্ব মামলা</a></span>
      </div>
   </div>
   
</div>

<?php /*
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure" style="width: 100%">
   <div id="container"></div>
</figure>
*/ ?>

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid mb-10" id="kt_subheader">
   <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
         <!--begin::Page Title-->
         <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5  font-size-h4">শুনানী/মামলার তারিখ</h5>
         <!--end::Page Title-->
         <!--begin::Action-->
         <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
         <a href="{{ route('dashboard.hearing-today') }}" class="btn btn-light-primary font-weight-bolder btn-sm mr-3 font-size-h4">আজকের দিনে</a>
         <a href="{{ route('dashboard.hearing-tomorrow') }}" class="btn btn-light-primary font-weight-bolder btn-sm mr-3 font-size-h4">আগামীকাল</a>
         <a href="{{ route('dashboard.hearing-nextWeek') }}" class="btn btn-light-primary font-weight-bolder btn-sm mr-3 font-size-h4">আগামী সপ্তাহে</a>
         <a href="{{ route('dashboard.hearing-nextMonth') }}" class="btn btn-light-primary font-weight-bolder btn-sm mr-3 font-size-h4">আগামী মাসে</a>
         <!--end::Action-->
      </div>
      <!--end::Info-->
   </div>
</div>
<!--end::Subheader-->

<?php /*
<div class="row mb-5">
   <div class="col-md-12">
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <div id="case_type_div"></div>
   </div>
</div>
*/ ?>



<!--begin::Row-->
<div class="row">
   <div class="col-md-8">
      <div class="card card-custom">
         <div class="card-header flex-wrap bg-danger py-5">
            <div class="card-title">
               <h3 class="card-label h3 font-weight-bolder"> পদক্ষেপ নিতে হবে এমন মামলাসমূহ</h3>
            </div>
         </div>
         <div class="card-body p-0">
            <ul class="navi navi-border navi-hover navi-active">
               @forelse ($case_status as $row)

               <li class="navi-item">
                  <a class="navi-link" href="{{ route('action.receive', $row->cs_id) }}">
                     <span class="navi-icon"><i class="fas fa-folder-open icon-lg text-danger mr-3"></i></span>
                     <div class="navi-text">
                        <span class="d-block font-weight-bold h4 pt-2">{{ $row->status_name }}</span>
                     </div>
                     <span class="navi-label">
                        <span class="label label-xl label-danger h5">{{ $row->total_case }}</span>
                     </span>
                  </a>
               </li>

               @empty

               <li class="navi-item">
                  <div class="alert alert-custom alert-light-success fade show m-5" role="alert">
                     <div class="alert-icon">
                        <i class="flaticon-list"></i>
                     </div>
                     <div class="alert-text font-size-h4">পদক্ষেপ নিতে হবে এমন কোন মামলা পাওয়া যায়নি</div>
                  </div>
               </li>

               @endforelse
            </ul>
         </div>
      </div>
   </div>
   @include('dashboard.inc._rm_case_action_status')

   <?php /*
   <div class="col-md-6">
      <div class="card card-custom">
         <div class="card-header flex-wrap bg-success py-5">
            <div class="card-title">
               <h3 class="card-label h3 font-weight-bolder"> মামলার অনুলিপি সমূহ</h3>
            </div>
         </div>
         <div class="card-body p-0">
            <ul class="navi navi-border navi-hover navi-active">
               <li class="navi-item">
                  <a class="navi-link" href="#">
                     <span class="navi-icon"><i class="fas fa-folder-open icon-lg text-success mr-3"></i></span>
                     <div class="navi-text">
                        <span class="d-block font-weight-bold h4 pt-2">নতুন মামলা রেজিস্টার এন্ট্রি</span>
                     </div>
                     <span class="navi-label">
                        <span class="label label-xl label-success h5">৫</span>
                     </span>
                  </a>
               </li>
               <li class="navi-item">
                  <a class="navi-link" href="#">
                     <span class="navi-icon"><i class="fas fa-folder-open icon-lg text-success mr-3"></i></span>
                     <div class="navi-text">
                        <span class="d-block font-weight-bold h4 pt-2">নতুন মামলা রেজিস্টার এন্ট্রি</span>
                     </div>
                     <span class="navi-label">
                        <span class="label label-xl label-success h5">৫</span>
                     </span>
                  </a>
               </li>
               <li class="navi-item">
                  <a class="navi-link" href="#">
                     <span class="navi-icon"><i class="fas fa-folder-open icon-lg text-success mr-3"></i></span>
                     <div class="navi-text">
                        <span class="d-block font-weight-bold h4 pt-2">নতুন মামলা রেজিস্টার এন্ট্রি</span>
                     </div>
                     <span class="navi-label">
                        <span class="label label-xl label-success h5">৫</span>
                     </span>
                  </a>
               </li>
               <li class="navi-item">
                  <a class="navi-link" href="#">
                     <span class="navi-icon"><i class="fas fa-folder-open icon-lg text-success mr-3"></i></span>
                     <div class="navi-text">
                        <span class="d-block font-weight-bold h4 pt-2">নতুন মামলা রেজিস্টার এন্ট্রি</span>
                     </div>
                     <span class="navi-label">
                        <span class="label label-xl label-success h5">৫</span>
                     </span>
                  </a>
               </li>
            </ul>
         </div>
      </div>
   </div>
   */ ?>
</div>
<!--end::Row-->

<!--end::Dashboard-->
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page--}}
@section('scripts')

<script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<!--end::Page Vendors-->
<script src="{{ asset('js/pages/widgets.js') }}"></script>
<!--end::Page Scripts-->

<?php /*
<script type="text/javascript">
   // Create the chart
   Highcharts.chart('container', {
      chart: {
         type: 'column'
      },
      title: {
         text: 'বিভাগ, জেলা ও উপজেলা ভিত্তিক মামলা'
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
               format: '{point.y:.1f}%'
            }
         }
      },

      tooltip: {
         headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
         pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
      },

      series: [
      {
         name: "Browsers",
         colorByPoint: true,
         data: [
         {
            name: "ঢাকা",
            y: 62.74,
            drilldown: "ঢাকা"
         },
         {
            name: "চট্টগ্রাম",
            y: 10.57,
            drilldown: "চট্টগ্রাম"
         },
         {
            name: "রাজশাহী ",
            y: 7.23,
            drilldown: "রাজশাহী "
         },
         {
            name: "খুলনা",
            y: 5.58,
            drilldown: "খুলনা"
         },
         {
            name: "বরিশাল",
            y: 4.02,
            drilldown: "বরিশাল"
         },
         {
            name: "সিলেট ",
            y: 1.92,
            drilldown: "সিলেট "
         },
         {
            name: "রংপুর",
            y: 7.62,
            drilldown: "রংপুর"
         },
         {
            name: "ময়মনসিংহ",
            y: 7.62,
            drilldown: "ময়মনসিংহ"
         }
         ]
      }
      ],
      drilldown: {
         series: [
         {
            name: "ঢাকা",
            id: "ঢাকা",
            data: [
            [
            "v65.0",
            0.1
            ],
            [
            "v64.0",
            1.3
            ],
            [
            "v63.0",
            53.02
            ],
            [
            "v62.0",
            1.4
            ],
            [
            "v61.0",
            0.88
            ],
            [
            "v60.0",
            0.56
            ],
            [
            "v59.0",
            0.45
            ],
            [
            "v58.0",
            0.49
            ],
            [
            "v57.0",
            0.32
            ],
            [
            "v56.0",
            0.29
            ],
            [
            "v55.0",
            0.79
            ],
            [
            "v54.0",
            0.18
            ],
            [
            "v51.0",
            0.13
            ],
            [
            "v49.0",
            2.16
            ],
            [
            "v48.0",
            0.13
            ],
            [
            "v47.0",
            0.11
            ],
            [
            "v43.0",
            0.17
            ],
            [
            "v29.0",
            0.26
            ]
            ]
         },
         {
          name: "চট্টগ্রাম",
          id: "চট্টগ্রাম",
          data: [
          [
          "v58.0",
          1.02
          ],
          [
          "v57.0",
          7.36
          ],
          [
          "v56.0",
          0.35
          ],
          [
          "v55.0",
          0.11
          ],
          [
          "v54.0",
          0.1
          ],
          [
          "v52.0",
          0.95
          ],
          [
          "v51.0",
          0.15
          ],
          [
          "v50.0",
          0.1
          ],
          [
          "v48.0",
          0.31
          ],
          [
          "v47.0",
          0.12
          ]
          ]
       },
       {
          name: "রাজশাহী ",
          id: "রাজশাহী ",
          data: [
          [
          "v11.0",
          6.2
          ],
          [
          "v10.0",
          0.29
          ],
          [
          "v9.0",
          0.27
          ],
          [
          "v8.0",
          0.47
          ]
          ]
       },
       {
          name: "খুলনা",
          id: "খুলনা",
          data: [
          [
          "v11.0",
          3.39
          ],
          [
          "v10.1",
          0.96
          ],
          [
          "v10.0",
          0.36
          ],
          [
          "v9.1",
          0.54
          ],
          [
          "v9.0",
          0.13
          ],
          [
          "v5.1",
          0.2
          ]
          ]
       },
       {
          name: "বরিশাল",
          id: "বরিশাল",
          data: [
          [
          "v16",
          2.6
          ],
          [
          "v15",
          0.92
          ],
          [
          "v14",
          0.4
          ],
          [
          "v13",
          0.1
          ]
          ]
       },
       {
          name: "সিলেট ",
          id: "সিলেট ",
          data: [
          [
          "v50.0",
          0.96
          ],
          [
          "v49.0",
          0.82
          ],
          [
          "v12.1",
          0.14
          ]
          ]
       },
       {
          name: "রংপুর",
          id: "রংপুর",
          data: [
          [
          "v50.0",
          0.96
          ],
          [
          "v49.0",
          0.82
          ],
          [
          "v12.1",
          0.14
          ]
          ]
       },
       {
          name: "ময়মনসিংহ",
          id: "ময়মনসিংহ",
          data: [
          [
          "v50.0",
          0.96
          ],
          [
          "v49.0",
          0.82
          ],
          [
          "v12.1",
          0.14
          ]
          ]
       }
       ]
    }
 });
</script>
*/ ?>


<?php /*
<script type="text/javascript">
   google.charts.load('current', {'packages':['bar']});
   google.charts.setOnLoadCallback(drawStuff);

   function drawStuff() {
      var data = new google.visualization.arrayToDataTable([
         ['Opening Move', 'মামলা'],
         ["দলিল সংশোধন", 44],
         ["দলিল বাতিল", 31],
         ["চিরস্থায়ী নিষেধাজ্ঞা", 12],
         ["বাটোয়ারা", 10],
         ["দখল পুনঃরুদ্ধার ", 12],
         ['ভুমি জরিপ', 3],
         ["দখল পুনঃরুদ্ধার ", 44],
         ["অর্পিত সম্পত্তি", 31],
         ["দখল পুনঃরুদ্ধার", 12],
         ["আর্বিট্রেশন", 10],
         ["সাকসেশন মামলা", 12]
         ]);

      var options = {
         title: 'মামলার ধরন',
         // width: 900,
         height: 300,
         legend: { position: 'none' },
         chart: { title: 'মামলার ধরনের উপর সংখ্যাভিত্তিক পরিসংখ্যান'},
            bars: 'veriticle', // Required for Material Bar Charts.
            axes: {
               x: {
               0: { side: 'bottom', label: 'মামলার ধরন'} // Top x-axis.
            }
         },
         bar: { groupWidth: "90%" }
      };

      var chart = new google.charts.Bar(document.getElementById('case_type_div'));
      chart.draw(data, options);
   };
</script>
*/
?>

@endsection
