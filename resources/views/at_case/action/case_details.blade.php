@extends('layouts.default')

@section('content')

<!--begin::Row-->
@include('at_case/action/inc_case_details/_send_sec')
<!--end::Row-->

<!--begin::Row-->
<div class="row">
    <div class="col-xl-12">
        <div class="alert alert-custom alert-notice alert-light-info fade show mb-5" role="alert" id="forwardSuccess"
            style="display: none;">
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
                    <ul class="nav nav-tabs nav-success nav-tabs-space-lg nav-tabs-line nav-bolder nav-tabs-line-3x"
                        role="tablist">
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
                            <a class="nav-link" data-toggle="tab" href="#tab_sf_report">
                                <span class="nav-icon"><i class="fa fas fa-layer-group mr-5"></i></span>
                                <span class="nav-text font-size-h3">চুড়ান্ত এসএফ প্রতিবেদন</span>
                            </a>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="tab" href="#tab_notice">
                                <span class="nav-icon"><i class="fa far fa-bell mr-5"></i></span>
                                <span class="nav-text font-size-h3">শুনানি নোটিশ</span>
                            </a>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="tab" href="#tab_result">
                                <span class="nav-icon"><i class="fa fas fa-receipt mr-5"></i></span>
                                <span class="nav-text font-size-h3">ফলাফল</span>
                            </a>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="tab" href="#tab_history">
                                <span class="nav-icon"><i class="fa fas fa-history mr-5"></i></span>
                                {{-- <span class="nav-text font-size-h3">হিস্টোরি</span> --}}
                                <span class="nav-text font-size-h3">টাইমলাইন</span>
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
                        @include('at_case/action/inc_case_details/_full_case')
                    </div>
                    <!--end::Tab Content-->

                    <!--begin::Tab Content-->
                    <div class="tab-pane" id="tab_sf" role="tabpanel">
                        @include('at_case/action/inc_case_details/_sf_tab')
                    </div>
                    <!--end::Tab Content-->

                    <!--begin::Tab Content-->
                    <div class="tab-pane" id="tab_sf_report" role="tabpanel">
                        @include('at_case/action/inc_case_details/_final_sf')
                    </div>
                    <!--end::Tab Content-->

                    <!--begin::Tab Content-->
                    <div class="tab-pane" id="tab_notice" role="tabpanel">
                        @include('at_case/action/inc_case_details/_case_hearing')
                    </div>
                    <!--end::Tab Content-->


                    <!--begin::Tab Content-->
                    <div class="tab-pane" id="tab_result" role="tabpanel">
                        @include('at_case/action/inc_case_details/_case_result')
                    </div>
                    <!--end::Tab Content-->

                    <!--begin::Tab Content-->
                    <div class="tab-pane" id="tab_history" role="tabpanel">
                        @include('at_case/action/inc_case_details/_case_history')
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
    {{-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <!--end::Page Vendors Styles-->
@endsection


{{-- Scripts Section Related Page --}}
@section('scripts')
    <!-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script> -->
    <!-- <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script> -->
    <!--end::Page Scripts-->
    <!-- <script src="{{ asset('plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script> -->
    <!-- <script src="{{ asset('js/pages/crud/forms/editors/ckeditor-classic.js') }}"></script> -->
    <!--end::Page Scripts-->

   @include('at_case.action.inc_case_details._script')
@endsection
