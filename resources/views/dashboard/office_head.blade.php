@extends('layouts.default')

@section('content')

@php
$new=$running=$finished=$applied=0;


$total_case = 11;
$running_case = 6;
$appeal_case = 4;
$completed_case = 1;


@endphp

<!--begin::Dashboard-->
<div class="row mb-5">
   <div class="col-md-3">
      <div class="card-counter primary">
         <a href="#"><i class="fa fas fa-layer-group text-white"></i></a>
         <span class="count-numbers"><a href="#"><?=en2bn($total_case)?></a></span>
         <span class="count-name"><a href="#">মোট মামলা</a></span>
      </div>
   </div>

   <div class="col-md-3">
      <div class="card-counter danger">
         <a href="#"><i class="fa fas fa-layer-group text-white"></i></a>
         <span class="count-numbers"><a href="#"><?=en2bn($running_case)?></a></span>
         <span class="count-name"><a href="#">চলমান মামলা</a></span>
      </div>
   </div>

   <div class="col-md-3">
      <div class="card-counter info">
         <a href="#"><i class="fa fas fa-layer-group text-white"></i></a>
         <span class="count-numbers"><a href="#"><?=en2bn($appeal_case)?></a></span>
         <span class="count-name"><a href="#">আপিল মামলা</a></span>
      </div>
   </div>

   <div class="col-md-3">
      <div class="card-counter success">
         <a href="#"><i class="fa fas fa-layer-group text-white"></i></a>
         <span class="count-numbers"><a href="#"><?=en2bn($completed_case)?></a></span>
         <span class="count-name"><a href="#">সম্পাদিত মামলা</a></span>
      </div>
   </div>
</div>

<!--begin::Row-->
<div class="row">
   <div class="col-md-8">
      <div class="card card-custom">
         <div class="card-header flex-wrap bg-danger py-5">
            <div class="card-title">
               <h3 class="card-label h3 font-weight-bolder"> পদক্ষেপ নিতে হবে এমন মামলাসমূহ</h3>
            </div>
         </div>
         
      </div>
   </div>

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
@endsection