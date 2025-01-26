@extends('layouts.app')

@section('cssComponent')
    <link href="{{ asset('css/publicHome.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12" style="background-color: rgb(238, 238, 238); border-radius: 6px; padding: 30px;">
                <div class="content-home">
                    <div class="col-md-12">
                        <h1 style="text-align: center">সার্টিফিকেট আদালত এ আপনাকে স্বাগতম ।</h1>
                        {{--<p style="font-size: initial">প্রতিকারের সর্বশেষ অবস্থা সম্পর্কে আপনার অসন্তোষ বা মতামত এই--}}
                        {{--ওয়েবসাইটের </p>--}}
                    </div>
                    <div class="col-md-12" style="padding-top: 3%;">
                        <p style="font-size: larger;">
                            গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের সার্টিফিকেট আদালত ব্যবস্থার অনলাইন প্ল্যাটফর্মে আপনাকে
                            স্বাগতম।
                            সিস্টেমটির মাধ্যমে আবেদনকারী সার্টিফিকেট মামলার আবেদন করতে পারবে, আপীল করতে পারবে এবং আপীলের
                            সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে।
                            পাশাপাশি সার্টিফিকেট মামলা দাখিল করার পর মামলার সর্বশেষ অবস্থা সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে
                            SMS ও ই-মেইলের মাধ্যমে সম্পর্কে জানানো হবে।
                            জেনারেল সার্টিফিকেট কোর্ট পরিচালনার সাথে সম্পৃক্ত জেনারেল সার্টিফিকেট অফিসারের কর্মদক্ষতা
                            বৃদ্ধি,
                            একটি সিস্টেমের মাধ্যমে প্রশিক্ষণ প্রদানে সহায়তাসহ তাৎক্ষণিকভাবে জেনারেল সার্টিফিকেট অফিসারকে
                            আইনী তথ্য সরবরাহ,
                            ঊর্ধ্বতন কর্তৃপক্ষের মাধ্যমে জেনারেল সার্টিফিকেট অফিসারের কার্যক্রম পরিবীক্ষণ, দ্রুততার সাথে
                            কার্যক্রম সম্পাদন,
                            জনগণের হয়রানি লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা
                            প্রদানের বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে।
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="background-color: #109347; border-radius: 0px; padding: 30px;">
                <div class="container col-md-6">
                    <div class="row ">
                        <div class="card-counter text-center col-md-4 ">
                            <a href="{{ url('/logincheck') }}">
                                <img class="mb-2" src="{{ asset('images/icons-workspace-64.png') }}" alt=""
                                     width="" height="">
                            </a><br>
                            <a style="color: white;font-size: larger; text-align: center;" href="{{ url('/logincheck') }}" class="service-type">
                                লগইন
                            </a>
                        </div>
                        <div class="card-counter text-center col-md-4 ">
                            <a href="{{ url('certificateAppealApplication/appealCreate') }}">
                                <img class="mb-2" src="{{ asset('images/iconGreenFile.png') }}" alt="" width=""
                                     height="">
                            </a><br>
                            <a style="color: white;font-size: larger" href="{{ route('appealCreate') }}"
                               class="service-type">
                                আপিল আবেদন
                            </a>
                        </div>
                        <div class="card-counter text-center col-md-4">
                            <a href="#" data-toggle="modal" data-target="#appealTrackModal">
                                <img class="mb-2" src="{{ asset('images/appealTrack.png') }}" alt="" width=""
                                     height="">
                            </a><br>
                            <a style="color: white;font-size: larger" href="#" data-toggle="modal" data-target="#appealTrackModal"
                               class="service-type">
                                আপিলের অবস্থা
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row bottom-part">
            <div class="col-md-12" style="background-color: rgb(238, 238, 238); border-radius: 6px; padding: 30px;">
                <div class="content-home">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="portlet light ">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 col-xs-12 box-design">
                                        <a class="media-embed" data-asset="true" href="#" data-toggle="modal"
                                           data-target="#basicModal1">
                                            <div class="mt-widget-1">
                                                <div class="mt-icon">
                                                    <i class="fa fa-user-circle-o fa-5x" aria-hidden="true"></i>
                                                </div>
                                                <div class="mt-body">
                                                    <p class="mt-user-title">সার্টিফিকেট কোর্ট ও মামলা পরিচালনা সম্পর্কিত প্রশ্নোত্তর</p>
                                                    <div class="mt-stats">
                                                        <div class="btn-group btn-group-justified">
                                                            <button style="background-color: #a6489c; color: white;" class="btn a2ipurple">
                                                                <span>সচরাচর জিজ্ঞাসা</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 box-design">
                                        <a class="media-embed" data-asset="true" href="#" data-toggle="modal"
                                           data-target="#basicModal2">
                                            <div class="mt-widget-1">
                                                <div class="mt-icon">
                                                    <i class="fa fa-file-text fa-5x" aria-hidden="true"></i>
                                                </div>
                                                <div class="mt-body">
                                                    <p class="mt-user-title">সরকারী দাবী আদায় আইন, ১৯১৩</p>
                                                    <div class="mt-stats">
                                                        <div class="btn-group btn-group-justified">
                                                            <button style="background-color: #a6489c; color: white;" class="btn a2igreen">
                                                                <span>ডাউনলোডস</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 box-design">
                                        <a class="" href="#" data-toggle="modal" data-target="#basicModal3">
                                            <div class="mt-widget-1">
                                                <div class="mt-icon">
                                                    <i class="fa fa-university fa-5x" aria-hidden="true"></i>
                                                </div>
                                                <div class="mt-body">
                                                    <p class="mt-user-title">ল’জ অব বাংলাদেশ</p>
                                                    <div class="mt-stats">
                                                        <div class="btn-group btn-group-justified">
                                                            <button style="background-color: #a6489c; color: white;" class="btn a2ipurple">
                                                                <span>গুরুত্বপূর্ণ লিঙ্ক</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 box-design">
                                        <a href="#" data-toggle="modal" data-target="#basicModal4">
                                            <div class="mt-widget-1">
                                                <div class="mt-icon">
                                                    <i class="fa fa-volume-control-phone fa-5x" aria-hidden="true"></i>
                                                </div>
                                                <div class="mt-body">
                                                    <p class="mt-user-title">সার্টিফিকেট কোর্ট সিস্টেম ব্যবহারে কোনো সমস্যার সম্মুখীন হলে</p>
                                                    <div class="mt-stats">
                                                        <div class="btn-group btn-group-justified">
                                                            <button style="background-color: #a6489c; color: white;" class="btn a2igreen">
                                                                <span>যোগাযোগ</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="basicModal1" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" id="myModalLabel">সচরাচর জিজ্ঞাসা</h3>
                </div>
                <div class="modal-body">
                    <h4>সার্টিফিকেট কোর্ট ও মামলা পরিচালনা সম্পর্কিত প্রশ্নোত্তর</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> বন্ধ করুন</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="basicModal2" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" id="myModalLabel">ডাউনলোডস</h3>
                </div>
                <div class="modal-body">
                    <h4>সরকারী দাবী আদায় আইন, ১৯১৩</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> বন্ধ করুন</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="basicModal3" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" id="myModalLabel">গুরুত্বপূর্ণ লিঙ্ক</h3>
                </div>
                <div class="modal-body">
                    <h4>ল’জ অব বাংলাদেশ</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> বন্ধ করুন</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="basicModal4" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title" id="myModalLabel">যোগাযোগ</h3>
                </div>
                <div class="modal-body">
                    <h4>সার্টিফিকেট কোর্ট সিস্টেম ব্যবহারে কোনো সমস্যার সম্মুখীন হলে</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> বন্ধ করুন</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="appealTrackModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <div class="col-1"></div>
                    <div class="col-10 text-center"><h3 class="modal-title" id="myModalLabel">আপিলের অবস্থা</h3></div>
                    <div class="col-1 ms-3">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="caseNo" class="control-label"><span
                                            style="color:#FF0000">* </span> মামলা নম্বর</label>
                                <input type="text" name="caseNo" id="caseNo" class="form-control"
                                       onchange="home.convertCaseNumberToEnglish(this)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000">* </span> বিভাগ</label>
                                <select style="width: 100%;" class="form-control selectDropdown" name="division"
                                        id="ddlDivision999">
                                    <option>বাছাই করুন...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000">* </span> জেলা</label>
                                <select style="width: 100%;" class="form-control selectDropdown" id="ddlZilla999"
                                        name="zilla">
                                    <option value="">বাছাই করুন...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <h4 style="color: #0D8BBD">আপিলের অবস্থা জানতে আপনার মামলা নাম্বার টি লিখুন এবং মামলা টি কোন বিভাগ
                        এবং জেলার তা নির্বাচন করুন। </h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> বন্ধ করুন</button>
                    <button onclick="home.appealCheck();" type="button" class="btn btn-success">
                        @lang('message.Submit')
                    </button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsComponent')
    <script src="{{ asset('js/location/location.js') }}"></script>
    <script src="{{ asset('js/englishToBangla/convertEngToBangla.js') }}"></script>
    <script src="{{ asset('js/initiate/init.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
