@extends('layouts.default')
@yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

@section('content')
<!--begin::Dashboard-->

@php
/*
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
*/
@endphp

<!--begin::Dashboard-->





<!--begin::Subheader-->
   @php
   /*
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
   */
   @endphp
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style type="text/css">
/*highchart css*/

   .highcharts-figure, .highcharts-data-table table {
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
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}


/*Pie chart*/
.highcharts-figure, .highcharts-data-table table {
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
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
 padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
 background: #f8f8f8;
}
.highcharts-data-table tr:hover {
 background: #f1f7ff;
}


input[type="number"] {
   min-width: 50px;
}
</style>

<?php
// $divisiondata=array();
// $districtdata=array();




// $result = array_merge($districtdata, $upazilatdata);

?>

<!--end::Subheader-->

{{-- -------------calendar start---------- --}}
@include('dashboard.calendar.calender_need')
{{-- -------------calendar end---------- --}}




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

      series: [
      {
        name: "Division",
        colorByPoint: true,
        
      }
      ],

      drilldown: {
         
      }
 });
</script>
// {{-- -------------callender end---------- --}}
@include('dashboard.calendar.calender_need_js')
// {{-- -------------callender end---------- --}}


@endsection


