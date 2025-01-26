@extends('layouts.default')

@section('content')

<!--begin::Row-->
<div class="row">
   <div class="col-xl-12">

      <div class="alert alert-custom alert-notice alert-light-info fade show mb-5" role="alert" style="display: none;">
         <div class="alert-icon">
            <i class="flaticon-paper-plane-1"></i>
         </div>
         <div class="alert-text font-weight-bold font-size-h3">মামলাটি সফলভাবে প্রেরণ করা হয়েছে</div>
      </div>


      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         {{ $message }}
      </div>
      @endif

      <!--begin::Card-->
      <div class="card card-custom gutter-b">
         <!--begin::Header-->
         <div class="card-header card-header-tabs-line">
            <div class="card-toolbar">
               <ul class="nav nav-tabs nav-success nav-tabs-space-lg nav-tabs-line nav-bolder nav-tabs-line-3x" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" data-toggle="tab" href="#tab_case_details">
                        <span class="nav-icon"><i class="fa fas fa-balance-scale mr-5"></i></span>
                        <span class="nav-text font-size-h3">পূর্ণাঙ্গ মামলা</span>
                     </a>
                  </li>
                  <li class="nav-item mr-3">
                     <a class="nav-link" data-toggle="tab" href="#tab_sf">
                        <span class="nav-icon"><i class="fa fas fa-layer-group mr-5"></i></span>
                        <span class="nav-text font-size-h3">এসএফ প্রতিবেদন</span>
                     </a>
                  </li>
                  <li class="nav-item mr-3">
                     <a class="nav-link" data-toggle="tab" href="#tab_notice">
                        <span class="nav-icon"><i class="fa far fa-bell mr-5"></i></span>
                        <span class="nav-text font-size-h3">শুনানি নোটিশ</span>
                     </a>
                  </li>
                  <li class="nav-item mr-3">
                     <a class="nav-link" data-toggle="tab" href="#tab_history">
                        <span class="nav-icon"><i class="fa fas fa-history mr-5"></i></span>
                        {{-- <span class="nav-text font-size-h3">মামলার হিস্টোরি</span> --}}
                        <span class="nav-text font-size-h3">মামলার টাইমলাইন</span>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
         <!--end::Header-->

         <!--begin::Body-->
         <div class="card-body px-0">
            <div class="tab-content pt-5">
               <!--begin::Tab Content-->
               <div class="tab-pane active" id="tab_case_details" role="tabpanel">
                  <div class="container">
                     {{-- $info->is_sf --}}
                     <div class="row">
                        <div class="col-md-6">
                           <h4 class="font-weight-bolder">সাধারণ তথ্য</h4>
                           <table class="tg">
                              <tr>
                                 <th class="tg-19u4" width="130">আদালতের নাম</th>
                                 <td class="tg-nluh">{{ $info->court_name }}</td>
                              </tr>
                              <tr>
                                 <th class="tg-19u4">উপজেলা</th>
                                 <td class="tg-nluh">{{ $info->upazila_name_bn }}</td>
                              </tr>
                              <tr>
                                 <th class="tg-19u4">মৌজা</th>
                                 <td class="tg-nluh">{{ $info->mouja_name_bn }}</td>
                              </tr>
                              <tr>
                                 <th class="tg-19u4">মামলা নং</th>
                                 <td class="tg-nluh">{{ $info->case_number }}</td>
                              </tr>
                              <tr>
                                 <th class="tg-19u4">মামলা রুজুর তারিখ</th>
                                 <td class="tg-nluh">{{ $info->case_date }}</td>
                              </tr>
                              <tr>
                                 <th class="tg-19u4">মামলার বর্তমান অবস্থান</th>
                                 <td class="tg-nluh">{{ $info->status_name }}</td>
                              </tr>
                              <tr>
                                 <th class="tg-19u4">বর্তমান ষ্ট্যাটাস</th>
                                 <td class="tg-nluh"> @if ($info->status === 1)
                                    নতুন!
                                    @elseif ($info->status === 2)
                                    চলমান!
                                    @elseif ($info->status === 3)
                                    আপিল!
                                    @else
                                    সম্পাদিত !
                                    @endif
                                 </td>
                              </tr>
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
                                 <td class="tg-nluh">{{$k}}.</td>
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
                                 <td class="tg-nluh">{{ $k }}.</td>
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
                           @php $k = 1; @endphp
                           @foreach ($surveys as $survey)
                           <tr>
                              <td class="tg-nluh">{{ $k }}.</td>
                              <td class="tg-nluh">{{ $survey->st_name }}</td>
                              <td class="tg-nluh">{{ $survey->khotian_no  }}</td>
                              <td class="tg-nluh">{{ $survey->daag_no }}</td>
                              <td class="tg-nluh">{{ $survey->lt_name }}</td>
                              <td class="tg-nluh text-right">{{ $survey->land_size }}</td>
                              <td class="tg-nluh text-right">{{ $survey->land_demand }}</td>
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
                     <h4 class="font-weight-bolder">তফশীল বিবরণ</h4>
                     <table class="tg">
                        <tr>
                           <td class="tg-nluh font-size-lg font-weight-bold">{{ $info->tafsil }}</td>
                        </tr>
                     </table>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-md-12">
                     <h4 class="font-weight-bolder">চৌহদ্দীর বিবরণ</h4>
                     <table class="tg">
                        <tr>
                           <td class="tg-nluh font-size-lg font-weight-bold">{{ $info->chowhaddi }}</td>
                        </tr>
                     </table>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col-md-12">
                     <h4 class="font-weight-bolder">কারণ দর্শাইবার স্ক্যান কপি</h4>

                     <!-- <a href="uploads/{{$info->show_cause_file}}" target="_blank">কারণ দর্শাইবার স্ক্যান কপি ডাউনলোড</a> -->

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

                                 <embed src="{{ asset('uploads/'.$info->show_cause_file) }}" type="application/pdf" width="100%" height="400px" />

                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-light-primary font-weight-bold font-size-h5" data-dismiss="modal">বন্ধ করুন</button>
                                 </div>
                              </div>
                           </div>
                        </div> <!-- /modal -->

                     </div>
                  </div>
               </div> <!--end::Tab Content-->
            </div>
            <!--end::Tab Content-->

            <!--begin::Tab Content-->
            <div class="tab-pane" id="tab_sf" role="tabpanel">
               <div class="container">
                  <div class="alert alert-danger" style="display:none"></div>

                  <div class="alert alert-custom alert-light-success fade show mb-9" role="alert" id="sf_notice_success" style="display:none">
                     <div class="alert-icon">
                        <i class="flaticon2-check-mark"></i>
                     </div>
                     <div class="alert-text font-size-h3">এস এফ প্রতিবেদন সফলভাবে তৈরি হয়েছে</div>
                     <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">
                              <i class="ki ki-close"></i>
                           </span>
                        </button>
                     </div>
                  </div>

                  <div class="alert alert-custom alert-light-success fade show mb-9" role="alert" id="sf_notice_updated" style="display:none">
                     <div class="alert-icon">
                        <i class="flaticon2-check-mark"></i>
                     </div>
                     <div class="alert-text font-size-h3">সফলভাবে এস এফ প্রতিবেদন সংশোধন করা হয়েছে</div>
                     <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">
                              <i class="ki ki-close"></i>
                           </span>
                        </button>
                     </div>
                  </div>

                  <?php if($info->is_sf){ ?>
                  <!--begin::Row Edit SF-->
                  <div class="row" id="sf_edit_content" style="display: none;">
                     <div class="col-md-12">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b example example-compact">
                           <!--begin::Form-->
                           <form action="{{ url('dashboard/editsf') }}" class="form" method="POST" enctype="multipart/form-data">
                              @csrf

                              <!-- <div class="loadersmall"></div> -->
                              <div class="row mb-5">
                                 <div class="col-md-6">
                                    <fieldset>
                                       <legend style="width: 70%;">কারণ দর্শানো নোটিশের প্যারা ভিত্তিক জবাব সংশোধন করুন</legend>
                                       <div class="form-group row">
                                          <div class="col-lg-12">
                                             <textarea name="sf_details" id="sf_details" class="form-control" rows="13" spellcheck="false"><?php echo $sf->sf_details?></textarea>
                                          </div>
                                          <input type="hidden" name="hide_case_id" id="hide_case_id" value="{{ $info->id }}">
                                          <input type="hidden" name="hide_sf_id" id="hide_sf_id" value="{{ $sf->id }}">
                                       </div>
                                    </fieldset>
                                 </div>

                                 <div class="col-md-6">
                                    <embed src="{{ asset('uploads/'.$info->show_cause_file) }}" type="application/pdf" width="100%" height="400px" />
                                    </div>
                                 </div>

                                 <div class="card-footer">
                                    <div class="row">
                                       <div class="col-lg-4"></div>
                                       <div class="col-lg-7">
                                          <button type="button" id="sfUpdateSubmit" class="btn btn-primary font-weight-bold font-size-h2 px-8 py-3"><i class="flaticon2-box icon-3x"></i> সংরক্ষণ করুন</button>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                              <!--end::Form-->
                           </div>
                           <!--end::Card-->
                        </div>
                     </div>
                     <!--end::Row-->
                     <?php } ?>


                     <!--begin::Row Create SF-->
                     <div class="row" id="sf_content" style="display: none;">
                        <div class="col-md-12">
                           <!--begin::Card-->
                           <div class="card card-custom gutter-b example example-compact">
                              <!--begin::Form-->
                              <form action="{{ url('dashboard.createsf') }}" class="form" method="POST" enctype="multipart/form-data">
                                 @csrf
                                 <!-- <div class="loadersmall"></div> -->
                                 <div class="row mb-5">
                                    <div class="col-md-6">
                                       <fieldset>
                                          <legend style="width: 70%;">কারণ দর্শানো নোটিশের প্যারা ভিত্তিক জবাব লিখুন</legend>
                                          <div class="form-group row">
                                             <div class="col-lg-12">
                                                <textarea name="sf_details" id="sf_details" class="form-control" rows="13" spellcheck="false"></textarea>
                                             </div>
                                             <input type="hidden" name="hide_case_id" id="hide_case_id" value="{{ $info->id }}">
                                          </div>
                                       </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                       <embed src="{{ asset('uploads/'.$info->show_cause_file) }}" type="application/pdf" width="100%" height="400px" />
                                       </div>
                                    </div>

                                    <div class="card-footer">
                                       <div class="row">
                                          <div class="col-lg-4"></div>
                                          <div class="col-lg-7">
                                             <button type="button" id="sfCreateSubmit" class="btn btn-primary font-weight-bold font-size-h2 px-8 py-3"><i class="flaticon2-box icon-3x"></i> সংরক্ষণ করুন</button>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                                 <!--end::Form-->
                              </div>
                              <!--end::Card-->
                           </div>
                        </div>
                        <!--end::Row-->

                        <?php if($info->is_sf){ ?>
                        <div id="sf_docs">
                           <?php if(Auth::user()->role_id == 12 || Auth::user()->role_id == 9 || Auth::user()->role_id == 10 || Auth::user()->role_id == 11){ ?>
                              <a href="javascript:void(0)" id="sf_edit_button" class="btn btn-danger float-right">
                                 <i class="fa fas fa-edit"></i> <b>সংশোধন করুন</b>
                              </a>
                              <?php } ?>

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
                        </div>

                        <?php }else{ ?>

                        <!--begin::Notice-->
                        <div class="alert alert-custom alert-light-danger fade show mb-9" role="alert" id="sf_notice">
                           <div class="alert-icon">
                              <i class="flaticon-warning"></i>
                           </div>
                           <div class="alert-text font-size-h3">এখনও পর্যন্ত কোন এসএফ প্রতিবেদন তৈরি করা হয়নি !</div>
                           <div class="alert-close">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">
                                    <i class="ki ki-close"></i>
                                 </span>
                              </button>
                           </div>
                        </div>
                        <!--end::Notice-->

                        <?php if(Auth::user()->role_id == 12){ ?>
                           <div class="row justify-content-md-center" id="sf_create_button">
                              <div class="col-5">
                                 <a href="javascript:void(0)" id="sf_create" class="btn btn-primary font-weight-bold font-size-h2 px-12 py-5"><i class="flaticon2-layers icon-3x"></i> এস এফ প্রতিবেদন তৈরি করুন</a>
                              </div>
                           </div>
                           <?php } ?>
                           <?php } ?>

                        </div>
                     </div>
                     <!--end::Tab Content-->
                     <!--begin::Tab Content-->
                     <div class="tab-pane" id="tab_notice" role="tabpanel">
                        <div class="container">

                           <div class="alert alert-danger" style="display:none"></div>

                           <div class="alert alert-custom alert-light-success fade show mb-9" role="alert" id="hearing_notice_success" style="display:none">
                              <div class="alert-icon">
                                 <i class="flaticon2-check-mark"></i>
                              </div>
                              <div class="alert-text font-size-h3">শুনানির তারিখ সংরক্ষণ করা হয়েছে</div>
                              <div class="alert-close">
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">
                                       <i class="ki ki-close"></i>
                                    </span>
                                 </button>
                              </div>
                           </div>

                           <?php if(Auth::user()->role_id == 13){ ?>
                              <a href="javascript:void(0)" id="hearing_add_button" class="btn btn-danger float-right"><i class="fa fas fa-landmark"></i> <b>শুনানির তারিখ যুক্ত করুন</b></a>
                              <?php } ?>

                              <div class="clearfix"></div>

                              <div id="hearing_content">
                                 <?php if(!empty($hearings)){ ?>
                                 <table class="table table-hover mb-6 font-size-h5">
                                    <thead class="thead-light  font-size-h3">
                                       <tr>
                                          <th scope="col" width="30">#</th>
                                          <th scope="col" width="200">শুনানির তারিখ</th>
                                          <th scope="col">মন্তব্য</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php $i=0; ?>
                                       @foreach ($hearings as $row)
                                       <tr>
                                          <td scope="row">{{ ++$i }}.</td>
                                          <td>{{ $row->hearing_date }}</td>
                                          <td>{{ $row->hearing_comment }}</td>
                                       </tr>
                                       @endforeach
                                    </tbody>
                                 </table>
                                 <?php }else{ ?>
                                 <!--begin::Notice-->
                                 <div class="alert alert-custom alert-light-success fade show mb-9" role="alert">
                                    <div class="alert-icon">
                                       <i class="flaticon-warning"></i>
                                    </div>
                                    <div class="alert-text font-size-h3">কোন শুনানির নোটিশ পাওয়া যাইনি</div>
                                    <div class="alert-close">
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                          <span aria-hidden="true">
                                             <i class="ki ki-close"></i>
                                          </span>
                                       </button>
                                    </div>
                                 </div>
                                 <!--end::Notice-->
                                 <?php } ?>
                              </div>

                              <!--begin::Row Create SF-->
                              <div class="row" id="hearing_add_content" style="display: none;">
                                 <div class="col-md-12">
                                    <!--begin::Card-->
                                    <div class="card card-custom gutter-b example example-compact">
                                       <!--begin::Form-->
                                       <form action="{{ url('dashboard.hearing-add') }}" class="form" method="POST" enctype="multipart/form-data">
                                          @csrf
                                          <!-- <div class="loadersmall"></div> -->
                                          <div class="row mb-5">
                                             <div class="col-md-12">
                                                <fieldset>
                                                   <div class="form-group row">
                                                      <div class="col-lg-4">
                                                         <label>শুনানির তারিখ <span class="text-danger">*</span></label>
                                                         <input type="text" name="hearing_date" id="hearing_date" class="form-control form-control-sm common_datepicker" placeholder="দিন/মাস/তারিখ" autocomplete="off">
                                                      </div>
                                                      <div class="col-lg-8">
                                                         <label>মন্তব্য <span class="text-danger">*</span></label>
                                                         <textarea name="hearing_comment" id="hearing_comment" class="form-control" rows="5" spellcheck="false"></textarea>
                                                      </div>
                                                      <input type="hidden" name="hide_case_id" id="hide_case_id" value="{{ $info->id }}">
                                                   </div>
                                                </fieldset>
                                             </div>
                                          </div>

                                          <div class="card-footer">
                                             <div class="row">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-7">
                                                   <button type="button" id="hearingSubmit" class="btn btn-primary font-weight-bold font-size-h2 px-8 py-3"><i class="flaticon2-box icon-3x"></i> সংরক্ষণ করুন</button>
                                                </div>
                                             </div>
                                          </div>
                                       </form>
                                       <!--end::Form-->
                                    </div>
                                    <!--end::Card-->
                                 </div>
                              </div>
                              <!--end::Row-->

                           </div>
                        </div>
                        <!--end::Tab Content-->
                        <!--begin::Tab Content-->
                        <div class="tab-pane" id="tab_history" role="tabpanel">
                           <div class="container">
                              <!-- <div class="separator separator-dashed my-10"></div> -->

                              <?php if(!empty($logs)){ ?>
                              <!--begin::Timeline-->
                              <div class="timeline timeline-3">
                                 <div class="timeline-items">

                                    <?php foreach ($logs as $row) { ?>
                                    <div class="timeline-item">
                                       <div class="timeline-media">
                                          <i class="fa fas fa-angle-double-up text-warning"></i>
                                       </div>
                                       <div class="timeline-content">
                                          <div class="d-flex align-items-center justify-content-between mb-3">
                                             <div class="mr-2">
                                                <a href="javascript:void(0)" class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5"><?=$row->status_name?></a>
                                                <span class="text-muted ml-2 font-size-h6 "><?=$row->created_at?> | <?=$row->name?> | <?=$row->role_name?></span>
                                             </div>
                                          </div>
                                          <p class="p-0 font-italic font-size-h5"><?=$row->comment?></p>
                                       </div>
                                    </div>
                                    <?php } ?>

                        <?php /*
                        <div class="timeline-item">
                           <div class="timeline-media">
                              <i class="fa fas fa-angle-double-down text-warning"></i>
                           </div>
                           <div class="timeline-content">
                              <div class="d-flex align-items-center justify-content-between mb-3">
                                 <div class="mr-2">
                                    <a href="javascript:void(0)" class="text-dark-75 text-hover-primary font-weight-bolder"> এডিসি (রেভিনিউ) এর নিকট প্রেরণ</a>
                                    <span class="text-muted ml-2">8:30PM 20 June</span>
                                 </div>
                              </div>
                              <p class="p-0">মন্তব্য যদি থাকে এখানে দেখানো হবে</p>
                           </div>
                        </div>
                        <div class="timeline-item">
                           <div class="timeline-media">
                              <i class="fa fas fa-angle-double-down text-warning"></i>
                           </div>
                           <div class="timeline-content">
                              <div class="d-flex align-items-center justify-content-between mb-3">
                                 <div class="mr-2">
                                    <a href="javascript:void(0)" class="text-dark-75 text-hover-primary font-weight-bolder">ডিসি মহোদয়ের নিকট প্রেরণ</a>
                                    <span class="text-muted ml-2">11:00AM 30 June</span>
                                 </div>
                              </div>
                              <p class="p-0">মন্তব্য যদি থাকে এখানে দেখানো হবে মন্তব্য যদি থাকে এখানে দেখানো হবে মন্তব্য যদি থাকে এখানে দেখানো হবে মন্তব্য যদি থাকে এখানে দেখানো হবে</p>
                           </div>
                        </div>
                        <div class="timeline-item">
                           <div class="timeline-media">
                              <i class="flaticon2-notification fl text-primary"></i>
                           </div>
                           <div class="timeline-content">
                              <div class="d-flex align-items-center justify-content-between mb-3">
                                 <div class="mr-2">
                                    <a href="javascript:void(0)" class="text-dark-75 text-hover-primary font-weight-bolder">নতুন মামলা রেজিস্টার এন্ট্রি</a>
                                    <span class="text-muted ml-2">2 months ago</span>
                                 </div>
                              </div>
                              <!-- <p class="p-0"></p> -->
                           </div>
                        </div>
                        */ ?>
                     </div>
                  </div>
                  <!--end::Timeline-->
                  <?php } else { ?>

                  <!--begin::Notice-->
                  <div class="alert alert-custom alert-light-success fade show mb-9" role="alert">
                     <div class="alert-icon">
                        <i class="flaticon-warning"></i>
                     </div>
                     <div class="alert-text font-size-h3">কোন তথ্য পাওয়া যাইনি</div>
                  </div>
                  <!--end::Notice-->

                  <?php } ?>
               </div>
               <!--end::Container-->
            </div>
            <!--end::Tab Content-->
         </div>
      </div>
      <!--end::Body-->
   </div>
   <!--end::Card-->
</div>
</div>
<!--end::Row-->


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

<script type="text/javascript">
   $(document).ready(function(){
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });

      // Case forwared to other by popup modal
      $('#formSubmit').click(function(e){
         var radioValue = $("input[name='group']:checked").val();
         // alert(radioValue);
         e.preventDefault();

         $.ajax({
            url: "{{ url('/dashboard/caseforward') }}",
            method: 'post',
            data: {
               case_id: $('#hide_case_id').val(),
               group: radioValue,
               comment: $('#comment').val()
            },
            success: function(result){
               if(result.errors)
               {
                  $('.alert-danger').html('');

                  $.each(result.errors, function(key, value){
                     $('.alert-danger').show();
                     $('.alert-danger').append('<li>'+value+'</li>');
                  });
               } else {
                  $('.alert-danger').hide();
                  $('#caseForwardModal').modal('hide');
                  $('.alert-custom').show();
               }
            }
         });
      });

      // Create for new sf document hide create button
      $('#sf_create').click(function(){
         $('#sf_content').show();
         $('#sf_notice').hide(1000);
         $('#sf_create_button').hide(1000);
      });

      // Submit SF answer by ULAO
      $('#sfCreateSubmit').click(function(e){
         // var radioValue = $("input[name='group']:checked").val();
         // alert($('#hide_case_id').val());
         e.preventDefault();

         $.ajax({
            url: "{{ url('/dashboard/createsf') }}",
            method: 'post',
            data: {
               case_id: $('#hide_case_id').val(),
               sf_details: $('#sf_details').val()
            },
            success: function(result){
               if(result.errors)
               {
                  $('.alert-danger').html('');

                  $.each(result.errors, function(key, value){
                     $('.alert-danger').show();
                     $('.alert-danger').append('<li>'+value+'</li>');
                  });
               } else {
                  // result.sfdata
                  $('.alert-danger').hide();
                  $('#sf_content').hide();
                  $('#sf_notice_success').show();
               }
            }
         });
      });

      // Click edit button hide sf document and show edit form
      $('#sf_edit_button').click(function(){
         $('#sf_edit_content').show();
         $('#sf_docs').hide(1000);
         // $('#sf_edit_button').hide(1000);
      });

      // Edit Submit SF answer by AC (Land), ULAO, Kanango, Survayer
      $('#sfUpdateSubmit').click(function(e){
         // var radioValue = $("input[name='group']:checked").val();
         // alert($('#hide_case_id').val());
         // var id = $('#hide_case_id').val();
         e.preventDefault();

         $.ajax({
            url: "{{ url('/dashboard/editsf') }}",
            method: 'post',
            data: {
               case_id: $('#hide_case_id').val(),
               sf_id: $('#hide_sf_id').val(),
               sf_details: $('#sf_details').val()
            },
            success: function(result){
               if(result.errors)
               {
                  $('.alert-danger').html('');

                  $.each(result.errors, function(key, value){
                     $('.alert-danger').show();
                     $('.alert-danger').append('<li>'+value+'</li>');
                  });
               } else {
                  // result.sfdata
                  $('.alert-danger').hide();
                  $('#sf_edit_content').hide();
                  $('#sf_notice_updated').show();
                  $('#sf_docs').hide(1000);
               }
            }
         });
      });

      // Click hearing add button hide alert box
      $('#hearing_add_button').click(function(){
         $('#hearing_add_content').show();
         $('#hearing_content').hide(1000);
         $('#hearing_add_button').hide(1000);
      });

      // Edit Submit SF answer by AC (Land), ULAO, Kanango, Survayer
      $('#hearingSubmit').click(function(e){
         // var radioValue = $("input[name='group']:checked").val();
         // alert($('#hide_case_id').val());
         // var id = $('#hide_case_id').val();
         e.preventDefault();

         $.ajax({
            url: "{{ url('/dashboard/hearing-add') }}",
            method: 'post',
            data: {
               case_id: $('#hide_case_id').val(),
               hearing_date: $('#hearing_date').val(),
               hearing_comment: $('#hearing_comment').val()
            },
            success: function(result){
               if(result.errors)
               {
                  $('.alert-danger').html('');

                  $.each(result.errors, function(key, value){
                     $('.alert-danger').show();
                     $('.alert-danger').append('<li>'+value+'</li>');
                  });
               } else {
                  // result.sfdata
                  $('.alert-danger').hide();
                  $('#hearing_add_content').hide();
                  $('#hearing_notice_success').show();
                  // $('#sf_docs').hide(1000);
               }
            }
         });
      });

   });

   // common datepicker
   $('.common_datepicker').datepicker({
      format: "dd/mm/yyyy",
      todayHighlight: true,
      orientation: "bottom left"
   });
</script>

@endsection
