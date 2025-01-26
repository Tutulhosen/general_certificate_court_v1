@php
    //dd($log_details_single_by_id);
    if (!empty($log_details_single_by_id->applicant)) {
        $applicant = json_decode($log_details_single_by_id->applicant);
    } else {
        $applicant = null;
    }
    
    if (!empty($log_details_single_by_id->defaulter)) {
        $defaulter = json_decode($log_details_single_by_id->defaulter);
        //dd($defaulter);
    } else {
        $defaulter = null;
    }
    
    if (!empty($log_details_single_by_id->nominees)) {
        $nominees = json_decode($log_details_single_by_id->nominees);
    } else {
        $nominees = null;
    }
    
    $case_date_from_created = explode(' ', $log_details_single_by_id->created_at)[0];
    
    if ($log_details_single_by_id->case_basic_info) {
        $case_basic_info = json_decode($log_details_single_by_id->case_basic_info);
        $appeal_data_from_gcc_appeal = DB::table('gcc_appeals')
            ->join('court', 'gcc_appeals.court_id', 'court.id')
            ->where('gcc_appeals.id', $log_details_single_by_id->appeal_id)
            ->select('gcc_appeals.division_name', 'gcc_appeals.district_name', 'gcc_appeals.upazila_name', 'court.court_name')
            ->first();
        //dd($case_basic_info);
    } else {
        $case_basic_info = null;
    }
    
    $files = json_decode($log_details_single_by_id->files);
    
    //dd($defaulter);
    
@endphp

@extends('layouts.default')

@section('content')
    <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }

        .tg td {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            overflow: hidden;
            padding: 6px 5px;
            word-break: normal;
        }

        .tg th {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            font-weight: normal;
            overflow: hidden;
            padding: 6px 5px;
            word-break: normal;
        }

        .tg .tg-nluh {
            background-color: #dae8fc;
            border-color: #cbcefb;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-19u4 {
            background-color: #ecf4ff;
            border-color: #cbcefb;
            font-weight: bold;
            text-align: right;
            vertical-align: top
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
                        <a href="javascript:generatePDF()" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
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
                @if (!empty($case_basic_info))
                    <div class="col-md-12">
                        <p>আবেদনের তারিখ , {{ $case_basic_info->caseDate }}</p>
                        <p>মোট দাবী , {{ $case_basic_info->totalLoanAmount }}</p>
                        <p>মোট দাবী (কথায়) , {{ $case_basic_info->totalLoanAmountText }}</p>
                        <p>প্রাতিষ্ঠানের নাম , {{ $case_basic_info->applicant_office_name }} </p>
                        <p>প্রাতিষ্ঠানের ঠিকানা , {{ $case_basic_info->organization_physical_address }} </p>
                        <p>প্রাতিষ্ঠানের রাউটিং , {{ $case_basic_info->organization_routing_id }} </p>
                        <p>বিভাগ , {{ $appeal_data_from_gcc_appeal->division_name }}</p>
                        <p>জেলা , {{ $appeal_data_from_gcc_appeal->district_name }}</p>
                        <p>উপজেলা , {{ $appeal_data_from_gcc_appeal->upazila_name }}</p>
                        <p>কোর্ট , {{ $appeal_data_from_gcc_appeal->court_name }}</p>
                    </div>
                @endif
                <div class="col-md-12">
                    @if (!empty($defaulter))
                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="4">খাতকের বিবরণ</th>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="row">ক্রম</th>
                                    <th scope="row">নাম</th>
                                    <th scope="row">লিঙ্গ</th>
                                    <th scope="row">পিতা/স্বামীর নাম</th>
                                    <th scope="row">মাতার নাম</th>
                                    <th scope="row">জাতীয় পরিচয়পত্র</th>
                                    <th scope="row">মোবাইল নম্বর</th>
                                    <th scope="row">ইমেইল</th>
                                    <th scope="row">ঠিকানা</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    if (!isset($defaulter->gender)) {
                                        $gender = ' - ';
                                    } else {
                                        if ($defaulter->gender == 'MALE') {
                                            $gender = 'পুরুষ';
                                        } else {
                                            $gender = 'মেয়ে';
                                        }
                                    }
                                    
                                @endphp

                                <tr>
                                    <td>{{ en2bn('1') }}.</td>
                                    <td>{{ $defaulter->name ?? '-' }}</td>
                                    <td>{{ $gender }}</td>
                                    <td>{{ $defaulter->father ?? '-' }}</td>
                                    <td>{{ $defaulter->mother ?? '-' }}</td>
                                    <td>{{ $defaulter->nid ?? '-' }}</td>
                                    <td>{{ $defaulter->phn ?? '-' }}</td>
                                    <td>{{ $defaulter->email ?? '-' }}</td>
                                    <td>{{ $defaulter->permanent_address ?? '-' }}</td>
                                </tr>

                            </tbody>
                        </table>
                    @endif
                    <br>
                    @if (!empty($applicant))
                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="4">ধারকের বিবরণ</th>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="row">ক্রম</th>
                                    <th scope="row">নাম</th>
                                    <th scope="row">লিঙ্গ</th>
                                    <th scope="row">পিতা/স্বামীর নাম</th>
                                    <th scope="row">মাতার নাম</th>
                                    <th scope="row">জাতীয় পরিচয়পত্র</th>
                                    <th scope="row">মোবাইল নম্বর</th>
                                    <th scope="row">ইমেইল</th>
                                    <th scope="row">ঠিকানা</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $k = 1; @endphp
                                @foreach ($applicant as $applicantpeople)
                                    @php
                                        if (!isset($applicantpeople->gender)) {
                                            $applicantpeoplegender = ' - ';
                                        } else {
                                            if ($applicantpeople->gender == 'MALE') {
                                                $applicantpeoplegender = 'পুরুষ';
                                            } else {
                                                $applicantpeoplegender = 'মেয়ে';
                                            }
                                        }
                                        
                                    @endphp

                                    <tr>
                                        <td>{{ en2bn($k) }}.</td>
                                        <td>{{ $applicantpeople->name ?? '-' }}</td>
                                        <td>{{ $applicantpeoplegender }}</td>
                                        <td>{{ $applicantpeople->father ?? '-' }}</td>
                                        <td>{{ $applicantpeople->mother ?? '-' }}</td>
                                        <td>{{ $applicantpeople->nid ?? '-' }}</td>
                                        <td>{{ $applicantpeople->phn ?? '-' }}</td>
                                        <td>{{ $applicantpeople->email ?? '-' }}</td>
                                        <td>{{ $applicantpeople->permanent_address ?? '-' }}</td>
                                    </tr>
                                    @php $k++; @endphp
                                @endforeach

                            </tbody>
                        </table>
                        <br>
                       
                        <br>
                    @endif
                    @if (!empty($nominees))
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="4">উত্তরাধিকারীর বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row">ক্রম</th>
                                <th scope="row">নাম</th>
                                <th scope="row">লিঙ্গ</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">মাতার নাম</th>
                                <th scope="row">জাতীয় পরিচয়পত্র</th>
                                <th scope="row">মোবাইল নম্বর</th>
                                <th scope="row">ইমেইল</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $k = 1; @endphp
                            @foreach ($nominees as $nomineespeople)
                                @php
                                    if (!isset($nomineespeople->gender)) {
                                        $nomineespeoplegender = ' - ';
                                    } else {
                                        if ($nomineespeople->gender == 'MALE') {
                                            $nomineespeoplegender = 'পুরুষ';
                                        } else {
                                            $nomineespeoplegender = 'মেয়ে';
                                        }
                                    }
                                    
                                @endphp

                                <tr>
                                    <td>{{ en2bn($k) }}.</td>
                                    <td>{{ $nomineespeople->name ?? '-' }}</td>
                                    <td>{{ $nomineespeoplegender }}</td>
                                    <td>{{ $nomineespeople->father ?? '-' }}</td>
                                    <td>{{ $nomineespeople->mother ?? '-' }}</td>
                                    <td>{{ $nomineespeople->nid ?? '-' }}</td>
                                    <td>{{ $nomineespeople->phn ?? '-' }}</td>
                                    <td>{{ $nomineespeople->email ?? '-' }}</td>
                                    <td>{{ $nomineespeople->presentAddress ?? '-' }}</td>
                                </tr>
                                @php $k++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>

            </div>
            <br>
            @if (empty($files))
                <div class="pt-5">
                    <p class="text-center font-weight-normal font-size-lg">কোনো সংযুক্তি খুঁজে পাওয়া যায়নি</p>
                </div>
            @else
                <table class="table table-striped border">
                    <thead>
                        <th class="h3" scope="col" colspan="2">সংযুক্তি</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @foreach ($files as $key => $row)
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn bg-success-o-75"
                                                type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                        </div>

                                        <input readonly type="text" class="form-control"
                                            value="{{ $row->file_category ?? '' }}" />
                                        <div class="input-group-append">
                                            <a href="{{ asset($row->file_path . $row->file_name) }}" target="_blank"
                                                class="btn btn-sm btn-success font-size-h5 float-left">
                                                <i class="fa fas fa-file-pdf"></i>
                                                <b>দেখুন</b>

                                            </a>

                                        </div>

                                    </div>
        </div>
        <br>
        @endforeach
        </td>
        </tr>
        </tbody>
        </table>
        @endif


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
