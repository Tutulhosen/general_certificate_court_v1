<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>


    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Arvo'>
    <style>
        .page_404 {
            padding: 40px 0;
            background: #fff;
            font-family: 'Arvo', serif;
        }

        .page_404 img {
            width: 100%;
        }

        .four_zero_four_bg {

            /* background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif); */
            background-image: url('{{ url("uploads/404/dribbble_1.gif") }}');
            height: 400px;
            background-position: center;
        }


        .four_zero_four_bg h1 {
            font-size: 80px;
        }

        .four_zero_four_bg h3 {
            font-size: 80px;
        }

        .link_404 {
            color: #fff !important;
            padding: 10px 20px;
            background: #39ac31;
            margin: 20px 0;
            display: inline-block;
        }

        .contant_box_404 {
            margin-top: -50px;
        }

    </style>
</head>

<body>

    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1  text-center">
                        <div class="four_zero_four_bg">

                            <h1 class="text-center ">404</h1>


                        </div>

                        <div class="contant_box_404">
                             <img alt="Logo" src="{{ asset(App\Models\SiteSetting::first()->site_logo) }}" width="50px"  style="width: 200px" />
                            <h3 class="h2">
                                দুঃখিত!
                            </h3>

                            <p>আপনি যে পৃষ্ঠাটি খুঁজছেন তা পাওয়া যাচ্ছে না!</p>
                            <a href="{{ url('/') }}" class="link_404">পূর্বে ফিরে যান</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
