@extends('layouts.default')

@section('content')
<style>
    legend{
        height: 70px;
    }
</style>

    <div class="row">

        <div class="col-md-12">

            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    <div class="card-toolbar">
  
                    </div>
                </div>


                <form action="{{ url('report/pdf') }}" class="form" method="POST" target="_blank">
                    @csrf
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8    )
                            <fieldset class="mb-6">
                                <legend>ফিল্টারিং ফিল্ড সমূহ</legend>

                                <div class="form-group row">
                                    @if (globalUserInfo()->role_id != 6 || globalUserInfo()->role_id != 7)
                                        <div class="col-lg-2 mb-3">
                                            <select name="division" class="form-control form-control-sm">
                                                <option value="">-বিভাগ নির্বাচন করুন-</option>
                                                @foreach ($divisions as $value)
                                                    <option value="{{ $value->id }}"> {{ $value->division_name_bn }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    
                                        <div class="col-lg-2 mb-3">
                                            <select name="district" id="district_id" class="form-control form-control-sm">
                                                <option value="">-জেলা নির্বাচন করুন-</option>
                                            </select>
                                        </div>
                                    
                                        <div class="col-lg-2 mb-3">
                                            <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                                                <option value="">-উপজিলা নির্বাচন করুন-</option>
                                            </select>
                                        </div>
                                    @endif

                                        <div class="col-lg-3 mb-3">
                                            <input type="text" name="date_start" class="form-control form-control-sm common_datepicker" 
                                                placeholder="তারিখ হতে" autocomplete="off">
                                        </div>
                                    
                                        <div class="col-lg-3 mb-3">
                                            <input type="text" name="date_end" class="form-control form-control-sm common_datepicker" 
                                                placeholder="তারিখ পর্যন্ত" autocomplete="off">
                                        </div>

                                </div>
                            </fieldset>
                        @endif

                        @if (globalUserInfo()->role_id == 34)
                            <fieldset class="mb-6">
                                <legend>ফিল্টারিং ফিল্ড সমূহ</legend>
                                <input type="hidden" name="division" value="{{user_office_info()->division_id}}">
                                <div class="form-group row">

                                    <div>
                                        <div id="userDivisionName" data-user-division-name="{{ $user_division_name }}">
                                        </div>
                                        <div id="userDivisionId" data-user-division-id="{{ $user_division_id }}"></div>
                                    </div>
                                    <div class="col-lg-3 mb-5">
   
                                        <select name="district" id="district_id" class="form-control form-control-sm">
                                            <option value="">-জেলা নির্বাচন করুন-</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-2 mb-3">
                                        <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                                            <option value="">-উপজিলা নির্বাচন করুন-</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 mb-5">
                                        <input type="text" name="date_start"
                                            class="form-control form-control-sm common_datepicker" placeholder="তারিখ হতে"
                                            autocomplete="off">
                                    </div>
                                    <div class="col-lg-3 mb-5">
                                        <input type="text" name="date_end"
                                            class="form-control form-control-sm common_datepicker"
                                            placeholder="তারিখ পর্যন্ত" autocomplete="off">
                                    </div>

                                </div>
                            </fieldset>
                        @endif

                        @if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7)
                            <fieldset class="mb-6">
                                <legend>ফিল্টারিং ফিল্ড সমূহ</legend>
                                <input type="hidden" name="division" value="{{user_office_info()->division_id}}">
                                <input type="hidden" name="district" value="{{user_office_info()->district_id}}">

                                <div class="form-group row">
                                    <div>
                                        <div id="userDistrictName" data-user-district-name="{{ $user_district_name }}">
                                        </div>
                                        <div id="userDistrictId" data-user-district-id="{{ $user_district_id }}"></div>
                                    </div>

                                    <div class="col-lg-2 mb-3">
                                        <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                                            <option value="">-উপজিলা নির্বাচন করুন-</option>
                                        </select>
                                    </div>
                                    

                                    <div class="col-lg-3 mb-5">
                                        <input type="text" name="date_start"
                                            class="form-control form-control-sm common_datepicker" placeholder="তারিখ হতে"
                                            autocomplete="off">
                                    </div>
                                    <div class="col-lg-3 mb-5">
                                        <input type="text" name="date_end"
                                            class="form-control form-control-sm common_datepicker"
                                            placeholder="তারিখ পর্যন্ত" autocomplete="off">
                                    </div>

                                </div>
                            </fieldset>
                        @endif

                        @if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8 || globalUserInfo()->role_id == 34)
                            <div class="row">
                                <fieldset class="col-lg-4 mb-6">
                                    <legend>জেনারেল সার্টিফিকেট আদালতের মামলা সংক্রান্ত বিস্তারিত তথ্য
                                    </legend>
                                    @if (globalUserInfo()->role_id == 34)
                                    @else
                                        <button type="submit" name="btnsubmit" value="pdf_num_division"
                                            class="btn btn-info btn-cons margin-top"> বিভাগ ভিত্তিক</button>
                                    @endif

                                    <button type="submit" name="btnsubmit" value="pdf_num_district"
                                        onclick="return validFunc1()" class="btn btn-info btn-cons margin-top"> জেলা
                                        ভিত্তিক</button>
                                    <button type="submit" name="btnsubmit" value="pdf_num_upazila"
                                        onclick="return validFunc2()" class="btn btn-info btn-cons margin-top"> উপজেলা
                                        ভিত্তিক</button>
                                </fieldset>

                                <fieldset class="col-lg-4 mb-6">
                                    <legend>জেনারেল সার্টিফিকেট আদালতে অর্থ আদায় সংক্রান্ত তথ্য</legend>
                                    @if (globalUserInfo()->role_id == 34)
                                    @else
                                        <button type="submit" name="btnsubmit" value="pdf_payment_division"
                                            class="btn btn-info btn-cons margin-top"> বিভাগ ভিত্তিক</button>
                                    @endif
                                    <button type="submit" name="btnsubmit" value="pdf_payment_district"
                                        onclick="return validFunc1()" class="btn btn-info btn-cons margin-top"> জেলা
                                        ভিত্তিক</button>
                                    <button type="submit" name="btnsubmit" value="pdf_payment_upazila"
                                        onclick="return validFunc2()" class="btn btn-info btn-cons margin-top"> উপজেলা
                                        ভিত্তিক</button>
                                </fieldset>
                                <fieldset class="col-lg-4 mb-6">
                                    <legend>জেনারেল সার্টিফিকেট আদালতে দিন ভিত্তিক রিপোর্ট</legend>
                                        <button type="submit" name="btnsubmit" value="pdf_new_report_division"
                                            class="btn btn-info btn-cons margin-top"> বিভাগ ভিত্তিক</button>
                                    <button type="submit" name="btnsubmit" value="pdf_new_report_district"
                                        onclick="return validFunc1()" class="btn btn-info btn-cons margin-top"> জেলা
                                        ভিত্তিক</button>
                                    <button type="submit" name="btnsubmit" value="pdf_new_report_upazila"
                                        onclick="return validFunc2()" class="btn btn-info btn-cons margin-top"> উপজেলা
                                        ভিত্তিক</button>
                                </fieldset>
                                
                            </div>
                            <div class="row">
                                <fieldset class="col-lg-4 mb-6">
                                    <legend>জেনারেল সার্টিফিকেট আদালতে দৈনিক রিপোর্ট</legend>
                                    @if (globalUserInfo()->role_id == 34)
                                    @else
                                        <button type="submit" name="btnsubmit" value="pdf_daily_division"
                                            class="btn btn-info btn-cons margin-top"> বিভাগ ভিত্তিক</button>
                                    @endif
                                    <button type="submit" name="btnsubmit" value="pdf_daily_district"
                                        onclick="return validFunc1()" class="btn btn-info btn-cons margin-top"> জেলা
                                        ভিত্তিক</button>
                                    <button type="submit" name="btnsubmit" value="pdf_daily_upazila"
                                        onclick="return validFunc2()" class="btn btn-info btn-cons margin-top"> উপজেলা
                                        ভিত্তিক</button>
                                </fieldset>
                                <fieldset class="col-lg-4 mb-6">
                                    <legend>জেনারেল সার্টিফিকেট আদালতে আদালত ভিত্তিক রিপোর্ট</legend>
                                    <button type="submit" name="btnsubmit" value="pdf_case"
                                        class="btn btn-info btn-cons margin-top"> মামলার তালিকা</button>
                                </fieldset>
                            </div>
                        @elseif (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7)
                            <div class="row">
                                <fieldset class="col-lg-4 mb-6 ">
                                    <legend>জেনারেল সার্টিফিকেট আদালতের মামলা সংক্রান্ত বিস্তারিত তথ্য</legend>

                                    <button type="submit" name="btnsubmit" value="pdf_num_upazila"
                                        onclick="return validFunc2()" class="btn btn-info btn-cons margin-top"> উপজেলা
                                        ভিত্তিক</button>
                                </fieldset>
                                
                                <fieldset class="col-lg-4 mb-6">
                                    <legend>জেনারেল সার্টিফিকেট আদালতে অর্থ আদায় সংক্রান্ত তথ্য </legend>

                                    <button type="submit" name="btnsubmit" value="pdf_payment_upazila"
                                        onclick="return validFunc2()" class="btn btn-info btn-cons margin-top"> উপজেলা
                                        ভিত্তিক</button>
                                </fieldset>
                                <fieldset class="col-lg-4 mb-6">
                                    <legend>জেনারেল সার্টিফিকেট আদালতে দিন ভিত্তিক রিপোর্ট</legend>
                                        
                                    <button type="submit" name="btnsubmit" value="pdf_new_report_district"
                                        onclick="return validFunc1()" class="btn btn-info btn-cons margin-top"> জেলা
                                        ভিত্তিক</button>
                                    <button type="submit" name="btnsubmit" value="pdf_new_report_upazila"
                                        onclick="return validFunc2()" class="btn btn-info btn-cons margin-top"> উপজেলা
                                        ভিত্তিক</button>
                                </fieldset>
                            </div>

                            <div class="row">
                                <fieldset class="col-lg-4 mb-6">
                                    <legend>জেনারেল সার্টিফিকেট আদালতে দৈনিক রিপোর্ট</legend>
                                    
                                    <button type="submit" name="btnsubmit" value="pdf_daily_upazila"
                                        onclick="return validFunc2()" class="btn btn-info btn-cons margin-top"> উপজেলা
                                        ভিত্তিক</button>
                                </fieldset>
                                <fieldset class="col-lg-4 mb-6">
                                    <legend> জেনারেল সার্টিফিকেট আদালতে আদালত ভিত্তিক রিপোর্ট</legend>
                                    <button type="submit" name="btnsubmit" value="pdf_case"
                                        class="btn btn-info btn-cons margin-top"> মামলার তালিকা</button>

                                </fieldset>
                            </div>
                            
                        @endif

                    </div>


                </form>
  
            </div>
      
        </div>

    </div>


@endsection


@section('styles')

@endsection

@section('scripts')
    <script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
    <script>
        // common datepicker
        $('.common_datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            orientation: "bottom left"
        });
    </script>

    <script type="text/javascript">
        jQuery(document).ready(function() {

            // Dependable District List
            jQuery('select[name="division"]').on('change', function() {
                var dataID = jQuery(this).val();

                jQuery("#district_id").after('<div class="loadersmall"></div>');

                if (dataID) {
                    jQuery.ajax({
                        url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentdistrict/' +
                            dataID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="district"]').html(
                                '<div class="loadersmall"></div>');

                            jQuery('select[name="district"]').html(
                                '<option value="">--জেলা নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                jQuery('select[name="district"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                            jQuery('.loadersmall').remove();
                        }
                    });
                } else {
                    $('select[name="district"]').after('<option value="">--জেলা নির্বাচন করুন --</option>');
                }
            });



            // Dependable Upazila List
            jQuery('select[name="district"]').on('change', function() {
                var dataID = jQuery(this).val();

                jQuery("#upazila_id").after('<div class="loadersmall"></div>');

                if (dataID) {
                    jQuery.ajax({
                        url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentupazila/' +
                            dataID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="upazila"]').html(
                                '<div class="loadersmall"></div>');

                            jQuery('select[name="upazila"]').html(
                                '<option value="">--উপজেলা নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                jQuery('select[name="upazila"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                            jQuery('.loadersmall').remove();
                        }
                    });
                } else {
                    $('select[name="upazila"]').empty();
                }
            });
            

            const user_division_name = $('#userDivisionName').data('userDivisionName');
            const user_division_id = $('#userDivisionId').data('userDivisionId');
            // console.log($('#userDivisionId'))
            if (user_division_id) {
                jQuery.ajax({
                    url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentdistrict/' +
                        user_division_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="district"]').html(
                            '<div class="loadersmall"></div>');

                        jQuery('select[name="district"]').html(
                            '<option value="">--জেলা নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="district"]').append(
                                '<option value="' + key + '">' + value +
                                '</option>');
                        });
                        jQuery('.loadersmall').remove();
                    }
                });
            } else {
                $('select[name="district"]').empty();
            }

            const user_district_name = $('#userDistrictName').data('userDistrictName');
            const user_district_id = $('#userDistrictId').data('userDistrictId');

            if (user_district_id) {
                jQuery.ajax({
                    url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentupazila/' +
                        user_district_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="upazila"]').html(
                            '<div class="loadersmall"></div>');

                        jQuery('select[name="upazila"]').html(
                            '<option value="">--উপজেলা নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="upazila"]').append(
                                '<option value="' + key + '">' + value +
                                '</option>');
                        });
                        jQuery('.loadersmall').remove();
                    }
                });
            } else {
                $('select[name="upazila"]').empty();
            }

        });
    </script>
    <!--end::Page Scripts-->
@endsection
