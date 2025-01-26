@extends('layouts.default')

@section('content')
    <!--begin::Row-->

    <style>
        .hide {
            display: none;
        }

        .show {
            display: block;
        }

        .waring-border-field {
            border: 2px solid tomato;
        }

        .warning-message-alert {
            color: red;
        }

        .waring-message-alert-success {
            color: aqua;
        }

        .waring-border-field-succes {
            border: 2px solid aqua;
        }
    </style>
    <div class="row">

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
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
                <form id="appealCase" action="{{ route('appeal.store') }}" class="form" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="appealId" value="{{ $appeal->id }}">
                    <input type="hidden" name="appealType" value="edit">
                    <div class="card-body">
                        <div class="row mb-8 ">
                            <div class="col-md-12">
                                <div class="example-preview">
                                    <ul class="nav nav-pills nav-fill">
                                        <li class="nav-item">
                                            <a class="nav-link px-0 active" id="regTab0" data-toggle="tab" href="#regTab_0">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">মামলার তথ্য</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab1" data-toggle="tab" href="#regTab_1">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">আবেদনকারীর তথ্য</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab2" data-toggle="tab" href="#regTab_2">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">ঋণগ্রহীতার তথ্য</span>
                                            </a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab4" data-toggle="tab" href="#regTab_4">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">আইনজীবীর তথ্য</span>
                                            </a>
                                        </li> -->
                                        @if(globalUserInfo()->role_id == 27)
                                        <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab5" data-toggle="tab" href="#regTab_5">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">উত্তরাধিকারীর তথ্য</span>
                                            </a>
                                        </li>
                                        @endif
                                        <!-- <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab6" data-toggle="tab" href="#regTab_6">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">জারিকারকের তথ্য </span>
                                            </a>
                                        </li> -->
                                    </ul>
                                    <hr>
                                    <div class="tab-content mt-5" id="myTabContent4">
                                        <div role="tabpanel" aria-labelledby="regTab0" class="tab-pane fade show active"
                                            id="regTab_0">
                                            <div class="panel panel-info radius-none">
                                                <div class="panel-body">
                                                    <div class="clearfix">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                {{-- <div class="form-group">
                                                                    <label for="caseEntryType" class="control-label"> মামলার ধরন </label>
                                                                    <div class="radio">
                                                                        <label class="mr-5">
                                                                           
                                                                            <input type="radio" id="new" class="caseEntryType mr-2" value="NEW"
                                                                                
                                                                                name="caseEntryType" {{ ($appeal->case_entry_type == 'NEW')? "checked" : "disabled" }} >নতুন মামলা
                                                                        </label>
                                                                        <label>
                                                                            <input type="radio" id="oldCaseRadio" class="caseEntryType  mr-2"
                                                                                value="OLD" name="caseEntryType"
                                                                             {{ ($appeal->case_entry_type == 'OLD')? "checked" : "disabled" }}  >পুরাতন মামলা
                                                                        </label>
                                                                    </div>
                                                                </div> --}}
                                                            </div>
                                                            <div class="col-md-6 {{ $appeal->case_entry_type == 'OLD' ? '' : 'd-none' }}" id="prevCaseDiv">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label for="previouscaseNo" class="control-label">পূর্ববর্তী মামলা
                                                                            নম্বর</label>
                                                                        <input type="text" name="previouscaseNo" id="previouscaseNo"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ $appeal->prev_case_no ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="caseNo" class="control-label">মামলা নম্বর</label>
                                                                    <input name="caseNo" id="caseNo" class="form-control form-control-sm"
                                                                        value="{{ $appeal->case_no ?? '' }}" readonly/>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>আবেদনের তারিখ  <span class="text-danger">*</span></label>
                                                                    <input type="text" name="caseDate" id="case_date"
                                                                        value="{{ en2bn(date('d-m-Y', strtotime($appeal->case_date)) ) }}"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="দিন/মাস/তারিখ" autocomplete="off" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="lawSection" class="control-label">সংশ্লিষ্ট আইন ও ধারা</label>
                                                                    <input name="lawSection" id="lawSection" class="form-control form-control-sm"
                                                                        value="{{ $appeal->law_section ?? '' }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            {{-- @dd($appeal) --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="totalLoanAmount" class="control-label"><span style="color:#FF0000">*
                                                                        </span>দাবিকৃত অর্থের পরিমাণ</label>
                                                                    <input type="text" name="totalLoanAmount" id="totalLoanAmount"
                                                                        class="form-control form-control-sm" value="{{ en2bn($appeal->loan_amount) ?? '' }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="totalLoanAmountText" class="control-label">দাবিকৃত অর্থের পরিমাণ
                                                                        (কথায়)</label>
                                                                    <input readonly="readonly" type="text" name="totalLoanAmountText"
                                                                        id="totalLoanAmountText" class="form-control form-control-sm"
                                                                        value="{{ $appeal->loan_amount_text ?? '' }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(globalUserInfo()->role_id == 28)
                                                            <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="comment" class="control-label">মন্তব্য </label>
                                                                            <textarea  type="text" name="comment"
                                                                            id="comment" class="form-control form-control-sm"
                                                                            placeholder="এইখানে মন্তব্য লিখুন " rows="3">{{ $appeal->comment ?? '' }}</textarea>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        @elseif(globalUserInfo()->role_id == 27 && !empty($appeal->comment))
                                                            <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="comment" class="control-label">সার্টিফিকেট সহকারীর মন্তব্য </label>
                                                                            <textarea  type="text" name="comment"
                                                                            id="comment" class="form-control form-control-sm"
                                                                            placeholder="এইখানে মন্তব্য লিখুন " rows="3" readonly="readonly">{{ $appeal->comment ?? '' }}</textarea>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" aria-labelledby="regTab1" class="tab-pane fade" id="regTab_1">
                                            <div class="panel panel-info radius-none">
                                                <div style="margin: 10px" id="accordion" role="tablist"
                                                    aria-multiselectable="true" class="panel-group notesDiv">
                                                    <section class="panel panel-primary applicantInfo" id="applicantInfo">
                                                        <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                                            @forelse ($applicantCitizen as $key => $item)
                                                                @php
                                                                    $count = ++$key;
                                                                @endphp
                                                                <div id="cloneApplicant" class="card">
                                                                    <input type="hidden" id="ApplicantCount" value="1">
                                                                    <div class="card-header" id="headingOne3">
                                                                        <div class="card-title h4 {{ $count == 1 ? '' : 'collapsed' }}" data-toggle="collapse" data-target="#collapseOne3{{ $count }}">
                                                                            আবেদনকারীর তথ্য &nbsp; <span id="spannCount">({{ $count }})</span>
                                                                        </div>
                                                                    </div>
                                                                    <div id="collapseOne3{{ $count }}" class="collapse {{ $count == 1 ? 'show' : '' }}"
                                                                        data-parent="#accordionExample3">
                                                                        <div class="card-body">
                                                                            <div class="clearfix">
                                                                                
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantName_1"
                                                                                                class="control-label">আবেদনকারীর নাম</label>
                                                                                            <input name="applicant[name][]" id="applicantName_1"
                                                                                                class="form-control form-control-sm name-group" value="{{ $item->citizen_name ?? ''}}" readonly>
                                                                                            <input type="hidden" name="applicant[type][]"
                                                                                                class="form-control form-control-sm" value="1">
                                                                                            <input type="hidden" name="applicant[id][]"
                                                                                                id="applicantId_1" class="form-control form-control-sm" value="{{ $item->id ?? ''}}">
                                                                                            <input type="hidden" name="applicant[thana][]"
                                                                                                id="applicantThana_1" class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden" name="applicant[upazilla][]"
                                                                                                id="applicantUpazilla_1" class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden" name="applicant[age][]"
                                                                                                id="applicantAge_1" class="form-control form-control-sm"
                                                                                                value="">
                                                                                        </div>
                                                                                    </div>
                                                                                     <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantOrganizationID_1"
                                                                                                class="control-label"> প্রাতিষ্ঠানিক আইডি </label>
                                                                                            <input name="applicant[organization_id][]"
                                                                                                id="applicantOrganizationID_1"
                                                                                                class="form-control form-control-sm name-group" value="{{ $item->organization_id ?? ''}}" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantDesignation_1"
                                                                                                class="control-label">পদবি</label>
                                                                                            <input name="applicant[designation][]"
                                                                                                id="applicantDesignation_1"
                                                                                                class="form-control form-control-sm name-group" value="{{ $item->designation ?? ''}}" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantOrganization_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span> প্রতিষ্ঠানের নাম</label>
                                                                                            <input name="applicant[organization][]"
                                                                                                id="applicantOrganization_1" class="form-control form-control-sm"
                                                                                                value="{{ $item->organization ?? ''}}"
                                                                                                onchange="appealUiUtils.changeInitialNote();" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantType" class="control-label"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span>প্রতিষ্ঠানের ধরন
                                                                                            </label>
                                                                                            <br>

                                                                                            <select style="width: 100%;"
                                                                                            class="selectDropdown form-control form-control-sm" name="applicant_organization[Type][0]">
                                                                                            
                                                                                            
                                                                                            <option value="BANK"  {{ $appeal->applicant_type == 'BANK' ? 'selected' : 'disabled'}}  >ব্যাংক</option>
                                                                                            <option value="GOVERNMENT" {{ $appeal->applicant_type == 'GOVERNMENT' ? 'selected' : 'disabled'}} >সরকারি প্রতিষ্ঠান</option>
                                                                                            <option value="OTHER_COMPANY" {{ $appeal->applicant_type == 'OTHER_COMPANY' ? 'selected' : 'disabled'}} >স্বায়ত্তশাসিত প্রতিষ্ঠান</option>
                                                                                            </select>
                                                                                     
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantGender_1"
                                                                                                class="control-label">লিঙ্গ</label>
                                                                                            <select style="width: 100%;"
                                                                                                class="selectDropdown form-control form-control-sm"
                                                                                                name="applicant[gender][]" id="applicantGender_1">
                                                                                                
                                                                                                <option value="MALE"  {{ $item->citizen_gender == 'MALE' ? 'selected' : 'disabled'}}  >পুরুষ</option>
                                                                                                <option value="FEMALE" {{ $item->citizen_gender == 'FEMALE' ? 'selected' : 'disabled'}} >নারী</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantFather_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>পিতার নাম</label>
                                                                                            <input name="applicant[father][]"
                                                                                                id="applicantFather_1" class="form-control form-control-sm"
                                                                                                value="{{ $item->father?? '' }}" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantMother_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>মাতার নাম</label>
                                                                                            <input name="applicant[mother][]"
                                                                                                id="applicantMother_1" class="form-control form-control-sm"
                                                                                                value="{{ $item->mother?? '' }}" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantNid_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>জাতীয় পরিচয়
                                                                                                পত্র</label>
                                                                                            <input name="applicant[nid][]" id="applicantNid_1" class="form-control form-control-sm" value="{{ $item->citizen_NID?? '' }}" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantPhn_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span>মোবাইল</label>
                                                                                            <input name="applicant[phn][]" id="applicantPhn_1"
                                                                                                class="form-control form-control-sm" value="{{ $item->citizen_phone_no?? '' }}" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantPresentAddree_1"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span>প্রতিষ্ঠানের ঠিকানা</label>
                                                                                            <textarea id="applicantPresentAddree_1"
                                                                                                name="applicant[presentAddress][]" rows="1"
                                                                                                class="form-control element-block blank"
                                                                                                aria-describedby="note-error"
                                                                                                aria-invalid="false" readonly>{{ $item->present_address ?? '' }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantEmail_1"><span
                                                                                                    style="color:#ff0000d8">*
                                                                                                </span>ইমেইল</label>
                                                                                                <input type="email" name="applicant[email][]"
                                                                                                id="applicantEmail_1" class="form-control form-control-sm"
                                                                                                value="{{ $item->email ?? '' }}" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                            @endforelse
                                                        </div>
                                                    </section>
                                                </div>

                                                {{-- <div style="text-align: right;margin: 10px;">
                                                    <button type="button" id="RemoveApplicant" class="btn btn-danger">
                                                        বাতিল
                                                    </button>
                                                    <button id="AddApplicant" type="button" class="btn btn-primary">
                                                        আবেদনকারী যোগ করুন
                                                    </button>
                                                </div> --}}
                                            </div>
                                        </div>

                                       


                                        <div role="tabpanel" aria-labelledby="regTab2" class="tab-pane fade"
                                            id="regTab_2">
                                            <div class="panel panel-info radius-none">
                                                {{-- <div class="panel-heading radius-none"> --}}
                                                {{-- <h4 class="panel-title">@lang('message.defaulterBlockHeading')</h4> --}}
                                                {{-- </div> --}}
                                                <div class="panel-body">
                                                    <div class="clearfix">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterName_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ঋণগ্রহীতার নাম</label>
                                                                    <input name="defaulter[name]" id="defaulterName_1" class="form-control form-control-sm" value="{{ $defaulterCitizen->citizen_name ?? '' }}" readonly>
                                                                    <input type="hidden" name="defaulter[type]"
                                                                        class="form-control form-control-sm" value="2">
                                                                    <input type="hidden" name="defaulter[id]"
                                                                        id="defaulterId_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->id ?? '' }}">
                                                                    <input type="hidden" name="defaulter[email]"
                                                                        id="defaulterEmail_1"
                                                                        class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="defaulter[thana]"
                                                                        id="defaulterThana_1"
                                                                        class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="defaulter[upazilla]"
                                                                        id="defaulterUpazilla_1"
                                                                        class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="defaulter[age]"
                                                                        id="defaulterAge_1"
                                                                        class="form-control form-control-sm" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterPhn_1"
                                                                        class="control-label">মোবাইল</label>
                                                                    <input name="defaulter[phn]" id="defaulterPhn_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->citizen_phone_no ?? ''}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterNid_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>জাতীয় পরিচয়
                                                                        পত্র</label>
                                                                    <input name="defaulter[nid]" id="defaulterNid_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->citizen_NID ?? ''}}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterGender_1"
                                                                        class="control-label">লিঙ্গ</label>
                                                                    <select style="width: 100%;"
                                                                        class="selectDropdown form-control form-control-sm form-control-sm"
                                                                        name="defaulter[gender]" id="defaulterGender_1">
                                                                       
                                                                        <option value="MALE" {{ $defaulterCitizen->citizen_gender == 'MALE' ? 'selected' : 'disabled'}}  >পুরুষ</option>
                                                                        <option value="FEMALE" {{ $defaulterCitizen->citizen_gender == 'FEMALE' ? 'selected' : 'disabled'}}  >নারী</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <input name="defaulter[organization_id]" id="defaulterOrganizationID_1" type="hidden">
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterFather_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                                    <input name="defaulter[father]" id="defaulterFather_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->father ?? '' }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterMother_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>মাতার নাম</label>
                                                                    <input name="defaulter[mother]" id="defaulterMother_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->mother ?? '' }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterDesignation_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000">*
                                                                        </span>পদবি / পেশা</label>
                                                                    <input name="defaulter[designation]"
                                                                        id="defaulterDesignation_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->designation ?? '' }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterOrganization_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>প্রতিষ্ঠানের
                                                                        নাম</label>
                                                                    <input name="defaulter[organization]"
                                                                        id="defaulterOrganization_1"
                                                                        class="form-control form-control-sm" value="{{ $defaulterCitizen->organization ?? '' }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterPresentAddree_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ঠিকানা</label>
                                                                    <textarea id="defaulterPresentAddree_1"
                                                                        name="defaulter[presentAddress]" rows="5"
                                                                        class="form-control element-block blank"
                                                                        aria-describedby="note-error"
                                                                        aria-invalid="false" readonly>{{ $defaulterCitizen->present_address ?? '-' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterEmail_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ইমেইল</label>
                                                                        <input type="email" name="defaulter[email]"
                                                                        id="defaulterEmail_1" class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->email ?? '-' }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                       <!--  <div role="tabpanel" aria-labelledby="regTab4" class="tab-pane fade"
                                            id="regTab_4">
                                            <div class="panel panel-info radius-none ">
                                                {{-- <div class="panel-heading radius-none"> --}}
                                                {{-- <h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4> --}}
                                                {{-- </div> --}}
                                                <div class="panel-body">
                                                    <div class="clearfix">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawyerName_1" class="control-label"><span
                                                                            style="color:#FF0000"></span>আইনজীবীর
                                                                        নাম</label>
                                                                    <input name="lawyer[name]" id="lawyerName_1"
                                                                        class="form-control form-control-sm" value="{{ $lawerCitizen->citizen_name ?? '' }}">
                                                                    <input type="hidden" name="lawyer[type]"
                                                                        class="form-control form-control-sm" value="4">
                                                                    <input type="hidden" name="lawyer[id]" id="lawyerId_1"
                                                                        class="form-control form-control-sm" value="{{ $lawerCitizen->id ?? '' }}">
                                                                    <input type="hidden" name="lawyer[email]"
                                                                        id="lawyerEmail_1"
                                                                        class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="lawyer[thana]"
                                                                        id="lawyerThana_1"
                                                                        class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="lawyer[upazilla]"
                                                                        id="lawyerUpazilla_1"
                                                                        class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="lawyer[age]" id="lawyerAge_1"
                                                                        class="form-control form-control-sm" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawyerPhn_1"
                                                                        class="control-label">মোবাইল</label>
                                                                    <input name="lawyer[phn]" id="lawyerPhn_1"
                                                                        class="form-control form-control-sm" value="{{ $lawerCitizen->citizen_phone_no ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawyerNid_1" class="control-label"><span
                                                                            style="color:#FF0000"></span>জাতীয় পরিচয়
                                                                        পত্র</label>
                                                                    <input name="lawyer[nid]" id="lawyerNid_1"
                                                                        class="form-control form-control-sm" value="{{ $lawerCitizen->citizen_NID ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="lawyerGender_1" class="control-label">নারী
                                                                        / পুরুষ</label>
                                                                    <select style="width: 100%;"
                                                                        class="selectDropdown form-control form-control-sm form-control-sm"
                                                                        name="lawyer[gender]" id="lawyerGender_1">
                                                                        <option value="">বাছাই করুন</option>
                                                                        <option value="MALE" {{ isset($lawerCitizen->citizen_gender) == 'MALE' ? 'selected' : ''}}>পুরুষ</option>
                                                                        <option value="FEMALE" {{ isset($lawerCitizen->citizen_gender) == 'FEMALE' ? 'selected' : ''}}>নারী</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="applicantOrganizationID_1"
                                                                        class="control-label"> <span
                                                                            style="color:#FF0000">*</span>প্রাতিষ্ঠানিক আইডি </label>
                                                                    <input name="lawyer[organization_id]"
                                                                        id="lawyerOrganizationID_1"
                                                                        class="form-control form-control-sm name-group" value="" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawyerFather_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                                    <input name="lawyer[father]" id="lawyerFather_1"
                                                                        class="form-control form-control-sm" value="{{ $lawerCitizen->father ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawyerMother_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>মাতার নাম</label>
                                                                    <input name="lawyer[mother]" id="lawyerMother_1"
                                                                        class="form-control form-control-sm" value="{{ $lawerCitizen->mother ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawyerDesignation_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>পদবি</label>
                                                                    <input name="lawyer[designation]"
                                                                        id="lawyerDesignation_1"
                                                                        class="form-control form-control-sm" value="{{ $lawerCitizen->designation ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawyerOrganization_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>প্রতিষ্ঠানের
                                                                        নাম</label>
                                                                    <input name="lawyer[organization]"
                                                                        id="lawyerOrganization_1"
                                                                        class="form-control form-control-sm" value="{{ $lawerCitizen->organization ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawyerPresentAddree_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ঠিকানা</label>
                                                                    <textarea id="lawyerPresentAddree_1"
                                                                        name="lawyer[presentAddress]" rows="1"
                                                                        class="form-control element-block blank"
                                                                        aria-describedby="note-error"
                                                                        aria-invalid="false">{{ $lawerCitizen->present_address ?? '-' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawyerEmail_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ইমেইল</label>
                                                                        <input type="email" name="lawyer[email]"
                                                                        id="lawyerEmail_1" class="form-control form-control-sm"
                                                                        value="{{ $lawerCitizen->email ?? '-' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        @if(globalUserInfo()->role_id == 27 )
                                        
                                        <div role="tabpanel" aria-labelledby="regTab5" class="tab-pane fade"
                                            id="regTab_5">
                                            <div class="panel panel-info radius-none ">

                                                {{-- <div class="panel-heading radius-none"> --}}
                                                {{-- <h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4> --}}
                                                {{-- </div> --}}
                                                <div style="margin: 10px" id="accordion" role="tablist"
                                                    aria-multiselectable="true" class="panel-group notesDiv">
                                                    <section class="panel panel-primary nomineeInfo" id="nomineeInfo">
                                                        <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                                            <input type="hidden" id="NomineeCount" value="{{ count($nomineeCitizen) }}">
                                                            @forelse ($nomineeCitizen as $key => $item)
                                                                @php
                                                                    $count = ++$key;
                                                                @endphp
                                                                <div id="cloneNomenee" class="card">
                                                                    <div class="card-header" id="headingOne3">
                                                                        <div class="card-title h4 {{ $count == 1 ? '' : 'collapsed' }}" data-toggle="collapse"
                                                                            data-target="#collapseOne3{{ $count }}">
                                                                            উত্তরাধিকারীর তথ্য &nbsp; <span id="spannCount">({{ $count }})</span>
                                                                        </div>
                                                                    </div>
                                                                    <div id="collapseOne3{{ $count }}" class="collapse {{ $count == 1 ? 'show' : '' }} "
                                                                        data-parent="#accordionExample3">
                                                                        <div class="card-body">
                                                                            <div class="clearfix">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeName_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000">*</span>উত্তরাধিকারীর
                                                                                                নাম</label>
                                                                                            <input name="nominee[name][]"
                                                                                                id="nomineeName_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->citizen_name }}" required>
                                                                                            <input type="hidden"
                                                                                                name="nominee[type][]"
                                                                                                class="form-control form-control-sm"
                                                                                                value="5">
                                                                                            <input type="hidden"
                                                                                                name="nominee[id][]"
                                                                                                id="nomineeId_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->id }}">
                                                                                            <input type="hidden"
                                                                                                name="nominee[email][]"
                                                                                                id="nomineeEmail_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden"
                                                                                                name="nominee[thana][]"
                                                                                                id="nomineeThana_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden"
                                                                                                name="nominee[upazilla][]"
                                                                                                id="nomineeUpazilla_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden"
                                                                                                name="nominee[designation][]"
                                                                                                id="nomineeDesignation_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input type="hidden"
                                                                                                name="nominee[organization][]"
                                                                                                id="nomineeOrganization_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineePhn_1"
                                                                                                class="control-label"><span
                                                                                                style="color:#FF0000">*</span>মোবাইল</label>
                                                                                            <input name="nominee[phn][]"
                                                                                                id="nomineePhn_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->citizen_phone_no }}" required>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeNid_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000">*</span>জাতীয়
                                                                                                পরিচয় পত্র</label>
                                                                                            <input name="nominee[nid][]"
                                                                                                id="nomineeNid_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->citizen_NID }}" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeGender_1"
                                                                                                class="control-label">নারী /
                                                                                                পুরুষ</label>
                                                                                            <select style="width: 100%;"
                                                                                                class="selectDropdown form-control form-control-sm"
                                                                                                name="nominee[gender][]"
                                                                                                id="nomineeGender_1">
                                                                                                <option value="">
                                                                                                    বাছাই করুন</option>
                                                                                                <option value="MALE" {{ $item->citizen_gender == 'MALE' ? 'selected' : 'disabled' }}> পুরুষ</option>
                                                                                                <option value="FEMALE" {{ $item->citizen_gender == 'FEMALE' ? 'selected' : 'disabled' }}> নারী</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input name="nominee[organization_id][]" id="nomineeOrganizationID_1" type="hidden">
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeFather_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>পিতার
                                                                                                নাম</label>
                                                                                            <input name="nominee[father][]"
                                                                                                id="nomineeFather_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->father }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeMother_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>মাতার
                                                                                                নাম</label>
                                                                                            <input name="nominee[mother][]"
                                                                                                id="nomineeMother_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->mother }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nomineeAge_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>বয়স</label>
                                                                                            <input name="nominee[age][]"
                                                                                                id="nomineeAge_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->age }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="nomineePresentAddree_1"><span
                                                                                                style="color:#FF0000">*</span>ঠিকানা</label>
                                                                                            <textarea
                                                                                                id="nomineePresentAddree_1"
                                                                                                name="nominee[presentAddress][]"
                                                                                                rows="3"
                                                                                                class="form-control form-control-sm element-block blank"
                                                                                                aria-describedby="note-error"
                                                                                                aria-invalid="false" required>{{ $item->presentAddress }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                            <div id="cloneNomenee" class="card">
                                                                <input type="hidden" id="NomineeCount" value="1">
                                                                <div class="card-header" id="headingOne3">
                                                                    <div class="card-title h4" data-toggle="collapse"
                                                                        data-target="#collapseOne3">
                                                                        উত্তরাধিকারীর তথ্য &nbsp; <span
                                                                            id="spannCount">(1)</span>
                                                                    </div>
                                                                </div>
                                                                <div id="collapseOne3" class="collapse show"
                                                                    data-parent="#accordionExample3">
                                                                    <div class="card-body">
                                                                        <div class="clearfix">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="text-dark font-weight-bold">
                                                                                    <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <input required type="text" {{-- id="applicantCiNID_1" --}} class="form-control check_nid_number_1" data-nomineerow-index='1' placeholder="উদাহরণ- 19825624603112948" id="nominee_nid_input_1" onclick="addDatePicker(this.id)">
                                                                                        <span id="res_applicant_1"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <div class="input-group">
                                                                                            <input required type="text" id="nominee_dob_input_1" placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী) বছর/মাস/তারিখ" {{-- id="dob" --}} class="form-control common_datepicker_1" autocomplete="off" data-nomineerow-index='0' >

                                                                                            <input type="button" id="nominee_nid_1" data-nomineerow-index='1' class="btn btn-primary check_nid_button" onclick="NIDCHECKnominee(this.id)" value="সন্ধান করুন">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="nomineeName_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000">*</span>উত্তরাধিকারীর
                                                                                            নাম</label>
                                                                                        <input name="nominee[name][]"
                                                                                            id="nomineeName_1"
                                                                                            class="form-control form-control-sm validation"
                                                                                            value="" >
                                                                                        <div class="required_message hide">This Field is required</div>
                                                                                        <input type="hidden"
                                                                                            name="nominee[type][]"
                                                                                            class="form-control form-control-sm"
                                                                                            value="5">
                                                                                        <input type="hidden"
                                                                                            name="nominee[id][]"
                                                                                            id="nomineeId_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                        <input type="hidden"
                                                                                            name="nominee[thana][]"
                                                                                            id="nomineeThana_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                        <input type="hidden"
                                                                                            name="nominee[upazilla][]"
                                                                                            id="nomineeUpazilla_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                        <input type="hidden"
                                                                                            name="nominee[designation][]"
                                                                                            id="nomineeDesignation_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                        <input type="hidden"
                                                                                            name="nominee[organization][]"
                                                                                            id="nomineeOrganization_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="nomineePhn_1"
                                                                                            class="control-label"><span
                                                                            style="color:#FF0000">*</span>মোবাইল</label>
                                                                                        <input name="nominee[phn][]"
                                                                                            id="nomineePhn_1"
                                                                                            class="form-control form-control-sm phone validation"
                                                                                            value="" required>
                                                                                        <div class="required_message hide">This Field is required</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                              
                                                                            </div>   
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="nomineeNid_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000">*</span>জাতীয়
                                                                                            পরিচয় পত্র</label>
                                                                                        <input name="nominee[nid][]"
                                                                                            id="nomineeNid_1"
                                                                                            class="form-control form-control-sm validation"
                                                                                            value="" required>
                                                                                        <div class="required_message hide">This Field is required</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="nomineeGender_1"
                                                                                            class="control-label">নারী /
                                                                                            পুরুষ</label>
                                                                                        <select style="width: 100%;"
                                                                                            class="selectDropdown form-control"
                                                                                            name="nominee[gender][]"
                                                                                            id="nomineeGender_1">
                                                                                            <option value="">
                                                                                                বাছাই করুন</option>
                                                                                            <option value="MALE">
                                                                                                পুরুষ</option>
                                                                                            <option value="FEMALE">
                                                                                                নারী</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                                                                <input name="nominee[organization_id][]" id="nomineeOrganizationID_1" type="hidden">

                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="nomineeFather_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000"></span>পিতার নাম</label>
                                                                                        <input name="nominee[father][]"
                                                                                            id="nomineeFather_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="nomineeMother_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000"></span>মাতার
                                                                                            নাম</label>
                                                                                        <input name="nominee[mother][]"
                                                                                            id="nomineeMother_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="nomineeAge_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000"></span>বয়স</label>
                                                                                        <input name="nominee[age][]"
                                                                                            id="nomineeAge_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                                {{-- <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="nomineePresentAddree_1">ঠিকানা</label>
                                                                                        <textarea
                                                                                            id="nomineePresentAddree_1"
                                                                                            name="nominee[presentAddress][]"
                                                                                            rows="1"
                                                                                            class="form-control form-control-sm element-block blank"
                                                                                            aria-describedby="note-error"
                                                                                            aria-invalid="false"></textarea>
                                                                                    </div>
                                                                                </div> --}}
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="nomineeEmail_1"><span
                                                                                                style="color:#FF0000">*
                                                                                            </span>ইমেইল</label>
                                                                                            <input type="email" name="nominee[email][]" id="nomineeEmail_1" class="form-control form-control-sm validation email" value="">
                                                                                            <div class="required_message hide">This Field is required</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="nomineePresentAddree_1"><span
                                                                                                style="color:#FF0000">*
                                                                                            </span>ঠিকানা</label>
                                                                                        <textarea id="nomineePresentAddree_1"
                                                                                            name="nominee[presentAddress][]" rows="3"
                                                                                            class="form-control element-block blank validation"
                                                                                            aria-describedby="note-error"
                                                                                            aria-invalid="false" ></textarea>
                                                                                            <div class="required_message hide">This Field is required</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforelse


                                                        </div>
                                                    </section>
                                                </div>
                                                <div style="text-align: right;margin: 10px;">
                                                    <button type="button" id="RemoveNominee" class="btn btn-danger">
                                                        বাতিল
                                                    </button>
                                                    <button id="AddNominee" type="button" class="btn btn-primary">
                                                        উত্তরাধিকারী যোগ করুন
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                        @endif
                                        <!-- <div role="tabpanel" aria-labelledby="regTab6" class="tab-pane fade"
                                            id="regTab_6">
                                            <div class="panel panel-info radius-none ">
                                                {{-- <div class="panel-heading radius-none"> --}}
                                                {{-- <h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4> --}}
                                                {{-- </div> --}}
                                                <div class="panel-body">
                                                    <div class="clearfix">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="text-dark font-weight-bold h4">
                                                                <label for="">নাগরিক সন্ধান করুন </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input required type="text" class="form-control" placeholder="Enter NID No." name="issuer[ciNID]" value="{{ $issuerCitizen->nid ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input required type="text" name="issuer[dob]" placeholder="Enter Date of Birth" id="dob" class="form-control common_datepicker" autocomplete="off" value="{{ $issuerCitizen->dob ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="button" name="issuer[cCheck]" onclick="checkCitizen('issuer')" class="btn btn-danger" value="সন্ধান করুন"> <span class="ml-5" id="res_issuer"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group" id="issuer_nidPic"></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawyerName_1" class="control-label"><span
                                                                            style="color:#FF0000"></span>জারিকারকের নাম</label>
                                                                    <input name="issuer[name]" id="issuerName_1"
                                                                        class="form-control form-control-sm" value="{{ $issuerCitizen->citizen_name ?? '' }}">
                                                                    <input type="hidden" name="issuer[type]"
                                                                        class="form-control form-control-sm" value="7">
                                                                    <input type="hidden" name="issuer[id]"
                                                                        id="issuerId_1" class="form-control form-control-sm" value="{{ $issuerCitizen->id ?? '' }}">
                                                                    <input type="hidden"
                                                                        name="issuer[thana]"
                                                                        id="issuerThana_1"
                                                                        class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="issuer[upazilla]"
                                                                        id="issuerUpazilla_1"
                                                                        class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="issuer[designation]"
                                                                        id="issuerDesignation_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $issuerCitizen->designation ?? '' }}">
                                                                    <input type="hidden" name="issuer[organization]"
                                                                        id="issuerOrganization_1" class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden" name="issuer[age]"
                                                                        id="issuerAge_1" class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="issuer[mother]"
                                                                        id="issuerMother_1" class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="issuer[presentAddress]"
                                                                        id="issuerPresentAddree_1" class="form-control form-control-sm"
                                                                        value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="issuerFather_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                                    <input name="issuer[father]" id="issuerFather_1"
                                                                        class="form-control form-control-sm" value="{{ $issuerCitizen->father ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="issuerNid_1" class="control-label"><span
                                                                            style="color:#FF0000"></span>জাতীয় পরিচয়
                                                                        পত্র</label>
                                                                    <input name="issuer[nid]" id="issuerNid_1"
                                                                        class="form-control form-control-sm" value="{{ $issuerCitizen->nid ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="issuerGender_1" class="control-label">নারী
                                                                        / পুরুষ</label>
                                                                    <select style="width: 100%;"
                                                                        class="selectDropdown form-control"
                                                                        name="issuer[gender]" id="issuerGender_1">
                                                                        <option value="">বাছাই করুন</option>
                                                                        <option {{ isset($issuerCitizen->citizen_gender) == 'MALE' ? 'selected' : '' }} value="MALE">পুরুষ</option>
                                                                        <option {{ isset($issuerCitizen->citizen_gender) == 'FEMALE' ? 'selected' : '' }} value="FEMALE">নারী</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="applicantOrganizationID_1"
                                                                        class="control-label"> প্রাতিষ্ঠানিক আইডি </label>
                                                                    <input name="issuer[organization_id]"
                                                                        id="issuerOrganizationID_1"
                                                                        class="form-control form-control-sm name-group" value="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="issuerPhn_1"
                                                                        class="control-label">মোবাইল</label>
                                                                    <input name="issuer[phn]" id="issuerPhn_1"
                                                                        class="form-control form-control-sm" value="{{ $issuerCitizen->citizen_phone_no ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="issuerEmail_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ইমেইল</label>
                                                                        <input type="email" name="issuer[email]" id="issuerEmail_1" class="form-control form-control-sm" value="{{ $issuerCitizen->email ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="issuerPresentAddree_1">ঠিকানা</label>
                                                                    <textarea
                                                                        id="issuerPresentAddree_1"
                                                                        name="issuer[presentAddress]"
                                                                        rows="1"
                                                                        class="form-control form-control-sm element-block blank"
                                                                        aria-describedby="note-error"
                                                                        aria-invalid="false">{{ $issuerCitizen->present_address ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(globalUserInfo()->role_id != 28)
                        <fieldset class="mb-8 p-7">
                            <legend>কার্যক্রম</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- <div class="example-preview"> --}}
                                    <div class="panel panel-info radius-none">
                                        {{-- <div class="panel-heading radius-none">
                                            <h4 class="panel-title">কার্যক্রম</h4>
                                        </div>
                                        <hr> --}}

                                        
                                        
                                        <div class="panel-body">
                                            
                                            @forelse ($notes as  $note)
                                            @php
                                                    // dd($note)
                                                    @endphp
                                                <div class="form-group" id="initialNoteDiv">
                                                    <label for="note">রিকুইজিশন নোট</label>
                                                    <textarea class="form-control note-control" id="note" name="note"
                                                    rows="5">{{ $note->order_text }}</textarea>
                                                    <input type="hidden" name="noteId" id="noteId" class="form-control form-control-sm" value="{{ $note->id ?? '' }}">
                                                </div>
                                                @empty
                                                <div class="form-group" id="initialNoteDiv">
                                                    <label for="note">রিকুইজিশন নোট</label>
                                                    <textarea class="form-control note-control" id="note" name="note"
                                                    rows="5"></textarea>
                                                    <input type="hidden" name="noteId" id="noteId"
                                                    class="form-control form-control-sm" value="">
                                                </div>
                                                @endforelse
                                                
                                                {{-- </div> --}}
                                                
                                                {{-- <div class="col-md-4"> --}}
                                                    
                                                    <input type="hidden" name="causeListId" id="causeListId" value="{{ $appealCauseList[0]->id ?? '' }}">
                                                    
                                                    
                                                </div>
                                            </div>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                </fieldset>
                                @endif
                        <fieldset class=" mb-8">
                            <div class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0 mb-2">
                                <div class="d-flex align-items-center mr-2 py-2">
                                    <h3 class="mb-0 mr-8">সংযুক্তি</h3>
                                </div>
                            </div>
                                @forelse ($attachmentList as $key => $row)
                                    <div class="form-group mb-2" id="deleteFile{{ $row->id }}">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn bg-success-o-75" type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                            </div>
                                            {{-- <input readonly type="text" class="form-control" value="{{ asset($row->file_path . $row->file_name) }}" /> --}}
                                            <input readonly type="text" class="form-control" value="{{ $row->file_category ?? '' }}" />
                                            <div class="input-group-append">
                                                <a href="{{ asset($row->file_path . $row->file_name) }}" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left">
                                                    <i class="fa fas fa-file-pdf"></i>
                                                    <b>দেখুন</b>
                                                    {{-- <embed src="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" type="application/pdf" width="100%" height="600px" />  --}}
                                                 </a>
                                                {{-- <a href="minarkhan.com" class="btn btn-success" type="button">দেখুন </a> --}}
                                            </div>
                                            <div class="input-group-append">
                                                <a href="javascript:void(0);" id="" onclick="deleteFile({{ $row->id }},{{ $id }} )" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                    <b>মুছুন</b>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                <div class="pt-5">
                                    <p class="text-center font-weight-normal font-size-lg">কোনো সংযুক্তি খুঁজে পাওয়া যায়নি</p>
                                </div>
                                @endforelse
                        </fieldset>
                        <fieldset class=" mb-8">
                            <div
                                class="rounded bg-success-o-100 d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                                <div class="d-flex align-items-center mr-2 py-2">
                                    <h3 class="mb-0 mr-8">সংযুক্তি (যদি থাকে)</h3>
                                </div>
                                <!--end::Info-->
                                <!--begin::Users-->
                                <div class="symbol-group symbol-hover py-2">
                                    <div class="symbol symbol-30 symbol-light-primary" data-toggle="tooltip"
                                        data-placement="top" title="" role="button" data-original-title="Add New File">
                                        <div id="addFileRow">
                                            <span class="symbol-label font-weight-bold bg-success">
                                                <i class="text-white fa flaticon2-plus font-size-sm"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Users-->
                            </div>
                            <div class="mt-3 px-5">
                                <table width="100%" class="border-0 px-5" id="fileDiv" style="border:1px solid #dcd8d8;">
                                    <tr></tr>
                                </table>
                                <input type="hidden" id="other_attachment_count" value="1">
                            </div>
                        </fieldset>
                        <div class="row buttonsDiv">
                            <div class="col-md-12 text-center">
                                <div class="form-group">
                                    <!-- <input type="hidden" id="status" name="status" value="DRAFT"> -->
                                    <!-- <button type="button" class="btn btn-primary" onclick="myFunction()">
                                        {{-- সংরক্ষণ করুন --}}
                                        খসড়া করুন
                                    </button> -->
                                    @if(globalUserInfo()->role_id == 27)
                                    <button type="button" onclick="formSubmit()" class="btn btn-warning">
                                        সংরক্ষণ
                                    </button>
                                    <input type="hidden" id="button_text_submit"  value="সংরক্ষণ">
                                    <input type="hidden" id="status" name="status" value="ON_TRIAL">
                                    @else
                                    <input type="hidden" id="status" name="status" value="SEND_TO_GCO">
                                    <button type="button" onclick="formSubmit()" class="btn btn-warning">
                                        প্রেরণ 
                                    </button>
                                    <input type="hidden" id="button_text_submit"  value="প্রেরণ">
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-body-->
                </form>
            </div>
        </div>

    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
    <script src="{{ asset('js/number2banglaWord.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function deleteFile(id,appeal_id) {
            Swal.fire({
                title: "আপনি কি মুছে ফেলতে চান?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "হ্যাঁ",
                cancelButtonText: "না",
            })
            .then(function(result) {
                if (result.value) {
                    KTApp.blockPage({
                        // overlayColor: '#1bc5bd',
                        overlayColor: 'black',
                        opacity: 0.2,
                        // size: 'sm',
                        message: 'Please wait...',
                        state: 'danger' // a bootstrap color
                    });

                    var url = "{{ url('appeal/deleteFile') }}/" + id+"/"+appeal_id;
                    console.log(url);
                    // return;
                    $.ajax({
                        url: url,
                        dataType: "json",
                        type: "Post",
                        async: true,
                        data: { },
                        success: function (data) {
                            console.log(data);
                            Swal.fire({
                                position: "top-right",
                                icon: "success",
                                title: "সফলভাবে মুছে ফেলা হয়েছে!",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            KTApp.unblockPage();
                            $('#deleteFile'+id).hide();
                        },
                        error: function (xhr, exception) {
                            var msg = "";
                            if (xhr.status === 0) {
                                msg = "Not connect.\n Verify Network." + xhr.responseText;
                            } else if (xhr.status == 404) {
                                msg = "Requested page not found. [404]" + xhr.responseText;
                            } else if (xhr.status == 500) {
                                msg = "Internal Server Error [500]." +  xhr.responseText;
                            } else if (exception === "parsererror") {
                                msg = "Requested JSON parse failed.";
                            } else if (exception === "timeout") {
                                msg = "Time out error." + xhr.responseText;
                            } else if (exception === "abort") {
                                msg = "Ajax request aborted.";
                            } else {
                                msg = "Error:" + xhr.status + " " + xhr.responseText;
                            }
                            console.log(msg);
                            KTApp.unblockPage();
                        }
                    })
                    // toastr.success("সফলভাবে সাবমিট করা হয়েছে!", "Success");
                }
            });
        }
    </script>
    @include('appealInitiate.appealCreate_Ajax')
    @include('appealInitiate.appealCreate_Js')
@endsection
