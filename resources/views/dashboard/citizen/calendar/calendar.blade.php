
@yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

@section('content')
<!--begin::Dashboard-->



<!--begin::Dashboard-->





<!--begin::Subheader-->
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
@if (Auth::user()->role_id != 2)
@include('dashboard.citizen.calendar.calender_need')
@endif
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
@if (Auth::user()->role_id != 2)
@include('dashboard.citizen.calendar.calender_need_js')
@endif
// {{-- -------------callender end---------- --}}


@endsection


