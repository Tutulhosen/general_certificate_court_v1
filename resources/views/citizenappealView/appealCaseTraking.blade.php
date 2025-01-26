@php
$user = Auth::user();
$roleID = Auth::user()->role_id;
@endphp

@extends('layouts.citizen.citizen')

@section('content')
    <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
            font-family: 'Kalpurush';
            width: 100%;
        }

        .tg td {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-family: 'Kalpurush', Arial, sans-serif;
            font-size: 14px;
            overflow: hidden;
            padding: 5px 5px;
            word-break: normal;
        }

        .tg th {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-family: 'Kalpurush', Arial, sans-serif;
            font-size: 14px;
            font-weight: normal;
            overflow: hidden;
            padding: 5px 5px;
            word-break: normal;
        }

        .tg .tg-5kbr {
            background-color: #b9f5cc;
            border-color: #c0c0c0;
            font-weight: bold;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-wo29 {
            border-color: #c0c0c0;
            text-align: left;
            vertical-align: top;
            font-weight: bold;
        }

    </style>


    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    </div>
                    <div class="col-md-4">
                        @if ($appeal->appeal_status == 'SEND_TO_EM' || $appeal->appeal_status == 'SEND_TO_ADM')
                            <a href="{{ route('appeal.edit', encrypt($appeal->id)) }}"
                                class="btn btn-primary btn-link font-weight-bolder">
                                <i class="la la-edit"></i>সংশোধন
                            </a>
                        @endif
                        {{-- <a href="javascript:generatePDF()" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a> --}}
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            <div class="row" id="element-to-print">

                <div class="col-md-5 mx-auto">
                    <table class="tg">
                        <thead>
                            <tr>
                                <th class="tg-5kbr" width="150">মামলার অবস্থা</th>
                                <th class="tg-wo29">{{ appeal_status_bng($appeal->appeal_status) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="tg-5kbr">মামলা নম্বর</td>
                                <td class="tg-wo29">{{ en2bn($appeal->case_no) }}</td>
                            </tr>
                            <tr>
                                <td class="tg-5kbr">আবেদনকারীর নাম</td>
                                <td class="tg-wo29">{{ $appeal->caseCreator->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="tg-5kbr">আবেদনের তারিখ</td>
                                <td class="tg-wo29">{{ en2bn($appeal->case_date) }}</td>
                            </tr>
                            <tr>
                                <td class="tg-5kbr">আবেদনকারীর ধরন</td>
                                <td class="tg-wo29">{{ $appeal->caseCreator->role->role_name }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>


                <div class="col-md-8 mx-auto" style="margin-top: 20px; text-align:center">
                    <h2>আদেশের তালিকা</h2>
                    <style type="text/css">
                        .tg2 {
                            border-collapse: collapse;
                            border-spacing: 0;
                            font-family: 'Kalpurush';
                            width: 100%;
                        }

                        .tg2 td {
                            border-color: black;
                            border-style: solid;
                            border-width: 1px;
                            font-family: 'Kalpurush', Arial, sans-serif;
                            font-size: 14px;
                            overflow: hidden;
                            padding: 6px 5px;
                            word-break: normal;
                        }

                        .tg2 th {
                            border-color: black;
                            border-style: solid;
                            border-width: 1px;
                            font-family: 'Kalpurush', Arial, sans-serif;
                            font-size: 14px;
                            font-weight: normal;
                            overflow: hidden;
                            padding: 6px 5px;
                            word-break: normal;
                        }

                        .tg2 .tg-5kbr {
                            background-color: #b9f5cc;
                            border-color: #c0c0c0;
                            font-weight: bold;
                            text-align: center;
                            vertical-align: top
                        }

                        .tg2 .tg-wo29 {
                            border-color: #c0c0c0;
                            text-align: left;
                            vertical-align: top
                        }

                    </style>
                    <table class="tg2">
                        <thead>
                            <tr>
                                <th class="tg-5kbr">নম্বর</th>
                                <th class="tg-5kbr">তারিখ</th>
                                <th class="tg-5kbr">আদেশ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shortOrderTemplateList as $key => $shortOrderTemplate)
                                @php
                                    $trialDate = explode(' ', $shortOrderTemplate->conduct_date);
                                @endphp
                                <tr>
                                    <td class="tg-wo29">{{ en2bn($key+1) }} -
                                        নম্বর :</td>
                                    <td class="tg-wo29">{{ en2bn($trialDate[0]) }}</td>
                                    <td class="tg-wo29">{{ $shortOrderTemplate->case_short_decision }}</td>
                                </tr>
                            @empty
                                <td class="tg-wo29" colspan="3">তথ্য খুঁজে পাওয়া যায়নি... </td>
                            @endforelse
                        </tbody>
                    </table>

                </div>

            </div>
            <br>

        </div>
        <!--end::Card-->
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
                html2pdf(element);
            }
        </script>
    @endsection

    {{-- Includable CSS Related Page --}}
    @section('styles')
        <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Page Vendors Styles-->
    @endsection

    {{-- Scripts Section Related Page --}}
    @section('scripts')
        <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
        <!--end::Page Scripts-->
    @endsection
