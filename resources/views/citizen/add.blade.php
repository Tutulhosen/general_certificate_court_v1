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

            #password-strength-status {
                padding: 5px 10px;
                color: #FFFFFF;
                border-radius: 4px;
                margin-top: 5px;
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
                <h2 class="text-center"><button class="btn btn-success font-weight-bolder"
                        style="font-size: 25px;">প্রোফাইল</button></h2>
                <form action="{{ route('citizenRegister.store') }}" class="form" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" value="{{ $results->father }}" name="father">
                    <input type="hidden" value="{{ $results->mother }}" name="mother">

                    <div class="card-body">
                        <input type="hidden" name="citizen_nid" value="{{ $results->national_id }}">
                        <input type="hidden" name="photo" value="{{ $results->photo }}">
                        <div class="form-group row">
                            <label> ছবি </label>
                            <div class="col-lg-4 mb-5 mt-5 ">
                                <span class="text-dark flex-root font-weight-bolder font-size-h6">
                                    @if ($results->photo != null)
                                        <img src="{{ $results->photo }}" width="200" height="200">
                                    @else
                                        <img src="{{ url('/') }}/uploads/profile/default.jpg" width="200"
                                            height="200">
                                    @endif
                                </span>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 mb-5">
                                    <label> নাম <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm"
                                        value="{{ $results->name_bn }}" readonly>
                                </div>

                                

                                <div class="col-lg-6 mb-5">
                                    <label>জন্ম তারিখ <span class="text-danger">*</span></label>
                                    <input type="date" name="dob" id="dob" class="form-control form-control-sm"
                                        value="{{ $results->dob }}" readonly>
                                </div>


                                <div class="col-lg-6 mb-5">
                                    <label>লিঙ্গ <span class="text-danger">*</span></label>
                                    <select name="citizen_gender" id="citizen_gender" class="form-control form-control-sm" readonly>
                                        <!-- <span id="loading"></span> -->
                                        <option value="">-- নির্বাচন করুন --</option>
                                        <option value="MALE" {{ $results->gender == 'MALE' ? 'selected' : 'disabled' }}>পুরুষ
                                        </option>
                                        <option value="FEMALE" {{ $results->gender == 'FEMALE' ? 'selected' : 'disabled' }}>নারী
                                        </option>
                                    </select>
                                </div>


                                <div class="col-lg-6 mb-5">
                                    <label>মোবাইল নম্বর <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile_no" id="mobile_no"
                                        class="form-control form-control-sm" placeholder="মোবাইল নম্বর" autocomplete="off" value="{{ old('mobile_no') }}">

                                        <div class="phone_alert hide">Invalid Mobile  Number</div>

                                        @error('mobile_no')
                                            <div class="alert alert-danger ">{{ $message }}</div>
                                        @enderror
                                </div>


                                <div class="col-lg-6 mb-5">
                                    <label>ই-মেইল <span class="text-danger"></span></label>
                                    <input type="email" name="email" id="email" class="form-control form-control-sm"
                                        placeholder="ই-মেইল" value="{{ old('email') }}">
                                      
                                        <div class="email_alert hide">Invalid Email Address</div>

                                        @error('email')
                                            <div class="alert alert-danger email_alert">{{ $message }}</div>
                                        @enderror
                                </div>


                                <div class="col-lg-6 mb-5form-group">

                                    <label>পাসওয়ার্ড <span class="text-danger">*</span></label>
                                    <div class="input-group" id="show_hide_password_citigen_registation">
                                        <input type="password" name="password" id="password"
                                            class="form-control form-control-sm" required/>
                                        
                                        <div class="input-group-addon bg-secondary">
                                            <a href=""><i class="fa fa-eye-slash p-5 mt-1"
                                                    aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div id="password-strength-status" class="text-danger"></div>
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-lg-6 mb-5form-group">
                                    <label>কনফার্ম পাসওয়ার্ড <span class="text-danger">*</span></label>
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        class="form-control form-control-sm" required/>
                                    <span id='message'></span>
                                    @error('confirm_password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-lg-12 mb-5">
                                    <label>স্থায়ী ঠিকানা<span class="text-danger">*</span></label>
                                    <textarea name="permanentAddress" id="permanentAddress" class="form-control form-control-sm common_datepicker"
                                        autocomplete="off" value="" readonly>{{ $results->permanent_address }}
                                    </textarea>
                                </div>
                                <div class="col-lg-12 mb-5">
                                    <label>বর্তমান ঠিকানা<span class="text-danger">*</span></label>
                                    <textarea name="presentAddress" id="presentAddress" class="form-control form-control-sm common_datepicker"
                                        autocomplete="off" value="" readonly>{{ $results->present_address }}
                                    </textarea>

                                </div>
                            </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
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
           
            $("#show_hide_password_citigen_registation a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password_citigen_registation input').attr("type") == "text") {
                $('#show_hide_password_citigen_registation input').attr('type', 'password');
                $('#show_hide_password_citigen_registation i').addClass("fa-eye-slash");
                $('#show_hide_password_citigen_registation i').removeClass("fa-eye");
            } else if ($('#show_hide_password_citigen_registation input').attr("type") == "password") {
                $('#show_hide_password_citigen_registation input').attr('type', 'text');
                $('#show_hide_password_citigen_registation i').removeClass("fa-eye-slash");
                $('#show_hide_password_citigen_registation i').addClass("fa-eye");
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
                        "মাঝারি (বর্ণমালা, সংখ্যা এবং বিশেষ অক্ষর বা কিছু সংমিশ্রণ অন্তর্ভুক্ত করা উচিত।)"
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
    function isPhone(phone)
    {
        var regex = /(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/;
        return regex.test(phone);
    }
    
       $('#mobile_no').on('keyup',function(){
        
        let is_phone=isPhone($('#mobile_no').val());
        
        if(!is_phone)
        {
           $(this).addClass('waring-border-field');
           $(this).next('.phone_alert').removeClass('hide');
           $(this).next('.phone_alert').addClass('show warning-message-alert');
        }
        else{
            
           $(this).removeClass('waring-border-field');
           $(this).next('.phone_alert').addClass('hide');
           $(this).next('.phone_alert').removeClass('show warning-message-alert');
        }

       })
       $('#email').on('keyup',function(){
        
        let is_email=isEmail($('#email').val());
        if(!is_email)
        {
           $(this).addClass('waring-border-field');
           $(this).next('.email_alert').removeClass('hide');
           $(this).next('.email_alert').addClass('show warning-message-alert');
        }
        else{
            
           $(this).removeClass('waring-border-field');
           $(this).next('.email_alert').addClass('hide');
           $(this).next('.email_alert').removeClass('show warning-message-alert');
        }
        

       })


        });
    </script>
@endsection
