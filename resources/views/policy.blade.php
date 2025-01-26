@extends('layouts.landing')

@section('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('custom/style.bundle.css') }}" />
@endsection
@auth
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-4"style="margin-top:100px;text-align:center;">
                    <img src="{{ asset('images/book.png') }}" alt="Girl in a jacket" width="100%" height="250">
                </div>
                <div class="col-md-8">
                    <div style="margin-top: 165px; margin-left: 55px;">
                        <h1 class="phome_h1_text">স্মার্ট এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট </h1>
                    </div>
                </div>
                <div class="col-md-12 mt-5">
                    গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের স্মার্ট এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট  ব্যবস্থার অনলাইন প্ল্যাটফর্মে
                    আপনাকে
                    স্বাগতম।
                    সিস্টেমটির মাধ্যমে নাগরিক অভিযোগ দায়ের  করতে পারবে, আপীল করতে পারবে এবং আপীলের
                    সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে।
                    পাশাপাশি নাগরিক মামলা দাখিল করার পর মামলার সর্বশেষ অবস্থা সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে
                    SMS ও ই-মেইলের মাধ্যমে সম্পর্কে জানানো হবে।
                    জনগণের হয়রানি লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা
                    প্রদানের বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে।
                </div>
                <div class="col-md-6 mt-5">
                    <a href=""><button type="button" class="px-15 btn btn-success">বিস্তারিত</button></a>
                    <a href="#!" class="svg-home-play" style="#008841 !importan">
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

    <div class="col-md-12 mt-10 row" style="background-color:#f0f1ef ;">
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
@include('_information_help_center_links')
@endsection 
@else
@section('landing')
<div class="container">
    <div class="row">
        
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            
            <div class="row " style=" margin-top: 100px;">
                <h1 class="p-5" style="text-align: center; background-color:#008841; color:white; margin:auto; border-radius: 5px">গোপনীয়তার নীতিমালা</h1>
                <div id="accordion" style="width: 100%;">
                    
                    <div class="card" >
                      <div class="card-headers p-3" id="headingOne">
                        <h5 class="mb-0">
                          <button style="width: 100%; text-align:left" class="btn btn-success " data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            ১. ভূমিকা 
                          </button>
                        </h5>
                      </div>
                  
                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের জেনারেল সার্টিফিকেট আদালত ব্যবস্থার অনলাইন প্ল্যাটফর্মে আপনাকে স্বাগতম। <br><br>
                            আমাদের ওয়েবসাইট gcc.ecourt.gov.bd এর মাধ্যমে আমরা মামলা ব্যবস্থাপনা সিস্টেম পরিচালনা করছি, এবং এটির মাধ্যমে আমরা কীভাবে আমাদের পরিষেবা ব্যবহার করছি, সে সম্পর্কে ব্যাখ্যা দেওয়া হয়েছে। আমাদের গোপনীয়তা নীতি gcc.ecourt.gov.bd  আপনার পরিদর্শন অনুভব করে এবং তার মাধ্যমে আমরা কোনও তথ্য সংগ্রহ, রক্ষণ, এবং প্রকাশ করি তা ব্যাখ্যা করে। আমরা আপনার ডেটা ব্যবহার করে পরিষেবা প্রদান এবং তাকে আরও উন্নত করতে পারি। আপনি যদি এই পরিষেবা ব্যবহার করতে সম্মত হন, তবে আপনি এই নীতির মাধ্যমে তথ্য সংগ্রহ এবং ব্যবহার করতে সম্মত হয়েছেন। এই গোপনীয়তা নীতি অনুসারে, এই শর্তাবলি যত্ন নেওয়া হয়েছে এবং এটির মাধ্যমে আমাদের প্রয়োজনীয় নিরাপত্তা ও বিধি মেনে চলা হয়েছে।
                            
                        </div>
                      </div>
                    </div>

                    <div class="card" >
                      <div class="card-headers p-3"  id="headingTwo">
                        <h5 class="mb-0">
                          <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            ২. সংজ্ঞা
                          </button>
                        </h5>
                      </div>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের জেনারেল সার্টিফিকেট আদালত ব্যবস্থার অনলাইন প্ল্যাটফর্মটি  gcc.ecourt.gov.bd ওয়েবসাইট দ্বারা পরিচালিত। সিস্টেমটির মাধ্যমে প্রতিষ্ঠান মামলার আবেদন করতে পারবে, আপীল করতে পারবে এবং আপীলের সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে। পাশাপাশি প্রতিষ্ঠান মামলা দাখিল করার পর মামলার সর্বশেষ অবস্থা সম্পর্কে সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে SMS ও ই-মেইলের মাধ্যমে জানানো হবে। প্রতিষ্টানের ও জনগণের সময় ও শ্রম লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা প্রদানের বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে।
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-headers p-3" id="headingThree">
                        <h5 class="mb-0">
                          <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            ৩. তথ্য সংগ্রহ এবং ব্যবহার
                          </button>
                        </h5>
                      </div>
                      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            আমরা আপনাকে আমাদের পরিষেবা প্রদান এবং উন্নত করার জন্য বিভিন্ন উদ্দেশ্যে বিভিন্ন ধরণের তথ্য সংগ্রহ করি।
                        </div>
                      </div>
                    </div>

                    <div class="card">
                        <div class="card-headers p-3" id="headingFour">
                          <h5 class="mb-0">
                            <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                ৪. সংগৃহীত ডেটার ধরন
                            </button>
                          </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                          <div class="card-body">
                            ব্যক্তিগত তথ্যঃ<br>
                            আমাদের পরিষেবা ব্যবহার করার সময়, আমরা আপনাকে কিছু ব্যক্তিগতভাবে শনাক্তযোগ্য তথ্য প্রদান করতে বলতে পারি যা আপনার সাথে যোগাযোগ বা সনাক্ত করতে ব্যবহার করা যেতে পারে ("ব্যক্তিগত ডেটা")। ব্যক্তিগতভাবে, শনাক্তযোগ্য তথ্য অন্তর্ভুক্ত হতে পারে, কিন্তু এর মধ্যে সীমাবদ্ধ নয়ঃ<br>
                            <ul style="list-style: none">
                                <li>০.১। ইমেইল ঠিকানা</li>
                                <li>০.২। প্রথম নাম এবং শেষ নাম</li>
                                <li>০.৩। ফোন নম্বর, NID</li>
                                <li>০.৪। ঠিকানা, দেশ, জিপ/পোস্টাল কোড, শহর</li>
                                <li>০.৫। কুকিজ এবং ব্যবহারের ডেটা</li>
                            </ul>

                            আপনি আপনার ব্রাউজারকে সব কুকিজ প্রত্যাখ্যান করতে বা কুকি কখন পাঠানো হচ্ছে তা নির্দেশ করতে পারেন। যাইহোক, যদি আপনি কুকিজ গ্রহণ না করেন, তাহলে আপনি আমাদের পরিষেবার কিছু অংশ ব্যবহার করতে পারবেন না।<br>
                            কুকিজের উদাহরণ আমরা ব্যবহার করি: <br>
                            <ul style="list-style: none">
                                <li>০.১ সেশন কুকিজঃ আমরা আমাদের সেবা চালানোর জন্য সেশন কুকি ব্যবহার করি।</li>
                                <li>০.২। পছন্দ কুকিজঃ আমরা আপনার পছন্দ এবং বিভিন্ন সেটিংস মনে রাখতে পছন্দ কুকিজ ব্যবহার করি।</li>
                                <li>০.৩। সিকিউরিটি কুকিজঃ আমরা নিরাপত্তার জন্য সিকিউরিটি কুকি ব্যবহার করি।</li>
                                <li>০.৪। বিজ্ঞাপন কুকিঃ বিজ্ঞাপন কুকিজ আপনাকে এবং আপনার আগ্রহের সাথে প্রাসঙ্গিক হতে পারে এমন বিজ্ঞাপন দিয়ে আপনাকে পরিবেশন করতে ব্যবহৃত হয়।</li>
                               
                            </ul>
                            
                            
                            
                            
                            
                          </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-headers p-3" id="headingFive">
                          <h5 class="mb-0">
                            <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                ৫. ডেটার ব্যবহার
                            </button>
                          </h5>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                          <div class="card-body">
                            ভূমি রাজস্ব মামলা ব্যবস্থাপনা সিস্টেমে বিভিন্ন উদ্দেশ্যে সংগৃহীত তথ্য ব্যবহার করে: <br>
                            <ul style="list-style: none">
                                <li>০.১। আমাদের পরিষেবা প্রদান এবং বজায় রাখার জন্য;</li>
                                <li>০.২। আমাদের সেবার পরিবর্তন সম্পর্কে আপনাকে অবহিত করতে;</li>
                                <li> ০.৩। আপনি যখন আমাদের সেবার ইন্টারেক্টিভ ফিচারে অংশ নেওয়ার অনুমতি দেবেন;</li>
                                <li>০.৪। গ্রাহক সহায়তা প্রদান;</li>
                                <li>০.৫ বিশ্লেষণ বা মূল্যবান তথ্য সংগ্রহ করা যাতে আমরা আমাদের পরিষেবা উন্নত করতে পারি;</li>
                                <li>০.৬। আমাদের পরিষেবার ব্যবহার পর্যবেক্ষণ করতে;</li>
                                <li>০.৭। প্রযুক্তিগত সমস্যাগুলি সনাক্ত করা, প্রতিরোধ করা এবং সমাধান করা;</li>
                                <li>০.৮। অন্য কোন উদ্দেশ্য পূরণ করার জন্য যা আপনি প্রদান করেন;</li>
                                <li>০.৯। যখন আপনি তথ্য প্রদান করেন তখন অন্য কোন উপায়ে আমরা বর্ণনা করতে পারি;</li>
                                <li>০.১০। আপনার সম্মতির সাথে অন্য কোন উদ্দেশ্যে।</li>
                            </ul>

                          </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-headers p-3" id="headingSix">
                          <h5 class="mb-0">
                            <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                ৬. ডেটা ধরে রাখা
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                          <div class="card-body">
                            এই গোপনীয়তা নীতিতে নির্ধারিত উদ্দেশ্যে যতক্ষণ প্রয়োজন ততক্ষণ আমরা আপনার ব্যক্তিগত তথ্য ধরে রাখব। আমরা আপনার ব্যক্তিগত ডেটা আমাদের আইনী বাধ্যবাধকতা মেনে চলার জন্য প্রয়োজনীয় পরিমাণে ধরে রাখব এবং ব্যবহার করব (উদাহরণস্বরূপ, প্রযোজ্য আইন মেনে চলার জন্য যদি আমাদের আপনার ডেটা ধরে রাখতে হয়), বিরোধ নিষ্পত্তি করতে এবং আমাদের আইনি চুক্তি এবং নীতিগুলি কার্যকর করতে। <br>
                            আমরা অভ্যন্তরীণ বিশ্লেষণের উদ্দেশ্যে ব্যবহারের ডেটাও ধরে রাখব। ব্যবহারের ডেটা সাধারণত স্বল্প সময়ের জন্য ধরে রাখা হয়, এই ডেটাটি নিরাপত্তা জোরদার করার জন্য বা আমাদের সেবার কার্যকারিতা উন্নত করার জন্য ব্যবহার করা হয়, অথবা আমরা আইনগতভাবে এই ডেটা দীর্ঘ সময়ের জন্য ধরে রাখতে বাধ্য। 
                            

                            
                          </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-headers p-3" id="headingSeven">
                          <h5 class="mb-0">
                            <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                ৭. তথ্য স্থানান্তর
                            </button>
                          </h5>
                        </div>
                        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
                          <div class="card-body">
                            ব্যক্তিগত তথ্য সহ আপনার তথ্য, আপনার দেশ বা অন্যান্য সরকারি এখতিয়ারের বাইরে অবস্থিত কম্পিউটারে স্থানান্তরিত এবং রক্ষণাবেক্ষণ করা যেতে পারে যেখানে ডেটা সুরক্ষা আইন আপনার এখতিয়ারের থেকে ভিন্ন হতে পারে।আপনি যদি বাংলাদেশের বাইরে থাকেন এবং আমাদের তথ্য প্রদান করতে চান, দয়া করে মনে রাখবেন যে আমরা ব্যক্তিগত তথ্য সহ তথ্য বাংলাদেশে স্থানান্তর করি এবং সেখানে প্রক্রিয়া করি।এই গোপনীয়তা নীতিতে আপনার সম্মতি এবং আপনার এই ধরনের তথ্য জমা দেওয়ার পরে সেই স্থানান্তরের প্রতি আপনার চুক্তির প্রতিনিধিত্ব করে।আপনার ডেটা সুরক্ষিতভাবে এবং এই গোপনীয়তা নীতি অনুসারে নিশ্চিত করার জন্য জেনারেল সার্টিফিকেট আদালত ব্যবস্থার অনলাইন প্ল্যাটফর্ম যুক্তিসঙ্গতভাবে প্রয়োজনীয় সমস্ত পদক্ষেপ গ্রহণ করবে এবং আপনার ব্যক্তিগত ডেটা কোনও সংস্থা বা দেশে স্থানান্তরিত হবে ন, যতক্ষণ না নিরাপত্তা সহ পর্যাপ্ত নিয়ন্ত্রণ থাকে। 
                            

                            
                          </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-headers p-3" id="headingEight">
                          <h5 class="mb-0">
                            <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                ৮. তথ্য প্রকাশ
                            </button>
                          </h5>
                        </div>
                        <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
                          <div class="card-body">
                            আমরা সংগৃহীত ব্যক্তিগত তথ্য প্রকাশ করতে পারি, অথবা আপনি প্রদান করেনঃ <br>
                            <ul style="list-style: none">
                                <li>১। আইন প্রয়োগের জন্য প্রকাশ।</li>
                                <li>২। নির্দিষ্ট পরিস্থিতিতে, আইন দ্বারা বা সরকারি কর্তৃপক্ষের বৈধ অনুরোধের জবাবে আমাদের  ব্যক্তিগত তথ্য প্রকাশের প্রয়োজন হতে পারে।</li>
                            </ul>
                                
                                

                            

                            
                          </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-headers p-3" id="headingNine">
                          <h5 class="mb-0">
                            <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                ৯. ডেটার নিরাপত্তা 
                            </button>
                          </h5>
                        </div>
                        <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion">
                          <div class="card-body">
                            আপনার ডেটার নিরাপত্তা আমাদের জন্য গুরুত্বপূর্ণ কিন্তু মনে রাখবেন যে ইন্টারনেটে ট্রান্সমিশনের কোন পদ্ধতি বা ইলেকট্রনিক স্টোরেজ পদ্ধতি ১০০% নিরাপদ নয়। যদিও আমরা আপনার ব্যক্তিগত তথ্য সুরক্ষার জন্য বাণিজ্যিকভাবে গ্রহণযোগ্য উপায় ব্যবহার করার চেষ্টা করি, আমরা এর সম্পূর্ণ নিরাপত্তার নিশ্চয়তা দিতে পারি না।

                            

                            
                          </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-headers p-3" id="headingTen">
                          <h5 class="mb-0">
                            <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                ১০. পরিষেবা প্রদানকারী 
                            </button>
                          </h5>
                        </div>
                        <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordion">
                          <div class="card-body">
                            আমরা আমাদের পরিষেবা প্রদানকারী, আমাদের পক্ষ থেকে পরিষেবা প্রদান, পরিষেবা-সম্পর্কিত পরিষেবাগুলি সম্পাদন বা আমাদের পরিষেবা কীভাবে ব্যবহার করা হয় তা বিশ্লেষণে আমাদের সহায়তা করার জন্য তৃতীয় পক্ষের সংস্থা এবং ব্যক্তিদের নিয়োগ করতে পারি।আমাদের পক্ষ থেকে এই কাজগুলো করার জন্য এই তৃতীয় পক্ষগুলি আপনার ব্যক্তিগত তথ্য অ্যাক্সেস করতে পারে এবং এটি অন্য কোন উদ্দেশ্যে প্রকাশ বা ব্যবহার করতে বাধ্য নয়।

                            

                            
                          </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-headers p-3" id="headingEleven">
                          <h5 class="mb-0">
                            <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                                ১১. শিশুদের গোপনীয়তা
                            </button>
                          </h5>
                        </div>
                        <div id="collapseEleven" class="collapse" aria-labelledby="headingEleven" data-parent="#accordion">
                          <div class="card-body">
                            আমাদের পরিষেবাগুলি ১৮ বছরের কম বয়সী শিশুদের দ্বারা ব্যবহারের উদ্দেশ্যে নয়।
                            আমরা ১৮ বছরের কম বয়সী শিশুদের কাছ থেকে ব্যক্তিগতভাবে শনাক্তযোগ্য তথ্য সংগ্রহ করি না। যদি আপনি সচেতন হন যে একটি শিশু আমাদের ব্যক্তিগত তথ্য প্রদান করেছে, তাহলে দয়া করে আমাদের সাথে যোগাযোগ করুন। যদি আমরা সচেতন হই যে আমরা পিতামাতার সম্মতি যাচাই ছাড়াই শিশুদের কাছ থেকে ব্যক্তিগত তথ্য সংগ্রহ করেছি, আমরা আমাদের সার্ভার থেকে সেই তথ্য অপসারণের পদক্ষেপ গ্রহণ করি।
                          </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-headers p-3" id="headingTwelve">
                          <h5 class="mb-0">
                            <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                                ১২. এই গোপনীয়তা নীতিতে পরিবর্তন
                            </button>
                          </h5>
                        </div>
                        <div id="collapseTwelve" class="collapse" aria-labelledby="headingTwelve" data-parent="#accordion">
                          <div class="card-body">
                            আমরা সময়ে সময়ে আমাদের গোপনীয়তা নীতি আপডেট করতে পারি। এই পৃষ্ঠায় নতুন গোপনীয়তা নীতি পোস্ট করে আমরা আপনাকে কোন পরিবর্তন সম্পর্কে অবহিত করব।
                            পরিবর্তনটি কার্যকর হওয়ার আগে এবং আমাদের গোপনীয়তা নীতির শীর্ষে "কার্যকর তারিখ" আপডেট করার পূর্বে আমরা আপনাকে ইমেইল অথবা আমাদের পরিষেবার একটি বিশিষ্ট নোটিশের মাধ্যমে জানানো হবে। যেকোনো পরিবর্তনের জন্য আপনাকে পর্যায়ক্রমে এই গোপনীয়তা নীতি পর্যালোচনা করার পরামর্শ দেওয়া হচ্ছে। এই গোপনীয়তা নীতিতে পরিবর্তনগুলি যখন এই পৃষ্ঠায় পোস্ট করা হয় তখন কার্যকর হয়।

                          </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-headers p-3" id="headingthirten">
                          <h5 class="mb-0">
                            <button style="width: 100%; text-align:left" class="btn btn-success collapsed" data-toggle="collapse" data-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
                                ১৩. আমাদের সাথে যোগাযোগ করুন
                            </button>
                          </h5>
                        </div>
                        <div id="collapseThirteen" class="collapse" aria-labelledby="headingthirten" data-parent="#accordion">
                          <div class="card-body">
                            এই গোপনীয়তা নীতি সম্পর্কে আপনার যদি কোন প্রশ্ন থাকে, অনুগ্রহপূর্বক আমাদের সাথে হট লাইনের মাধ্যমে যোগাযোগ করুনঃ ৩৩৩।

                          </div>
                        </div>
                    </div>


                </div>  

                
            </div>
        <div class="col-lg-1"></div>
    </div>

    
    
    
</div>

@endsection
@endauth





    
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
        });
    </script>
@endsection
