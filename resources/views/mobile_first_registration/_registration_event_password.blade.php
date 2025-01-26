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
                                <div class="col-md-2"></div>
                                <div class="col-md-8">

                                    <h4 class="p-2 text-center"
                                        style="color: #fff;
                                        background-color: #008841;
                                        border-color: #008841;
                                        border-radius:5px
                                        ">
                                        <i class="fas fa-users" style="color: #fff;"></i> {{ $page_title }}
                                    </h4>
                                </div>

                            </div>
                            <br>
                            <form id="nidVerifyForm" action="{{ route('mobile.first.password.match') }}" class="form"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user_id }}">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>নতুন পাসওয়ার্ড <span class="text-danger">*</span></label>
                                            <div class="input-group" id="show_hide_password_citigen_register">
                                                <input type="password" name="password" id="password"
                                                    class="form-control form-control-sm" />

                                                <div class="input-group-addon bg-secondary">
                                                    <a href=""><i class="fa fa-eye-slash p-5 mt-1"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="password-strength-status" class="text-danger"></div>
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>কনফার্ম পাসওয়ার্ড <span class="text-danger">*</span></label>
                                            <input type="password" name="confirm_password" id="confirm_password"
                                                class="form-control form-control-sm" />
                                            <span id='message'></span>
                                            @error('confirm_password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row buttonsDiv text-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" id="submit_btn">
                                                পরবর্তী ধাপ
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </form>
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
    <script type="text/javascript"></script>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#password, #confirm_password').on('keyup', function() {
                if ($('#password').val() == $('#confirm_password').val()) {
                    $('#message').html('Matching').css('color', 'green');
                } else
                    $('#message').html('Not Matching').css('color', 'red');
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

            $("#show_hide_password_citigen_register a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password_citigen_register input').attr("type") == "text") {
                    $('#show_hide_password_citigen_register input').attr('type', 'password');
                    $('#show_hide_password_citigen_register i').addClass("fa-eye-slash");
                    $('#show_hide_password_citigen_register i').removeClass("fa-eye");
                } else if ($('#show_hide_password_citigen_register input').attr("type") == "password") {
                    $('#show_hide_password_citigen_register input').attr('type', 'text');
                    $('#show_hide_password_citigen_register i').removeClass("fa-eye-slash");
                    $('#show_hide_password_citigen_register i').addClass("fa-eye");
                }
            });

        });
    </script>
@endsection
