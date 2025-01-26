@extends('layouts.landing')

@section('style')
@endsection

@section('landing')
    <!--begin::Landing hero-->
      
        <div class="container">
            <div class="row">
                <div class="col-lg-12 phomebuttons">
       
                    <div class="card phomebutton_card" style="background: #f6f6f7 !important">
                        <div class="card-body phomebutton_cbody">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <a href="{{ url('cdap/user/create/citizen') }}"><button class="btn btn-success btn-block"><i class="fas fa-users"></i> নাগরিক নিবন্ধন</button></a>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <a href="{{ url('cdap/user/create/organization') }}"><button class="btn btn-success btn-block"><i class="fas fa-user"></i> প্রাতিষ্ঠানিক  নিবন্ধন</button></a>
                                </div>
                            </div>
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
   


    @include('_information_help_center_links')
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
        });
    </script>
@endsection
