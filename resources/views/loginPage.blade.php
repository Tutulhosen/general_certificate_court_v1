@extends('layouts.landing')

@section('style')
@endsection

@section('landing')
    <!--begin::Landing hero-->
    <link rel="stylesheet" type="text/css" href="http://parsleyjs.org/src/parsley.css" />
    @auth
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4"style="margin-top:100px;text-align:center;">
                            <img src="{{ asset('images/book.png') }}" alt="Girl in a jacket" width="100%" height="250">
                        </div>
                        <div class="col-md-8">
                            <div style="margin-top: 165px; margin-left: 55px;">
                                <h1 class="phome_h1_text">নির্বাহী ম্যাজিস্ট্রেট আদালত</h1>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের নির্বাহী ম্যাজিস্ট্রেট আদালত ব্যবস্থার অনলাইন প্ল্যাটফর্মে
                            আপনাকে
                            স্বাগতম।
                            সিস্টেমটির মাধ্যমে নাগরিক মামলার আবেদন করতে পারবে, আপীল করতে পারবে এবং আপীলের
                            সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে।
                            পাশাপাশি নাগরিক মামলা দাখিল করার পর মামলার সর্বশেষ অবস্থা সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে
                            SMS ও ই-মেইলের মাধ্যমে সম্পর্কে জানানো হবে।
                            জনগণের হয়রানি লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা
                            প্রদানের বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে।
                        </div>
                        <div class="col-md-6 mt-5">
                            <a href=""><button type="button" class="px-15 btn btn-success">বিস্তারিত</button></a>
                            <a href="#!" class="svg-home-play">
                                <span class="svg-icon  svg-icon-primary svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path
                                                d="M9.82866499,18.2771971 L16.5693679,12.3976203 C16.7774696,12.2161036 16.7990211,11.9002555 16.6175044,11.6921539 C16.6029128,11.6754252 16.5872233,11.6596867 16.5705402,11.6450431 L9.82983723,5.72838979 C9.62230202,5.54622572 9.30638833,5.56679309 9.12422426,5.7743283 C9.04415337,5.86555116 9,5.98278612 9,6.10416552 L9,17.9003957 C9,18.1765381 9.22385763,18.4003957 9.5,18.4003957 C9.62084305,18.4003957 9.73759731,18.3566309 9.82866499,18.2771971 Z"
                                                fill="#000000"></path>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                <strong>Watch Video</strong>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12 mt-10" style="background-color:#f0f1ef ;">
                <div class="row">
                    <div class="col-md-1 mt-5">
                        <p type="text">খবরঃ</p>
                    </div>
                    <div class="col-md-11 mt-5">
                        <marquee style="font-size: 18px" direction="left" scrollamount="3" onmouseover="this.stop()"
                            onmouseout="this.start()">
                            @foreach ($short_news as $row)
                                {{ $row->news_details }}
                            @endforeach
                        </marquee>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-lg-12 phomebuttons">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card " style="background: #f6f6f7 !important">
                        <div class="card-body mt-15">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="javascript:void(0)" class="form fv-plugins-bootstrap fv-plugins-framework"
                                        id="kt_login_singin_form" action="" novalidate="novalidate">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-8">
                                            <!--begin::Title-->
                                                <div class="form-group fv-plugins-icon-container has-success">
                                                    <label class="font-size-h6 font-weight-bolder text-dark">ইমেইল, ইউজারনেম, এন আই
                                                        ডি</label>
                                                    <input class="form-control h-auto border-info "
                                                        placeholder="ইমেইল, ইউজারনেম, এন আই ডি" type="text" name="email" autocomplete="off" required>
                                                    <div class="fv-plugins-message-container"></div>
                                                
                                                    <div class="d-flex justify-content-between mt-n5">
                                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">পাসওয়ার্ড</label>
                                                        <a href="custom/pages/login/login-3/forgot.html"
                                                            class="text-info font-size-h6 font-weight-bolder text-hover-info pt-5">
                                                        </a>
                                                    </div>
                                                    <input class="form-control h-auto border-info "
                                                        placeholder="পাসওয়ার্ড" type="password" name="password" autocomplete="off" required>
                                                    <div class="fv-plugins-message-container"></div>
                                                    <div class="row">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-4">
                                                            <a href="{{ url('/forget/password') }}" type="button"
                                                                value="">{{ __('পাসওয়ার্ড রিসেট') }}</a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <!--end::Form group-->
                                                <!--begin::Action-->
                                                <div class="pb-lg-0 pb-5">
                                                    <a href="{{ url('/') }}" class="text-center btn btn-success  font-size-h6 px-8 py-4 my-3 mr-3">পূর্ববর্তী
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <!--end::Form group-->
                                                <!--begin::Action-->
                                                <div class="pb-lg-0 pb-5">
                                                    <button onclick="labelmk()" id="kt_login_singin_form_submit_button"
                                                        class="text-center btn btn-success  font-size-h6 px-8 py-4 my-3 mr-3"
                                                        wait-class="spinner spinner-right spinner-white pr-15">লগইন</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Action-->
                                        <input type="hidden">
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <!--end::Form group-->
                                        <!--begin::Action-->
                                        <div class="pb-lg-0 pb-5">
                                            <button class="text-center btn bg-primary btn-block font-size-h6 px-8 py-4 my-3 mr-3"
                                                wait-class="spinner spinner-right spinner-white pr-15 "style="color:white;"><i class="fab fa-facebook-f" style="color:white;"></i> Facebook</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <!--end::Form group-->
                                        <!--begin::Action-->
                                        <div class="pb-lg-0 pb-5">
                                            <button class="text-center btn btn-danger btn-block font-size-h6 px-8 py-4 my-3 mr-3"
                                                wait-class="spinner spinner-right spinner-white pr-15"><i class="fab fa-google-plus-g"></i> Google</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <!--end::Form group-->
                                        <!--begin::Action-->
                                        <div class="pb-lg-0 pb-5">
                                            <button class="btn btn-success btn-block" id="loginID2" data-toggle="modal" data-target="#exampleModalLong2"><i class="fas fa-users"></i>CDAP</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 text-center">
                                    <span class="text-center text-danger">*মাইগভের মাধ্যমে লগইন করতে চাইলে CDAP এ ক্লিক করুন*</span>
                                </div>
                            </div>
                            <br>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5" style="background-color:#f0f1ef;margin-left:-2px;margin-right:-2px">
                <div class="col-md-1 mt-5">
                    <p type="text">খবরঃ</p>
                </div>
                <div class="col-md-11 mt-5">
                    <marquee style="font-size: 18px" direction="left" scrollamount="3" onmouseover="this.stop()"
                        onmouseout="this.start()">
                        @foreach ($short_news as $row)
                            {{ $row->news_details }}
                        @endforeach
                    </marquee>
                </div>
            </div>
        </div>
    @endauth


    @include('_information_help_center_links')
    <style type="text/css">
        label.error {
            color: red;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
    <script type="text/javascript">
        // $(document).ready(function() {
        // Jquery custome validate
        $.validator.addMethod("nidlength", function(value, element) {
            var nid = $('#nid_no').val().length;
            if (nid == 10 || nid == 13 || nid == 17) {
                return true;
            }
            // return nid == 10 || nid == 13 || nid == 17;
            // return value.indexOf(" ") < 0 && value != ""; 
        }, "শুধুমাত্র ১০, ১৩ অথবা ১৭ সংখ্যা প্রযোজ্য");

        // Validate User Registration
        $('#nidVerifyForm').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                nid_no: {
                    required: true,
                    digits: true,
                    nidlength: true,
                    minlength: 10,
                    maxlength: 17
                },
                dob: {
                    required: true,
                    date: true
                }
            },

            messages: {

                nid_no: {
                    required: "ন্যাশনাল আইডি প্রদান করুন",
                    minlength: "সর্বনিন্ম {0} টি সংখ্যা প্রদান করুন"
                },

                dob: {
                    required: "ন্যাশনাল আইডি অনুসারে জন্ম তারিখ প্রদান করুন "
                },
            },

            invalidHandler: function(event, validator) {
                //display error alert on form submit    
            },

            errorPlacement: function(label, element) { // render error placement for each input type  
                $('<span class="error"></span>').insertAfter(element).append(label)
                // $('<span class="error"></span>').insertAfter(element).append(label)
                var parent = $(element).parent('.input-with-icon');
                parent.removeClass('success-control').addClass('error-control');
            },

            highlight: function(element) { // hightlight error inputs

            },

            unhighlight: function(element) { // revert the change done by hightlight

            },

            success: function(label, element) {
                var parent = $(element).parent('.input-with-icon');
                parent.removeClass('error-control').addClass('success-control');
            },

            submitHandler: function(form) {
                form.submit();
            }
        });
        // });   
    </script>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("a.h2.btn.btn-info").on('click', function(event) {
                if (this.hash !== "") {
                    event.preventDefault();
                    var hash = this.hash;
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function() {
                        window.location.hash = hash;
                    });
                }
            });

            // common datepicker =============== start
            $('.common_datepicker').datepicker({
                format: "yyyy/mm/dd",
                todayHighlight: true,
                mindate: new Date(),
                orientation: "bottom left"
            });
            // common datepicker =============== end


        });
    </script>

<script type="text/javascript">
    function labelmk(){
        var _token = $("#kt_login_singin_form input[name='_token']").val();
        var email = $("#kt_login_singin_form input[name='email']").val();
        var password = $("#kt_login_singin_form input[name='password']").val();

        if(email == '' || password == ''){
            toastr.info('Email or password not will be null!', "Error");
            return;
        }
        $.ajax({
            url: "{{ url('') }}/csLogin",
            type: 'POST',
            data: {
                _token: _token,
                email: email,
                password: password,
            },
            success: function(data) {
                console.log(data);
                if ($.isEmptyObject(data.error)) {
                    toastr.success(data.success, "Success");
                    //$('#exampleModalLong').modal('toggle');
                    console.log(data.success);
                    setTimeout(function(){
                        // location.reload();
                        $(location).attr('href', "{{ url('') }}/dashboard");
                    }, 1000);
                } else {
                    toastr.error(data.error, "Error");
                    console.log(data.error);
                    
                    // printErrorMsg(data.error);
                }
            }
        });
    }
    $(document).ready(function() {
        $("#kt_login_singin_form_submit_button").click(function(e) {
            return;
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var email = $("input[name='email']").val();
            var password = $("input[name='password']").val();
            $.ajax({
                url: "/register",
                type: 'POST',
                data: {
                    _token: _token,
                    profetion: profetion,
                    name: name,
                    email: email,
                    password: password,
                    agreeCheckboxUser: agreeCheckboxUser
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        alert(data.success);
                        // window.location.replace(data.url);
                    } else {
                        alert('data.error');
                        // printErrorMsg(data.error);
                    }
                }
            });
        });

        function printErrorMsg(msg) {
            // $(".print-error-msg").find("ul").html('');
            $(".error_msg").css('display', 'block');
            $("#first_name_err").append(msg['first_name']);
            $("#last_name_err").append(msg['last_name']);
            $("#email_err").append(msg['email']);
            $("#address_err").append(msg['address']);
            // $.each( msg, function( key, value ) {
            //     $(".print-error-msg").find("ul").append(key+'<li>'+value+'</li>');
            //     if(key=='first_name'){
            //     }
            // });
        }
    });
</script>
@endsection
