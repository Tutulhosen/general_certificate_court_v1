@php
   $user = Auth::user();
   $roleID = Auth::user()->role_id;
   $data = json_decode($caseActivityLog->new_data, true);
   // echo $data['court_id'];
   // print_r($data);
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
         <div class="col-md-6">
            <h4 class="font-weight-bolder">সাধারণ তথ্য</h4>
            <table class="tg">
               <thead>
                  <tr>
                      @php

                      @endphp
                     <th class="tg-19u4" width="130">আদালতের নাম</th>
                     <td class="tg-nluh">
                         {{-- {{ $info->court_name }} --}}
                         {{ App\Models\Court::where('id', $data['court_id'])->first()->court_name }}

                    </td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">বিভাগ</th>
                     <td class="tg-nluh">
                         {{-- {{ $info->division_name_bn }} --}}
                         {{ DB::table('division')->select('division_name_bn')->where('id', '=', $data['division_id'])->first()->division_name_bn }}
                    </td>

                  </tr>
                  <tr>
                     <th class="tg-19u4">জেলা</th>
                     <td class="tg-nluh">
                         {{-- {{ $info->district_name_bn }} --}}
                         {{ DB::table('district')->select('district_name_bn')->where('id', '=', $data['district_id'])->first()->district_name_bn }}

                        </td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">উপজেলা</th>
                     <td class="tg-nluh">
                         {{-- {{ $info->upazila_name_bn }} --}}
                         {{ DB::table('upazila')->select('upazila_name_bn')->where('id', '=', $data['upazila_id'])->first()->upazila_name_bn }}

                        </td>
                    </tr>
                    <tr>
                        <th class="tg-19u4">মৌজা</th>
                        <td class="tg-nluh">
                            {{-- {{ $info->mouja_name_bn }} --}}
                            {{ DB::table('mouja')->select('mouja_name_bn')->where('id', '=', $data['mouja_id'])->first()->mouja_name_bn }}
                        </td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">মামলা নং</th>
                     <td class="tg-nluh">{{  en2bn($data['case_number']) }}</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">মামলা রুজুর তারিখ</th>
                     <td class="tg-nluh">{{ en2bn($data['case_date']) }}</td>
                  </tr>


                  <tr>
                     <th class="tg-19u4">ফলাফল</th>
                     <td class="tg-nluh">@if($data['case_result'] == 1)
                                              জয়!
                                         @elseif($data['case_result'] === 0)
                                              পরাজয়!
                                          @else
                                              চলমান
                                          @endif
                     </td>
                  </tr>
                  @if (!empty($data['lost_reason']))
                  <tr>
                     <th class="tg-19u4">পরাজয়ের কারণ</th>
                     <td class="tg-nluh">{{ $data['lost_reason'] }}</td>
                  </tr>
                  @endif
                  <tr>
                     <th class="tg-19u4">মামলায় হেরে গিয়ে কি আপিল করা হয়েছে</th>
                     <td class="tg-nluh">@if ($data['is_lost_appeal'] == 1)
                                              হ্যা!
                                          @else
                                              না!
                                          @endif
                     </td>
                  </tr>
                  @if(!empty($data['ref_id']))
                  <tr>
                     <th class="tg-19u4">পূর্বের মামলা নং</th>
                     <td class="tg-nluh"><a href="{{ route('case.details', $data['ref_id']) }}" target="_blank">{{ $data['ref_id'] }}</a> </td>
                  </tr>
                  @endif
                  <tr>
                     <th class="tg-19u4">মামলার বর্তমান অবস্থান</th>
                     <td class="tg-nluh">
                         {{-- {{ $info->status_name }}, এর জন্য {{ $info->role_name }} এর কাছে --}}
                         {{ DB::table('case_status')->select('status_name')->where('id', '=', $data['cs_id'])->first()->status_name }}
                         এর জন্য <b>
                         {{App\Models\Role::where('id', $data['action_user_group_id'])->first()->role_name}}
                        </b> এর কাছে
                    </td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">বর্তমান ষ্ট্যাটাস</th>
                     <td class="tg-nluh">
                        @if ($data['status'] == 1)
                            নতুন চলমান!
                        @elseif ($data['status'] == 2)
                            আপিল করা হয়েছে!
                        @elseif ($data['status'] == 3)
                            সম্পাদিত !
                        @endif
                     </td>
                  </tr>
               </tr>
            </thead>
         </table>
         </div>
      <div class="col-md-6">
            <h4 class="font-weight-bolder">বাদীর বিবরণ</h4>
            <table class="tg">
               <thead>
                  <tr>
                     <th class="tg-19u4" width="10">ক্রম</th>
                     <th class="tg-19u4 text-center" width="200">নাম</th>
                     <th class="tg-19u4 text-center">পিতা/স্বামীর নাম</th>
                     <th class="tg-19u4 text-center">ঠিকানা</th>
                  </tr>
               </thead>
               <tbody>
                @for ( $i=0; $i < count($data['badi']['badi_name']); $i++)
                    <tr>
                        <td class="tg-nluh">{{en2bn($i+1)}}.</td>
                        <td class="tg-nluh">{{ $data['badi']['badi_name'][$i] }}</td>
                        <td class="tg-nluh">{{ $data['badi']['badi_spouse_name'][$i] }}</td>
                        <td class="tg-nluh">{{ $data['badi']['badi_address'][$i] }}</td>
                    </tr>
                @endfor
               </tbody>
            </table>

            <br>
            <h4 class="font-weight-bolder">বিবাদীর বিবরণ</h4>
            <table class="tg">
               <thead>
                  <tr>
                     <th class="tg-19u4" width="10">ক্রম</th>
                     <th class="tg-19u4 text-center" width="200">নাম</th>
                     <th class="tg-19u4 text-center">পিতা/স্বামীর নাম</th>
                     <th class="tg-19u4 text-center">ঠিকানা</th>
                  </tr>
               </thead>
               <tbody>
                @for ( $i=0; $i < count($data['bibadi']['bibadi_name']); $i++)
                    <tr>
                        <td class="tg-nluh">{{en2bn($i+1)}}.</td>
                        <td class="tg-nluh">{{ $data['bibadi']['bibadi_name'][$i] }}</td>
                        <td class="tg-nluh">{{ $data['bibadi']['bibadi_spouse_name'][$i] }}</td>
                        <td class="tg-nluh">{{ $data['bibadi']['bibadi_address'][$i] }}</td>
                    </tr>
                @endfor
               </tbody>
            </table>
      </div>
   </div>
   <br>
   <div class="row">
      <div class="col-md-12">
          <h4 class="font-weight-bolder">জরিপের বিবরণ</h4>
            <table class="tg">
            <thead>
               <tr>
                  <th class="tg-19u4" width="10">ক্রম</th>
                  <th class="tg-19u4 text-center">জরিপের ধরণ </th>
                  <th class="tg-19u4 text-center">খতিয়ান নং</th>
                  <th class="tg-19u4 text-center">দাগ নং</th>
                  <th class="tg-19u4 text-center">জমির শ্রেণী</th>
                  <th class="tg-19u4" width="150">জমির পরিমাণ (শতক)</th>
                  <th class="tg-19u4" width="170">নালিশী জমির পরিমাণ (শতক)</th>
               </tr>
            </thead>
               <tbody>
                @for ( $i=0; $i < count($data['case_survey']['st_id']); $i++)
                    <tr>
                        <td class="tg-nluh">{{en2bn($i+1)}}.</td>
                        <td class="tg-nluh">{{ DB::table('survey_type')->select('st_name')->where('id', $data['case_survey']['st_id'][$i])->first()->st_name }}</td>
                        <td class="tg-nluh">{{ en2bn($data['case_survey']['khotian_no'][$i])  }}</td>
                        <td class="tg-nluh">{{ en2bn($data['case_survey']['daag_no'][$i])  }}</td>
                        <td class="tg-nluh">{{ DB::table('land_type')->select('lt_name')->where('id', $data['case_survey']['lt_id'][$i])->first()->lt_name }}</td>
                        <td class="tg-nluh text-right">{{ en2bn($data['case_survey']['land_size'][$i] ) }}</td>
                        <td class="tg-nluh text-right">{{ en2bn($data['case_survey']['land_demand'][$i] ) }}</td>
                    </tr>
                @endfor
               </tbody>
            </table>

      </div>
   </div>
   <br>
   <div class="row">
      <div class="col-md-12">
          <!-- <h4 class="font-weight-bolder"></h4>  -->
            <table class="tg">
               <tr>
                  <th class="tg-19u4 text-left" width="100">তফশীল বিবরণ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ $data['tafsil'] }}</td>
               </tr>
               <tr>
                  <th class="tg-19u4 text-left" width="100">চৌহদ্দীর বিবরণ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ $data['chowhaddi'] }}</td>
               </tr>
               <tr>
                  <th class="tg-19u4 text-left" width="100">মন্তব্য</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ $data['comments'] }}</td>
               </tr>
            </table>

      </div>
   </div>
   <br>
   <br>

   <div class="row">
      <div class="col-md-7">
         @if($data['sc_receiving_date'] != NULL)
          <h4 class="font-weight-bolder">তারিখ সমুহ</h4>
            <table class="tg">
               <tr>
                  <th class="tg-19u4 text-left">কারণ দর্শাইবার নোটিশ প্রাপ্তির তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ $data['sc_receiving_date'] }}</td>
               </tr>
               @endif
               @if($data['send_date_rm_ac'] != NULL)
               <tr>
                  <th class="tg-19u4 text-left">কারণ দর্শাইবার আপিল নোটিশ প্রাপ্তির তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($data['send_date_rm_ac']) }}</td>
               </tr>
               @endif
               @if($data['send_date_rm_ac'] != NULL)
               <tr>
                  <th class="tg-19u4 text-left">এস এফ তৈরির জন্য আর এম অফিস থেকে এসি ল্যান্ড অফিসে প্রেরণের তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($data['send_date_rm_ac']) }}</td>
               </tr>
               @endif
               @if($data['send_date_ac_ulo'] != NULL)
               <tr>
                  <th class="tg-19u4 text-left">এস এফ তৈরির জন্য এসি ল্যান্ড থেকে ইউ এল ও অফিসে প্রেরণের তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($data['send_date_ac_ulo']) }}</td>
               </tr>
               @endif
               @if($data['send_date_sf_ulo_ac'] != NULL)
               <tr>
                  <th class="tg-19u4 text-left">এস এফ ফাইল ইউ এল ও অফিস থেকে এসি ল্যান্ড অফিসে প্রেরণের তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($data['send_date_sf_ulo_ac']) }}</td>
               </tr>
               @endif
               @if($data['send_date_ans_ac_rm'] != NULL)
               <tr>
                  <th class="tg-19u4 text-left">এস এফ এর জবাব প্রাপ্তির তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($data['send_date_ans_ac_rm']) }}</td>
               </tr>
               @endif
               @if($data['send_date_sf_rm_adc'] != NULL)
               <tr>
                  <th class="tg-19u4 text-left">এফ এফ প্রতিবেদন চূড়ান্ত করার তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($data['send_date_sf_rm_adc']) }}</td>
               </tr>
            </table>
        @endif
      </div>
      <div class="col-md-5">
          @if($data['order_date'] != NULL)
          <h4 class="font-weight-bolder">আদেশের তারিখ সমুহ</h4>
            <table class="tg">
               <tr>
                  <th class="tg-19u4 text-left" width="150">আদেশের তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($data['order_date']) }}</td>
               </tr>
               @endif
               @if($data['next_assign_date'] != NULL)
               <tr>
                  <th class="tg-19u4 text-left" width="150">পরবর্তী ধার্য তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($data['next_assign_date']) }}</td>
               </tr>
               @endif
               @if($data['past_order_date'] != NULL)
               <tr>
                  <th class="tg-19u4 text-left" width="150">বিগত তারিখের আদেশ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($data['past_order_date']) }}</td>
               </tr>
               @endif
            </table>

      </div>
   </div>
   <br>

   {{-- <div class="row">
      <div class="col-md-12">
         <h4 class="font-weight-bolder">এস এফের লগ</h4>
         <table class="tg">
         <thead>
            <tr>
               <th class="tg-19u4" width="10">ক্রম</th>
               <th class="tg-19u4 text-center">নাম</th>
               <th class="tg-19u4 text-center">তারিখ</th>
               <th class="tg-19u4 text-center">বিস্তারিত</th>
            </tr>
         </thead>
            <tbody>
               @php $i = 1; @endphp
               @foreach ($sf_logs as $row)
               <tr>
                  <td class="tg-nluh">{{ en2bn($i) }}.</td>
                  <td class="tg-nluh">{{ $row->name }}</td>
                  <td class="tg-nluh">{{ en2bn($row->created_at) }}</td>
                  <td class="tg-nluh"><a href="{{ route('case.sflog.details', $row->id) }}" target="_blank"> বিস্তারিত </a></td>
               </tr>
               @php $i++; @endphp
               @endforeach
            </tbody>
         </table>
        </div>
    </div>

   <br> --}}
   <div class="row">
      <div class="col-md-4">
         <h4 class="font-weight-bolder">কারণ দর্শাইবার স্ক্যান কপি</h4>
         <a href="#" class="btn btn-success btn-shadow font-weight-bold font-size-h4" data-toggle="modal" data-target="#showCauseModal">
            <i class="fa fas fa-file-pdf icon-md"></i> কারণ দর্শাইবার স্ক্যান কপি
         </a>

         <!-- Modal-->
         <div class="modal fade" id="showCauseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title font-weight-bolder font-size-h3" id="exampleModalLabel">কারণ দর্শাইবার স্ক্যান কপি</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                     </button>
                  </div>
                  <div class="modal-body">

                     <embed src="{{ asset('uploads/show_cause/'.$data['show_cause_file']) }}" type="application/pdf" width="100%" height="400px" />

                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5" data-dismiss="modal">বন্ধ করুন</button>
                     </div>
                  </div>
               </div>
            </div> <!-- /modal -->
      </div>
      @if($data['power_attorney_file'] != NULL && $data['appeal_sc_file'] != NULL)
      <div class="col-md-4">
         <h4 class="font-weight-bolder">পাওয়ার অফ অ্যাটর্নি ফাইল স্ক্যান কপি</h4>
         <a href="#" class="btn btn-success btn-shadow font-weight-bold font-size-h4" data-toggle="modal" data-target="#powerOfAtornyModal">
            <i class="fa fas fa-file-pdf icon-md"></i> পাওয়ার অফ অ্যাটর্নি ফাইল স্ক্যান কপি
         </a>

         <!-- Modal-->
         <div class="modal fade" id="powerOfAtornyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title font-weight-bolder font-size-h3" id="exampleModalLabel">পাওয়ার অফ অ্যাটর্নি ফাইল স্ক্যান কপি</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                     </button>
                  </div>
                  <div class="modal-body">

                     <embed src="{{ asset('uploads/power_of_attorney/'.$data['power_attorney_file']) }}" type="application/pdf" width="100%" height="400px" />

                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5" data-dismiss="modal">বন্ধ করুন</button>
                     </div>
                  </div>
               </div>
            </div> <!-- /modal -->
      </div>
      <div class="col-md-4">
         <h4 class="font-weight-bolder">কারণ দর্শাইবার আপিল নোটিশ স্ক্যান কপি</h4>
         <a href="#" class="btn btn-success btn-shadow font-weight-bold font-size-h4" data-toggle="modal" data-target="#SfAppeal">
            <i class="fa fas fa-file-pdf icon-md"></i> কারণ দর্শাইবার আপিল নোটিশ স্ক্যান কপি
         </a>

         <!-- Modal-->
         <div class="modal fade" id="SfAppeal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title font-weight-bolder font-size-h3" id="exampleModalLabel">কারণ দর্শাইবার আপিল নোটিশ স্ক্যান কপি</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                     </button>
                  </div>
                  <div class="modal-body">

                     <embed src="{{ asset('uploads/appeal_sc/'.$data['appeal_sc_file']) }}" type="application/pdf" width="100%" height="400px" />

                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5" data-dismiss="modal">বন্ধ করুন</button>
                     </div>
                  </div>
               </div>
            </div> <!-- /modal -->
      </div>
      @endif
   </div>
   <br>
   <div class="row">
    @if($data['sf_report'] != NULL)
         <div class="col-md-4">
            <h4 class="font-weight-bolder">এস এফ এর চূড়ান্ত প্রতিবেদন</h4>
            <a href="#" class="btn btn-success btn-shadow font-weight-bold font-size-h4" data-toggle="modal" data-target="#sfFinalFile">
               <i class="fa fas fa-file-pdf icon-md"></i> এস এফ এর চূড়ান্ত প্রতিবেদন
            </a>

            <!-- Modal-->
            <div class="modal fade" id="sfFinalFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title font-weight-bolder font-size-h3" id="exampleModalLabel">এস এফ এর চূড়ান্ত প্রতিবেদন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                     </div>
                     <div class="modal-body">

                        <embed src="{{ asset('uploads/sf_report/'. $data['sf_report']) }}" type="application/pdf" width="100%" height="400px" />

                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5" data-dismiss="modal">বন্ধ করুন</button>
                        </div>
                     </div>
                  </div>
               </div> <!-- /modal -->
         </div>
         @endif
         @if($data['order_file'] != NULL)

         <div class="col-md-4">
            <h4 class="font-weight-bolder">আদেশের ফাইল</h4>
            <a href="#" class="btn btn-success btn-shadow font-weight-bold font-size-h4" data-toggle="modal" data-target="#orderFile">
               <i class="fa fas fa-file-pdf icon-md"></i> আদেশের ফাইল
            </a>

            <!-- Modal-->
            <div class="modal fade" id="orderFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title font-weight-bolder font-size-h3" id="exampleModalLabel">আদেশের ফাইল</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                     </div>
                     <div class="modal-body">

                        <embed src="{{ asset('uploads/order/'.$data['order_file']) }}" type="application/pdf" width="100%" height="400px" />

                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5" data-dismiss="modal">বন্ধ করুন</button>
                        </div>
                     </div>
                  </div>
               </div> <!-- /modal -->
         </div>
   </div>
    @endif

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


