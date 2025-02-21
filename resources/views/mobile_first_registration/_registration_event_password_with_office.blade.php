@extends('layouts.landing')
@section('content')
    <div class="row">
        <style>
            .thumb {
                width: 200px;
                height: 200Spx;
            }
        </style>
        <style>
            #password-strength-status {
                padding: 5px 10px;
                color: #FFFFFF;
                border-radius: 4px;
                margin-top: 5px;
            }

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

            .medium-password {
                background-color: #b7d60a;
                border: #BBB418 1px solid;
            }

            .weak-password {
                background-color: #ce1d14;
                border: #AA4502 1px solid;
            }

            .strong-password {
                background-color: #12CC1A;
                border: #0FA015 1px solid;
            }

            .waring-border-field {
                border: 2px solid #f5c6cb !important;

            }

            .warning-message-alert {
                color: red;
            }

            .waring-border-field-succes {
                border: 2px solid #c3e6cb !important;

            }
        </style>

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">

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
                <h2 class="text-center">
                    <div class="btn btn-success font-weight-bolder" style="font-size: 25px;">প্রোফাইল</div>
                </h2>
                <form action="{{ route('mobile.first.password.match.organization') }}" class="form" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        @if (isset($gmail))
                            <input type="hidden" name="gmail" value="{{ $gmail }}">
                        @endif

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
                                <select class="form-control" aria-label=".form-select-lg example" name="office_id"
                                    id="office_id" required>
                                    <option value=" ">প্রতিষ্ঠান নির্বাচন করুন </option>

                                </select>
                                @error('office_id')
                                    <div class="alert alert-danger">প্রতিষ্ঠান নির্বাচন করুন</div>
                                @enderror
                            </div>

                            <div class="col-lg-12 mb-5">
                                <label> প্রতিষ্ঠানের নাম বাংলাতে <span class="text-danger">*</span></label>
                                <input type="text" name="office_name_bn" id="office_name_bn"
                                    class="form-control form-control-sm" value="{{ old('office_name_bn') }}" required>
                                @error('office_name_bn')
                                    <div class="alert alert-danger"> প্রতিষ্ঠানের নাম বাংলাতে দিন</div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-5">
                                <label> প্রতিষ্ঠানের নাম ইংরেজিতে<span class="text-danger">*</span></label>
                                <input type="text" name="office_name_en" id="office_name_en"
                                    class="form-control form-control-sm only_english" value="{{ old('office_name_en') }}"
                                    required>
                                @error('office_name_en')
                                    <div class="alert alert-danger"> প্রতিষ্ঠানের নাম ইংরেজিতে দিন</div>
                                @enderror
                            </div>

                            <div class="col-lg-12 mb-5">
                                <label> প্রতিষ্ঠানের ঠিকানা <span class="text-danger">*</span></label>
                                <textarea name="organization_physical_address" id="organization_physical_address"
                                    class="form-control form-control-sm common_datepicker" autocomplete="off">{{ old('organization_physical_address') }}</textarea>
                                @error('organization_physical_address')
                                    <div class="alert alert-danger">প্রতিষ্ঠানের ঠিকানা দিন</div>
                                @enderror
                            </div>

                            <div class="col-lg-12 mb-5">
                                <label> রাউটিং নং (ইংরেজিতে)<span class="text-danger">*</span></label>
                                <input type="text" name="organization_id" id="organization_id"
                                    class="form-control form-control-sm only_english" required
                                    value="{{ old('organization_id') }}">

                                @error('organization_id')
                                    <div class="alert alert-danger"> রাউটিং নং ইংরেজিতে দিন</div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-5">
                                <label> পদবী <span class="text-danger">*</span></label>
                                <input type="text" name="designation" id="designation"
                                    class="form-control form-control-sm" value="{{ old('designation') }}" required
                                    value="{{ old('designation') }}">
                            </div>
                            <div class="col-lg-12 mb-5">
                                <label>প্রতিষ্ঠান প্রতিনিধির আইডি (ইংরেজিতে)<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="organization_employee_id" id="organization_employee_id"
                                    class="form-control form-control-sm only_english"
                                    value="{{ old('organization_employee_id') }}" required
                                    value="{{ old('organization_employee_id') }}">
                            </div>
                            @if (!isset($gmail))
                                <div class="col-lg-6 mb-5form-group">

                                    <label>পাসওয়ার্ড <span class="text-danger">*</span></label>
                                    <div class="input-group" id="show_hide_password_organization_registation">
                                        <input type="password" name="password" id="password"
                                            class="form-control form-control-sm" required />

                                        <div class="input-group-addon bg-secondary">
                                            <a href=""><i class="fa fa-eye-slash p-5 mt-1"
                                                    aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div id="password-strength-status" class="text-danger"></div>
                                </div>
                                <div class="col-lg-6 mb-5form-group">
                                    <label>কনফার্ম পাসওয়ার্ড <span class="text-danger">*</span></label>
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        class="form-control form-control-sm" required />
                                    <span id='message'></span>
                                    @error('confirm_password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <input type="hidden" name="password" id="password"
                                    class="form-control form-control-sm" value="google_sso_login_password_14789_gcc_ourtm" required />

                                <input type="hidden" name="confirm_password" id="confirm_password"
                                    class="form-control form-control-sm" value="google_sso_login_password_14789_gcc_ourtm" required />
                            @endif
                        </div>

                        <!--end::Card-body-->
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-success mr-2"
                                    onclick="return confirm('আপনি কি সংরক্ষণ করতে চান?')">সংরক্ষণ করুন</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>

    </div>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $('#password, #confirm_password').on('keyup', function() {

            if ($('#password').val() == $('#confirm_password').val()) {
                $('#message').html('Matching').css('color', 'green');
            } else
                $('#message').html('Not Matching').css('color', 'red');
        });
    </script>
@endsection
@section('styles')
    <link href="assets/css/pages/login/login-3.css" rel="stylesheet" type="text/css" />
@endsection
@section('scripts')
    <script src="assets/js/pages/custom/login/login-3.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {


            $(".only_english").keypress(function(event) {
                var ew = event.which;
                if (ew == 32)
                    return true;
                if (48 <= ew && ew <= 57)
                    return true;
                if (65 <= ew && ew <= 90)
                    return true;
                if (97 <= ew && ew <= 122)
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

            jQuery('#organization_type').on('change', function() {
                var organization_type = jQuery(this).val();
                jQuery("#office_id").after('<div class="loadersmall"></div>');
                jQuery.ajax({
                    url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentorganization/',
                    type: "POST",
                    dataType: "json",
                    data: {

                        _token: "{{ csrf_token() }}",
                        division_id: $('#division_id').val(),
                        district_id: $('#district_id').val(),
                        upazila_id: $('#upazila_id').val(),
                        organization_type: organization_type
                    },
                    success: function(data) {


                        jQuery('select[name="office_id"]').html(
                            '<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="office_id"]').append(
                                '<option value="' + value.id + '">' + value
                                .office_name_bn + '</option>'
                            );
                        });
                        jQuery('select[name="office_id"]').append(
                            '<option value="OTHERS">অনন্যা</option>'
                        );
                    }
                });

            })


            jQuery('#office_id').on('change', function() {

                var dataID = jQuery(this).val();
                if (dataID == "OTHERS") {
                    $('#organization_physical_address').val("");
                    $('#organization_physical_address').prop('readonly', false);
                    $('#organization_id').val("");;
                    $('#organization_id').prop('readonly', false);

                    $('#office_name_bn').val("");
                    $('#office_name_bn').prop('readonly', false);
                    $('#office_name_en').val("");
                    $('#office_name_en').prop('readonly', false);
                } else {
                    jQuery.ajax({
                        url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentOfficeName/' +
                            dataID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#organization_physical_address').val(data
                                .organization_physical_address);
                            $('#organization_physical_address').prop('readonly', true);
                            $('#organization_id').val(data.organization_routing_id);
                            $('#organization_id').prop('readonly', true);
                            $('#office_name_bn').val(data.office_name_bn);
                            $('#office_name_en').val(data.office_name_en);
                            $('#office_name_bn').prop('readonly', true);
                            $('#office_name_en').prop('readonly', true);
                        }
                    });
                }

            })

            $(':input[type=file]').on('change', function() { //on file input change

                if (window.File && window.FileReader && window.FileList && window
                    .Blob) //check File API supported browser
                {
                    $('#thumb-output').html(''); //clear html of output element
                    var data = $(this)[0].files; //this file data

                    $.each(data, function(index, file) { //loop though each file
                        if (/(\.|\/)(gif|jpe?g|png)$/i.test(file
                                .type)) { //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file) { //trigger function on successful read
                                return function(e) {
                                    var img = $('<img/>').addClass('thumb').attr('src',
                                        e.target.result); //create image element
                                    $('#thumb-output').append(
                                        img); //append image to output element
                                };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                    });
                } else {
                    alert("Your browser doesn't support File API!"); //if File API is absent
                }
            });

            $('#password, #confirm_password').on('keyup', function() {
                if ($('#password').val() == $('#confirm_password').val()) {
                    $('#message').html('Matching').css('color', 'green');
                } else
                    $('#message').html('Not Matching').css('color', 'red');
            });

            $("#show_hide_password_organization_registation a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password_organization_registation input').attr("type") == "text") {
                    $('#show_hide_password_organization_registation input').attr('type', 'password');
                    $('#show_hide_password_organization_registation i').addClass("fa-eye-slash");
                    $('#show_hide_password_organization_registation i').removeClass("fa-eye");
                } else if ($('#show_hide_password_organization_registation input').attr("type") ==
                    "password") {
                    $('#show_hide_password_organization_registation input').attr('type', 'text');
                    $('#show_hide_password_organization_registation i').removeClass("fa-eye-slash");
                    $('#show_hide_password_organization_registation i').addClass("fa-eye");
                }
            });


            $("#password").on('keyup', function() {
                var number = /([0-9])/;
                var alphabets = /([a-zA-Z])/;
                var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
                if ($('#password').val().length < 6) {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('weak-password');
                    $('#password-strength-status').html("দুর্বল (অন্তত 6টি অক্ষর হতে হবে।)");
                    jQuery('#password').removeClass('waring-border-field-succes');
                    jQuery('#password').addClass('waring-border-field');
                } else {
                    if ($('#password').val().match(number) && $('#password').val().match(alphabets) && $(
                            '#password').val().match(special_characters)) {
                        $('#password-strength-status').removeClass();
                        $('#password-strength-status').addClass('strong-password');
                        $('#password-strength-status').html("শক্তিশালী");
                        jQuery('#password').removeClass('waring-border-field');
                        jQuery('#password').addClass('waring-border-field-succes');
                    } else {
                        $('#password-strength-status').removeClass();
                        $('#password-strength-status').addClass('medium-password');
                        $('#password-strength-status').html(
                            "মাঝারি (পাসওয়ার্ডে অন্তত একটি বড় হাতের অক্ষর, একটি ছোট হাতের অক্ষর, একটি সংখ্যা এবং একটি বিশেষ অক্ষর থাকতে হবে।)"
                        );
                        jQuery('#password').removeClass('waring-border-field');
                        jQuery('#password').addClass('waring-border-field-succes');
                    }
                }
            });

            function isEmail(email) {
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            }

            function isPhone(phone) {
                var regex = /(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/;
                return regex.test(phone);
            }

            $('#mobile_no').on('keyup', function() {

                let is_phone = isPhone($('#mobile_no').val());

                if (!is_phone) {
                    $(this).addClass('waring-border-field');
                    $(this).next('.phone_alert').removeClass('hide');
                    $(this).next('.phone_alert').addClass('show warning-message-alert');
                } else {

                    $(this).removeClass('waring-border-field');
                    $(this).next('.phone_alert').addClass('hide');
                    $(this).next('.phone_alert').removeClass('show warning-message-alert');
                }

            })
            $('#email').on('keyup', function() {

                let is_email = isEmail($('#email').val());
                if (!is_email) {
                    $(this).addClass('waring-border-field');
                    $(this).next('.email_alert').removeClass('hide');
                    $(this).next('.email_alert').addClass('show warning-message-alert');
                } else {

                    $(this).removeClass('waring-border-field');
                    $(this).next('.email_alert').addClass('hide');
                    $(this).next('.email_alert').removeClass('show warning-message-alert');
                }


            })


        });
    </script>
@endsection
