@extends('layouts.default')

@section('content')

@php //echo $userManagement->name;
//exit(); @endphp

<!--begin::Card-->
<div class="card card-custom col-7">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-label"> মামলার স্ট্যাটাস এর বিস্তারিত </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('case-status') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-list"></i> মামলার স্ট্যাটাস এর তালিকা
         </a>
      </div>
   </div>
   <div class="card-body">
     <table class="tg">
         <thead>
            <tr>
               <th class="tg-19u4" width="130">স্ট্যাটাস নাম</th>
               <td class="tg-nluh">{{ $case_status->status_name }}</td>
            </tr>
            <tr>
               <th class="tg-19u4">মন্তব্যের টেমপ্লেট</th>
               <td class="tg-nluh">{{ $case_status->status_templete }}</td>
            </tr>
            <tr>
               <th class="tg-19u4">ইউজাররোল</th>
               @forelse($roles as $role)
               <td class="tg-nluh">{{ $role->role_name }}</td>
               @empty
               <td class="tg-nluh">কোনো ডাটা খুঁজে পাওয়া যায়নি</td>
               @endforelse
            </tr>
         </thead>
      </table>            
   </div>  
</div>
<!--end::Card-->

@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page--}}
@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
<!--end::Page Scripts-->
@endsection


