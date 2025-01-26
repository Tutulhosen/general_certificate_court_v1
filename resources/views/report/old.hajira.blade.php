<html>
<style>
    .contentForm {
        width: 612px;
        margin-left: auto;
        margin-right: auto;
        border: 1px dotted gray;
        font-family: nikoshBan;
        text-align: justify;
        text-justify: inter-word
    }

    .para {
        text-indent: 32px
    }

    .underline {
        text-decoration: underline
    }

    @media print {
        .contentForm {
            border: 0 dotted
        }
    }

    p.p_indent {
        text-indent: 30px
    }

    h3 {
        text-align: center
    }

    h3.top_title_2nd {
        margin-top: -18px
    }

    .clear_div {
        clear: both;
        width: 100%;
        height: 20px
    }

    br {
        line-height: 5px
    }

</style>

@extends('layouts.default')

@section('content')
<body onload="onload()">

    <div class="contentForm" style="font-size: medium; background-color: white;">
        <div style="padding-bottom: 10%;padding-top: 20%; ">
            <div style="float: left;width: 70%;padding-left: 3%; ">
                <b> জেলাঃ {{ $district }}</b>
            </div>
            {{-- <div style="float: right; padding-right: 3%; ">
                <b>আদালত/ট্রাইবুনাল</b>
            </div> --}}
        </div>
        <div style="padding-bottom: 10%">
            <div style="float: left;width: 40%; padding-left: 3%; ">
                <b>সূত্রঃ</b>
            </div>
            <div style="float: right; padding-right: 3%; ">
                <b>মামলা নংঃ <span id="caseNumber">{{ $case_no }}</span></b>
            </div>
        </div>
        <div style="padding-top: 7%">
            <table style="width: 100%;border: 1px solid black;margin-top: 10%;border-collapse: collapse;"
                class="tableCustom">
                <thead style="border: 1px solid black;" class="theadCustom">
                    <td style="border: 1px solid black;" class="tdCustom">
                        <P style="height: 60px;padding-top: 5px;text-align: center;"><b>দরখাস্তকারী/আপীলকারী
                                ডিক্রীদার</b></P>
                        <p style="text-align: center;"><b>নাম / পদবীঃ</b></p>
                        <p style="text-align: center;" id="applicantNameH"><b>
                            {{ $applicant['citizen_name'] }} <br>
                            {{ $applicant['designation'] }}</b>
                        </p>
                        <p style="text-align: center;"><b>স্বাক্ষর ও তারিখঃ</b></p><br>
                        <p style="text-align: center;padding-top: 10px;text-decoration: overline dotted black;" class="hajiraDate"> {{ en2bn($trial_date) }}</p>

                    </td>
                    <td style="border: 1px solid black;" class="tdCustom">বনাম</td>
                    <td style="border: 1px solid black;" class="tdCustom">
                        <P style="height: 60px;padding-top: 5px;text-align: center;">
                            <b>প্রতিপক্ষ/রেসপনডেন্ট/ দেনাদার</b></P>
                        <p style="text-align: center;"><b>নাম / পদবীঃ</b></p>
                        <p style="text-align: center;" id="defaulterNameH"><b>
                            {{ $defaulter['citizen_name'] }} <br>
                            {{ $defaulter['designation'] }}</b>
                        </p>
                        <p style="text-align: center;"><b>স্বাক্ষর ও তারিখঃ</b></p><br>
                        <p style="text-align: center;padding-top: 10px;text-decoration: overline dotted black;" class="hajiraDate"> {{ en2bn($trial_date) }} </p>

                    </td>
                </thead>
            </table>
        </div>
    </div>
    <!-- <script type="text/javascript">
        function onload() {
            // var url = window.location.search.substring(1)
            // var img = document.getElementById('img')
            // img.src = url
            window.print()
        }
    </script> -->
</body>
@endsection


</html>
