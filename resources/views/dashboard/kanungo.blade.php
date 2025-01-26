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

<!--begin::Dashboard-->
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