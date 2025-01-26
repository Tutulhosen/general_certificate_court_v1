@extends('layouts.citizen.citizen')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom col-12">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label"> {{ $page_title }} </h3>
            </div>
            <!-- <div class="card-toolbar">
             <a href="{{ url('division') }}" class="btn btn-sm btn-primary font-weight-bolder">
                <i class="la la-list"></i> ব্যবহারকারীর তালিকা
             </a>
          </div> -->
        </div>
        
      <a href=""></a>
      @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
     @endif
      @if(Session::has('organization_case_error'))
      <div class="alert alert-danger">
        {{ Session::get('organization_case_error') }}
      </div>
      @endif
        <form action="{{ route('post.organization.change.applicant') }}" method="POST">
            @csrf
                

            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="mb-12">
                    <div class="form-group row">

                        <div class="col-lg-3 mb-5">
                            <label>বিভাগ নির্বাচন<span class="text-danger">*</span></label>
                            <select class="form-control" aria-label=".form-select-lg example" name="division_id"
                                id="division_id" required>
                                <option value="">বিভাগ নির্বাচন করুন </option>
                                @foreach ($division as $single_division)
                                    <option value="{{ $single_division->id }}">{{ $single_division->division_name_bn }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <label>জেলা নির্বাচন করুন <span class="text-danger">*</span></label>
                            <select class="form-control" aria-label=".form-select-lg example" name="district_id"
                                id="district_id" required>
                                <option value="">জেলা নির্বাচন করুন </option>

                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <label>উপজেলা নির্বাচন করুন <span class="text-danger">*</span></label>
                            <select class="form-control" aria-label=".form-select-lg example" name="upazila_id"
                                id="upazila_id" required>
                                <option value="">উপজেলা নির্বাচন করুন </option>

                            </select>
                        </div>
                        <div class="col-lg-3 mb-5">
                            <label>প্রতিষ্ঠানের ধরন নির্বাচন করুন <span class="text-danger">*</span></label>
                            <select class="form-control" aria-label=".form-select-lg example" name="organization_type"
                                id="organization_type" required>
                                <option value="">প্রতিষ্ঠানের ধরন নির্বাচন করুন </option>
                                <option value="BANK">ব্যাংক</option>
                                <option value="GOVERNMENT">সরকারি প্রতিষ্ঠান</option>
                                <option value="OTHER_COMPANY">স্বায়ত্তশাসিত প্রতিষ্ঠান</option>
                            </select>
                        </div>
                        {{-- ** Perse by Division District *** --}}

                        <div class="col-lg-12 mb-5">
                            <label> প্রতিষ্ঠানের নাম <span class="text-danger">*</span></label>
                            <select class="form-control" aria-label=".form-select-lg example" name="office_id" id="office_id" required>
                                <option value=" ">প্রতিষ্ঠান নির্বাচন করুন </option>
                                
                            </select>
                            @error('office_id')
                                <div class="alert alert-danger">প্রতিষ্ঠান নির্বাচন করুন</div>
                            @enderror
                        </div>
                        
                        <div class="col-lg-12 mb-5">
                            <label> প্রতিষ্ঠানের নাম বাংলাতে <span class="text-danger">*</span></label>
                            <input type="text" name="office_name_bn" id="office_name_bn" class="form-control form-control-sm" value="{{ old('office_name_bn') }}" required>
                            @error('office_name_bn')
                                <div class="alert alert-danger"> প্রতিষ্ঠানের নাম বাংলাতে দিন</div>
                            @enderror
                        </div>
                        <div class="col-lg-12 mb-5">
                            <label> প্রতিষ্ঠানের নাম ইংরেজিতে<span class="text-danger">*</span></label>
                            <input type="text" name="office_name_en" id="office_name_en" class="form-control form-control-sm only_english" value="{{ old('office_name_en') }}" required>
                            @error('office_name_en')
                                <div class="alert alert-danger"> প্রতিষ্ঠানের নাম ইংরেজিতে দিন</div>
                            @enderror
                        </div>

                        <div class="col-lg-12 mb-5">
                            <label> প্রতিষ্ঠানের ঠিকানা <span class="text-danger">*</span></label>
                            <textarea name="organization_physical_address" id="organization_physical_address" class="form-control form-control-sm common_datepicker"
                            autocomplete="off">{{ old('organization_physical_address') }}</textarea>
                            @error('organization_physical_address')
                                <div class="alert alert-danger">প্রতিষ্ঠানের ঠিকানা দিন</div>
                            @enderror
                        </div>                        
                        <div class="col-lg-12 mb-5">
                            <label> পদবী <span class="text-danger">*</span></label>
                            <input type="text" name="designation" id="designation"
                                class="form-control form-control-sm"
                                value="{{ globalUserInfo()->designation }}"
                                required >
                            
                            @error('designation')
                                <div class="alert alert-danger"> পদবী দিতে হবে</div>
                             @enderror
                        </div>
                        <div class="col-lg-12 mb-5">
                            <label> প্রতিষ্ঠান প্রতিনিধির প্রতিষ্ঠানে , প্রতিষ্ঠান প্রতিনিধির EmployeeID (ইংরেজিতে)<span class="text-danger">*</span></label>
                            <input type="text" name="organization_employee_id" id="organization_employee_id"
                                class="form-control form-control-sm only_english"
                                value="{{ globalUserInfo()->organization_employee_id  }}"
                                required >
                        </div>
                        
                        <div class="col-lg-12 mb-5">
                            <label> রাউটিং নং (ইংরেজিতে)<span class="text-danger">*</span></label>
                            <input type="text" name="organization_id" id="organization_id"
                                class="form-control form-control-sm only_english"
                                required value="{{ old('organization_id') }}">
                                
                            @error('organization_id')
                                <div class="alert alert-danger"> রাউটিং নং ইংরেজিতে দিন</div>
                            @enderror
                        </div>
                    </div>

                </div>
             
            </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary font-weight-bold mr-2">সংরক্ষণ</button>
            </div>
        </div>
    </div>

    </form>
    </div>
    <!--end::Card-->
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}

@section('scripts')
    <script src="assets/js/pages/custom/login/login-3.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            
            $(".only_english").keypress(function(event){
                    var ew = event.which;
                    if(ew == 32)
                        return true;
                    if(48 <= ew && ew <= 57)
                        return true;
                    if(65 <= ew && ew <= 90)
                        return true;
                    if(97 <= ew && ew <= 122)
                        return true;
                    return false;
            });
            jQuery('select[name="division_id"]').on('change', function() {
                var dataID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#district_id").after('<div class="loadersmall"></div>');
                // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
                // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
                // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
                // jQuery('.loadersmall').remove();
                if (dataID) {
                    jQuery.ajax({
                        url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentdistrict/' +
                            dataID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="district_id"]').html(
                                '<div class="loadersmall"></div>');
                            //console.log(data);
                            // jQuery('#mouja_id').removeAttr('disabled');
                            // jQuery('#mouja_id option').remove();

                            jQuery('select[name="district_id"]').html(
                                '<option value="">-- নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                jQuery('select[name="district_id"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                            jQuery('.loadersmall').remove();
                            // $('select[name="mouja"] .overlay').remove();
                            // $("#loading").hide();
                        }
                    });
                } else {
                    $('select[name="district_id"]').empty();
                }
            });

            // Upazila Dropdown
            jQuery('select[name="district_id"]').on('change', function() {
                var dataID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#upazila_id").after('<div class="loadersmall"></div>');
                // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
                // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
                // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
                // jQuery('.loadersmall').remove();
                /*if(dataID)
                {*/
                jQuery.ajax({
                    url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentupazila/' +
                        dataID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="upazila_id"]').html(
                            '<div class="loadersmall"></div>');
                        //console.log(data);
                        // jQuery('#mouja_id').removeAttr('disabled');
                        // jQuery('#mouja_id option').remove();

                        jQuery('select[name="upazila_id"]').html(
                            '<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="upazila_id"]').append(
                                '<option value="' + key + '">' + value + '</option>'
                                );
                        });
                        jQuery('.loadersmall').remove();
                        // $('select[name="mouja"] .overlay').remove();
                        // $("#loading").hide();
                    }
                });

            });

            jQuery('#organization_type').on('change',function(){
                var organization_type = jQuery(this).val();
                
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
                       
                       
                        jQuery('select[name="office_id"]').html(
                            '<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="office_id"]').append(
                                '<option value="' + value.id + '">' + value.office_name_bn + '</option>'
                                );
                        });
                        jQuery('select[name="office_id"]').append(
                                '<option value="OTHERS">অনন্যা</option>'
                                );
                    }
                });

            })
            

            jQuery('#office_id').on('change',function(){

                var dataID = jQuery(this).val();
                if(dataID=="OTHERS")
                {
                        $('#organization_physical_address').val("");
                        $('#organization_physical_address').prop('readonly',false);
                        $('#organization_id').val("");;
                        $('#organization_id').prop('readonly',false);
                       
                         $('#office_name_bn').val("");
                         $('#office_name_bn').prop('readonly',false);
                        $('#office_name_en').val("");
                        $('#office_name_en').prop('readonly',false);
                }
                else
                {
                   jQuery.ajax({
                    url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentOfficeName/' +
                        dataID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#organization_physical_address').val(data.organization_physical_address);
                        $('#organization_physical_address').prop('readonly',true);
                        $('#organization_id').val(data.organization_routing_id);
                        $('#organization_id').prop('readonly',true);
                        $('#office_name_bn').val(data.office_name_bn);
                        $('#office_name_en').val(data.office_name_en);
                        $('#office_name_bn').prop('readonly',true);
                        $('#office_name_en').prop('readonly',true);
                    }
                }); 
                }
                
            })
        });
    </script>
@endsection