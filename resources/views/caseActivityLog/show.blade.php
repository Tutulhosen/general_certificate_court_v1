@php
$user = Auth::user();
$roleID = Auth::user()->role_id;
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
    <div id="DivIdToPrint" class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    {{-- <a onclick='printDiv();' class="align-right btn btn-primary float-right" href="">Print</a> --}}
                    <a class="align-right btn btn-primary float-right" href="{{ route('case_audit.caseActivityPDFlog', $info->id) }}">Print</a>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <h5><span class="font-weight-bolder">মামলা নং: </span>{{ en2bn($info->case_number) }}</h5>
                    <h5><span class="font-weight-bolder">আদালতের নাম: </span> {{ $info->court_name }}</h5>
                    <h5><span class="font-weight-bolder">জেলা: </span> {{ $info->district_name_bn }}</h5>
                    <h5><span class="font-weight-bolder">উপজেলা: </span> {{ $info->upazila_name_bn }}</h5>
                    {{-- <h5><span class="font-weight-bolder">Union:</span> সাধারণ তথ্য</h5> --}}
                    <h5><span class="font-weight-bolder">মৌজা: </span> {{ $info->mouja_name_bn }}</h5>
                </div>
                <div class="col-md-4">
                    <h5>
                        <span class="font-weight-bolder">মামলার ফলাফল:</span>
                        @if ($info->case_result == '1')
                            জয়!
                        @elseif($info->case_result == '0')
                            পরাজয়!
                        @else
                            চলমান
                        @endif
                    </h5>

                    @php
                        // print_r( $info->caseSF->id );
                    @endphp
                    <h5><span class="font-weight-bolder">জিপি/সলিসিটর:</span>
                        {{ App\Models\CaseRegister::findOrFail($info->id)->caseSF->user->name ?? 'এস এফ এখনো তৈরী করা হয়নি ' }}
                    </h5>
                    <h5>
                        <span class="font-weight-bolder">বাদী:</span>
                        @if (count($badis) == 1)
                            @foreach ($badis as $badi)
                                {{ $badi->badi_name }}
                            @endforeach
                        @else
                            @foreach ($badis as $key => $badi)
                                <p class="ml-4">{{ $badi->badi_name == null ? '' : en2bn($key+1) . '. ' . $badi->badi_name  }}</p>
                            @endforeach
                        @endif
                    </h5>
                    <h5>
                        <span class="font-weight-bolder">ঠিকানা:</span>
                        @if (count($badis) == 1)
                            @foreach ($badis as $badi)
                                {{ $badi->badi_address }}
                            @endforeach
                        @else
                            @foreach ($badis as $key => $badi)
                                <p class="ml-4">{{ $badi->badi_address  == null ? '' : en2bn($key+1) . '. ' . $badi->badi_address }}</p>
                            @endforeach
                        @endif
                    </h5>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-8 my-5">
                    <table class="tg">
                        <thead class="thead-customStyle2">
                            <tr>
                                <th class="font-weight-bolder">তারিখ ও সময়</th>
                                <th class="font-weight-bolder">ব্যবহারকারীর নাম</th>
                                <th class="font-weight-bolder">ব্যবহারকারীর পদবি</th>
                                <th class="font-weight-bolder">অ্যাক্টিভিটি</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($caseActivityLogs as $caseActivityLog)
                            @php
                            $data = json_decode($caseActivityLog->new_data, true);

                            @endphp
                            <tr>
                                <td>{{ en2bn($caseActivityLog->created_at)}}</td>
                                <td>{{ $caseActivityLog->user->name ?? '-'}}</td>
                                <td>{{ $caseActivityLog->role->role_name ?? '-'}}</td>
                                <td>
                                    @if ( $caseActivityLog->message == 'নতুন মামলা রেজিস্ট্রেশন করা হয়েছে')
                                        <h5>
                                            {{ $caseActivityLog->message ?? '-'}}
                                            <a href="{{ route('case_audit.reg_case_details', $caseActivityLog->id) }}" target="_blank" class="btn btn-primary btn-sm float-right">{{ 'বিস্তারিত দেখুন' }}</a>
                                        </h5>
                                        @elseif ( $caseActivityLog->message == 'রেজিস্ট্রার মামলা আপডেট করা হয়েছে')
                                        <h5>
                                            {{ $caseActivityLog->message ?? '-'}}
                                            <a href="{{ route('case_audit.reg_case_details', $caseActivityLog->id) }}" target="_blank" class="btn btn-primary btn-sm float-right">{{ 'বিস্তারিত দেখুন' }}</a>
                                        </h5>

                                    @elseif ( $caseActivityLog->message == 'এস এফ ফাইল তৈরী করা হয়েছে')
                                        <h5>
                                            {{ $caseActivityLog->message ?? '-'}}
                                            <a href="{{ route('case_audit.sf.details', $caseActivityLog->id) }}" target="_blank" class="btn btn-primary btn-sm float-right">{{ 'বিস্তারিত দেখুন' }}</a>
                                        </h5>
                                        {{-- <h5>বিস্তারিত এস এফ:</h5> --}}
                                        {{-- <h5>"{{ $data[0]['sf_data'][0]['sf_details']}}"</h5> --}}
                                        {{-- <a href="{{ route('case_audit.sf.details', $caseActivityLog->id) }}" class="btn btn-primary btn-sm float-right">{{ 'বিস্তারিত দেখুন' }}</a> --}}
                                    @elseif ( $caseActivityLog->message == 'এস এফ ফাইল আপডেট করা হয়েছে')
                                        <h5>
                                            {{ $caseActivityLog->message ?? '-'}}
                                            <a href="{{ route('case_audit.sf.details', $caseActivityLog->id) }}" target="_blank" class="btn btn-primary btn-sm float-right">{{ 'বিস্তারিত দেখুন' }}</a>
                                        </h5>

                                        {{-- <h5>{{ $caseActivityLog->message ?? '-'}}</h5>
                                        <h5>বিস্তারিত এস এফ:</h5>
                                        <h5>"{{ $data[0]['sf_data'][0]['sf_details']}}"</h5> --}}
                                    @elseif ( $caseActivityLog->message == 'মামলাটি প্রেরণ করা হয়েছে')
                                        <h5>
                                            {{ DB::table('case_status')->select('status_name')->where('id', '=', $data[1]['log_datas']['log_data']['status_id'])->first()->status_name }}
                                        </h5>
                                            {{-- {{ $data[1]['log_datas']['log_data']['status_id'] }} --}}
                                        <h5>মন্তব্য: "{{ $data[1]['log_datas']['log_data']['comment']}}"</h5>
                                    @elseif ( $caseActivityLog->message == 'মামলার এস এফ রিপোর্ট আপলোড করা হয়েছে')
                                        <h5>{{ $caseActivityLog->message ?? '-'}}</h5>
                                        <h5>ফাইলের নাম : "{{ $data[0]['case_register'][0]['sf_report']}}"</h5>

                                        <a href="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left"> <i class="fa fas fa-file-pdf"></i><b>এফএফ প্রতিবেদন</b>
                                            {{-- <embed src="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" type="application/pdf" width="100%" height="600px" />  --}}
                                         </a>
                                    @elseif ( $caseActivityLog->message == 'মামলার হিয়ারিং ফাইল আপলোড করা হয়েছে')
                                        <h5>{{ $caseActivityLog->message ?? '-'}}</h5>
                                        <h5>শুনানির তারিখ: {{ en2bn($data[0]['case_hearing'][0]['hearing_date']) }}</h5>
                                        <h5>মন্তব্য: "{{ $data[0]['case_hearing'][0]['hearing_comment']}}"</h5>
                                        <h5>ফাইলের নাম : {{ $data[0]['case_hearing'][0]['hearing_file']}}</h5>

                                        <a href="{{ asset('uploads/order/'.$data[0]['case_hearing'][0]['hearing_file']) }}" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left"> <i class="fa fas fa-file-pdf"></i><b>মামলার হিয়ারিং ফাইল</b>
                                            {{-- <embed src="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" type="application/pdf" width="100%" height="600px" />  --}}
                                         </a>
                                    @elseif ( $caseActivityLog->message == 'মামলার ফলাফল আপডেট করা হয়েছে')
                                        <h5>{{ $caseActivityLog->message ?? '-'}}</h5>
                                        @if ($data[0]['case_register'][0]['is_win'] == 2)
                                            <h5>মামলার ফলাফলঃ পরাজয় </h5>
                                            <h5>পরাজয়ের কারণঃ " {{ $data[0]['case_register'][0]['lost_reason'] ?? '-' }} "</h5>
                                        @else
                                            <h5>মামলার ফলাফলঃ জয়ী </h5>
                                        @endif
                                        <h5>বর্তমান ষ্ট্যাটাস:
                                            @if ($data[0]['case_register'][0]['status'] == 1)
                                                নতুন চলমান!
                                            @elseif ($data[0]['case_register'][0]['status'] == 2)
                                                আপিল করা হয়েছে!
                                            @elseif ($data[0]['case_register'][0]['status'] == 3)
                                                সম্পাদিত !
                                            @endif
                                        </h5>
                                        <h5>
                                            মামলায় হেরে গিয়ে কি আপিল করা হয়েছে:
                                            @if ($data[0]['case_register'][0]['is_lost_appeal'] == 1)
                                                হ্যা!
                                            @else
                                                না!
                                            @endif
                                        </h5>
                                        <h5>
                                            মামলার রায় সরকারের পক্ষে গিয়েছে কিনা?:
                                            @if ($data[0]['case_register'][0]['in_favour_govt'] == 1)
                                                হ্যা!
                                            @else
                                                না!
                                            @endif
                                        </h5>
                                    @else
                                    <h5>Action:{{ $caseActivityLog->message ?? '-'}}</h5>
                                        <pre>
                                            @php
                                                $data = json_decode($caseActivityLog->new_data, true);
                                                print_r($data);
                                            @endphp
                                        </pre>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="4">কোন নিরীক্ষা পাওয়া যায়নি</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
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

    <script>
        function printDiv()
{

  var divToPrint=document.getElementById('DivIdToPrint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
    </script>


@endsection
