
@extends('layouts.default')

@push('head')
    <link href="{{ asset('assets/css/pages/wizard/wizard-1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/tachyons.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

    <!--begin::Row-->
    <div class="row">
        @if (Session::has('Errormassage'))
            <div class="alert alert-danger text-center">
                {{ Session::get('Errormassage') }}
            </div>
        @endif
        <div class="col-md-12">
           <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder" style="padding-top: 30px;">{{ $page_title }}</h3>
                    <div class="card-toolbar">
                        <!-- <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div> -->
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <style>
                    .wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-title {
                        color: #7e8299;
                        font-size: 1.5rem;
                        font-weight: 700;
                    }
                </style>
                 <div class="wizard wizard-1" id="appealWizard" data-wizard-state="step-first" data-wizard-clickable="true">
                    <div class="wizard-nav border-bottom">
                        <div class="wizard-steps p-8 p-lg-10">
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                <div class="wizard-label">
                                    <span class="svg-icon svg-icon-4x wizard-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <h3 class="wizard-title">মামলার তথ্য</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                x="11" y="5" width="2" height="14" rx="1" />
                                            <path
                                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <span class="svg-icon svg-icon-4x wizard-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Devices/Display1.svg-->
                                        <i class="fas fa-file-alt"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <h3 class="wizard-title">আবেদনকারীর তথ্য</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                x="11" y="5" width="2" height="14" rx="1" />
                                            <path
                                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <span class="svg-icon svg-icon-4x wizard-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Globe.svg-->
                                        <i class="fas fa-file-invoice"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <h3 class="wizard-title">খাতকের তথ্য</h3>
                                </div>
                             {{--    <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                x="11" y="5" width="2" height="14" rx="1" />
                                            <path
                                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span> --}}

                            </div>
                            {{-- <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <span class="svg-icon svg-icon-4x wizard-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Globe.svg-->
                                        <i class="fas fa-file-invoice"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <h3 class="wizard-title">সংযুক্তি</h3>
                                </div>
                                

                            </div> --}}
                            

                        </div>
                    </div>
                    <!--begin::Wizard Body-->
                    <div class="row justify-content-center mt-5 mb-10 px-8 mb-lg-15 px-lg-10">
                        <div class="col-xl-12 col-xxl-7">
                            <!--begin::Form Wizard-->
                            <form id="appealCase" action="{{route('appeal.currentAppealStore')}}" class="form" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- <form class="form" id="kt_projects_add_form"> --}}
                                <!--begin::Step 1-->
                                <input type="hidden" name="caseEntryType" value="RUNNING">
                                <input type="hidden" name="lawSection" value="সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা">
                                <fieldset class="pb-5 create_cause" data-wizard-type="step-content"
                                    data-wizard-state="current">
                                    <legend class="font-weight-bold text-dark"><strong
                                            style="font-size: 20px !important;color:black !important">মামলার তথ্য</strong>
                                    </legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="caseNo" class="control-label"><span style="color:#FF0000">* </span>মামলা নম্বর </label>
                                                <input name="caseNo" id="caseNo" class="form-control form-control-sm" placeholder="মামলা নম্বর" >
                                                    <!-- সিস্টেম কর্তৃক পূরণকৃত  -->
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>আবেদনের তারিখ <span class="text-danger">*</span></label>
                                                <input type="text" name="caseDate" id="caseDate"
                                                class="form-control form-control-sm common_datepicker"
                                                placeholder="দিন/মাস/তারিখ" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="totalLoanAmount" class="control-label"><span style="color:#FF0000">* </span>দাবিকৃত অর্থের পরিমাণ (আসল)</label>
                                                <input type="text" name="totalLoanAmount" id="totalLoanAmount" class="form-control form-control-sm" value="" onkeyup="totalSum()">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="totalLoanAmountText" class="control-label">দাবিকৃত অর্থের
                                                    পরিমাণ
                                                    (কথায়)</label>
                                                <input readonly="readonly" type="text" name="totalLoanAmountText"
                                                    id="totalLoanAmountText" class="form-control form-control-sm"
                                                    value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="totalInterest" class="control-label">মোট সুদের পরিমাণ</label>
                                                <input type="text" name="totalInterest" id="totalInterest" class="form-control form-control-sm" value="" onkeyup="totalSum()">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="totalInterestText" class="control-label">মোট সুদের পরিমাণ
                                                    (কথায়)</label>
                                                <input readonly="readonly" type="text" name="totalInterestText"
                                                    id="totalInterestText" class="form-control form-control-sm"
                                                    value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="interestRate" class="control-label">সুদের হার</label>
                                                <div class="input-group">
                                                    <input type="text" name="interestRate" id="interestRate"
                                                        class="form-control form-control-sm input_bangla" value="">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"
                                                            style="background-color: #007BFF; color: #FFFFFF;">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="totalAmountWithInterest" class="control-label">মোট অর্থের পরিমাণ (সুদসহ)</label>
                                                <input type="text" onkeyup="totalSum()" name="totalAmountWithInterest" id="totalAmountWithInterest" class="form-control form-control-sm" value="" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="court_fee" class="control-label">কোর্ট ফি</label>
                                                <input type="text" name="court_fee" id="court_fee"
                                                    class="form-control form-control-sm" value="" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="court_fee_attached" class="control-label">কোর্ট ফি সংযুক্তি</label>
                                                <input type="file" name="court_fee_attached" id="court_fee_attached"
                                                    class="form-control form-control-sm" value="" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="process_fee" class="control-label">প্রসেস ফি</label>
                                                <input type="text" name="process_fee" id="process_fee"
                                                    class="form-control form-control-sm" value="" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="court_id" class="control-label"><span
                                                        style="color:#FF0000">*
                                                    </span>আদালত সংশ্লিষ্ট কর্মকর্তা নির্বাচন করুন</label>
                                                <select class="selectDropdown form-control form-control-sm" id="court_id"
                                                    style="width: 100%;" name="court_id">
                                                   
                                                      @foreach ($data['available_court'] as $key => $value)
                                                        <option value="{{ $value->id }}">{{ $value->court_name }}
                                                        </option>
                                                       @endforeach  
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div
                                        class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                                        <div class="d-flex align-items-center mr-2 py-2">
                                            <h3 class="mb-0 mr-8">সংযুক্তি (যদি থাকে)</h3>
                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Users-->
                                        <div class="symbol-group symbol-hover py-2">
                                            <div class="symbol symbol-30 symbol-light-primary" data-toggle="tooltip"
                                                data-placement="top" title="" role="button"
                                                data-original-title="Add New File">
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
                                        <table width="100%" class="border-0 px-5" id="fileDiv"
                                            style="border:1px solid #dcd8d8;">
                                            <tr></tr>
                                        </table>
                                        <input type="hidden" id="other_attachment_count" value="1">
                                    </div>
                                    <br>

                                    <!-- Template -->
                                    <div id="template" style="display: none">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" data-name="file.type"
                                                    class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" data-name="file.name"
                                                                class="custom-file-input">
                                                            <label class="custom-file-label custom-input2"
                                                                for="customFile2">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                                        <button type="button"
                                                            class="fas fa-minus-circle btn btn-sm btn-danger font-weight-bolder removeRow"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                {{-- <div ></div> --}}
                                <!--end::Step 1-->

                                <!--begin::Step 2-->
                                <div class="pb-5" data-wizard-type="step-content">
                                    <input type="hidden" id="ApplicantCount" value="1">
                                    <fieldset>
                                        <legend class="font-weight-bold text-dark"><strong
                                                style="font-size: 20px !important">আবেদনকারীর তথ্য (1)</strong></legend>
                                        <input type="hidden" id="ApplicantCount" value="1">
                                      
                                        <input type="hidden" id="division_id" value="{{ $data['divisionId'] }}">
                                        <input type="hidden" id="district_id" value="{{ $data['districtId'] }}">

                                        <div class="row">
                                           <div class="col-lg-4 mb-5">
                                               <div class="form-group">
                                                    <label class="control-label"><span style="color:#FF0000">* </span>উপজেলা নির্বাচন করুন </label>
                                                    <select class="form-control" name="applicant[upazila_id][0]" aria-label=".form-select-lg example" id="upazila_id">
                                                        <option value="">উপজেলা নির্বাচন করুন </option>
                                                        @foreach ($data['upazila'] as $key => $value)
                                                        <option value="{{ $value->id }}">{{ $value->upazila_name_bn }}
                                                        </option>
                                                       @endforeach  
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-5">
                                                <div class="form-group">

                                                <label><span style="color:#FF0000">* </span> প্রতিষ্ঠানের ধরন নির্বাচন করুন </label>
                                                <select class="form-control" aria-label=".form-select-lg example" id="applicantTypeBank" name="applicant_organization[Type][0]"  >
                                                    <option value="">প্রতিষ্ঠানের ধরন নির্বাচন করুন </option>
                                                    <option value="BANK">ব্যাংক</option>
                                                    <option value="GOVERNMENT">সরকারি প্রতিষ্ঠান</option>
                                                    <option value="OTHER_COMPANY">স্বায়ত্তশাসিত প্রতিষ্ঠান</option>
                                                </select>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="applicantOrganization_1" class="control-label">
                                                        <span style="color:#FF0000">* </span> প্রতিষ্ঠানের নাম</label>
                                                        {{--<input name="applicant[organization][0]" id="applicantOrganization_1"
                                                        class="form-control form-control-sm"
                                                        value=""
                                                        onchange="appealUiUtils.changeInitialNote();" readonly>--}}
                                                        {{-- $data['office_name'] --}}


                                                        <select class="form-control" aria-label=".form-select-lg example" name="applicant[organization][0]" id="applicantOrganization_1">
                                                            <option value="">প্রতিষ্ঠান নির্বাচন করুন </option>
                                                            
                                                        </select>
                                                         
                                                </div>

                                            </div>
                         
                                            <input type="hidden" id="organization_name_default_from_previous"
                                                value="">
                                                {{-- $data['office_name'] --}}
                                            <input type="hidden" id="organization_routing_id_previous"
                                                value="">
                                                {{-- $data['organization_routing_id'] --}}
                                            <input type="hidden" id="organization_physical_address_previous"
                                                value="">
                                                {{-- $data['organization_physical_address'] --}}
                                            <input type="hidden" id="organization_type_previous"
                                                value="">
                                                {{-- $data['organization_type'] --}}
                                            <input type="hidden" id="organization_type_bn_name_previous"
                                                value="">
                                                {{-- $data['organization_type_bn_name'] --}}
                                            
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="applicantName_1" class="control-label">
                                                        <span style="color:#FF0000">*</span> আবেদনকারীর নাম / পদবি</label>
                                                         <input type="text" value="" placeholder="আবেদনকারীর নাম" name="applicant[name][0]" id="applicant_name" required class="form-control form-control-sm">
                                                    

                                                        <input type="hidden" name="applicant[type][]"
                                                        class="form-control form-control-sm" value="1">

                                                        <input type="hidden" name="applicant[thana][0]" id="applicantThana_1"
                                                        class="form-control form-control-sm" value="">
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="applicantDesignation_1" class="control-label">
                                                        পদবি</label>
                                                    <input name="applicant[designation][0]"  id="applicantDesignation_1"
                                                        class="form-control form-control-sm name-group"
                                                         value="">
                                                </div>
                                            </div> --}}
                                            <div class="col-md-4">
                                                <div class="form-group" id="inputBoxContainer">
                                                    <label for="applicantOrganizationID_1" class="control-label">
                                                        <span style="color:#FF0000">* </span> 
                                                            রাউটিং নাম্বার
                                                        </label>
                                                    <input 
                                                        
                                                        class="form-control form-control-sm " id="applicantOrganizationID_1" required
                                                        value="" name="applicant[organization_routing_id][0]" >
                                                     
                                                        {{-- $data['organization_routing_id'] --}}

                                                </div>
                                                <div class="form-group" id="inputBoxContainer2">
                                                    <label for="applicantOrganizationID_2" class="control-label">
                                                        <!-- <span style="color:#FF0000">* </span>  -->
                                                            প্রাতিষ্ঠানিক আইডি 
                                                        </label>
                                                    <input 
                                                        id="applicantOrganizationID_2"
                                                        class="form-control form-control-sm "
                                                        value="" name="applicant[organization_id][0]">
                                                        {{-- $data['organization_routing_id'] --}}

                                                </div>
                                            </div>

                                            <!-- <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="applicantType" class="control-label"><span
                                                            style="color:#FF0000">* </span>প্রতিষ্ঠানের ধরন </label>
                                                    <select class="selectDropdown form-control form-control-sm"
                                                        id="applicantTypeBank" style="width: 100%;"
                                                        name="applicant_organization[Type][0]">

                                                        <option value="">
                                                        {{-- $data['organization_type'] --}}
                                                            {{-- $data['organization_type_bn_name'] --}}</option>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label class="control-label"><span
                                                                style="color:#FF0000"></span>লিঙ্গ</label><br>
                                                        <select class="form-control" name="applicant[gender][0]">

                                                            <option value="MALE"
                                                                {{-- $data['citizen_gender'] == 'MALE' ? ' selected' : 'disabled' --}}>
                                                                পুরুষ </option>
                                                            <option value="FEMALE"
                                                                {{-- $data['citizen_gender'] == 'FEMALE' ? ' selected' : 'disabled' --}}>
                                                                নারী </option>
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="applicantFather_1" class="control-label">
                                                        <!-- <span style="color:#FF0000">* </span> -->
                                                            প্রাতিষ্ঠানিক প্রতিনিধির Employee ID</label>
                                                    <input name="applicant[organization_employee_id][0]"
                                                        id="applicantFather_1" class="form-control form-control-sm"
                                                        value=""  >
                                                        {{-- $data['organization_employee_id'] --}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantFather_1" class="control-label"><span
                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                    <input name="applicant[father][0]" id="applicantFather_1"
                                                        class="form-control form-control-sm"
                                                        value="" >
                                                        {{--$data['father'] --}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantMother_1" class="control-label"><span
                                                            style="color:#FF0000"></span>মাতার নাম</label>
                                                    <input name="applicant[mother][0]" id="applicantMother_1"
                                                        class="form-control form-control-sm"
                                                        value="" >
                                                        {{-- $data['mother'] --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantNid_1" class="control-label">
                                                        <!-- <span style="color:#FF0000">*</span> -->
                                                            জাতীয় পরিচয় পত্র
                                                    </label>
                                                    <input name="applicant[nid][0]" type="text" id="applicantNid_1"
                                                        class="form-control form-control-sm"
                                                        value="" >
                                                        {{-- globalUserInfo()->citizen_nid --}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                
                                                <div class="form-group">
                                                    <label for="applicantPhn_1" class="control-label">মোবাইল</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span
                                                                class="input-group-text">+88</span></div>
                                                        <input name="applicant[phn][0]" id="applicantPhn_1"
                                                            class="form-control form-control-sm"
                                                            value=""
                                                            placeholder="ইংরেজিতে দিতে হবে" >
                                                            {{-- globalUserInfo()->mobile_no --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label> প্রতিষ্ঠানের ঠিকানা</label>
                                                    <textarea name="applicant[organization_physical_address][0]" rows="4" class="form-control element-block blank"
                                                        aria-describedby="note-error" aria-invalid="false" >{{-- $data['organization_physical_address'] --}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantEmail_1">ইমেইল</label>
                                                    <input type="email" name="applicant[email][0]"
                                                        class="form-control form-control-sm"
                                                        value="" >
                                                        {{-- globalUserInfo()->email --}}
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Template -->
                                    <fieldset id="applicantTemplate" style="display: none; margin-top: 30px;">
                                        <legend class="font-weight-bold text-dark"><strong
                                                style="font-size: 20px !important" data-name="applicant.info">আবেদনকারীর
                                                তথ্য (1)</strong></legend>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-dark font-weight-bold">
                                                    <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input required type="text" {{-- id="applicantCiNID_1" --}}
                                                        class="form-control" placeholder="উদাহরণ- 19825624603112948"
                                                        data-name="applicant.NIDNumber" onclick="addDatePicker(this.id)">
                                                    <span id="res_applicant_1"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input required type="text" id="applicantDob_1"
                                                            data-name="applicant.DOBNumber"
                                                            placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী) বছর/মাস/তারিখ"
                                                            {{-- id="dob" --}} class="form-control common_datepicker_1"
                                                            autocomplete="off">

                                                        <input type="button" data-name="applicant.NIDCheckButton"
                                                            class="btn btn-primary check_nid_button" value="সন্ধান করুন">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"><span style="color:#FF0000">*</span>
                                                        আবেদনকারীর নাম</label>



                                                    <input type="text" data-name="applicant.name"
                                                        class="form-control form-control-sm" readonly>

                                                    <input type="hidden" data-name="applicant.type" value="1">
                                                    <input type="hidden" data-name="applicant.id">
                                                    <input type="hidden" data-name="applicant.thana">
                                                    <input type="hidden" data-name="applicant.upazilla">
                                                    <input type="hidden" data-name="applicant.age">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"><span style="color:#FF0000">* </span>
                                                        প্রতিষ্ঠানের নাম</label>
                                                    <input data-name="applicant.organization"
                                                        class="form-control form-control-sm input-reset">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label"><span style="color:#FF0000">* </span>
                                                        পদবি</label>
                                                    <input data-name="applicant.designation"
                                                        class="form-control form-control-sm input-reset">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label"><span style="color:#FF0000">* </span>
                                                        প্রাতিষ্ঠানিক আইডি </label>
                                                    <input data-name="applicant.organization_routing_id"
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label"><span
                                                            style="color:#FF0000"></span>লিঙ্গ</label><br>
                                                    <select class="form-control" data-name="applicant.gender">

                                                        <option value="MALE"> পুরুষ </option>
                                                        <option value="FEMALE"> নারী </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="applicantFather_1" class="control-label"><span
                                                            style="color:#FF0000">* </span>আবেদনকারীর প্রতিষ্ঠানে
                                                        আবেদনকারীর EmployeeID</label>

                                                    <input data-name="applicant.organization_employee_id"
                                                        class="input-reset form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantFather_1" class="control-label"><span
                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                    <input data-name="applicant.father"
                                                        class="input-reset form-control form-control-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantMother_1" class="control-label"><span
                                                            style="color:#FF0000"></span>মাতার নাম</label>
                                                    <input data-name="applicant.mother"
                                                        class="input-reset form-control form-control-sm" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantNid_1" class="control-label"><span
                                                            style="color:#FF0000">*</span>জাতীয় পরিচয় পত্র</label>
                                                    <input data-name="applicant.nid" type="text"
                                                        class="input-reset form-control form-control-sm" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {{-- <div class="form-group">
                                                    <label for="applicantPhn_1" class="control-label"><span style="color:#FF0000">* </span>মোবাইল</label>
                                                    <input data-name="applicant.phn" class="input-reset form-control form-control-sm">
                                                </div> --}}
                                                <div class="form-group">
                                                    <label for="applicantPhn_1" class="control-label"><span
                                                            style="color:#FF0000">* </span>মোবাইল</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span
                                                                class="input-group-text">+88</span></div>
                                                        <input data-name="applicant.phn"
                                                            class="input-reset form-control form-control-sm"
                                                            placeholder="ইংরেজিতে দিতে হবে">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><span style="color:#FF0000">* </span>প্রতিষ্ঠানের ঠিকানা</label>
                                                    <textarea data-name="applicant.organization_physical_address" rows="4"
                                                        class="input-reset form-control element-block blank"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="applicantEmail_1"><span
                                                            style="color:#FF0000">*</span>ইমেইল</label>
                                                    <input type="email" data-name="applicant.email"
                                                        class="input-reset form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div style="margin-top: 15px;display:none">
                                        
                                        <div class="col-md-12" style="float: right; margin-bottom: -20px;">
                                            <button id="RemoveApplicant" type="button" class="btn btn-danger"
                                                value="0" style="float: right;">বাতিল</button>
                                            <button id="ApplicantAdd" type="button" class="btn btn-success"
                                                value="0" style="float: right; margin-right: 10px;"> প্রতিষ্ঠানের
                                                প্রতিনিধি যোগ করুন </button>
                                        </div>

                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <!--end::Step 2-->

                                <!--begin::Step 3-->
                                <fieldset class="pb-5" data-wizard-type="step-content">
                                    <legend class="font-weight-bold text-dark"><strong
                                            style="font-size: 20px !important">ঋণগ্রহীতার তথ্য</strong></legend>
                                    

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-dark font-weight-bold">
                                                <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input required type="text" {{-- id="applicantCiNID_1" --}}
                                                    class="form-control check_nid_number"
                                                    placeholder="উদাহরণ- 19825624603112948" id="defaulter_nid_input_smdn">
                                                <span id="res_applicant_1"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input required type="text" name="defaulter_dob_input_smdn"
                                                        id="defaulter_dob_input_smdn"
                                                        placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী) বছর/মাস/তারিখ"
                                                        {{-- id="dob" --}} class="form-control common_datepicker"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="button" class="btn btn-primary check_nid_button"
                                                        onclick="NIDCHECKDefaulter()" value="সন্ধান করুন">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="defaultername"><span style="color:#FF0000">*
                                                    </span>ঋণগ্রহীতার নাম</label>
 
                                                <input type="text" value="" placeholder="ঋণগ্রহীতার নাম" name="defaulter[name]" id="defaultername" required class="form-control form-control-sm">
                                               
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="defaulter[type]"
                                                    class="form-control form-control-sm" value="2">
                                        <input type="hidden" name="defaulter[id]" id="defaulterId_1"
                                            class="form-control form-control-sm" value="">
                                        <input type="hidden" name="defaulter[thana]" id="defaulterThana_1"
                                            class="form-control form-control-sm" value="">
                                        <input type="hidden" name="defaulter[upazilla]" id="defaulterUpazilla_1"
                                            class="form-control form-control-sm" value="">
                                        <input type="hidden" name="defaulter[age]" id="defaulterAge_1"
                                            class="form-control form-control-sm" value="">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">মোবাইল</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span
                                                            class="input-group-text">+88</span></div>
                                                    <input name="defaulter[phn]" class="form-control form-control-sm"
                                                        placeholder="ইংরেজিতে দিতে হবে">
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">জাতীয়
                                                    পরিচয়
                                                    পত্র</label>
                                                <input name="defaulter[nid]" class="form-control form-control-sm ">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span
                                                        style="color:#FF0000"></span>লিঙ্গ</label>
                                                <select class="form-control" name="defaulter[gender]">

                                                    <option value="MALE"> পুরুষ </option>
                                                    <option value="FEMALE"> নারী </option>
                                                </select>

                                            </div>
                                        </div>
                                        <input name="defaulter[organization_routing_id]" id="defaulterOrganizationID_1"
                                            type="hidden">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">পিতার
                                                    নাম</label>
                                                <input name="defaulter[father]" class="form-control form-control-sm ">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">মাতার
                                                    নাম</label>
                                                <input name="defaulter[mother]" class="form-control form-control-sm ">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">পদবি /
                                                    পেশা</label>
                                                <input name="defaulter[designation]" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">প্রতিষ্ঠানের
                                                    নাম(যদি থাকে)</label>
                                                <input name="defaulter[organization]"
                                                    class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>বর্তমান ঠিকানা</label>
                                                <textarea name="defaulter[present_address]" rows="4" class="form-control element-block blank "></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ইমেইল</label>
                                                <input type="email" name="defaulter[email]"
                                                    class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>স্থায়ী ঠিকানা</label>
                                                <textarea name="defaulter[permanent_address]" rows="4" class="form-control element-block blank "></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                               <!--begin::Step 4-->
                                <fieldset class="pb-5 " data-wizard-type="step-content">
                                    <div class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                                        <div class="d-flex align-items-center mr-2 py-2">
                                            <h3 class="mb-0 mr-8">আদেশ নামা সংযুক্তি (যদি থাকে)</h3>
                                        </div>
                                        <!--end::Info-->
                                      
                                    </div>
                                    
                                    <br>

                                    <!-- Template -->
                                    <!-- <div id="template" > -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="onama_file_type" class="form-control form-control-sm"
                                                id="file_name_important" placeholder="আদেশ নামা">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                        <input type="file" id="order_customFile" onChange="runningAttachmentTitle()" id="order_customFile" style="display: none;" name="onama_file_name">
                                                            <!-- <input type="file"  name="file_name[]" onChange="runningAttachmentTitle()" class="custom-file-input" id="order_customFile" style="display: none;"> -->
                                                            <label class=" custom-file-label order_customFilealamin"  for="order_customFile">ফাইল নির্বাচন করুন</label>
                                                            <!-- <div class="order_customFilealamin"></div> -->
                                                        </div>


                                                        <!-- <button type="button"
                                                            class="fas fa-minus-circle btn btn-sm btn-danger font-weight-bolder removeRow"></button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div> -->
                                    <div class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                                        <div class="d-flex align-items-center mr-2 py-2">
                                            <h3 class="mb-0 mr-8">আদেশের টেমপ্লেট সংযুক্তি (যদি থাকে)</h3>
                                        </div>
                                    </div>
                                    <br>
                                    <!-- <div id="template" > -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                
                                                <input type="text" name="order_file_type[]" class="form-control form-control-sm"  id="file_name_order_templateFile_1" value="রাজকীয় প্রাপ্যের সার্টিফিকেট" placeholder="রাজকীয় প্রাপ্যের সার্টিফিকেট">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            
                                                            <input type="file" id="order_templateFile_1" onChange="orderTemplateFile(1)" id="order_templateFile_1" style="display: none;" name="order_file_name[]">
                                                            <label class=" custom-file-label order_templateFile_1"  for="order_templateFile_1">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                                        <!-- <button type="button"
                                                            class="fas fa-minus-circle btn btn-sm btn-danger font-weight-bolder removeRow"></button> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="order_file_type[]" class="form-control form-control-sm"  id="file_name_order_templateFile_2" value="৭ ধারার নোটিশ" placeholder="৭ ধারার নোটিশ">
                                                    
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" id="order_templateFile_2" onChange="orderTemplateFile(2)" id="order_templateFile_2" style="display: none;" name="order_file_name[]">
                                                            <label class=" custom-file-label order_templateFile_2"  for="order_templateFile_2">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                                  
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="order_file_type[]" class="form-control form-control-sm"  id="file_name_order_templateFile_3" value="১০ (ক) ধারার নোটিশ" placeholder="১০ (ক) ধারার নোটিশ">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                           
                                                            <input type="file" id="order_templateFile_3" onChange="orderTemplateFile(3)" id="order_templateFile_3" style="display: none;" name="order_file_name[]">
                                                            <label class=" custom-file-label order_templateFile_3"  for="order_templateFile_3">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="order_file_type[]" class="form-control form-control-sm"  id="file_name_order_templateFile_4" value="৭৭ বিধি কারন দর্শানোর নোটিশ" placeholder="৭৭ বিধি কারন দর্শানোর নোটিশ">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                        <input type="file" id="order_templateFile_4" onChange="orderTemplateFile(4)" id="order_templateFile_4" style="display: none;" name="order_file_name[]">
                                                            <label class=" custom-file-label order_templateFile_4"  for="order_templateFile_4">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                                     
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input  type="text" name="order_file_type[]" class="form-control form-control-sm"  id="file_name_order_templateFile_5" value="২৯ ধারার গ্রেফতারী পরোয়ানা" placeholder="২৯ ধারার গ্রেফতারী পরোয়ানা">
                                                    
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" id="order_templateFile_5" onChange="orderTemplateFile(5)" id="order_templateFile_5" style="display: none;" name="order_file_name[]">
                                                                <label class=" custom-file-label order_templateFile_5"  for="order_templateFile_5">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                                
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <input  type="text" name="order_file_type[]" class="form-control form-control-sm"  id="file_name_order_templateFile_6" value="অস্থাবর সম্পত্তির দখলকারীকে সম্পত্তি নিলামে বিক্রির সম্পর্কে নোটিশ ক্রোক পরোয়ানা" placeholder="অস্থাবর সম্পত্তির দখলকারীকে সম্পত্তি নিলামে বিক্রির সম্পর্কে নোটিশ ক্রোক পরোয়ানা">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" id="order_templateFile_6" onChange="orderTemplateFile(6)" id="order_templateFile_6" style="display: none;" name="order_file_name[]">
                                                            <label class=" custom-file-label order_templateFile_6"  for="order_templateFile_6">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                             
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="order_file_type[]" class="form-control form-control-sm"  id="file_name_order_templateFile_7" value="ঘোষণাপত্র স্থির করবার নোটিশ" placeholder="ঘোষণাপত্র স্থির করবার নোটিশ">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" id="order_templateFile_7" onChange="orderTemplateFile(7)" id="order_templateFile_7" style="display: none;" name="order_file_name[]">
                                                            <label class=" custom-file-label order_templateFile_7"  for="order_templateFile_7">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="order_file_type[]" class="form-control form-control-sm"  id="file_name_order_templateFile_8" value="দখল অর্পণের আদেশ" placeholder="দখল অর্পণের আদেশ">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                        <input type="file" id="order_templateFile_8" onChange="orderTemplateFile(8)" id="order_templateFile_8" style="display: none;" name="order_file_name[]">
                                                            <label class=" custom-file-label order_templateFile_8"  for="order_templateFile_8">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                                
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="order_file_type[]" class="form-control form-control-sm"  id="file_name_order_templateFile_9" value="নিলাম ইস্তেহার" placeholder="নিলাম ইস্তেহার">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                        <input type="file" id="order_templateFile_9" onChange="orderTemplateFile(9)" id="order_templateFile_9" style="display: none;" name="order_file_name[]">
                                                            <label class=" custom-file-label order_templateFile_9"  for="order_templateFile_9">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="order_file_type[]" class="form-control form-control-sm"  id="file_name_order_templateFile_10" value="নিলাম ইস্তেহার প্রকাশে নাজিরকে আদেশ" placeholder="নিলাম ইস্তেহার প্রকাশে নাজিরকে আদেশ">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                        <input type="file" id="order_templateFile_10" onChange="orderTemplateFile(10)" id="order_templateFile_10" style="display: none;" name="order_file_name[]">
                                                            <label class=" custom-file-label order_templateFile_10"  for="order_templateFile_10">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                                        <!-- <button type="button"
                                                            class="fas fa-minus-circle btn btn-sm btn-danger font-weight-bolder removeRow"></button> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <input type="text" data-name="file.type"
                                                    class="form-control form-control-sm" placeholder="আদেশের টেমপ্লেট">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" data-name="file.name"
                                                                class="custom-file-input">
                                                            <label class="custom-file-label custom-input2"
                                                                for="customFile2">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                                        
                                                    </div>
                                                </div>
                                            </div> -->
                                            
                                        </div>
                                    <!-- </div> -->
                                    <div class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                                        <div class="d-flex align-items-center mr-2 py-2">
                                            <h3 class="mb-0 mr-8">হাজিরা সংযুক্তি (যদি থাকে)</h3>
                                        </div>
                                    </div>
                                    <br>
                                    <!-- <div id="template" > -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="attendance_file_type" class="form-control form-control-sm"
                                                id="file_name_attendance" placeholder="হাজিরা">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                        
                                                            <input type="file" id="attendance_customFile" onChange="attendancefile()" name="attendance_file_name" style="display: none;">
                                                            <label class="custom-file-label attendance_customFile"
                                                                for="attendance_customFile">ফাইল নির্বাচন করুন</label>
                                                        </div>

                                                        <!-- <button type="button"
                                                            class="fas fa-minus-circle btn btn-sm btn-danger font-weight-bolder removeRow"></button> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div> -->
                                </fieldset>
                                <!--begin::Step 4-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-between mt-5 pt-10">
                                    <div class="mr-2">
                                        <button type="button"
                                            class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4"
                                            data-wizard-type="action-prev">পূর্ববর্তী</button>
                                    </div>
                                    <div>
                                        <input type="hidden" name="status" value="DRAFT_FOR_RUNNING_ENTRY_CASE">
                                        <button type="button"
                                            class="btn btn-success font-weight-bolder text-uppercase px-9 py-4"
                                            data-wizard-type="action-submit">প্রেরণ করুন</button>
                                        <button type="button"
                                            class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"
                                            data-wizard-type="action-next">পরবর্তী পদক্ষেপ</button>
                                    </div>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end::Form Wizard-->
                        </div>
                    </div>
                    <!--end::Wizard Body-->
                </div>
           </div>
        </div>
    </div>
    
@endsection
@section('styles')
@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script>
    $(document).ready(function() {

        $('#inputBoxContainer').hide();
        $('#inputBoxContainer2').hide();
        jQuery('#applicantTypeBank').on('change',function(){
            // alert('hi');
            var organization_type = jQuery(this).val();
            // alert(organization_type);
                if (organization_type === 'BANK') {
                $('#inputBoxContainer').show();
                $('#inputBoxContainer2').hide();
                $('#applicantOrganizationID_1').val('');
                
                } else {
                $('#inputBoxContainer2').show();
                $('#inputBoxContainer').hide();
                $('#applicantOrganizationID_2').val('');

                }
            jQuery.ajax({
                url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentorganization/',
                type: "POST",
                dataType: "json",
                data:{
                    _token: "{{ csrf_token() }}",
                    division_id:$('#division_id').val(),
                    district_id:$('#district_id').val(),
                    upazila_id:$('#upazila_id').val(),
                    organization_type:organization_type
                },
                success: function(data) {
        
                    jQuery('select[name="applicant[organization][0]"]').html(
                        '<option value="">-- নির্বাচন করুন --</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('select[name="applicant[organization][0]"]').append(
                            '<option value="' + value.organization_routing_id + '">' + value.office_name_bn + '</option>'
                            );
                    });
                    // jQuery('select[name="office_id"]').append(
                    //         '<option value="OTHERS">অনন্যা</option>'
                    //         );
                }
            });



        })

        jQuery('#applicantOrganization_1').on('change', function() {
            const routingNumber = jQuery(this).val();
            const org_type = $('#applicantTypeBank').val();
            if (org_type === 'OTHER_COMPANY' || org_type === 'GOVERNMENT') {
                $('#applicantOrganizationID_2').val(routingNumber);
            } else {
                $('#applicantOrganizationID_1').val(routingNumber);
            }
        })



    });

    


    function runningAttachmentTitle() {
  
    // var value = $('#customFile' + id).val();
    var value = $('#order_customFile')[0].files[0];
    
    const fsize = $('#order_customFile')[0].files[0].size;
    const file_size = Math.round((fsize / 1024));
    
    var file_extension = value['name'].split('.').pop().toLowerCase();
  

 



   if ($.inArray(file_extension, ['pdf', 'docx']) == -1) {
       Swal.fire(
  
           'ফাইল ফরম্যাট PDF,docx হতে হবে ',
  
       )
      // $(obj).closest("tr").remove();
   }
   if (file_size > 30720) {
       Swal.fire(
  
           'ফাইল সাইজ অনেক বড় , ফাইল সাইজ ২ মেগাবাইটের কম হতে হবে',
  
       )
       //$(obj).closest("tr").remove();
   }
  
  var custom_file_name = $('#file_name_important').val();
  
  if (custom_file_name == "") {
  
      Swal.fire(
  
          'ফাইল এর প্রথমে যে নাম দেয়ার field আছে সেখানে ফাইল এর নাম দিন ',
  
      )
      //  $(obj).closest("tr").remove();
  }

  var fileName = value['name'].split('\\').pop();
     console.log(value);

     $('.order_customFilealamin').text(value['name']);
  }

  function attendancefile(){
    // var value = $('#customFile' + id).val();
    var value = $('#attendance_customFile')[0].files[0];
    
    const fsize = $('#attendance_customFile')[0].files[0].size;
    const file_size = Math.round((fsize / 1024));
    
    var file_extension = value['name'].split('.').pop().toLowerCase();
  if ($.inArray(file_extension, ['pdf', 'docx']) == -1) {
      Swal.fire(
 
          'ফাইল ফরম্যাট PDF,docx হতে হবে ',
 
      )
     //  $(obj).closest("tr").remove();
  }
  if (file_size > 30720) {
      Swal.fire(
 
          'ফাইল সাইজ অনেক বড় , ফাইল সাইজ ২ মেগাবাইটের কম হতে হবে',
 
      )
     //  $(obj).closest("tr").remove();
  }
 
    const custom_file_name = $('#file_name_attendance').val();
    
    if (custom_file_name == "") {
        Swal.fire(
    
            'ফাইল এর প্রথমে যে নাম দেয়ার field আছে সেখানে ফাইল এর নাম দিন ',
        )
        //  $(obj).closest("tr").remove();
    }

    var fileName = value['name'].split('\\').pop();
    $('.attendance_customFile').text(value['name']);
  }

  function orderTemplateFile(id){
    
      // var value = $('#customFile' + id).val();
      var value = $('#order_templateFile_'+id)[0].files[0];
    
    const fsize = $('#order_templateFile_'+id)[0].files[0].size;
    const file_size = Math.round((fsize / 1024));
    
    var file_extension = value['name'].split('.').pop().toLowerCase();
  if ($.inArray(file_extension, ['pdf', 'docx']) == -1) {
      Swal.fire(
 
          'ফাইল ফরম্যাট PDF,docx হতে হবে ',
 
      )
     //  $(obj).closest("tr").remove();
  }
  if (file_size > 30720) {
      Swal.fire(
 
          'ফাইল সাইজ অনেক বড় , ফাইল সাইজ ২ মেগাবাইটের কম হতে হবে',
 
      )
     //  $(obj).closest("tr").remove();
  }
 
    const custom_file_name = $('#file_name_order_templateFile_'+id).val();
 
    if (custom_file_name == "") {
        Swal.fire(
    
            'ফাইল এর প্রথমে যে নাম দেয়ার field আছে সেখানে ফাইল এর নাম দিন ',
        )
        //  $(obj).closest("tr").remove();
    }

    var fileName = value['name'].split('\\').pop();
    $('.order_templateFile_'+id).text(value['name']);
  }



</script>

<script type="text/javascript">

        
    function totalSum(){


        var totalLoanAmount = parseFloat(NumToBangla.replaceBn2EnNumbers($('#totalLoanAmount').val())) || 0;
        var totalInterest = parseFloat(NumToBangla.replaceBn2EnNumbers($('#totalInterest').val())) || 0;
        var totalAmountWithInterest = totalLoanAmount + totalInterest;
     
        console.log(totalAmountWithInterest);
        
        $('#totalAmountWithInterest').val(NumToBangla.en2bn(totalAmountWithInterest));
    }
    
</script>
<script src="{{ asset('js/number2banglaWord.js?v=1') }}"></script>



    @include('citizenAppealInitiate.appealCreate_Js')

@endsection

<!-- begin::Styles the pages -->
@push('footer')
    {{-- <script src="{{ asset('js/es6-shim.min.js') }}"></script> --}}
    <script src="{{ asset('js/appeal/Tachyons.min.js') }}"></script>
    <script src="{{ asset('js/appeal/appealCreateValidateOn-trial.js') }}"></script>
    
    
@endpush
<!-- end::Styles the pages -->