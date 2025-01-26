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
               @if ($info->is_win == '2')
               <th class="tg-19u4">পরাজয়ের কারণ</th>
               <td class="tg-nluh">{{ $info->lost_reason }}</td>
               <th class="tg-19u4">মামলায় হেরে গিয়ে কি আপিল করা হয়েছে</th>
               <td class="tg-nluh">@if ($info->is_lost_appeal === 1)
                 হ্যা!
                 @else
                 না!
                 @endif
              </td>
               @endif
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
   <div class="row mt-5">
      <div class="col-md-12">
          {{-- <h4 class="font-weight-bolder">এস এফ লগের বিস্তারিত</h4> --}}
          <?php
            ?>
            <div id="sf_docs">
                <div>
                    <a href="{{ route('action.pdf_sf', $info->id) }}" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left"> <i class="fa fas fa-file-pdf"></i> <b>জেনারেট পিডিএফ</b>
                    </a>
                </div><br><br><br>
                   <div class="text-center font-weight-bolder font-size-h2">কারণ দর্শাইবার জবাব</div>
                   <div class="text-center font-weight-bolder font-size-h3">মোকামঃ {{ $info->court_name }}</div>
                   <div class="text-center font-weight-bold font-size-h3"><b>বিষয়ঃ</b> দেওয়ানী মোকাদ্দমা নং {{ $info->case_number }} এর প্যারাভিত্তিক জবাব প্রেরণ প্রসঙ্গে</div> <br>
                   <p class="font-size-h4">
                      @php $badi_sl = 1; @endphp
                      @foreach ($badis as $badi)
                      {{$badi_sl}}। {{ $badi->badi_name }}, পিতা/স্বামীঃ {{ $badi->badi_spouse_name }} <br>
                      সাং {{ $badi->badi_address }}
                      <br>
                      @php $badi_sl++; @endphp
                      @endforeach
                      ................................................................. বাদী
                   </p>

                   <div class="font-weight-bolder font-size-h3 mt-5 mb-5">বনাম</div>

                   <p class="font-size-h4">
                     @php $bibadi_sl = 1; @endphp
                     @foreach ($bibadis as $bibadi)
                     {{$bibadi_sl}}। {{ $bibadi->bibadi_name }}, পিতা/স্বামীঃ {{ $bibadi->bibadi_spouse_name }} <br>
                     সাং {{ $bibadi->bibadi_address }}
                     <br>
                     @php $bibadi_sl++; @endphp
                     @endforeach
                     ................................................................. বিবাদী
                  </p>

                  <p class="font-size-h4 mt-15">
                   <?php echo nl2br($sf->sf_details); ?>
                </p>
                <table>
                   <tr>
                      @foreach ($sf_signatures as $signature)
                      <td width="30%">
                         @if($signature->signature != NULL)
                         <img src="{{ asset('uploads/signature/'.$signature->signature) }}" alt="{{ $signature->name }}" height="50">
                         @endif
                         <br><strong>{{ $signature->name }}</strong><br>
                         <span style="font-size:15px;">{{ $signature->role_name }}<br>
                         {{ $signature->office_name_bn }}<br></span>
                      </td>
                      @endforeach
                   </tr>
                </table>
             </div>
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


