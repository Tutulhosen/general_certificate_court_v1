@extends('layouts.default')
@section('content')

    <style>
        .blink {
            animation: blinker 1.5s linear infinite;
            color: red;
            font-family: sans-serif;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
    <!--begin::Card-->


<div class="card card-custom">
    <div class="card-header flex-wrap py-5">
        <div class="card-title" style="display: flex; justify-content: space-between; width: 100%">
            <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            <form action="{{ route('appeal.generateAppeal.pdf') }}" method="post">
                @csrf
                <div>
                    <button type="submit" class="btn btn-danger btn-link">Export</button>
                    <input type="hidden" name="page_title" value="{{ $page_title }}">
                </div>
            </form>
        </div>
        @if (Request::is('appeal/trial_date_list'))
            @if (Auth::user()->role_id == 27 ||
                    Auth::user()->role_id == 6 ||
                    Auth::user()->role_id == 34 ||
                    Auth::user()->role_id == 25)
                <div class="card-toolbar">
                    <a href="{{ route('appeal.hearingTimeUpdate') }}" class="btn btn-sm btn-primary font-weight-bolder">
                        <i class="la la-edit"></i>শুনানির সময় পরিবর্তন
                    </a>
                </div>
            @endif
        @endif

        @if (Auth::user()->role_id == 5)
            <div class="card-toolbar">
                <a href="{{ url('case/add') }}" class="btn btn-sm btn-primary font-weight-bolder">
                    <i class="la la-plus"></i>নতুন মামলা এন্ট্রি
                </a>
            </div>
        @endif
    </div>
    <div class="card-body overflow-auto " id="element-to-print-list">
        <div id="card-title-print" class="py-5" style="display: none">
            <h3 class="card-title-print h2 font-weight-bolder">{{ $page_title }}</h3>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        @include('appeal.search')
        @php
            $today = date('Y-m-d', strtotime(now()));
            $today_time = date('H:i:s', strtotime(now()));
        @endphp
        <table class="table table-hover mb-6 font-size-h5">
            <thead class="thead-customStyle2 font-size-h6">
                <tr style="text-align: justify " class="text-center">
                    <th scope="col" width="10">ক্রমিক নং</th>
                    <th scope="col" width="100" style="">সার্টিফিকেট অবস্থা</th>
                    <th scope="col" width="100">মামলা নম্বর</th>
                    @if (globalUserInfo()->role_id == 34)
                        <th scope="col" width="100">জেলা</th>
                    @elseif(globalUserInfo()->role_id == 6)
                        <th scope="col" width="100">উপজেলা</th>
                    @endif
                    <th scope="col" width="100">আবেদনকারীর নাম</th>
                    <th scope="col" width="100">জেনারেল সার্টিফিকেট আদালত</th>
                    <th scope="col" width="100">
                        @if ($caseStatus == 'PENDING')
                            আবেদনের তারিখ
                        @else
                            পরবর্তী তারিখ
                        @endif
                    </th>
                    <th scope="col" width="100" class="disicion">পদক্ষেপ</th>
                </tr>
            </thead>
            <tbody>
                {{-- @dd($results    ) --}}
                @foreach ($results as $key => $row)
                    <tr class="text-center">
                        <td scope="row" class="tg-bn">{{ en2bn($key + $results->firstItem()) }}.</td>
                        <td> {{ appeal_status_bng($row->appeal_status) }}</td> {{-- Helper Function for Bangla Status --}}
                        <td>
                            @if (isset($row->case_entry_type))
                                {{-- @dd($row->case_entry_type) --}}
                                @if ($row->case_entry_type == 'RUNNING')
                                    {{ en2bn($row->case_no) }}/ <br>
                                    {{ $row->manual_case_no }} <br>
                                    (পুরাতন চলমান মামলা)
                                @else
                                    {{ en2bn($row->case_no) }}
                                @endif

                                {{-- {{ en2bn($row->case_no) }} --}}
                            @else
                                {{ en2bn($row->case_no) }}
                            @endif
                        </td>
                        @if (globalUserInfo()->role_id == 34)
                            <td>{{ isset($row->district->district_name_bn) ? $row->district->district_name_bn : ' ' }}
                            </td>
                        @elseif(globalUserInfo()->role_id == 6)
                            <td>{{ isset($row->upazila->upazila_name_bn) ? $row->upazila->upazila_name_bn : ' ' }}</td>
                        @endif
                        @if ($row->is_applied_for_review == 0)
                            <td>
                                {{-- @dd($row->id); --}}
                                @php
                                    $applicant_name = DB::table('gcc_appeal_citizens')
                                        ->join('gcc_citizens', 'gcc_appeal_citizens.citizen_id', 'gcc_citizens.id')
                                        ->where('gcc_appeal_citizens.appeal_id', $row->id)
                                        ->where('gcc_appeal_citizens.citizen_type_id', 1)
                                        ->select('gcc_citizens.citizen_name')
                                        ->first();
                                @endphp
                                {{ $applicant_name->citizen_name ?? '' }}
                            </td>
                        @else
                            <td>{{ $row->reviewerName->name }}</td>
                        @endif
                        <td>@php
                            if (isset($row->court_id)) {
                                echo DB::table('court')
                                    ->where('id', $row->court_id)
                                    ->first()->court_name;
                            }
                        @endphp</td>
                        <td>
                            @if ($caseStatus == 'PENDING')
                                {{ $row->case_date ? en2bn($row->case_date) : '-' }}
                            @else
                                {{ $row->next_date == '1970-01-01' ? '-' : en2bn($row->next_date) }}
                        </td>
                @endif

                <td class="disicion">
                    <div class="btn-group float-right">
                        <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item"
                                href="{{ route('appeal.appealView', encrypt($row->id)) }}">বিস্তারিত তথ্য</a>
                            @if (globalUserInfo()->role_id != 35)
                                @if ($row->appeal_status != 'SEND_TO_ASST_GCO' && $row->appeal_status != 'SEND_TO_GCO')
                                    <a class="dropdown-item"
                                        href="{{ route('appeal.nothiView', encrypt($row->id)) }}">নথি দেখুন</a>
                                @endif
                                @if (
                                    $row->next_date == $today &&
                                        $row->next_date_trial_time <= $today_time &&
                                        $row->appeal_status != 'CLOSED' &&
                                        $row->is_hearing_required == 1)
                                    <a class="dropdown-item blink"
                                        href="{{ route('jitsi.meet', ['appeal_id' => encrypt($row->id)]) }}"
                                        style="color: red;" target="_blank">অনলাইন শুনানি</a>
                                @endif

                                @if (globalUserInfo()->role_id == 28)
                                    @if ($row->action_required == 'GCO' && $row->appeal_status != 'CLOSED')
                                        <a class="dropdown-item" href="#">জিসিও এর আদেশের অপেক্ষায়</a>
                                    @else
                                        @if ($row->appeal_status == 'SEND_TO_ASST_GCO')
                                            <a class="dropdown-item"
                                                href="{{ route('appeal.edit', encrypt($row->id)) }}">সংশোধন ও
                                                প্রেরণ</a>
                                        @elseif($row->action_required == 'ASST' && $row->appeal_status != 'CLOSED')
                                            <a class="dropdown-item"
                                                href="{{ route('appeal.edit', encrypt($row->id)) }}">সংশোধন ও
                                                প্রেরণ</a>
                                        @endif
                                    @endif
                                @endif
                                @if ($row->action_required == 'ASST' && $row->appeal_status != 'CLOSED' && globalUserInfo()->role_id != 28)
                                    <a class="dropdown-item" href="#">সহকারীর অপেক্ষায়</a>
                                @else
                                    @if (globalUserInfo()->role_id == 6 ||
                                            globalUserInfo()->role_id == 25 ||
                                            globalUserInfo()->role_id == 27 ||
                                            globalUserInfo()->role_id == 34)
                                        @if ($row->appeal_status == 'SEND_TO_GCO')
                                            {{-- <a class="dropdown-item" href="{{ route('appeal.status_change', encrypt($row->id)) }}?status=REJECTED">মামলা বর্জন  করুন</a> --}}
                                            <a class="dropdown-item"
                                                href="{{ route('appeal.trial', encrypt($row->id)) }}">মামলা
                                                গ্রহণ
                                                করুন</a>
                                        @elseif (
                                            $row->appeal_status == 'SEND_TO_DC' ||
                                                $row->appeal_status == 'SEND_TO_DIV_COM' ||
                                                $row->appeal_status == 'SEND_TO_LAB_CM')
                                            @if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 34)
                                                <a class="dropdown-item"
                                                    href="{{ route('appeal.trial', encrypt($row->id)) }}">মামলা
                                                    গ্রহণ করুন</a>
                                            @endif
                                        @elseif (
                                            $row->appeal_status == 'ON_TRIAL' ||
                                                $row->appeal_status == 'ON_TRIAL_DC' ||
                                                $row->appeal_status == 'ON_TRIAL_DIV_COM' ||
                                                $row->appeal_status == 'ON_TRIAL_LAB_CM')
                                            <a class="dropdown-item"
                                                href="{{ route('appeal.trial', encrypt($row->id)) }}">কার্যক্রম
                                                পরিচালনা করুন</a>
                                        @endif
                                        @if (Request::url() === route('appeal.collectPaymentList'))
                                            <a class="dropdown-item"
                                                href="{{ route('appeal.collectPayment', encrypt($row->id)) }}">অর্থ
                                                আদায়</a>
                                        @endif
                                    @endif
                                @endif
                            @else
                                @if ($row->appeal_status == 'DRAFT')
                                    <a class="dropdown-item"
                                        href="{{ route('appeal.edit', encrypt($row->id)) }}">সংশোধন করুন</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {!! $results->links() !!}
        </div>
    </div>
    <!--end::Card-->

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function generateAppealPDF() {
            var element = document.getElementById('element-to-print-list');
            const elementtoprintlist = document.getElementById('card-title-print');
            console.log(document.getElementsByClassName("disicion"))
            document.querySelectorAll(".disicion").forEach(element => {
                element.style.display = 'none';
            });

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
                    scale: 10
                },
            };

            html2pdf().set(opt).from(element).save().then(() => {
                // Hide the card-title-print element after PDF generation is complete
                document.getElementById('card-title-print').style.display = 'none';

                // Show elements with class "disicion" again after PDF generation is complete
                document.querySelectorAll(".disicion").forEach(element => {
                    element.style.display = 'block';
                });
                location.reload();
            });
        }
    </script>
@endsection
