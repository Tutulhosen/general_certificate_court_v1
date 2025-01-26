@extends('layouts.default')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title h2 font-weight-bolder">{{ $data['page_title'] }}</h3>
                        <div class="card-toolbar">
                            <!-- <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div> -->
                        </div>
                    </div>

                    <!-- <div class="loadersmall"></div> -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!--begin::Form-->
                    <form action="{{ url('case/save') }}" class="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <fieldset class="mb-8">
                                <legend>মামলার তথ্য</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="caseEntryType" class="control-label"> মামলার ধরন </label>
                                            <div class="radio">
                                                <label class="mr-5">
                                                    <input type="radio" id="new" class="caseEntryType mr-2" value="NEW" checked name="caseEntryType">নতুন মামলা
                                                </label>
                                                <label>
                                                    <input type="radio" id="oldCaseRadio" class="caseEntryType  mr-2" value="OLD" name="caseEntryType">পুরাতন মামলা
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-none" id="prevCaseDiv">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="previouscaseNo" class="control-label">পূর্ববর্তী মামলা নম্বর</label>
                                                <input type="text" name="previouscaseNo" id="previouscaseNo" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="caseNo" class="control-label">মামলা নম্বর</label>
                                            <div name="caseNo" id="caseNo" class="form-control"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="caseDate" class="control-label"><span style="color:#FF0000">* </span>আবেদনের তারিখ</label>
                                            <div class='input-group date' id='datetimepicker1'>
                                                <input type='text' class="form-control" />
                                                <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                             </div>
                                            <div class="input-group">
                                                {{-- <input class="date form-control" onchange="appealUiUtils.changeInitialNote();" name="caseDate" id="caseDate" value="" type="text" required/>
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                </span> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-4 mb-5">
                                        <label>আদালতের নাম <span class="text-danger">*</span></label>
                                        <select name="court" id="court" class="form-control form-control-sm">
                                            <option value=""> -- নির্বাচন করুন --</option>
                                            {{-- @foreach ($courts as $value)
                                            <option value="{{ $value->id }}" {{ old('court') == $value->id ? 'selected' : '' }}> {{ $value->court_name }} </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <label>উপজেলা <span class="text-danger">*</span></label>
                                        <select name="upazila" id="upazila_id" class="form-control form-control-sm" >
                                            <option value="">-- নির্বাচন করুন --</option>
                                             {{-- @foreach ($upazilas as $value)
                                            <option value="{{ $value->id }}" {{ old('upazila') == $value->id ? 'selected' : '' }}> {{ $value->upazila_name_bn }} </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <label>মৌজা <span class="text-danger">*</span></label>
                                        <select name="mouja" id="mouja_id" class="form-control form-control-sm">
                                            <!-- <span id="loading"></span> -->
                                            <option value="">-- নির্বাচন করুন --</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <label>মামলার ধরণ <span class="text-danger">*</span></label>
                                        <input type="text" name="case_type" id="case_type" class="form-control form-control-sm" placeholder="মামলার ধরণ" autocomplete="off">
                                        <!-- <select name="case_type" id="case_type" class="form-control form-control-sm">
                                            <option value="">-- নির্বাচন করুন --</option>
                                            {{-- @foreach ($case_types as $value)
                                            <option value="{{ $value->id }}" {{ old('case_type') == $value->id ? 'selected' : '' }}> {{ $value->ct_name }} </option>
                                            @endforeach --}}
                                        </select> -->
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <label>মামলা নং <span class="text-danger">*</span></label>
                                        <input type="text" name="case_no" id="case_no" class="form-control form-control-sm" placeholder="মামলা নং ">
                                    </div>
                                    <div class="col-lg-4 mb-5">
                                        <label>মামলা রুজুর তারিখ <span class="text-danger">*</span></label>
                                        <input type="text" name="case_date" id="case_date" class="form-control form-control-sm common_datepicker" placeholder="দিন/মাস/তারিখ" autocomplete="off">
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group row">
                                <div class="col-lg-6 mb-5">
                                    <fieldset>
                                        <legend>বাদীর বিবরণ</legend>
                                        <table width="100%" border="1" id="badiDiv" style="border:1px solid #dcd8d8;">
                                            <tr>
                                                <th>বাদীর নাম <span class="text-danger">*</span></th>
                                                <th>পিতা/স্বামীর নাম</th>
                                                <th>ঠিকানা</th>
                                                <th width="50">
                                                    <a href="javascript:void();" id="addBadiRow" class="btn btn-sm btn-primary font-weight-bolder pr-2"><i class="fas fa-plus-circle"></i></a>
                                                </th>
                                            </tr>
                                            <tr></tr>
                                        </table>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6 mb-5">
                                    <fieldset>
                                        <legend>বিবাদীর বিবরণ</legend>
                                        <table width="100%" border="1" id="bibadiDiv" style="border:1px solid #dcd8d8;">
                                            <tr>
                                                <th>বিবাদীর নাম <span class="text-danger">*</span></th>
                                                <th>পিতা/স্বামীর নাম</th>
                                                <th>ঠিকানা</th>
                                                <th width="50">
                                                    <a href="javascript:void();" id="addBibadiRow" class="btn btn-sm btn-primary font-weight-bolder pr-2"><i class="fas fa-plus-circle"></i></a>
                                                </th>
                                            </tr>
                                            <tr></tr>
                                        </table>
                                    </fieldset>
                                </div>
                            </div>

                            <fieldset class="mb-8">
                                <legend>তফশীল বিবরণ </legend>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label></label>
                                        <textarea name="tafsil" class="form-control" id="tafsil" rows="3"  spellcheck="false"></textarea>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group row">
                                <div class="col-lg-12 mb-5">
                                    <fieldset>
                                        <legend>জরিপের বিবরণ</legend>
                                        <table width="100%" border="1" id="surveyDiv" style="border:1px solid #dcd8d8;">
                                            <tr>
                                                <th>জরিপের ধরণ <span class="text-danger">*</span></th>
                                                <th>খতিয়ান নং</th>
                                                <th>দাগ নং</th>
                                                <th>জমির শ্রেণী</th>
                                                <th>জমির পরিমাণ (শতক)</th>
                                                <th>নালিশী জমির পরিমাণ (শতক)</th>
                                                <th width="50">
                                                    <a href="javascript:void();" id="addSurveyRow" class="btn btn-sm btn-primary font-weight-bolder pr-2"><i class="fas fa-plus-circle"></i></a>
                                                </th>
                                            </tr>
                                            <tr></tr>
                                        </table>
                                    </fieldset>
                                </div>
                            </div>


                            <fieldset>
                                <legend>চৌহদ্দীর বিবরণ </legend>
                                <div class="col-lg-12 mb-5">
                                    <label></label>
                                    <textarea name="chowhaddi" class="form-control" id="chowhaddi" rows="3" spellcheck="false"></textarea>
                                </div>
                            </fieldset>
                            <br>
                            <div class="form-group row">
                                <div class="col-lg-6 mb-5">
                                    <fieldset>
                                        <legend>কারণ দর্শাইবার স্ক্যান কপি সংযুক্তি <span class="text-danger">*</span></legend>
                                        <div class="col-lg-12 mb-5">
                                            <div class="form-group">
                                                <label></label>
                                                <div></div>
                                                <div class="custom-file">
                                                    <input type="file" name="show_cause" class="custom-file-input" id="customFile" />
                                                    <label class="custom-file-label" for="customFile">ফাইল নির্বাচন করুন</label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6 mb-5">
                                    <fieldset>
                                        <legend>মন্তব্য </legend>
                                        <div class="col-lg-12 mb-5">
                                            <label></label>
                                            <textarea name="comments" class="form-control" id="comments" rows="2" spellcheck="false"></textarea>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                        </div> <!--end::Card-body-->

                        <!-- <div class="card-footer text-right bg-gray-100 border-top-0">
                            <button type="reset" class="btn btn-primary">সংরক্ষণ করুন</button>
                        </div> -->
                    <div class="card-footer">
                      <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-7">
                                <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary mr-3" id="preview">প্রিভিউ</button>
                                <button type="submit" class="btn btn-success mr-2" onclick="return confirm('আপনি কি সংরক্ষণ করতে চান?')">সংরক্ষণ করুন</button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="myModal">

                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                  <h3 class="modal-title">নতুন মামলার তথ্য</h3>
                                  <button type="button" class="close" data-dismiss="modal">×</button>
                              </div>

                              <!-- Modal body -->
                              <div class="modal-body">
                               <div class="row">

                                 <label><h4>সাধারণ তথ্য</h4></label>
                                 <table class="tg">
                                    <thead>
                                        <tr>
                                            <th class="tg-19u4 text-center">আদালতের নাম </th>
                                            <!-- <th class="tg-19u4 text-center">বিভাগ </th>
                                            <th class="tg-19u4 text-center">জেলা </th> -->
                                            <th class="tg-19u4 text-center">উপজেলা </th>
                                            <th class="tg-19u4 text-center">মৌজা </th>
                                        </tr>
                                        <tr>
                                            <td class="tg-nluh" id="previewCourt"></td>
                                           <!--  <td class="tg-nluh" id="previewDivision"></td>
                                            <td class="tg-nluh" id="previewDistrict"></td> -->
                                            <td class="tg-nluh" id="previewUpazila"></td>
                                            <td class="tg-nluh" id="previewMouja_id"></td>

                                        </tr>
                                        <tr>
                                           <!--  <th class="tg-19u4 text-center">মামলার ধরণ</th> -->
                                            <th class="tg-19u4 text-center">মামলা নং </th>
                                            <th class="tg-19u4 text-center">মামলা রুজুর তারিখ</th>
                                        </tr>
                                        <tr>
                                            <!-- <td class="tg-nluh" id="previewCase_type"></td> -->
                                            <td class="tg-nluh" id="previewCase_no"></td>
                                            <td class="tg-nluh" id="previewCase_date"></td>

                                        </tr>
                                    </thead>
                                </table>
                                <br>
                                <br>
                                <table class="tg">
                                    <label><h4>বাদীর তথ্য</h4></label>
                                    <thead>
                                        <tr>
                                            <th class="tg-19u4 text-center">বাদীর নাম</th>
                                            <th class="tg-19u4 text-center">পিতা/স্বামীর নাম</th>
                                            <th class="tg-19u4 text-center">ঠিকানা</th>
                                        </tr>
                                        <tr>
                                            <td class="tg-nluh" id="previewBadi_name"></td>
                                            <td class="tg-nluh" id="previewBadi_spouse_name"></td>
                                            <td class="tg-nluh" id="previewBadi_address"></td>

                                        </tr>
                                    </thead>
                                </table>
                                <br>
                                <br>
                                <table class="tg">
                                    <label><h4>বিবাদীর তথ্য</h4></label>
                                    <thead>
                                        <tr>
                                            <th class="tg-19u4 text-center">বিবাদীর নাম </th>
                                            <th class="tg-19u4 text-center">পিতা/স্বামীর নাম</th>
                                            <th class="tg-19u4 text-center">ঠিকানা</th>
                                        </tr>
                                        <tr>
                                            <td class="tg-nluh" id="previewBibadi_name"></td>
                                            <td class="tg-nluh" id="previewBibadi_spouse_name"></td>
                                            <td class="tg-nluh" id="previewBibadi_address"></td>
                                        </tr>

                                    </thead>
                                </table>
                                <br>
                                <br>
                                <table class="tg">
                                    <label><h4>জরিপের বিবরণ</h4></label>
                                    <thead>
                                        <tr>
                                            <th class="tg-19u4 text-center">জরিপের ধরণ </th>
                                            <th class="tg-19u4 text-center">দাগ নং</th>
                                            <th class="tg-19u4 text-center">খতিয়ান নং</th>
                                        </tr>
                                        <tr>
                                            <td class="tg-nluh" id="previewSt_id"></td>
                                            <td class="tg-nluh" id="previewKhotian_no"></td>
                                            <td class="tg-nluh" id="previewDaag_no"></td>
                                        </tr>

                                        <tr>
                                            <th class="tg-19u4 text-center">জমির শ্রেণী</th>
                                            <th class="tg-19u4 text-center">নালিশী জমির পরিমাণ (শতক)</th>
                                            <th class="tg-19u4 text-center">জমির পরিমাণ (শতক)</th>
                                        </tr>
                                        <tr>
                                            <td class="tg-nluh" id="previewLt_id"></td>
                                            <td class="tg-nluh" id="previewLand_size"></td>
                                            <td class="tg-nluh" id="previewLand_demand"></td>

                                        </tr>
                                    </thead>
                                </table>
                                <div class="col-lg-6 mb-5"></div>
                                <table class="tg">
                                    <thead>
                                        <tr>
                                            <th class="tg-19u4 text-center">তফশীল বিবরণ</th>
                                            <th class="tg-19u4 text-center">চৌহদ্দীর বিবরণ</th>
                                            <th class="tg-19u4 text-center">মন্তব্য</th>

                                        </tr>
                                        <tr>
                                            <td class="tg-nluh" id="previewTafsil"></td>
                                            <td class="tg-nluh" id="previewChowhaddi"></td>
                                            <td class="tg-nluh" id="previewComments"></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          </div>

                      </div>
                  </div>
              </div>

          </form>
          <!--end::Form-->
        </div>



        <div class="row">
            <div class="col-md-3">
                {{-- layouts/sidemenu.blade.php --}}
                {{-- @include('layouts.sidemenu') --}}
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <strong class="panel-title">
                            @lang('message.headingAppealForm')
                        </strong>
                    </div>
                    <input type="hidden" id="appealId" class="form-control" value="{{$data['appealId']}}">
                    <div class="panel-body">
                        <input type="hidden" id="officeId" value="{{ $data['office_id'] }}">
                        <form  method="post" id="appealForm" action="">
                            {{csrf_field()}}
                            <div class="clearfix criminal_defenders" id="c-defenderdiv_1">
                                {{--applicant Info--}}
                                <div class="panel panel-info radius-none">
                                    <div class="panel-heading radius-none">
                                        <h4 class="panel-title">@lang('message.caseInformationBlockHeading')</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="clearfix">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="caseEntryType" class="control-label">@lang('message.caseEntryType')</label>
                                                        <div class="radio">
                                                            <label><input type="radio" id="new" class="caseEntryType" value="NEW" onclick="appealUiUtils.checkCaseEntryType();"  checked name="caseEntryType">@lang('message.new') @lang('message.case')</label>
                                                            <label><input type="radio" id="old" class="caseEntryType" value="OLD" onclick="appealUiUtils.checkCaseEntryType();"  name="caseEntryType">@lang('message.old') @lang('message.case')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 hidden" id="prevCaseDiv">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label for="previouscaseNo" class="control-label">@lang('message.previous') @lang('message.caseNo')</label>
                                                            <input type="text" name="previouscaseNo" id="previouscaseNo" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="caseNo" class="control-label">@lang('message.caseNo')</label>
                                                        <div name="caseNo" id="caseNo" class="form-control"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="caseDate" class="control-label"><span style="color:#FF0000">* </span>@lang('message.applicantDate')</label>
                                                        <div class="input-group">
                                                            <input readonly="readonly" class="date form-control" onchange="appealUiUtils.changeInitialNote();" name="caseDate" id="caseDate" value="" type="text" required/>
                                                            <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="lawSection" class="control-label">@lang('message.lawSection')</label>
                                                        <input name="lawSection" id="lawSection" class="form-control" value="সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="totalLoanAmount" class="control-label"><span style="color:#FF0000">* </span>@lang('message.totalLoanAmount')</label>
                                                        <input  type="text" name="totalLoanAmount" id="totalLoanAmount" class="form-control" value="" onchange="appealUiUtils.validateAmount(this)">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="totalLoanAmountText" class="control-label">@lang('message.totalLoanAmountText')</label>
                                                        <input readonly="readonly" type="text" name="totalLoanAmountText" id="totalLoanAmountText" class="form-control" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>

                            <section class="" id="tabs">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabs-info" role="tablist">
                                    <li class="active"><a href="#t1" aria-controls="t1" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.applicantBlockHeading')</h4></a></li>
                                    <li><a href="#t2" aria-controls="t2" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.defaulterBlockHeading')</h4></a></li>
                                    <li><a href="#t3" aria-controls="t3" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.guarantorBlockHeading')</h4></a></li>
                                    <li><a href="#t4" aria-controls="t4" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4></a></li>
                                    <li><a href="#t5" aria-controls="t5" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.nomineeBlockHeading')</h4></a></li>
                                    <li><a href="#t6" aria-controls="t6" role="tab" data-toggle="tab"><h4 class="panel-title">@lang('message.policeBlockHeading')</h4></a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="t1">
                                        <div class="panel panel-info radius-none">
                                            {{--<div class="panel-heading radius-none">--}}
                                                {{--<h4 class="panel-title">@lang('message.applicantBlockHeading')</h4>--}}
                                            {{--</div>--}}
                                            <div class="panel-body bg-info">
                                                <div class="clearfix">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <span style="color: rebeccapurple">আবেদনকারীর নাম/পদবী দু’টি ফিল্ডের যেকোন একটি পূরণীয় বাধ্যতামূলক। </span><span style="color:#FF0000">* </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="applicantName_1" class="control-label">@lang('message.applicant')</label>
                                                                <input name="citizen[1][1][name]" id="applicantName_1" class="form-control name-group" value="" >
                                                                <input type="hidden" name="citizen[1][1][type]"  class="form-control" value="1">
                                                                <input type="hidden" name="citizen[1][1][id]" id="applicantId_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[1][1][email]" id="applicantEmail_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[1][1][thana]" id="applicantThana_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[1][1][upazilla]" id="applicantUpazilla_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[1][1][age]" id="applicantAge_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="applicantDesignation_1" class="control-label">@lang('message.designation')</label>
                                                                <input name="citizen[1][1][designation]" id="applicantDesignation_1" class="form-control name-group" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="applicantOrganization_1" class="control-label"><span style="color:#FF0000">* </span>@lang('message.organization')</label>
                                                                <input name="citizen[1][1][organization]" id="applicantOrganization_1" class="form-control" value="" onchange="appealUiUtils.changeInitialNote();">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="applicantType" class="control-label"><span style="color:#FF0000">* </span>@lang('message.organizationType')</label>
                                                                <div class="radio">
                                                                    <label><input onclick="appealUiUtils.changeInitialNote()" id="applicantTypeBank" class="applicantType" type="radio" name="applicantType" value="BANK" checked>ব্যাংক</label>
                                                                </div>
                                                                <div class="radio">
                                                                    <label><input onclick="appealUiUtils.changeInitialNote()" id="applicantTypeOther" class="applicantType" type="radio" name="applicantType" value="OTHER_COMPANY" >অন্যান্য কোম্পানি</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="applicantGender_1" class="control-label">@lang('message.gender')</label>
                                                                <select style="width: 100%;" class="selectDropdown form-control select2" name="citizen[1][1][gender]" id="applicantGender_1">
                                                                    <option value="">@lang('message.emptyText')</option>
                                                                    <option value="MALE">@lang('message.male')</option>
                                                                    <option value="FEMALE">@lang('message.female')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--<input name="citizen[1][1][father]" id="applicantFather_1" type="hidden" class="form-control" value="NOT APPLICABLE">--}}
                                                    {{--<input name="citizen[1][1][mother]" id="applicantMother_1" type="hidden" class="form-control" value="NOT APPLICABLE">--}}

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="applicantFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                                <input name="citizen[1][1][father]" id="applicantFather_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="applicantMother_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.mother')</label>
                                                                <input name="citizen[1][1][mother]" id="applicantMother_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="applicantNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                                <input name="citizen[1][1][nid]" id="applicantNid_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="applicantPhn_1" class="control-label"><span style="color:#FF0000">* </span>@lang('message.phn')</label>
                                                                <input name="citizen[1][1][phn]" id="applicantPhn_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="applicantPresentAddree_1"><span style="color:#FF0000">* </span>@lang('message.organizationAddress')</label>
                                                                <textarea id="applicantPresentAddree_1" name="citizen[1][1][presentAddress]" rows="5" class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="t2">
                                        <div class="panel panel-info radius-none">
                                            {{--<div class="panel-heading radius-none">--}}
                                                {{--<h4 class="panel-title">@lang('message.defaulterBlockHeading')</h4>--}}
                                            {{--</div>--}}
                                            <div class="panel-body bg-info">
                                                <div class="clearfix">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="defaulterName_1" class="control-label"><span style="color:#FF0000">* </span>@lang('message.defaulter')</label>
                                                                <input name="citizen[2][1][name]" id="defaulterName_1" class="form-control" value="" onchange="appealUiUtils.changeInitialNote()" >
                                                                <input type="hidden" name="citizen[2][1][type]"  class="form-control" value="2">
                                                                <input type="hidden" name="citizen[2][1][id]" id="defaulterId_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[2][1][email]" id="defaulterEmail_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[2][1][thana]" id="defaulterThana_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[2][1][upazilla]" id="defaulterUpazilla_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[2][1][age]" id="defaulterAge_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="defaulterPhn_1" class="control-label">@lang('message.phn')</label>
                                                                <input name="citizen[2][1][phn]" id="defaulterPhn_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="defaulterNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                                <input name="citizen[2][1][nid]" id="defaulterNid_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="defaulterGender_1" class="control-label">@lang('message.gender')</label>
                                                                <select style="width: 100%;" class="selectDropdown form-control select2" name="citizen[2][1][gender]" id="defaulterGender_1">
                                                                    <option value="">@lang('message.emptyText')</option>
                                                                    <option value="MALE">@lang('message.male')</option>
                                                                    <option value="FEMALE">@lang('message.female')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="defaulterFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                                <input name="citizen[2][1][father]" id="defaulterFather_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="defaulterMother_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.mother')</label>
                                                                <input name="citizen[2][1][mother]" id="defaulterMother_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="defaulterDesignation_1" class="control-label"><span style="color:#FF0000">* </span>@lang('message.designation') / পেশা</label>
                                                                <input name="citizen[2][1][designation]" id="defaulterDesignation_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="defaulterOrganization_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.organization')</label>
                                                                <input name="citizen[2][1][organization]" id="defaulterOrganization_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="defaulterPresentAddree_1"><span style="color:#FF0000">* </span>@lang('message.businessAddress')</label>
                                                                <textarea id="defaulterPresentAddree_1" name="citizen[2][1][presentAddress]" rows="5" class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="t3">
                                        <div class="panel panel-info radius-none ">
                                            {{--<div class="panel-heading radius-none">--}}
                                                {{--<h4 class="panel-title">@lang('message.guarantorBlockHeading')</h4>--}}
                                            {{--</div>--}}
                                            <div class="panel-body bg-info">
                                                <div class="clearfix">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantorName_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.guarantor')</label>
                                                                <input name="citizen[3][1][name]" id="guarantorName_1" class="form-control" value=""  >
                                                                <input type="hidden" name="citizen[3][1][type]"  class="form-control" value="3">
                                                                <input type="hidden" name="citizen[3][1][id]" id="guarantorId_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[3][1][email]" id="guarantorEmail_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[3][1][thana]" id="guarantorThana_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[3][1][upazilla]" id="guarantorUpazilla_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[3][1][age]" id="guarantorAge_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantorPhn_1" class="control-label">@lang('message.phn')</label>
                                                                <input name="citizen[3][1][phn]" id="guarantorPhn_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantorNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                                <input name="citizen[3][1][nid]" id="guarantorNid_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantorGender_1" class="control-label">@lang('message.gender')</label>
                                                                <select style="width: 100%;" class="selectDropdown form-control" name="citizen[3][1][gender]" id="guarantorGender_1">
                                                                    <option value="">@lang('message.emptyText')</option>
                                                                    <option value="MALE">@lang('message.male')</option>
                                                                    <option value="FEMALE">@lang('message.female')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantorFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                                <input name="citizen[3][1][father]" id="guarantorFather_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantorMother_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.mother')</label>
                                                                <input name="citizen[3][1][mother]" id="guarantorMother_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantorDesignation_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.designation')</label>
                                                                <input name="citizen[3][1][designation]" id="guarantorDesignation_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="guarantorOrganization_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.organization')</label>
                                                                <input name="citizen[3][1][organization]" id="guarantorOrganization_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="guarantorPresentAddree_1">@lang('message.presentAddress')</label>
                                                                <textarea id="guarantorPresentAddree_1" name="citizen[3][1][presentAddress]" rows="5" class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="t4">
                                        <div class="panel panel-info radius-none ">
                                            {{--<div class="panel-heading radius-none">--}}
                                                {{--<h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4>--}}
                                            {{--</div>--}}
                                            <div class="panel-body bg-info">
                                                <div class="clearfix">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lawyerName_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.lawyer')</label>
                                                                <input name="citizen[4][1][name]" id="lawyerName_1" class="form-control" value="" >
                                                                <input type="hidden" name="citizen[4][1][type]"  class="form-control" value="4">
                                                                <input type="hidden" name="citizen[4][1][id]" id="lawyerId_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[4][1][email]" id="lawyerEmail_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[4][1][thana]" id="lawyerThana_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[4][1][upazilla]" id="lawyerUpazilla_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[4][1][age]" id="lawyerAge_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lawyerPhn_1" class="control-label">@lang('message.phn')</label>
                                                                <input name="citizen[4][1][phn]" id="lawyerPhn_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lawyerNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                                <input name="citizen[4][1][nid]" id="lawyerNid_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lawyerGender_1" class="control-label">@lang('message.gender')</label>
                                                                <select style="width: 100%;" class="selectDropdown form-control" name="citizen[4][1][gender]" id="lawyerGender_1">
                                                                    <option value="">@lang('message.emptyText')</option>
                                                                    <option value="MALE">@lang('message.male')</option>
                                                                    <option value="FEMALE">@lang('message.female')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lawyerFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                                <input name="citizen[4][1][father]" id="lawyerFather_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lawyerMother_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.mother')</label>
                                                                <input name="citizen[4][1][mother]" id="lawyerMother_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lawyerDesignation_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.designation')</label>
                                                                <input name="citizen[4][1][designation]" id="lawyerDesignation_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lawyerOrganization_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.organization')</label>
                                                                <input name="citizen[4][1][organization]" id="lawyerOrganization_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="lawyerPresentAddree_1">@lang('message.presentAddress')</label>
                                                                <textarea id="lawyerPresentAddree_1" name="citizen[4][1][presentAddress]" rows="5" class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="t5">
                                        <div class="panel panel-info radius-none ">
                                            {{--<div class="panel-heading radius-none">--}}
                                            {{--<h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4>--}}
                                            {{--</div>--}}
                                            <div style="margin: 10px" id="accordion" role="tablist" aria-multiselectable="true" class="panel-group notesDiv">
                                                <section class="panel panel-primary nomineeInfo" id="nomineeInfo">
                                                    <div class="panel-heading" role="tab" id="headOne">
                                                        <h4 class="panel-title">
                                                            <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_1" aria-expanded="true">
                                                               (<span class="slNo">1</span>)  @lang('message.nomineeBlockHeading')<i class="fa fa-angle-down pull-right"></i>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_1" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="">
                                                        <div class="panel-body cpv p-10">
                                                            <div>
                                                                <div class="panel-body bg-info">
                                                                    <div class="clearfix">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="nomineeName_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nomineeName')</label>
                                                                                    <input name="citizen[5][1][name]" id="nomineeName_1" class="form-control" value="" >
                                                                                    <input type="hidden" name="citizen[5][1][type]"  class="form-control" value="5">
                                                                                    <input type="hidden" name="citizen[5][1][id]" id="nomineeId_1" class="form-control" value="">
                                                                                    <input type="hidden" name="citizen[5][1][email]" id="nomineeEmail_1" class="form-control" value="">
                                                                                    <input type="hidden" name="citizen[5][1][thana]" id="nomineeThana_1" class="form-control" value="">
                                                                                    <input type="hidden" name="citizen[5][1][upazilla]" id="nomineeUpazilla_1" class="form-control" value="">
                                                                                    <input type="hidden" name="citizen[5][1][designation]" id="nomineeDesignation_1" class="form-control" value="">
                                                                                    <input type="hidden" name="citizen[5][1][organization]" id="nomineeOrganization_1" class="form-control" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="nomineePhn_1" class="control-label">@lang('message.phn')</label>
                                                                                    <input name="citizen[5][1][phn]" id="nomineePhn_1" class="form-control" value="">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="nomineeNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                                                    <input name="citizen[5][1][nid]" id="nomineeNid_1" class="form-control" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="nomineeGender_1" class="control-label">@lang('message.gender')</label>
                                                                                    <select style="width: 100%;" class="selectDropdown form-control" name="citizen[5][1][gender]" id="nomineeGender_1">
                                                                                        <option value="">@lang('message.emptyText')</option>
                                                                                        <option value="MALE">@lang('message.male')</option>
                                                                                        <option value="FEMALE">@lang('message.female')</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="nomineeFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                                                    <input name="citizen[5][1][father]" id="nomineeFather_1" class="form-control" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="nomineeMother_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.mother')</label>
                                                                                    <input name="citizen[5][1][mother]" id="nomineeMother_1" class="form-control" value="">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="nomineeAge_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.age')</label>
                                                                                    <input name="citizen[5][1][age]" id="nomineeAge_1" class="form-control" value="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label for="nomineePresentAddree_1">@lang('message.presentAddress')</label>
                                                                                    <textarea id="nomineePresentAddree_1" name="citizen[5][1][presentAddress]" rows="5" class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                            <div style="text-align: right;margin: 10px;">
                                                <button type="button" class="btn btn-danger" onclick="appealUiUtils.deletNomineeInfo()">@lang('message.Delete')</button>
                                                <button type="button" class="btn btn-primary" onclick="appealUiUtils.addMoreNomineeInfo()" >@lang('message.nominee') @lang('message.Add')</button>
                                            </div>

                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="t6">
                                        <div class="panel panel-info radius-none ">
                                            {{--<div class="panel-heading radius-none">--}}
                                            {{--<h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4>--}}
                                            {{--</div>--}}
                                            <div class="panel-body bg-info">
                                                <div class="clearfix">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lawyerName_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.policeName')</label>
                                                                <input name="citizen[6][1][name]" id="policeName_1" class="form-control" value="" >
                                                                <input type="hidden" name="citizen[6][1][type]"  class="form-control" value="6">
                                                                <input type="hidden" name="citizen[6][1][id]" id="policeId_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[6][1][organization]" id="policeOrganization_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[6][1][age]" id="policeAge_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[6][1][mother]" id="policeMother_1" class="form-control" value="">
                                                                <input type="hidden" name="citizen[6][1][presentAddress]" id="policePresentAddree_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="policeFather_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.father')</label>
                                                                <input name="citizen[6][1][father]" id="policeFather_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="policeDesignation_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.designation')</label>
                                                                <input name="citizen[6][1][designation]" id="policeDesignation_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="policeNid_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.nid')</label>
                                                                <input name="citizen[6][1][nid]" id="policeNid_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="policeGender_1" class="control-label">@lang('message.gender')</label>
                                                                <select style="width: 100%;" class="selectDropdown form-control" name="citizen[6][1][gender]" id="policeGender_1">
                                                                    <option value="">@lang('message.emptyText')</option>
                                                                    <option value="MALE">@lang('message.male')</option>
                                                                    <option value="FEMALE">@lang('message.female')</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="policePhn_1" class="control-label">@lang('message.phn')</label>
                                                                <input name="citizen[6][1][phn]" id="policePhn_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="policeEmail_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.Email')</label>
                                                                <input name="citizen[6][1][email]" id="policeEmail_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="policeThana_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.thana')</label>
                                                                <input name="citizen[6][1][thana]" id="policeThana_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="policeUpazilla_1" class="control-label"><span style="color:#FF0000"></span>@lang('message.Upazilla')</label>
                                                                <input name="citizen[6][1][upazilla]" id="policeUpazilla_1" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <div class="panel panel-info radius-none">
                                <div class="panel-heading radius-none">
                                    <h4 class="panel-title">@lang('message.Karjokrom')</h4>
                                </div>
                                <div class="panel-body">
                                    {{--<div class="col-md-12">--}}
                                        <div class="form-group" id="initialNoteDiv">
                                            <label for="note">@lang('message.initialNote')</label>
                                            <textarea class="form-control note-control" id="note" name="note" rows="9"></textarea>
                                            <input type="hidden" name="noteId" id="noteId"  class="form-control" value="">
                                        </div>
                                    {{--</div>--}}

                                    {{--<div class="col-md-4">--}}
                                        <div class="form-group">
                                            <label for="gcoList" class="control-label"><span style="color:#FF0000"></span>@lang('message.gcoCourt')</label>
                                            <select style="width: 100%;" class="selectDropdown form-control select2 " id="gcoList" name="gcoList"></select>
                                        </div>
                                        <input type="hidden" name="causeListId" id="causeListId"  value="">


                                </div>
                            </div>

                            <div class="clearfix">
                                <div class="form-group">
                                    <div id="AttachedFile" class="panel panel-info"></div>
                                </div>
                            </div>

                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 class="panel-title">@lang('message.AttachmentTitle')
                                    <button type="button" class="btn btn-xs btn-primary multifileupload pull-right">
                                        <span><i class="fa fa-plus"></i> @lang('message.Attachments')</span>
                                    </button>
                                    </h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class=" photoContainer">

                                            <hr>
                                            <div class="docs-toggles">

                                            </div>
                                            <div class="docs-galley photoView">

                                            </div>
                                            <div class="docs-buttons" role="group"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row buttonsDiv">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{--<button type="button" onclick="appeal.cancel()" class="btn btn-danger">--}}
                                            {{--@lang('message.cancelForm')--}}
                                        {{--</button>--}}
                                        <button type="button" onclick="appeal.saveAsDraft()" class="btn btn-primary">
                                            @lang('message.Save')
                                        </button>
                                        <button type="button" onclick="appeal.sendToDM()" class="btn btn-warning">
                                            @lang('message.submitToDm')
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
<script>
    $(document).ready(function (){

        //Old Case Show/Hide
        $('input[type=radio][name=caseEntryType]').change(function() {
            if (this.value == 'NEW') {
                $("#prevCaseDiv").addClass("d-none");
            }
            else {
                $("#prevCaseDiv").removeClass("d-none");
            }
        });



    });
    function common_date(){
    $('.common_datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            orientation: "bottom left"
        });
  }
</script>
@endsection

