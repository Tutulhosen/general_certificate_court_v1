@extends('layouts.default')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>

        </div>
        <div class="card-body overflow-auto">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif

            <form action="{{ url('register/printPdf') }}" class="form" method="GET" enctype="multipart/form-data"
                id="myForm">
                @include('register.search')
                <div class="col-md-12">
                    <fieldset class="mb-8">
                        <legend>রেজিস্টার এর তথ্য নির্বাচন করুন</legend>
                        @csrf
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9  font-weight-bolder" id="checkVal">
                                <input checked type="checkbox" onchange="myFunction('serialNo','kromikNo')" id="kromikNo"
                                    name="kromikNo" value="kromikNo">
                                <label for="kromikNo"> ক্রমিক নম্বর</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('appealStat','appealStatus')"
                                    id="appealStatus" name="appealStatus" value="appealStatus"
                                    style="margin-left:43px !important">
                                <label for="appealStatus"> আপিল অবস্থা</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('caseNum','caseNo')" id="caseNo"
                                    name="caseNo" value="caseNo" style="margin-left: 43px !important">
                                <label for="caseNo"> মামলা নম্বর</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('caseResult','caseDecision')"
                                    id="caseDecision" name="caseDecision" value="caseDecision"
                                    style="margin-left: 24px !important">
                                <label for="caseDecision"> মামলার সিদ্ধান্ত</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('courtName','relatedCourt')"
                                    id="relatedCourt" name="relatedCourt" value="relatedCourt">
                                <label for="relatedCourt"> সংশ্লিষ্ট আদালত</label>&nbsp;&nbsp;<br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9  font-weight-bolder" id="checkVal">
                                <input checked type="checkbox" onchange="myFunction('nxtSunaniTime','nextHearingTime')"
                                    id="nextHearingTime" name="nextHearingTime" value="nextHearingTime">
                                <label for="nextHearingTime"> পরবর্তী শুনানীর সময়</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('nxtSunaniDate','nextHearingDate')"
                                    id="nextHearingDate" name="nextHearingDate" value="nextHearingDate">
                                <label for="nextHearingDate"> পরবর্তী শুনানীর তারিখ</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('applicantName','appellantName')"
                                    id="appellantName" name="appellantName" value="appellantName">
                                <label for="appellantName">আপীলকারীর নাম</label>&nbsp;&nbsp;
                                <input checked type="checkbox" onchange="myFunction('lawName','ruleName')" id="ruleName"
                                    name="ruleName" value="ruleName">
                                <label for="ruleName"> সংশ্লিষ্ট ধারা</label>&nbsp;&nbsp;<br>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Print</button>
                    </fieldset>
                </div>
            </form>
            <table class="table table-hover mb-6 font-size-h5">
                <thead class="thead-customStyle2 font-size-h6">
                    <tr>
                        <th class="serialNo" scope="col" width="30"> ক্রমিক নম্বর</th>
                        <th class="appealStat" scope="col">আপিল অবস্থা</th>
                        <th class="caseNum" scope="col">মামলা নম্বর</th>
                        <th class="caseResult" scope="col">মামলার সিদ্ধান্ত</th>
                        <th class="courtName" scope="col">সংশ্লিষ্ট আদালত</th>
                        <th class="nxtSunaniDate" scope="col">পরবর্তী শুনানীর তারিখ</th>
                        <th class="nxtSunaniTime" scope="col">পরবর্তী শুনানীর সময়</th>
                        <th class="applicantName" scope="col">আপীলকারীর নাম</th>
                        <th class="lawName" scope="col"> সংশ্লিষ্ট ধারা</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $key => $row)
                        <tr>

                            <td scope="row" class="tg-bn serialNo">{{ en2bn($key + $results->firstItem()) }}.</td>
                            <td class="appealStat"> {{ appeal_status_bng($row->appeal_status) }}</td> {{-- Helper Function for Bangla Status --}}
                            <td class="caseNum">{{ $row->case_no }}</td>
                            <td class="caseResult"> {{ case_dicision_status_bng($row->appeal_status) }}</td>
                            {{-- Helper Function for Bangla Status --}}
                            <td class="courtName">
                                {{ isset($row->court->court_name) ? $row->court->court_name : '-' }}
                            </td>
                            <td class="nxtSunaniDate">
                                {{--  @dd($row->appealCauseList);   --}}
                                @php
                                    $hearingDate = null;
                                @endphp
                                @foreach ($row->appealCauseList as $key => $item)
                                    @php
                                        if ($item->trial_date == '1970-01-01') {
                                            $hearingDate = '---';
                                        } else {
                                            $hearingDate = $item->trial_date;
                                        }
                                        if (date('a', strtotime($item->trial_time)) == 'am') {
                                            $time = 'সকাল';
                                        } else {
                                            $time = 'বিকাল';
                                        }
                                    @endphp
                                @endforeach
                                {{ en2bn($hearingDate) ?? '' }}
                            </td>
                            <td class="nxtSunaniTime">@php
                                $hearingTime = null;
                            @endphp
                                @foreach ($row->appealCauseList as $key => $item)
                                    @php
                                    if(isset($item->trial_time) && $item->trial_date != '1970-01-01')
                                    {
                                      $hearingTime = $time.' '.en2bn(date('h:i', strtotime($item->trial_time)));
                                    }
                                    else 
                                    {
                                      $hearingTime  = '----';
                                    }
                                        
                                    @endphp
                                @endforeach
                                {{ $hearingTime }}
                            </td>
                            <td class="applicantName">
                                {{-- @dd($row->appealCitizensJoin); --}}
                                @php
                                    $appName = null;
                                @endphp
                                @foreach ($row->appealCitizens as $key => $item)
                                    @foreach ($item->citizenType as $i => $it)
                                        @if ($it->citizen_type == 'applicant')
                                            @foreach ($item->citizensAppealJoin as $activeCheck)
                                                @if ($activeCheck->active == 1 && $appName == null && $row->id == $activeCheck->appeal_id)
                                                    @php
                                                        $appName = $item->citizen_name;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endforeach
                                {{ $appName ?? '' }}
                            </td>
                            <td class="lawName">{{ $row->law_section }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $results->links() !!}
            </div>
        </div>
    </div>
    <script>
        function myFunction(className, id) {
            console.log(id);
            var checkBox = document.getElementById(id);
            if (checkBox.checked == true) {
                console.log('true');
                $('.' + className).show(20);
            } else {
                console.log('false');
                $('.' + className).hide(20);
            }
        }

        function formSubmit() {
            console.log('asda');
            $("#myForm").attr('action', '/register/list');
            $("#myForm").submit();
        }
    </script>
    <!--end::Card-->
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script>
        function myFunction(className) {
            if (checkBox.checked == true) {
                console.log('true');
            } else {
                console.log('false');
            }
        }

        $("#submitButton").click(function() {
            // Submit the form
        });
    </script>

    <!-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
       <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
     -->


    <!--end::Page Scripts-->
@endsection
