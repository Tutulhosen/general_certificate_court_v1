<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    {{-- <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet" type="text/css" /> --}}
    <style>
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            text-align: center
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            color: #dee2e6
        }

       
 
        .thead-customStyle2 {
            background-color: #008841;
            color: #fff;
        }

        .thead-customStyle>tr>th,
        .thead-customStyle2>tr>th {
            position: relative;
        }

        .thead-customStyle>tr>th:before,
        .thead-customStyle2>tr>th:before {
            position: absolute;
            right: 0;
            width: 3px;
            height: 100%;
            background: #fff;
            content: "";
            top: 0;
        }
    </style>

</head>

<body>
    <h3 class="text-center" style="width: 100%">{{$page_title}}</h3>
    <table class="table table-hover mb-6 font-size-h5" style="width: 100%">
        <thead class="font-size-h6">
            <tr  style="text-align: justify" class="text-center thead-customStyle2  ">
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
                <th scope="col" width="100">পরবর্তী পদক্ষেপ</th>
            </tr>
        </thead>
        <tbody>

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
                    {{-- @dd($row->next_date) --}}
                    <td>{{ $row->next_date ?  en2bn($row->next_date): '----' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
