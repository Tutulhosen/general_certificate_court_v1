@extends('layouts.citizen.citizen')

@section('content')
    <!--begin::Row-->
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
                <form id="appealCase" action="{{ route('citizen.appeal.review.store') }}" class="form" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input readonly type="hidden" name="appealId" value="{{ $appeal->id }}">
                    <input readonly type="hidden" name="appealType" value="REVIEW">
                    <div class="card-body">
                        <div class="row mb-8 ">
                            <div class="col-md-12">
                                <div class="example-preview">
                                    <ul class="nav nav-pills nav-fill">
                                        <li class="nav-item">
                                            <a class="nav-link px-0 active" id="regTab0" data-toggle="tab"
                                                href="#regTab_0">
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
                                        <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab5" data-toggle="tab" href="#regTab_5">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">উত্তরাধিকারীর তথ্য</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <hr>
                                    <div class="tab-content mt-5" id="myTabContent4">
                                        <div role="tabpanel" aria-labelledby="regTab0" class="tab-pane fade show active"
                                            id="regTab_0">
                                            <div class="panel panel-info radius-none">
                                                <div class="panel-body">
                                                    <div class="clearfix">
                                                        <div class="row">
                                                            <div class="col-md-6" style="display: none;">
                                                                <div class="form-group">
                                                                    <label for="caseEntryType" class="control-label"> মামলার
                                                                        ধরন </label>
                                                                    <div class="radio">
                                                                        <label class="mr-5">
                                                                            <input readonly type="radio" id="new"
                                                                                class="caseEntryType mr-2" value="NEW"
                                                                                {{ $appeal->case_entry_type == 'NEW' ? 'checked' : '' }}
                                                                                name="caseEntryType">নতুন মামলা
                                                                        </label>
                                                                        <label>
                                                                            <input readonly type="radio" id="oldCaseRadio"
                                                                                class="caseEntryType  mr-2" value="OLD"
                                                                                name="caseEntryType"
                                                                                {{ $appeal->case_entry_type == 'OLD' ? 'checked' : '' }}>পুরাতন
                                                                            মামলা
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 {{ $appeal->case_entry_type == 'OLD' ? '' : 'd-none' }}"
                                                                id="prevCaseDiv">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label for="previouscaseNo"
                                                                            class="control-label">পূর্ববর্তী মামলা
                                                                            নম্বর</label>
                                                                        <input readonly type="text" name="previouscaseNo"
                                                                            id="previouscaseNo"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ $appeal->case_no ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    
                                                                        <label for="nomineeGender_1" class="control-label">কার নিকট রিভিউ আবেদন করবেন <span class="text-danger">*</span></label>
                                                                        <select class="selectDropdown form-control" onchange="statusChange(this)" name="reviewAppliedTo"id="reviewAppliedTo" required>
                                                                            <option value="">বাছাই করুন</option>
                                                                            @if($appeal->reviewed_to_dc == 0 )
                                                                                <option value="DC">জেলা প্রশাসক </option>
                                                                            
                                                                            @elseif($appeal->reviewed_to_divCom == 0 && $appeal->reviewed_to_dc == 1 && $appeal->reviewed_to_lab== 0)
                                                                                <option value="DivCom">বিভাগীয় কমিশনার</option>
                                                                            
                                                                            @elseif($appeal->reviewed_to_lab== 0 && $appeal->reviewed_to_divCom == 1 && $appeal->reviewed_to_dc == 1)
                                                                                <option value="LAB">ভূমি আপিল বোর্ড চেয়ারম্যান</option>
                                                                            @endif
                                                                        </select>
                                                                    
                                                                </div>
                                                                <div class="col-md-4">
                                                                    
                                                                        <label for="caseNo" class="control-label pt-3">মামলা নম্বর</label>
                                                                        <input readonly type="text" name="previouscaseNo" id="previouscaseNo"
                                                                                class="form-control "
                                                                                value="{{ $appeal->case_no ?? '' }}">
                                                                    
                                                                </div>
                                                            
                                                                <div class="col-md-4">
                                                                    
                                                                        <label>আবেদনের তারিখ <span class="text-danger">*</span></label>
                                                                        <input type="text" name="caseDate" id="case_date" value="{{ en2bn(date('Y-m-d', strtotime(now()))) }}" class="form-control  " placeholder="দিন/মাস/তারিখ" autocomplete="off" readonly>
                                                                </div>    
                                                            </div>
                                                            </div>





                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="lawSection"
                                                                        class="control-label">সংশ্লিষ্ট আইন ও ধারা</label>
                                                                    <input readonly name="lawSection" id="lawSection"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $appeal->law_section ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            {{-- @dd($appeal) --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="totalLoanAmount"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000">*
                                                                        </span>দাবিকৃত অর্থের পরিমাণ</label>
                                                                    <input readonly type="text" name="totalLoanAmount"
                                                                        id="totalLoanAmount"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ en2bn($appeal->loan_amount) ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="totalLoanAmountText"
                                                                        class="control-label pt-2">দাবিকৃত অর্থের পরিমাণ
                                                                        (কথায়)</label>
                                                                    <input readonly readonly="readonly" type="text"
                                                                        name="totalLoanAmountText"
                                                                        id="totalLoanAmountText"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $appeal->loan_amount_text ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if (globalUserInfo()->role_id == 28)
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="comment"
                                                                            class="control-label">মন্তব্য </label>
                                                                        <textarea type="text" name="comment" id="comment" class="form-control form-control-sm"
                                                                            placeholder="এইখানে মন্তব্য লিখুন " rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" aria-labelledby="regTab1" class="tab-pane fade"
                                            id="regTab_1" readonly>
                                            <div class="panel panel-info radius-none">
                                                <div style="margin: 10px" id="accordion" role="tablist"
                                                    aria-multiselectable="true" class="panel-group notesDiv">
                                                    <section class="panel panel-primary applicantInfo" id="applicantInfo">
                                                        <div class="accordion accordion-solid accordion-toggle-plus"
                                                            id="accordionExample3">
                                                            @forelse ($applicantCitizen as $key => $item)
                                                                @php
                                                                    $count = ++$key;
                                                                @endphp
                                                                <div id="cloneApplicant" class="card">
                                                                    <input readonly type="hidden" id="ApplicantCount"
                                                                        value="1">
                                                                    <div class="card-header" id="headingOne3">
                                                                        <div class="card-title h4 {{ $count == 1 ? '' : 'collapsed' }}"
                                                                            data-toggle="collapse"
                                                                            data-target="#collapseOne3{{ $count }}">
                                                                            আবেদনকারীর তথ্য &nbsp; <span
                                                                                id="spannCount">({{ $count }})</span>
                                                                        </div>
                                                                    </div>
                                                                    <div id="collapseOne3{{ $count }}"
                                                                        class="collapse {{ $count == 1 ? 'show' : '' }}"
                                                                        data-parent="#accordionExample3">
                                                                        <div class="card-body">
                                                                            <div class="clearfix">

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantName_1"
                                                                                                class="control-label">আবেদনকারীর
                                                                                                নাম</label>
                                                                                            <input readonly
                                                                                                name="applicant[name][]"
                                                                                                id="applicantName_1"
                                                                                                class="form-control form-control-sm name-group"
                                                                                                value="{{ $item->citizen_name ?? '' }}">
                                                                                            <input readonly type="hidden"
                                                                                                name="applicant[type][]"
                                                                                                class="form-control form-control-sm"
                                                                                                value="1">
                                                                                            <input readonly type="hidden"
                                                                                                name="applicant[id][]"
                                                                                                id="applicantId_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->id ?? '' }}">
                                                                                            <input readonly type="hidden"
                                                                                                name="applicant[thana][]"
                                                                                                id="applicantThana_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input readonly type="hidden"
                                                                                                name="applicant[upazilla][]"
                                                                                                id="applicantUpazilla_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                            <input readonly type="hidden"
                                                                                                name="applicant[age][]"
                                                                                                id="applicantAge_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="applicantOrganizationID_1"
                                                                                                class="control-label">
                                                                                                প্রাতিষ্ঠানিক আইডি </label>
                                                                                            <input readonly
                                                                                                name="applicant[organization_id][]"
                                                                                                id="applicantOrganizationID_1"
                                                                                                class="form-control form-control-sm name-group"
                                                                                                value="{{ $item->organization_id ?? '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="applicantDesignation_1"
                                                                                                class="control-label">পদবি</label>
                                                                                            <input readonly
                                                                                                name="applicant[designation][]"
                                                                                                id="applicantDesignation_1"
                                                                                                class="form-control form-control-sm name-group"
                                                                                                value="{{ $item->designation ?? '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="applicantOrganization_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span> প্রতিষ্ঠানের
                                                                                                নাম</label>
                                                                                            <input readonly
                                                                                                name="applicant[organization][]"
                                                                                                id="applicantOrganization_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->organization ?? '' }}"
                                                                                                onchange="appealUiUtils.changeInitialNote();">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantType"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span>প্রতিষ্ঠানের ধরন
                                                                                            </label>
                                                                                            <select style="width: 100%;"
                                                                                                class="selectDropdown form-control form-control-sm"
                                                                                                name="applicant_organization[Type]">


                                                                                                <option value="BANK"
                                                                                                    {{ $appeal->applicant_type == 'BANK' ? 'selected' : 'disabled' }}>
                                                                                                    ব্যাংক</option>
                                                                                                <option value="GOVERNMENT"
                                                                                                    {{ $appeal->applicant_type == 'GOVERNMENT' ? 'selected' : 'disabled' }}>
                                                                                                    সরকারি প্রতিষ্ঠান
                                                                                                </option>
                                                                                                <option
                                                                                                    value="OTHER_COMPANY"
                                                                                                    {{ $appeal->applicant_type == 'OTHER_COMPANY' ? 'selected' : 'disabled' }}>
                                                                                                    স্বায়ত্তশাসিত
                                                                                                    প্রতিষ্ঠান</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantGender_1"
                                                                                                class="control-label">নারী
                                                                                                / পুরুষ</label>
                                                                                            <select disable
                                                                                                style="width: 100%;"
                                                                                                class="selectDropdown form-control form-control-sm"
                                                                                                name="applicant[gender][]"
                                                                                                id="applicantGender_1">
                                                                                                <option value="">
                                                                                                    বাছাই করুন</option>
                                                                                                <option value="MALE"
                                                                                                    {{ $item->citizen_gender == 'MALE' ? 'selected' : 'disabled' }}>
                                                                                                    পুরুষ</option>
                                                                                                <option value="FEMALE"
                                                                                                    {{ $item->citizen_gender == 'FEMALE' ? 'selected' : 'disabled' }}>
                                                                                                    নারী</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantFather_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>পিতার
                                                                                                নাম</label>
                                                                                            <input readonly
                                                                                                name="applicant[father][]"
                                                                                                id="applicantFather_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->father ?? '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantMother_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>মাতার
                                                                                                নাম</label>
                                                                                            <input readonly
                                                                                                name="applicant[mother][]"
                                                                                                id="applicantMother_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->mother ?? '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantNid_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000"></span>জাতীয়
                                                                                                পরিচয়
                                                                                                পত্র</label>
                                                                                            <input readonly
                                                                                                name="applicant[nid][]"
                                                                                                id="applicantNid_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->citizen_NID ?? '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label for="applicantPhn_1"
                                                                                                class="control-label"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span>মোবাইল</label>
                                                                                            <input readonly
                                                                                                name="applicant[phn][]"
                                                                                                id="applicantPhn_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->citizen_phone_no ?? '' }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="applicantPresentAddree_1"><span
                                                                                                    style="color:#FF0000">*
                                                                                                </span>প্রতিষ্ঠানের
                                                                                                ঠিকানা</label>
                                                                                            <textarea id="applicantPresentAddree_1" name="applicant[presentAddress][]" rows="5"
                                                                                                class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false" readonly>{{ $item->present_address ?? '' }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="applicantEmail_1"><span
                                                                                                    style="color:#ff0000d8">*
                                                                                                </span>ইমেইল</label>
                                                                                            <input readonly type="email"
                                                                                                name="applicant[email][]"
                                                                                                id="applicantEmail_1"
                                                                                                class="form-control form-control-sm"
                                                                                                value="{{ $item->email ?? '' }}">
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


                                            </div>
                                        </div>
                                        <div role="tabpanel" aria-labelledby="regTab2" class="tab-pane fade"
                                            id="regTab_2" readonly>
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
                                                                    <input readonly name="defaulter[name]"
                                                                        id="defaulterName_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->citizen_name ?? '' }}">
                                                                    <input readonly type="hidden" name="defaulter[type]"
                                                                        class="form-control form-control-sm"
                                                                        value="2">
                                                                    <input readonly type="hidden" name="defaulter[id]"
                                                                        id="defaulterId_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->id ?? '' }}">
                                                                    <input readonly type="hidden" name="defaulter[email]"
                                                                        id="defaulterEmail_1"
                                                                        class="form-control form-control-sm"
                                                                        value="">
                                                                    <input readonly type="hidden" name="defaulter[thana]"
                                                                        id="defaulterThana_1"
                                                                        class="form-control form-control-sm"
                                                                        value="">
                                                                    <input readonly type="hidden"
                                                                        name="defaulter[upazilla]"
                                                                        id="defaulterUpazilla_1"
                                                                        class="form-control form-control-sm"
                                                                        value="">
                                                                    <input readonly type="hidden" name="defaulter[age]"
                                                                        id="defaulterAge_1"
                                                                        class="form-control form-control-sm"
                                                                        value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterPhn_1"
                                                                        class="control-label">মোবাইল</label>
                                                                    <input readonly name="defaulter[phn]"
                                                                        id="defaulterPhn_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->citizen_phone_no ?? '' }}">
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
                                                                    <input readonly name="defaulter[nid]"
                                                                        id="defaulterNid_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->citizen_NID ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterGender_1"
                                                                        class="control-label">লিঙ্গ</label>
                                                                    <select disable style="width: 100%;"
                                                                        class="selectDropdown form-control form-control-sm form-control-sm"
                                                                        name="defaulter[gender]" id="defaulterGender_1">
                                                                        <option value="">বাছাই করুন</option>
                                                                        <option value="MALE"
                                                                            {{ isset($defaulterCitizen->citizen_gender) == 'MALE' ? 'selected' : 'disabled' }}>
                                                                            পুরুষ</option>
                                                                        <option value="FEMALE"
                                                                            {{ isset($defaulterCitizen->citizen_gender) == 'FEMALE' ? 'selected' : 'disabled' }}>
                                                                            নারী</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <input readonly name="defaulter[organization_id]"
                                                                id="defaulterOrganizationID_1" type="hidden">
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterFather_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                                    <input readonly name="defaulter[father]"
                                                                        id="defaulterFather_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->father ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterMother_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>মাতার নাম</label>
                                                                    <input readonly name="defaulter[mother]"
                                                                        id="defaulterMother_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->mother ?? '' }}">
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
                                                                    <input readonly name="defaulter[designation]"
                                                                        id="defaulterDesignation_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->designation ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterOrganization_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>প্রতিষ্ঠানের
                                                                        নাম</label>
                                                                    <input readonly name="defaulter[organization]"
                                                                        id="defaulterOrganization_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->organization ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterPresentAddree_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ঠিকানা</label>
                                                                    <textarea id="defaulterPresentAddree_1" name="defaulter[presentAddress]" rows="5"
                                                                        class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false" readonly>{{ $defaulterCitizen->present_address ?? '-' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterEmail_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ইমেইল</label>
                                                                    <input readonly type="email" name="defaulter[email]"
                                                                        id="defaulterEmail_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $defaulterCitizen->email ?? '-' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" aria-labelledby="regTab5" class="tab-pane fade"
                                            id="regTab_5" readonly>
                                            <div class="panel panel-info radius-none ">

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
                                                                                            value="{{ $item->citizen_name }}" readonly>
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
                                                                                            value="{{ $item->citizen_phone_no }}" readonly>
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
                                                                                            value="{{ $item->citizen_NID }}" readonly>
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
                                                                                            value="{{ $item->father }}" readonly>
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
                                                                                            value="{{ $item->mother }}" readonly>
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
                                                                                            value="{{ $item->age }}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="nomineeAge_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000">*</span>ইমেইল</label>
                                                                                        <input name="nominee[email][]"
                                                                                            id="nomineeAge_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="{{ $item->email }}" readonly>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="nomineePresentAddree_1"><span
                                                                                            style="color:#FF0000">*</span>ঠিকানা</label>
                                                                                        <textarea
                                                                                            id="nomineePresentAddree_1"
                                                                                            name="nominee[present_address][]"
                                                                                            rows="3"
                                                                                            class="form-control form-control-sm element-block blank"
                                                                                            aria-describedby="note-error"
                                                                                            aria-invalid="false" readonly>{{ $item->present_address }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                        উত্তরাধিকারীর তথ্য নেই 
                                                        @endforelse


                                                    </div>
                                                </section>
                                            </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <fieldset class="mb-8 p-7" style="display: none;">
                            <legend>কার্যক্রম</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- <div class="example-preview"> --}}
                                    <div class="panel panel-info radius-none">
                                        {{-- <div class="panel-heading radius-none">
                                            <h4 class="panel-title">কার্যক্রম</h4>
                                        </div>
                                        <hr> --}}
                                        <div class="panel-body" readonly>
                                            @forelse ($notes as  $note)
                                                @php
                                                    // dd($note)
                                                @endphp
                                                <div class="form-group" id="initialNoteDiv">
                                                    <label for="note">রিকুইজিশন নোট</label>
                                                    <textarea class="form-control note-control" id="note" name="note" rows="5">{{ $note->order_text }}</textarea>
                                                    <input readonly type="hidden" name="noteId" id="noteId"
                                                        class="form-control form-control-sm"
                                                        value="{{ $note->id ?? '' }}">
                                                </div>
                                            @empty
                                                <div class="form-group" id="initialNoteDiv">
                                                    <label for="note">রিকুইজিশন নোট</label>
                                                    <textarea class="form-control note-control" id="note" name="note" rows="5"></textarea>
                                                    <input readonly type="hidden" name="noteId" id="noteId"
                                                        class="form-control form-control-sm" value="">
                                                </div>
                                            @endforelse

                                            {{-- </div> --}}

                                            {{-- <div class="col-md-4"> --}}

                                            <input readonly type="hidden" name="causeListId" id="causeListId"
                                                value="{{ $appealCauseList[0]->id ?? '' }}">


                                        </div>
                                    </div>
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class=" mb-8">
                            <div
                                class="rounded bg-success-o-100 d-flex align-items-center justify-content-between flex-wrap px-5 py-0 mb-2">
                                <div class="d-flex align-items-center mr-2 py-2">
                                    <h3 class="mb-0 mr-8">সংযুক্তি</h3>
                                </div>
                            </div>
                            @forelse ($attachmentList as $key => $row)
                                <div class="form-group mb-2" id="deleteFile{{ $row->id }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn bg-success-o-75"
                                                type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                        </div>
                                        <input readonly type="text" class="form-control"
                                            value="{{ $row->file_category ?? '' }}" />
                                        <div class="input-group-append">
                                            <a href="{{ asset($row->file_path . $row->file_name) }}" target="_blank"
                                                class="btn btn-sm btn-success font-size-h5 float-left">
                                                <i class="fa fas fa-file-pdf"></i>
                                                <b>দেখুন</b>
                                            </a>
                                            {{-- <a href="minarkhan.com" class="btn btn-success" type="button">দেখুন </a> --}}
                                        </div>
                                        {{-- <div class="input-group-append">
                                                <a href="javascript:void(0);" id="" onclick="deleteFile({{ $row->id }},{{ $id }} )" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                    <b>মুছুন</b>
                                                </a>
                                            </div> --}}
                                    </div>
                                </div>
                            @empty
                                <div class="pt-5">
                                    <p class="text-center font-weight-normal font-size-lg">কোনো সংযুক্তি খুঁজে পাওয়া যায়নি
                                    </p>
                                </div>
                            @endforelse
                        </fieldset>

                        <div class="row buttonsDiv">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input readonly type="hidden" id="status" name="status" value="DRAFT">

                                    <button type="button" onclick="formSubmit()" class="btn btn-warning">
                                        প্রেরণ(সংশ্লিষ্ট আদালত)
                                    </button>
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
    <script>
        function deleteFile(id, appeal_id) {
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

                        var url = "{{ url('appeal/deleteFile') }}/" + id + "/" + appeal_id;
                        console.log(url);
                        // return;
                        $.ajax({
                            url: url,
                            dataType: "json",
                            type: "Post",
                            async: true,
                            data: {},
                            success: function(data) {
                                console.log(data);
                                Swal.fire({
                                    position: "top-right",
                                    icon: "success",
                                    title: "সফলভাবে মুছে ফেলা হয়েছে!",
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                                KTApp.unblockPage();
                                $('#deleteFile' + id).hide();
                            },
                            error: function(xhr, exception) {
                                var msg = "";
                                if (xhr.status === 0) {
                                    msg = "Not connect.\n Verify Network." + xhr.responseText;
                                } else if (xhr.status == 404) {
                                    msg = "Requested page not found. [404]" + xhr.responseText;
                                } else if (xhr.status == 500) {
                                    msg = "Internal Server Error [500]." + xhr.responseText;
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
    @include('reviewAppeal.reviewAppealCreate_Ajax')
    @include('reviewAppeal.reviewAppealCreate_Js')
@endsection
