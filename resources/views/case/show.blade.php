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
      {{-- <div class="card-title"> --}}
          <div class="container">
              <div class="row">
                  <div class="col-10"><h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3></div>
                  {{-- <div class="col-8">fdsafsad</div> --}}
                  {{-- <div class="col-2"><a href="{{ route('messages_group') }}" class="btn btn-primary float-right">Message</a></div> --}}
                  <div class="col-2">
                      @if(Auth::user()->role_id == 2)
                      <a href="{{ route('messages_group') }}?c={{ $info->id }}" class="btn btn-primary float-right">বার্তা</a>
                        @endif
                    </div>
              </div>
          </div>
         {{-- <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>

         <table>
             <tr align="right">
                 <th>
                     <a  href="" class="btn btn-primary float-right">Message</a>

                 </th>
             </tr>
         </table> --}}
      {{-- </div> --}}
      @if ($roleID == 5 || $roleID == 7 || $roleID == 8)
      <div class="card-toolbar">
         <a href="{{ route('case.edit', $info->id) }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-edit"></i>মামলা সংশোধন করুন
         </a>
         <!-- &nbsp;
         <a href="{{ url('case/create') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>পুরাতন চলমান মামলা এন্ট্রি
         </a>   -->
      </div>
      @endif
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
                     <th class="tg-19u4" width="130">আদালতের নাম</th>
                     <td class="tg-nluh">{{ $info->court_name ?? ''}}</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">বিভাগ</th>
                     <td class="tg-nluh">{{ $info->division_name_bn ?? ''}}</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">জেলা</th>
                     <td class="tg-nluh">{{ $info->district_name_bn ?? ''}}</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">উপজেলা</th>
                     <td class="tg-nluh">{{ $info->upazila_name_bn ?? ''}}</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">মৌজা</th>
                     <td class="tg-nluh">{{ $info->mouja_name_bn ?? ''}}</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">মামলা নং</th>
                     <td class="tg-nluh">{{ $info->case_number ?? ''}}</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">মামলা রুজুর তারিখ</th>
                     <td class="tg-nluh">{{ en2bn($info->case_date) ?? ''}}</td>
                  </tr>


                  <tr>
                     <th class="tg-19u4">ফলাফল</th>
                     <td class="tg-nluh">@if($info->case_result == '1')
                                              জয়!
                                         @elseif($info->case_result == '0')
                                              পরাজয়!
                                          @else
                                              চলমান
                                          @endif
                     </td>
                     {{-- @dd($info->case_result) --}}
                  </tr>
                  @if (!empty($info->lost_reason))
                  <tr>
                     <th class="tg-19u4">পরাজয়ের কারণ</th>
                     <td class="tg-nluh">{{ $info->lost_reason ?? ''}}</td>
                  </tr>
                  @endif
                  <tr>
                     <th class="tg-19u4">মামলায় হেরে গিয়ে কি আপিল করা হয়েছে</th>
                     <td class="tg-nluh">@if ($info->is_lost_appeal == 1)
                                              হ্যা!
                                          @else
                                              না!
                                          @endif
                     </td>
                  </tr>
                  @if(!empty( $info->ref_id))
                  <tr>
                     <th class="tg-19u4">পূর্বের মামলা নং</th>
                     <td class="tg-nluh"><a href="{{ route('case.details', $info->ref_id) }}" target="_blank">{{ $info->ref_case_no }}</a> </td>
                  </tr>
                  @endif
                  <tr>
                     <th class="tg-19u4">মামলার বর্তমান অবস্থান</th>
                     <td class="tg-nluh">{{ $info->status_name }}, এর জন্য {{ $info->role_name }} এর কাছে</td>
                  </tr>
                  <tr>
                     <th class="tg-19u4">বর্তমান ষ্ট্যাটাস</th>
                     <td class="tg-nluh"> @if ($info->status == 1)
                                              নতুন চলমান!
                                          @elseif ($info->status == 2)
                                              আপিল করা হয়েছে!
                                          @elseif ($info->status == 3)
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
              @php $k = 1; @endphp
         @foreach ($badis as $badi)
            <tr>
               <td class="tg-nluh">{{en2bn($k)}}.</td>
               <td class="tg-nluh">{{ $badi->badi_name }}</td>
               <td class="tg-nluh">{{ $badi->badi_spouse_name }}</td>
               <td class="tg-nluh">{{ $badi->badi_address }}</td>
            </tr>
         @php $k++; @endphp
         @endforeach
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
            @php $k = 1; @endphp
            @foreach ($bibadis as $bibadi)

                  <tr>
                     <td class="tg-nluh">{{ en2bn($k) }}.</td>
                     <td class="tg-nluh">{{ $bibadi->bibadi_name }}</td>
                     <td class="tg-nluh">{{ $bibadi->bibadi_spouse_name }}</td>
                     <td class="tg-nluh">{{ $bibadi->bibadi_address }}</td>
                  </tr>
             @php $k++; @endphp
            @endforeach
               </tbody>
            </table>
      </div>
   </div>
   <br>
   <div class="row">
      <div class="col-md-12">
          <h4 class="font-weight-bolder">জরিপের বিবরণ</h4>
            <table class="tg">
            <thead class="thead-customStyle2">
               <tr>
                  <th class="tg-19u4" width="10">ক্রমিক নং</th>
                  <th class="tg-19u4 text-center">জরিপের ধরণ </th>
                  <th class="tg-19u4 text-center">খতিয়ান নং</th>
                  <th class="tg-19u4 text-center">দাগ নং</th>
                  <th class="tg-19u4 text-center">জমির শ্রেণী</th>
                  <th class="tg-19u4" width="150">জমির পরিমাণ (শতক)</th>
                  <th class="tg-19u4" width="170">নালিশী জমির পরিমাণ (শতক)</th>
               </tr>
            </thead>
               <tbody>
                  @php $k = 1; @endphp
                  @foreach ($surveys as $survey)
                  <tr>
                     <td class="tg-nluh">{{ en2bn($k) }}.</td>
                     <td class="tg-nluh">{{ $survey->st_name }}</td>
                     <td class="tg-nluh">{{ $survey->khotian_no  }}</td>
                     <td class="tg-nluh">{{ $survey->daag_no }}</td>
                     <td class="tg-nluh">{{ $survey->lt_name }}</td>
                     <td class="tg-nluh text-right">{{ en2bn($survey->land_size) }}</td>
                     <td class="tg-nluh text-right">{{ en2bn($survey->land_demand) }}</td>

                  </tr>
                  @php $k++; @endphp
                  @endforeach
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
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ $info->tafsil }}</td>
               </tr>
               <tr>
                  <th class="tg-19u4 text-left" width="100">চৌহদ্দীর বিবরণ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ $info->chowhaddi }}</td>
               </tr>
               <tr>
                  <th class="tg-19u4 text-left" width="100">মন্তব্য</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ $info->comments }}</td>
               </tr>
            </table>

      </div>
   </div>
   <br>
   <br>

   <div class="row">
      <div class="col-md-7">
         @if($info->sc_receiving_date != NULL)
          <h4 class="font-weight-bolder">তারিখ সমুহ</h4>
            <table class="tg">
               <tr>
                  <th class="tg-19u4 text-left">কারণ দর্শাইবার নোটিশ প্রাপ্তির তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ $info->sc_receiving_date }}</td>
               </tr>
               @endif
               @if($info->send_date_rm_ac != NULL)
               <tr>
                  <th class="tg-19u4 text-left">কারণ দর্শাইবার আপিল নোটিশ প্রাপ্তির তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->send_date_rm_ac) }}</td>
               </tr>
               @endif
               @if($info->send_date_rm_ac != NULL)
               <tr>
                  <th class="tg-19u4 text-left">এস এফ তৈরির জন্য আর এম অফিস থেকে এসি ল্যান্ড অফিসে প্রেরণের তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->send_date_rm_ac) }}</td>
               </tr>
               @endif
               @if($info->send_date_ac_ulo != NULL)
               <tr>
                  <th class="tg-19u4 text-left">এস এফ তৈরির জন্য এসি ল্যান্ড থেকে ইউ এল ও অফিসে প্রেরণের তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->send_date_ac_ulo) }}</td>
               </tr>
               @endif
               @if($info->send_date_sf_ulo_ac != NULL)
               <tr>
                  <th class="tg-19u4 text-left">এস এফ ফাইল ইউ এল ও অফিস থেকে এসি ল্যান্ড অফিসে প্রেরণের তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->send_date_sf_ulo_ac) }}</td>
               </tr>
               @endif
               @if($info->send_date_ans_ac_rm != NULL)
               <tr>
                  <th class="tg-19u4 text-left">এস এফ এর জবাব প্রাপ্তির তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->send_date_ans_ac_rm) }}</td>
               </tr>
               @endif
               @if($info->send_date_sf_rm_adc != NULL)
               <tr>
                  <th class="tg-19u4 text-left">এফ এফ প্রতিবেদন চূড়ান্ত করার তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->send_date_sf_rm_adc) }}</td>
               </tr>
               @endif

            </table>
      </div>
      <div class="col-md-5">
          @if($info->order_date != NULL)
          <h4 class="font-weight-bolder">আদেশের তারিখ সমুহ</h4>
            <table class="tg">
               <tr>
                  <th class="tg-19u4 text-left" width="150">আদেশের তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->order_date) }}</td>
               </tr>
               @endif
               @if($info->next_assign_date != NULL)
               <tr>
                  <th class="tg-19u4 text-left" width="150">পরবর্তী ধার্য তারিখ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->next_assign_date) }}</td>
               </tr>
               @endif
               @if($info->past_order_date != NULL)
               <tr>
                  <th class="tg-19u4 text-left" width="150">বিগত তারিখের আদেশ</th>
                  <td class="tg-nluh font-size-lg font-weight-bold">{{ en2bn($info->past_order_date) }}</td>
               </tr>
               @endif
            </table>

      </div>
   </div>
   <br>

   @if (count($sf_logs) != 0)
   <div class="row">
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
    <br>
    @endif

    @php
        $hearings = App\Models\CaseHearing::orderby('id', 'DESC')->where('case_id', $info->id)->get();
    @endphp
    @if (count($hearings) != 0)
    <div class="row">
        <div class="col-md-12">
           <h4 class="font-weight-bolder">শুনানির নোটিশ </h4>
           <table class="tg">
           <thead>
              <tr>
                 <th class="tg-19u4" width="10">ক্রম</th>
                 <th class="tg-19u4 text-center">শুনানির তারিখ</th>
                 <th class="tg-19u4 text-center">সংযুক্তি</th>
                 <th class="tg-19u4 text-center">মন্তব্য</th>
              </tr>
           </thead>
              <tbody class="text-center">
                @forelse ($hearings as $key=> $row)
                <tr>
                   <td class="tg-nluh text-center" scope="row">{{ en2bn($key+1) }}.</td>
                   <td class="tg-nluh text-center">{{ en2bn($row->hearing_date) }}</td>
                   <td class="tg-nluh text-center">
                        <a target="_black" href="{{ asset('uploads/order/'. $row->hearing_file) }}" class="btn btn-primary btn-sm">সংযুক্তি</a>
                    </td>
                   <td class="tg-nluh text-center" class="tg-nluh">{{ $row->hearing_comment }}</td>
                </tr>
                @empty
                <tr>
                    <td class="tg-nluh text-center" colspan="4">
                        <h3>
                            শুনানির কোন নোটিশ পাওয়া যাইনি
                        </h3>
                    </td>
                </tr>
                @endforelse
              </tbody>
           </table>
        </div>
    </div>
   <br>
   @endif


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

                     <embed src="{{ asset('uploads/show_cause/'.$info->show_cause_file) }}" type="application/pdf" width="100%" height="400px" />

                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5" data-dismiss="modal">বন্ধ করুন</button>
                     </div>
                  </div>
               </div>
            </div> <!-- /modal -->
      </div>
      @if($info->power_attorney_file != NULL && $info->appeal_sc_file != NULL)
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

                     <embed src="{{ asset('uploads/power_of_attorney/'.$info->power_attorney_file) }}" type="application/pdf" width="100%" height="400px" />

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

                     <embed src="{{ asset('uploads/appeal_sc/'.$info->appeal_sc_file) }}" type="application/pdf" width="100%" height="400px" />

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
    @if($info->sf_report != NULL)
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

                        <embed src="{{ asset('uploads/sf_report/'.$info->sf_report) }}" type="application/pdf" width="100%" height="400px" />

                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5" data-dismiss="modal">বন্ধ করুন</button>
                        </div>
                     </div>
                  </div>
               </div> <!-- /modal -->
         </div>
         @endif
         @if($info->order_file != NULL)

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

                        <embed src="{{ asset('uploads/order/'.$info->order_file) }}" type="application/pdf" width="100%" height="400px" />

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


