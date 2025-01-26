@extends('layouts.landing')
@yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

@section('content')


<style type="text/css">
    fieldset { border: 1px solid #ddd !important; margin: 0; xmin-width: 0; padding: 10px; position: relative; border-radius:4px; background-color:#d5f7d5; padding-left:10px!important; }
    fieldset .form-label{color: black;}
    legend{ font-size:14px; font-weight:bold; width: 45%; border: 1px solid #ddd; border-radius: 4px; padding: 5px 5px 5px 10px; background-color: #5cb85c; }
    .list-group-flush>.list-group-item {padding-left: 0;}
</style>

<div class="card">
    <div class="text-center p-5 m-5">
     <h1>আপনি দপ্তর ইউজার না </h1>
       <a href="{{ url()->previous() }}">অনুগ্রহ ফিরে যান</a>
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
   

@endsection