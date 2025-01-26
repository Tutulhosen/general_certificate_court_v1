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
                            <div class="row text-center">
                                <div class="col-md-12">
                                  <h3 class="py-3">আপনার Gmail Account <span  class="fw-bold text-danger">{{ $results }}</span> এর জন্য নাগরিক নিবন্ধন </h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <h4 class="p-2 text-center" style="color: #fff;
                                    background-color: #008841;
                                    border-color: #008841;
                                    border-radius:5px
                                    "><i class="fas fa-users" style="color: #fff;"></i> নাগরিক নিবন্ধন</h4>
                                </div>
                            </div>
                            <br>
                            <form id="nidVerifyForm" action="{{ route('citizen.nid_verify.google.sso') }}" class="form" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nid_no" class="control-label"><span style="color:#FF0000">*
                                                </span> জাতীয় পরিচয়পত্র নম্বর</label>
                                            <input type="text" name="nid_no" id="nid_no"
                                                class="form-control form-control name-group"
                                                placeholder="উদাহরণ- 19825624603112948" value="{{ old('nid_no') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dob" class="control-label"><span style="color:#FF0000">*
                                                </span> জন্ম তারিখ</label>
                                            <input type="text" name="dob" id="dob"
                                                class="form-control  common_datepicker" placeholder="বছর/মাস/তারিখ"
                                                autocomplete="off" value="{{ old('dob') }}">

                                        </div>
                                    </div>
                                    <!-- <textarea id="message" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20"
                                        data-parsley-maxlength="100"
                                        data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.."
                                        data-parsley-validation-threshold="10"></textarea> -->
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>

                                <div class="row buttonsDiv text-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" value="validate">
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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"></script>
    
    <script type="text/javascript">
        jQuery(function($) {
            $('.common_datepicker').datepicker({
                format: "yyyy/mm/dd",
                todayHighlight: true,
                mindate: new Date(),
                orientation: "bottom left"
            });
        })
        
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
{{-- @section('scripts')
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
@endsection --}}
