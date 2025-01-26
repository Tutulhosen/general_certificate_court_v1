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
      <div class="card-counter success">
         <a href="{{ route('atcase.index') }}"><i class="fa fas fa-layer-group text-white"></i></a>
         <span class="count-numbers"><a href="{{ route('rmcase.index') }}"><?=en2bn($total_rm_case)?></a></span>
         <span class="count-name"><a href="{{ route('rmcase.index') }}">মোট রাজস্ব মামলা</a></span>
      </div>
   </div>
   
</div>

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid mb-10" id="kt_subheader">
   <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-2">
         <!--begin::Page Title-->
         <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">শুনানী/মামলার তারিখ</h5>
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
      <?php /*
      <!--begin::Toolbar-->
      <div class="d-flex align-items-center flex-wrap">
         <!--begin::Actions-->
         <a href="#" class="btn btn-bg-white btn-icon-info btn-hover-primary btn-icon mr-3 my-2 my-lg-0">
            <i class="flaticon2-file icon-md"></i>
         </a>
         <a href="#" class="btn btn-bg-white btn-icon-danger btn-hover-primary btn-icon mr-3 my-2 my-lg-0">
            <i class="flaticon-download-1 icon-md"></i>
         </a>
         <a href="#" class="btn btn-bg-white btn-icon-success btn-hover-primary btn-icon mr-3 my-2 my-lg-0">
            <i class="flaticon2-fax icon-md"></i>
         </a>
         <a href="#" class="btn btn-bg-white btn-icon-warning btn-hover-primary btn-icon mr-3 my-2 my-lg-0">
            <i class="flaticon2-settings icon-md"></i>
         </a>
         <!--end::Actions-->
         <!--begin::Daterange-->
         <a href="#" class="btn btn-bg-white font-weight-bold mr-3 my-2 my-lg-0" id="kt_dashboard_daterangepicker" data-toggle="tooltip" title="Select dashboard daterange" data-placement="left">
            <span class="text-muted font-weight-bold mr-2" id="kt_dashboard_daterangepicker_title">Today</span>
            <span class="text-primary font-weight-bolder" id="kt_dashboard_daterangepicker_date">Aug 16</span>
         </a>
         <!--end::Daterange-->
         <!--begin::Dropdown-->
         <div class="dropdown dropdown-inline my-2 my-lg-0" data-toggle="tooltip" title="Quick actions" data-placement="left">
            <a href="#" class="btn btn-primary btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <span class="svg-icon svg-icon-md">
                  <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-2.svg-->
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000" />
                     </g>
                  </svg>
                  <!--end::Svg Icon-->
               </span>
            </a>
            <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
               <!--begin::Navigation-->
               <ul class="navi navi-hover">
                  <li class="navi-header font-weight-bold py-4">
                     <span class="font-size-lg">Choose Label:</span>
                     <i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="Click to learn more..."></i>
                  </li>
                  <li class="navi-separator mb-3 opacity-70"></li>
                  <li class="navi-item">
                     <a href="#" class="navi-link">
                        <span class="navi-text">
                           <span class="label label-xl label-inline label-light-success">Customer</span>
                        </span>
                     </a>
                  </li>
                  <li class="navi-item">
                     <a href="#" class="navi-link">
                        <span class="navi-text">
                           <span class="label label-xl label-inline label-light-danger">Partner</span>
                        </span>
                     </a>
                  </li>
                  <li class="navi-item">
                     <a href="#" class="navi-link">
                        <span class="navi-text">
                           <span class="label label-xl label-inline label-light-warning">Suplier</span>
                        </span>
                     </a>
                  </li>
                  <li class="navi-item">
                     <a href="#" class="navi-link">
                        <span class="navi-text">
                           <span class="label label-xl label-inline label-light-primary">Member</span>
                        </span>
                     </a>
                  </li>
                  <li class="navi-item">
                     <a href="#" class="navi-link">
                        <span class="navi-text">
                           <span class="label label-xl label-inline label-light-dark">Staff</span>
                        </span>
                     </a>
                  </li>
                  <li class="navi-separator mt-3 opacity-70"></li>
                  <li class="navi-footer py-4">
                     <a class="btn btn-clean font-weight-bold btn-sm" href="#">
                     <i class="ki ki-plus icon-sm"></i>Add new</a>
                  </li>
               </ul>
               <!--end::Navigation-->
            </div>
         </div>
         <!--end::Dropdown-->
      </div>
      <!--end::Toolbar-->
      */ ?>
   </div>
</div>
<!--end::Subheader-->

<!--begin::Dashboard-->

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
@endsection
