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
                                <h1 class="phome_h1_text">এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট</h1>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট ব্যবস্থার অনলাইন প্ল্যাটফর্মে
                            আপনাকে
                            স্বাগতম।
                            সিস্টেমটির মাধ্যমে নাগরিক অভিযোগ দায়ের করতে পারবে, আপীল করতে পারবে এবং আপীলের
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

        <div class="container" style="margin-top:100px">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 shadow-sm p-3 mb-5 bg-white rounded">
                    <img src="{{ asset('/images/logo_court.jpeg') }}" class="w-50" alt="">
                    <p class="text-dark h4 text-center">স্মার্ট জেনারেল সার্টিফিকেট আদালত ব্যবস্থায় লগইন করুন</p>
                    <form action="javascript:void(0)" class="form fv-plugins-bootstrap fv-plugins-framework"
                        id="kt_login_singin_form" action="" novalidate="novalidate">
                        @csrf
                        <div class="form-group fv-plugins-icon-container has-success">
                            <label class="font-size-h6 font-weight-bolder text-dark">ইমেইল,মোবাইল নং</label>
                            <input class="form-control h-auto border-info" placeholder="ইমেইল,মোবাইল নং" type="text"
                                name="email" autocomplete="off" required>
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">পাসওয়ার্ড</label>

                            </div>
                            <div class="input-group" id="show_hide_password_1"
                                style="border:1px solid#8950fc!important;
                    border-radius:5px ">
                                <input type="password" id="password" name="password"
                                    placeholder="ব্যবহারকারীর পাসওয়ার্ড লিখুন" class="form-control form-control-sm"
                                    value="" id="password" required>
                                <div class="input-group-addon bg-secondary">
                                    <a href=""><i class="fa fa-eye-slash p-5 mt-1" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            

                            <div class="row">
                                <div class="col-md-4 pt-5">
                                    <a href="{{ route('applicant.forget.password') }}" type="button"
                                        value="">{{ __('পাসওয়ার্ড রিসেট') }}</a>
                                </div>
                                <div class="col-md-8"></div>
                            </div>
                            <div class="pb-lg-0 pb-5 pt-5">
                                <button onclick="labelmk()" id="kt_login_singin_form_submit_button"
                                    class="text-center btn btn-success w-100">লগইন</button>
                            </div>
                            <p class="h4 pt-5 text-dark">স্মার্ট জেনারেল সার্টিফিকেট আদালত ব্যবস্থায় একাউন্ট নেই? <a href="{{ route('registration') }}">রেজিস্ট্রেশন করুন </a></p>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
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
    <script type="text/javascript"></script>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            $("#show_hide_password_1 a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password_1 input').attr("type") == "text") {
                    $('#show_hide_password_1 input').attr('type', 'password');
                    $('#show_hide_password_1 i').addClass("fa-eye-slash");
                    $('#show_hide_password_1 i').removeClass("fa-eye");
                } else if ($('#show_hide_password_1 input').attr("type") == "password") {
                    $('#show_hide_password_1 input').attr('type', 'text');
                    $('#show_hide_password_1 i').removeClass("fa-eye-slash");
                    $('#show_hide_password_1 i').addClass("fa-eye");
                }
            });

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
        function labelmk() {
            var _token = $("#kt_login_singin_form input[name='_token']").val();
            var email = $("#kt_login_singin_form input[name='email']").val();
            var password = $("#kt_login_singin_form input[name='password']").val();

            if (email == '' || password == '') {
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
                        setTimeout(function() {
                            // location.reload();
                            $(location).attr('href', "{{ url('') }}/dashboard");
                        }, 1000);
                    } else {
                        //toastr.error(data.error, "Error");
                        Swal.fire(data.nothi_msg);

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
