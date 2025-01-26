@extends('layouts.landing')
@section('landing')
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="container">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    </div>

                    <div class="col-2">
                        {{-- <a href="{{ route('appeal.pdfOrderSheet', $nothi_id) }}"
                    class="btn btn-danger btn-link" style="float: right;" target="_blank">জেনারেট পিডিএফ</a> --}}
                        <a href="javascript:generatePDF()" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
                    </div>

                    {{-- <div class="col-2">
                @if (Auth::user()->role_id == 2)
                <a href="{{ route('messages_group') }}?c={{ $appeal->id }}" class="btn btn-primary float-right">বার্তা</a>
                @endif
            </div> --}}

                </div>
            </div>
        </div>

        <div class="card-body" id="element-to-print">
            <div class="contentForm" style="font-size: medium;">
                <div id="head">
                    <p class="form-bd" style="text-align: left;"> বাংলাদেশ ফরম নম্বর - ২৭০ <br></p>
                    <h2 style="text-align: center;"> আদেশপত্র</h2>
                    <p style="text-align: center;"> (১৯১৭ সালের রেকর্ড ম্যানুয়েলের ১২৯ নং বিধি ) &nbsp;<br><span>আদেশপত্র,
                            তারিখ
                            {{ en2bn($appealOrderLists['ordershit_start_date']) }} হইতে {{ en2bn($appealOrderLists['ordershit_end_date']) }} পর্যন্ত ।</span> <br><span> উপজেলা/জেলা :{{ $appealOrderLists['case_Upzilla'] }}, 
                                {{ $appealOrderLists['case_District'] }} 
                            
                            ।</span> <br><br><span style="float: left"> মামলার ধরন :সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫
                            ধারা</span><span style="float: right;"> মামলা নম্বর-&nbsp; {{ en2bn($appealOrderLists['case_info']['case_no']) }} /{{ en2bn($appealOrderLists['case_info']['manual_case_no']) }} </span></p>
                    <div id="dependent"> </div><br>
                </div>

                <div id="body" style="overflow: hidden;">
                    <table cellspacing="0" cellpadding="0" border="1" width="100%">
                        <thead>
                            <tr>
                                <td valign="middle" width="5%" align="center"> আদেশের ক্রমিক নং ও তারিখ </td>
                                <td valign="middle" width="75%" align="center"> আদেশ ও অফিসারের স্বাক্ষর</td>
                                <td valign="middle" width="10%" align="center"> আদেশের উপর গৃহীত ব্যবস্থা</td>
                            </tr>
                        </thead>

                        <tbody>
                            @if (!empty($appealOrderLists['shortoder_array_date']))
                                @foreach ($appealOrderLists['shortoder_array_date'] as $index => $singleorder)
                                    <tr>
                                        <td width="10%" valign="middle" align="center">
                                            {{ en2bn(++$index) }}
                                            <br>
                                            {{ en2bn($singleorder['order_date']) }}
                                        </td>
                                        <td width="80%" valign="middle" align="left">
                                            <p>{{ $singleorder['certificate_asst_order'] }}</p>
                                            <br>
                                            <p>{{ $singleorder['gcc_order'] }}</p>
                                            <div align="center">
                                                <p style="color: blueviolet;">{{ $singleorder['gcc_name'] }}
                                                </p>
                                                <p style="color: blueviolet;">{{ $singleorder['designation'] }}
                                                </p>
                                                <img src="{{ $singleorder['gcc_signature'] }}" alt="">
                                            </div>
                                            
                                        </td>
                                        <td width="5%" valign="middle" align="center">
                                           
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>

                    </table>
                </div>

                <h3 id="rayNamaHeading" style="text-align: center;"></h3>
                <div id="rayHeadAppealNama" class="ray-head"></div>
                <div id="rayBodyAppealNama" class="ray-body"></div>
                <div class="row">
                    <div class="col-md-4">
                        
                    </div>
                    <div class="col-md-4">
                        <p>আমাকে স্ক্যান করুন</p>
                        <div id="qr_code_show">
                            {!! QrCode::size(170)->generate($data_image_path) !!}
                            {{-- <img src="{{ $data_image_path }}" alt=""> --}}
                        </div>
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

@section('scripts')
    {{-- https://www.byteblogger.com/how-to-export-webpage-to-pdf-using-javascript-html2pdf-and-jspdf/
    https://ekoopmans.github.io/html2pdf.js/ --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function generatePDF() {
            var element = document.getElementById('element-to-print');
            var opt = {
                margin: 1,
                filename: 'myfile.pdf',
                pagebreak: {
                    avoid: ['tr', 'td']
                },
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    </script>
@endsection

@section('jsComponent')
    <script src="{{ asset('js/appeal/appeal-ui-utils.js') }}"></script>
    <script src="{{ asset('js/appeal/appealPopulate.js') }}"></script>
    <script src="{{ asset('js/initiate/init.js') }}"></script>
    <script src="{{ asset('js/englishToBangla/convertEngToBangla.js') }}"></script>
    <script src="{{ asset('js/initiate/nothiTableInitiate.js') }}"></script>
@endsection
