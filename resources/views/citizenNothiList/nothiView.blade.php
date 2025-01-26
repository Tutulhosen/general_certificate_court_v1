@extends('layouts.citizen.citizen')
@section('content')
    <style>
        .accordion.accordion-toggle-arrow .card .card-header .card-title:after {
            color: white !important;
        }

    </style>
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="container">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    </div>
                    {{-- <div class="col-2">
                    @if (Auth::user()->role_id == 2)
                    <a href="{{ route('messages_group') }}?c={{ $appeal->id }}" class="btn btn-primary float-right">বার্তা</a>
                        @endif
                </div> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            <div class="accordion  accordion-toggle-arrow" id="accordionExample4">
                {{-- Order --}}
                <div class="card">
                    {{-- <div class="card-header bg-info" id="headingOne4">
                        <div class="card-title text-white" data-toggle="collapse" data-target="#collapseOne4">
                            <i class="fas fa-gavel text-white"></i> আদেশ নামা
                        </div>
                    </div> --}}
                    {{-- <div id="collapseOne4" class="collapse show" data-parent="#accordionExample4">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="100" scope="col" class="align-middle"> ১ - নম্বর :</th>
                                        <th scope="col" class="align-middle">আদেশ নামা</th>
                                        <th width="100">
                                            <a href="{{ route('appeal.getOrderSheets', encrypt($caseInfo[0]->id)) }}" target="_blank"><button id="printReport" class="btn btn-primary btn-link"
                                                type="button">
                                                <i class="flaticon2-print"></i>
                                                দেখুন
                                            </button></a>
                                           <!--  <input type="hidden" id="appealId" class="form-control"
                                                value="{{ $caseInfo[0]->id }}"> -->
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                </div>
                {{-- short Order --}}
                <div class="card">
                    <div class="card-header bg-info" id="headingTwo4">
                        <div class="card-title collapsed text-white" data-toggle="collapse" data-target="#collapseTwo4">
                            {{-- <i class="flaticon2-copy"></i> সংক্ষিপ্ত আদেশ --}}
                            <i class="fas fa-gavel text-white"></i> সংক্ষিপ্ত আদেশ
                        </div>
                    </div>
                    <div id="collapseTwo4" class="collapse show" data-parent="#accordionExample4">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    @forelse ($shortOrderTemplateList as $key => $shortOrderTemplate)
                                    @php
                                        $trialDate = explode(" ",$shortOrderTemplate->created_at);
                                    @endphp
                                         <tr>
                                            <th  width="100" scope="col" class="align-middle">{{ en2bn(++$key)}} -
                                                নম্বর : </th>
                                            <th scope="col" class="align-middle">
                                                {{ en2bn(date_formater_helpers_make_bd_v2($trialDate[0])) }}
                                            </th>
                                            <th scope="col" class="align-middle">
                                                {{ $shortOrderTemplate->template_name }}
                                            </th>
                                            <th width="100">
                                                <a  href="{{ route('appeal.getShortOrderSheets', ['id'=>$shortOrderTemplate->id]) }}" target="_blank">
                                                    <span class="btn btn-primary btn-link"
                                                        type="button"><i class="flaticon2-print"></i> দেখুন
                                                    </span>
                                                </a>
                                            </th>
                                        </tr>
                                    @empty
                                    <div class="card">
                                        <p class="h4 text-center mt-3">  তথ্য খুঁজে পাওয়া যায়নি... <i class="flaticon2-search"></i></p>

                                    </div>
                                    @endforelse


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- Payments --}}
                <div class="card">
                    <div class="card-header bg-info" id="headingTwo4">
                        <div class="card-title collapsed text-white" data-toggle="collapse" data-target="#collapseTen4">
                            {{-- <i class="flaticon2-copy"></i> সংক্ষিপ্ত আদেশ --}}
                            <i class="flaticon-notepad text-white"></i> অর্থ আদায়
                        </div>
                    </div>
                    <div id="collapseTen4" class="collapse" data-parent="#accordionExample4">
                        <div class="card-body">
                            <table class="table table-bordered table-condensed margin-0">
                                <tbody>


                                    @forelse ($paymentAttachment as $indexKey => $nfiles)

                                        <tr>
                                            <td class="wide-70px">
                                                {{ \App\Services\DataConversionService::toBangla(++$indexKey) }}
                                                - নম্বর : </td>
                                            <td class="wide-100px">
                                                {{ \App\Services\DataConversionService::toBangla($nfiles->paid_date) }}
                                            </td>
                                            <td>
                                                {{ $nfiles->file_category }}
                                            </td>
                                            <td class="wide-30px text-nowrap">
                                                <a title=" ডাউনলোড করতে ক্লিক করুন "
                                                    href="{{ url('/').'/'.$nfiles->file_path . $nfiles->file_name }}"
                                                    class="btn-link btn-md" download=""><i
                                                        class="fa fa-download"></i> ডাউনলোড </a>
                                            </td>
                                        </tr>
                                    @empty
                                    <div class="card">
                                        <p class="h4 text-center mt-3">  তথ্য খুঁজে পাওয়া যায়নি... <i class="flaticon2-search"></i></p>

                                    </div>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- নথি( সার্টিফিকেট আদালত) --}}
                <div class="card">
                    <div class="card-header bg-info" id="headingThree4">
                        <div class="card-title collapsed text-white" data-toggle="collapse" data-target="#collapseThree4">
                            <i class="flaticon-attachment text-white"></i> নথি( সার্টিফিকেট আদালত)
                        </div>
                    </div>
                    <div id="collapseThree4" class="collapse" data-parent="#accordionExample4">
                        <div class="card-body">
                            <table class="table table-bordered table-condensed margin-0">
                                <tbody>
                                    <?php
                                        if(count($nothiData) == 0){
                                    ?>

                                    <div class="card">
                                        <p class="h4 text-center mt-3">  তথ্য খুঁজে পাওয়া যায়নি... <i class="flaticon2-search"></i></p>
                                    </div>
                                <?php
                                    }else{

                                foreach ($nothiData as $nfiles) {

                                $trialDate = explode(" ",$nfiles['conduct_date']);

                                ?>
                                    <tr>
                                        <th  width="100" scope="col" class="align-middle">{{ $nfiles['index'] }} - নম্বর :
                                        </th>
                                        <th scope="col" class="align-middle">
                                            {{ $trialDate[0] }}
                                        </th>
                                        <th class="align-middle">
                                            {{ $nfiles['file_category'] }}
                                        </th>
                                        <th width="100" class="align-middle">
                                            <a href="{{ asset($nfiles['file_path'] . $nfiles['file_name']) }}" target="_blank"
                                                class="btn btn-sm btn-primary">
                                                <i class="flaticon2-print"></i> দেখুন
                                            </a>
                                            {{-- <a title=" ডাউনলোড করতে ক্লিক করুন "
                                                href="/ECOURT/{{ $nfiles['file_path'] . $nfiles['file_name'] }}"
                                                class="btn-link btn-md" download=""><i
                                                    class="fa fa-download"></i> ডাউনলোড </a> --}}
                                        </th>
                                    </tr>
                                    <?php }} ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- হাজিরা --}}
                <div class="card">
                    <div class="card-header bg-info" id="headingFour4">
                        <div class="card-title collapsed text-white" data-toggle="collapse" data-target="#collapseFour4">
                            <i class="fas fa-clipboard-check text-white"></i> হাজিরা
                        </div>
                    </div>
                    <div id="collapseFour4" class="collapse" data-parent="#accordionExample4">
                        <div class="card-body">
                            <table class="table table-bordered table-condensed margin-0">
                                <tbody>
                                    <thead>
                                        <td> নাম</td>
                                        <td> পদবী</td>
                                        <td> ধরণ</td>
                                        <td> তারিখ</td>
                                        <td> হাজিরা</td>
                                    </thead>
                                     {{-- @dd($citizenAttendanceList)  --}}
                                    @if(count($citizenAttendanceList) == 0)
                                        <tr>
                                            <td colspan="4">
                                            <div class="card ">
                                                <p class="h4 text-center mt-3 mute">  তথ্য খুঁজে পাওয়া যায়নি... <i class="flaticon2-search"></i></p>
                                            </div>
                                            </td>
                                        </tr>
                                    @else
                                        {{-- @if($citizenAttendanceList[0]->attendance == NULL || $citizenAttendanceList[0]->attendance == '' )
                                            <tr>
                                                <td colspan="4">
                                                <div class="card ">
                                                    <p class="h4 text-center mt-3 mute">  তথ্য খুঁজে পাওয়া যায়নি... <i class="flaticon2-search"></i></p>
                                                </div>
                                                </td>
                                            </tr>
                                        @else --}}
                                        @php  $citizenAttendanceList=array_reverse($citizenAttendanceList)  @endphp
                                            @foreach ($citizenAttendanceList as $citizenAttendance)
                                            <tr>
                                                {{-- @dd($citizenAttendance ) --}}

                                                <td>
                                                    {{ $citizenAttendance->citizen_name }}
                                                </td>
                                                <td>
                                                    {{ $citizenAttendance->citizen_designation }}
                                                </td>
                                                <td>
                                                    {{ $citizenAttendance->citizen_role }}
                                                </td>
                                                <td>
                                                    {{ en2bn(explode(' ',$citizenAttendance->attendance_date)[0]) }}
                                                </td>
                                                <td>
                                                    {{-- {{ $citizenAttendance->attendance}} --}}
                                                    @if ($citizenAttendance->attendance == 'PRESENT')
                                                        উপস্থিত
                                                    @endif
                                                    @if ($citizenAttendance->attendance == 'ABSENT')
                                                        অনুপস্থিত
                                                    @endif
                                                    @if ($citizenAttendance->attendance == '')
                                                    আবেদন শুরু
                                                  @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        {{-- @endif --}}
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- <div id="appealNamaTemplate" style="display: none; ">
        @include('reports.appealNama')
    </div>
    <div id="appealRayTemplate" style="display: none; ">
        @include('reports.rayNama')
    </div>

    <div id="appealShortOrderTemplate" style="display: none; ">
        @include('ShortOrderTemplate.shortOrderTemplateView')
    </div> --}}



@endsection
@section('jsComponent')
    <script src="{{ asset('js/appeal/appeal-ui-utils.js') }}"></script>
    <script src="{{ asset('js/appeal/appealPopulate.js') }}"></script>
    {{-- <script src="{{ asset('js/initiate/ .js') }}"></script> --}}
    <script src="{{ asset('js/reports/appealNama.js') }}"></script>
    <script src="{{ asset('js/reports/rayNama.js') }}"></script>
    <script src="{{ asset('js/shortOrderTemplate/shortOrderTemplate.js') }}"></script>
    <script src="{{ asset('js/englishToBangla/convertEngToBangla.js') }}"></script>
    <script>
        appealNama = module.exports = {
    getAppealOrderListsInfo:function (appealId) {
        return $.ajax({headers: { 'X-CSRF-Token' : appealPopulate.token }, url: '/appeal/get/appealnama',
            method:"post", data: {appealId:appealId}, dataType: 'json'});
    },
    printAppealNama:function () {
        var appealNamaContent='',
            rayNamaContent='',
            rayHead = '',
            rayBody = '';
        var appealId=$('#appealId').val();
        appealNama.getAppealOrderListsInfo(appealId).done(function (response,textStatus, jqXHR) {

            if(response.appealOrderLists.length>0){

                appealNamaContent=appealNama.getAppealNamaReport(response);

                $('#head').empty();
                $('#body').empty();

                $('#head').append(appealNamaContent.header);
                $('#body').append(appealNamaContent.body);


                //-------------------------------------------------------------------//

                var newwindow = window.open();
                newdocument = newwindow.document;
                newdocument.write($('#appealNamaTemplate').html());
                newdocument.close();
                setTimeout(function () {
                    newwindow.print();
                }, 500);
                return false;
            }else {
                $.alert('আদেশ প্রদান করা হয় নি','অবহিতকরণ বার্তা');
            }

        })

    },
    getAppealNamaReport:function (appealInfo) {
        var header='',body='',th='',tableClose='';
        header=appealNama.prepareAppealNamaHeader(appealInfo);
        th=appealInfo.appealOrderLists[0].order_detail_table_th;
        tableClose=appealInfo.appealOrderLists[0].order_detail_table_close;
        body=th+appealNama.prepareAppealNamaBody(appealInfo)+tableClose;

        return {header:header,body:body};
    },
    prepareAppealNamaHeader:function (appealInfo) {
        var length=appealInfo.appealOrderLists.length;
        var header=appealInfo.appealOrderLists[length-1].order_header;

        return header;

    },
    prepareAppealNamaBody:function (appealInfo) {

        var body="";
        $.each(appealInfo.appealOrderLists,function (index,orderList) {
            body+=orderList.order_detail_table_body;
        });

        return body;

    }
};
    </script>
@endsection
