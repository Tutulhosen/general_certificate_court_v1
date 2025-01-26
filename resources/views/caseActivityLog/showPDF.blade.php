<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$page_title?></title>
	<style type="text/css">
		.priview-body{font-size: 16px;color:#000;margin: 25px;}
		.priview-header{margin-bottom: 10px;text-align:center;}
		.priview-header div{font-size: 18px;}
		.priview-memorandum, .priview-from, .priview-to, .priview-subject, .priview-message, .priview-office, .priview-demand, .priview-signature{padding-bottom: 20px;}
		.priview-office{text-align: center;}
		.priview-imitation ul{list-style: none;}
		.priview-imitation ul li{display: block;}
		.date-name{width: 20%;float: left;padding-top: 23px;text-align: right;}
		.date-value{width: 70%;float:left;}
		.date-value ul{list-style: none;}
		.date-value ul li{text-align: center;}
		.date-value ul li.underline{border-bottom: 1px solid black;}
		.subject-content{text-decoration: underline;}
		.headding{border-top:1px solid #000;border-bottom:1px solid #000;}

		.col-1{width:8.33%;float:left;}
		.col-2{width:16.66%;float:left;}
		.col-3{width:25%;float:left;}
		.col-4{width:33.33%;float:left;}
		.col-5{width:41.66%;float:left;}
		.col-6{width:50%;float:left;}
		.col-7{width:58.33%;float:left;}
		.col-8{width:66.66%;float:left;}
		.col-9{width:75%;float:left;}
		.col-10{width:83.33%;float:left;}
		.col-11{width:91.66%;float:left;}
		.col-12{width:100%;float:left;}

		.table{width:100%;border-collapse: collapse;}
		.table td, .table th{border:1px solid #ddd;}
		.table tr.bottom-separate td,
		.table tr.bottom-separate td .table td{border-bottom:1px solid #ddd;}
		.borner-none td{border:0px solid #ddd;}
		.headding td, .total td{border-top:1px solid #ddd;border-bottom:1px solid #ddd;}
		.table td{padding:5px;}
		.text-center{text-align:center;}
		.text-right{text-align:right;}
		b{font-weight:500;}
	</style>
</head>
<body>
	<div class="priview-body">
		<div class="priview-header">
			<div class="row">
				<div class="col-3 text-left float-left">
					 <?=en2bn(date('d-m-Y'))?>
				</div>
				<div class="col-6 text-center float-left">
					<p class="text-center" style="margin-top: 0;"><span style="font-size:20px;font-weight: bold;">সিভিল স্যুট ম্যানেজমেন্ট সিষ্টেম</span><br> ভূমি মন্ত্রণালয়, বাংলাদেশ সচিবালয়, ঢাকা</p>
					<!-- <div style="font-size:18px;"><u><?=$page_title?></u></div> -->
					<?php //!empty($data_status)?'ব্যাক্তিগত ডাটার স্ট্যাটাসঃ '.func_datasheet_status($data_status).'<br>':''?>
					<?php // !empty($division_info->div_name_bn)?'বিভাগঃ '.$division_info->div_name_bn.'<br>':''?>
				</div>
				<div class="col-2 text-right float-right">
					স্লোগান
				</div>
			</div>
		</div>
			<div class="priview-memorandum">
				<div class="row">
					<div class="col-12 text-center">
						<div style="font-size:18px;"><u><?=$page_title?></u></div>
						{{-- <div style="font-size:18px;"><u><?//=en2bn($year)?></u></div> --}}
						<?php //!empty($data_status)?'ব্যাক্তিগত ডাটার স্ট্যাটাসঃ '.func_datasheet_status($data_status).'<br>':''?>
						<?php // !empty($division_info->div_name_bn)?'বিভাগঃ '.$division_info->div_name_bn.'<br>':''?>

					</div>
				</div>
			</div>
            <div class="col-2"></div>
            <div class="col-6">
                <h5><span class="font-weight-bolder">মামলা নং: </span>{{ en2bn($info->case_number) }}</h5>
                <h5><span class="font-weight-bolder">আদালতের নাম: </span> {{ $info->court_name }}</h5>
                <h5><span class="font-weight-bolder">জেলা: </span> {{ $info->district_name_bn }}</h5>
                <h5><span class="font-weight-bolder">উপজেলা: </span> {{ $info->upazila_name_bn }}</h5>
                <h5><span class="font-weight-bolder">মৌজা: </span> {{ $info->mouja_name_bn }}</h5>
            </div>
            <div class="col-6">
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
                            <p style="margin-left:15px;" class="ml-8">{{ $badi->badi_address  == null ? '' : 'ঠিকানা: ' . $badi->badi_address }}</p>

                        @endforeach
                    @endif
                </h5>
            </div>
            <div class="col-2"></div>
			<div class="priview-demand">
				<table class="table table-hover table-bordered report">
					<thead class="headding">
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
                                @elseif ( $caseActivityLog->message == 'এস এফ ফাইল আপডেট করা হয়েছে')
                                    <h5>
                                        {{ $caseActivityLog->message ?? '-'}}
                                        <a href="{{ route('case_audit.sf.details', $caseActivityLog->id) }}" target="_blank" class="btn btn-primary btn-sm float-right">{{ 'বিস্তারিত দেখুন' }}</a>
                                    </h5>
                                @elseif ( $caseActivityLog->message == 'মামলাটি প্রেরণ করা হয়েছে')
                                    <h5>
                                        {{ DB::table('case_status')->select('status_name')->where('id', '=', $data[1]['log_datas']['log_data']['status_id'])->first()->status_name }}
                                    </h5>
                                    <h5>মন্তব্য: "{{ $data[1]['log_datas']['log_data']['comment']}}"</h5>
                                @elseif ( $caseActivityLog->message == 'মামলার এস এফ রিপোর্ট আপলোড করা হয়েছে')
                                    <h5>{{ $caseActivityLog->message ?? '-'}}</h5>
                                    <h5>ফাইলের নাম : "{{ $data[0]['case_register'][0]['sf_report']}}"</h5>
                                    <a href="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left"> <i class="fa fas fa-file-pdf"></i><b>এফএফ প্রতিবেদন</b>
                                     </a>
                                @elseif ( $caseActivityLog->message == 'মামলার হিয়ারিং ফাইল আপলোড করা হয়েছে')
                                    <h5>{{ $caseActivityLog->message ?? '-'}}</h5>
                                    <h5>শুনানির তারিখ: {{ en2bn($data[0]['case_hearing'][0]['hearing_date']) }}</h5>
                                    <h5>মন্তব্য: "{{ $data[0]['case_hearing'][0]['hearing_comment']}}"</h5>
                                    <h5>ফাইলের নাম : {{ $data[0]['case_hearing'][0]['hearing_file']}}</h5>
                                    <a href="{{ asset('uploads/order/'.$data[0]['case_hearing'][0]['hearing_file']) }}" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left"> <i class="fa fas fa-file-pdf"></i><b>মামলার হিয়ারিং ফাইল</b>
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
	</body>
	</html>

