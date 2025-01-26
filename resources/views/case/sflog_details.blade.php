@php
$user = Auth::user();
$roleID = Auth::user()->role_id;
@endphp

@extends('layouts.default')

@section('content')

<style type="text/css">
   .tg {border-collapse:collapse;border-spacing:0;width: 100%;}
   .tg td{border-color:black;border-style:solid;border-width:1px;font-size:14px;overflow:hidden;padding:6px 5px;word-break:normal;}
   .tg th{border-color:black;border-style:solid;border-width:1px;font-size:14px;font-weight:normal;overflow:hidden;padding:6px 5px;word-break:normal;}
   .tg .tg-nluh{background-color:#dae8fc;border-color:#cbcefb;text-align:left;vertical-align:top}
   .tg .tg-19u4{background-color:#ecf4ff;border-color:#cbcefb;font-weight:bold;text-align:right;vertical-align:top}
</style>

<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
      </div>
   </div>
   <div class="card-body">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         {{ $message }}
      </div>
      @endif

      <div class="row">
         <div class="col-md-12">
            <h4 class="font-weight-bolder">সাধারণ তথ্য</h4>
            <table class="tg">
               <tr>
                  <th class="tg-19u4" width="130">আদালতের নাম</th>
                  <td class="tg-nluh">{{ $info->court_name }}</td>
                  <th class="tg-19u4">বিভাগ</th>
                  <td class="tg-nluh">{{ $info->division_name_bn }}</td>
               </tr>
               <tr>
                  <th class="tg-19u4">জেলা</th>
                  <td class="tg-nluh">{{ $info->district_name_bn }}</td>
                  <th class="tg-19u4">উপজেলা</th>
                  <td class="tg-nluh">{{ $info->upazila_name_bn }}</td>
               </tr>
               <tr>
                  <th class="tg-19u4">মৌজা</th>
                  <td class="tg-nluh">{{ $info->mouja_name_bn }}</td>
                  <th class="tg-19u4">মামলা নং</th>
                  <td class="tg-nluh">{{ $info->case_number }}</td>
               </tr>
               <tr>
                  <th class="tg-19u4">মামলা রুজুর তারিখ</th>
                  <td class="tg-nluh">{{ en2bn($info->case_date) }}</td>
                  <th class="tg-19u4">ফলাফল</th>
                  <td class="tg-nluh">
                      {{$info->is_win == '1' ? 'জয়!' : ($info->is_win == '2' ? 'পরাজয়!' : 'চলমান')}}
                  
                </td>
              </tr>
              <tr>
               @if ($info->is_win === 0)
               <th class="tg-19u4">পরাজয়ের কারণ</th>
               <td class="tg-nluh">{{ $info->lost_reason }}</td>
               @endif
               <th class="tg-19u4">মামলায় হেরে গিয়ে কি আপিল করা হয়েছে</th>
               <td class="tg-nluh">@if ($info->is_lost_appeal === 1)
                 হ্যা!
                 @else
                 না!
                 @endif
              </td>
           </tr>
           <tr>
            <th class="tg-19u4">মামলার বর্তমান অবস্থান</th>
            <td class="tg-nluh">{{ $info->status_name }}, এর জন্য {{ $info->role_name }} এর কাছে</td>
            <th class="tg-19u4">বর্তমান ষ্ট্যাটাস</th>
            <td class="tg-nluh"> @if ($info->status === 1)
              নতুন চলমান!
              @elseif ($info->status === 2)
              আপিল করা হয়েছে!
              @elseif ($info->status === 3)
              সম্পাদিত !
              @endif

           </td>
        </tr>
     </table>
  </div>
</div>

<br>
   <div class="row">
      <div class="col-md-12">
          <h4 class="font-weight-bolder">এস এফ লগের বিস্তারিত</h4>
          <?php
          echo nl2br($sflog->sf_log_details);
          ?>
      </div>
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


