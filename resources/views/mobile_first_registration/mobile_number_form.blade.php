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
                                <h1 class="phome_h1_text">স্মার্ট জেনারেল সার্টিফিকেট আদালত</h1>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের জেনারেল সার্টিফিকেট আদালত ব্যবস্থার অনলাইন প্ল্যাটফর্মে আপনাকে স্বাগতম। সিস্টেমটির মাধ্যমে প্রতিষ্ঠান মামলার আবেদন করতে পারবে, আপীল করতে পারবে এবং আপীলের সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে। পাশাপাশি প্রতিষ্ঠান মামলা দাখিল করার পর মামলার সর্বশেষ অবস্থা সম্পর্কে সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে SMS ও ই-মেইলের মাধ্যমে জানানো হবে। প্রতিষ্টানের ও জনগণের সময় ও শ্রম লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা প্রদানের বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে।
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
                                    @if (isset($results))
                                        <h4 class="p-2 text-center"
                                            style="color: #fff;
                                        background-color: #886400;
                                        border-color: #008841;
                                        border-radius:5px
                                        ">
                                            {{ $results }} এর জন্য
                                        </h4>
                                    @endif

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
                            <form id="nidVerifyForm" action="{{ route('mobile.first.registration.opt.send') }}" class="form"
                                method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="role_id" value="{{ $role_id }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nid_no" class="control-label"><span style="color:#FF0000">*
                                                </span>{{ $name_field_label }}</label>
                                            <input type="text" name="input_name" id="input_name"
                                                class="form-control form-control name-group" placeholder=""
                                                value="{{ old('input_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nid_no" class="control-label"><span style="color:#FF0000">*
                                                </span>{{ $mobile_field_label }}</label>
                                            <input type="text" name="mobile_no" id="mobile_no"
                                                class="form-control form-control name-group"
                                                placeholder="মোবাইল নং ইংরেজিতে ১১ অক্ষর" value="{{ old('mobile_no') }}"
                                                required>
                                            <div class="phone_alert hide">Invalid Mobile Number</div>
                                        </div>
                                    </div>
                                    @php
                                            if ($role_id == 35) {
                                                $email_mandatory = '<span style="color:#FF0000">*
                                                </span>';
                                                $email_required = 'required';
                                            } else {
                                                $email_mandatory = '';
                                                $email_required = '';
                                            }
                                            
                                        @endphp
                                    {{-- @dd($result) --}}
                                    @if (isset($results))
                                          <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="email"
                                                    class="control-label"><span style="color:#ffffff; display: hidden">*
                                                    </span>{{ $email_field_label }}</label>
                                                <input type="email" name="email" id="email"
                                                    class="form-control form-control name-group" placeholder="ইমেইল"
                                                    value="{{ $results }}" readonly>
                                                <div class="email_alert hide">Invalid Email Address</div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="email"
                                                    class="control-label"><span style="color:#ffffff; display: hidden">*
                                                    </span>{{ $email_field_label }}</label>
                                                <input type="email" name="email" id="email"
                                                    class="form-control form-control name-group" placeholder="ইমেইল"
                                                    value="{{ old('email') }}" />
                                                <div class="email_alert hide">Invalid Email Address</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>

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


            function isPhone(phone) {
                var regex = /(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/;
                return regex.test(phone);
            }

            function isEmail(email) {
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            }

            $('#mobile_no').on('keyup', function() {

                let is_phone = isPhone($('#mobile_no').val());

                if (!is_phone) {
                    $(this).addClass('waring-border-field');
                    $(this).next('.phone_alert').removeClass('hide');
                    $(this).next('.phone_alert').addClass('show warning-message-alert');
                    $('#submit_btn').prop('disabled', true);
                } else {

                    $(this).removeClass('waring-border-field');
                    $(this).next('.phone_alert').addClass('hide');
                    $(this).next('.phone_alert').removeClass('show warning-message-alert');
                    $('#submit_btn').prop('disabled', false);
                }

            })
            $('#email').on('keyup', function() {

                let is_email = isEmail($('#email').val());
                if (!is_email) {
                    $(this).addClass('waring-border-field');
                    $(this).next('.email_alert').removeClass('hide');
                    $(this).next('.email_alert').addClass('show warning-message-alert');
                    $('#submit_btn').prop('disabled', true);
                } else {

                    $(this).removeClass('waring-border-field');
                    $(this).next('.email_alert').addClass('hide');
                    $(this).next('.email_alert').removeClass('show warning-message-alert');
                    $('#submit_btn').prop('disabled', false);
                }


            })

        });
    </script>
@endsection
