<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;
use DatePeriod;

class ReportController extends Controller
{
    public function index()
    {
        // Dropdown List
        // dd(user_office_info()); 
        $data['courts'] = DB::table('court')->select('id', 'court_name')->get();
        $data['roles'] = DB::table('role')->select('id', 'role_name')->where('in_action', 1)->get();
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['getMonth'] = date('M', mktime(0, 0, 0));

        $data['page_title'] = 'রিপোর্ট'; //exit;
        // return view('case.case_add', compact('page_title', 'case_type'));
        if (globalUserInfo()->role_id == 34) {
            $data['user_division_name'] = user_office_info()->division_name_bn;
            $data['user_division_id'] = user_office_info()->division_id;
        }

        if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7) {
            $data['user_district_name'] = user_office_info()->dis_name_bn;
            $data['user_district_id'] = user_office_info()->district_id;
        }
        // dd($data);
        return view('report.index')->with($data);
    }

    public function caselist()
    {
        // Dropdown List
        $data['courts'] = DB::table('court')->select('id', 'court_name')->get();
        $data['roles'] = DB::table('role')->select('id', 'role_name')->where('in_action', 1)->get();
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['getMonth'] = date('M', mktime(0, 0, 0));

        $data['page_title'] = 'মামলার রিপোর্ট ফরম'; //exit;
        // return view('case.case_add', compact('page_title', 'case_type'));
        return view('report.caselist')->with($data);
    }

    public function pdf_generate(Request $request)
    {
      
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;

        if ($request->btnsubmit == 'pdf_payment_division') {
            $data['page_title'] = 'বিভাগ ভিত্তিক অর্থ আদায়ের রিপোর্ট'; //exit;

            // Get Division
            // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

            $data['year'] = $request->year;
            $data['month'] = $request->month;


            foreach ($data['divisions'] as $key => $value) {
                $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['claimed'] = $this->payment_claimed_amount_count_by_division($value->id, $data);
                $data['results'][$key]['received'] = $this->payment_received_amount_count_by_division($value->id, $data);
            }

            $html = view('report.pdf_payment_by_division')->with($data);

            $this->generatePamentPDF($html);
        }

        if ($request->btnsubmit == 'pdf_payment_district') {


            if (globalUserInfo()->role_id != 34) {
                $request->validate(
                    [
                        'division' => 'required',
                    ],
                    [
                        'division.required' => 'বিভাগ নির্বাচন করুন',
                    ]
                );
            }

            $data['page_title'] = 'জেলা ভিত্তিক অর্থ আদায়ের রিপোর্ট'; //exit;

            if (globalUserInfo()->role_id == 34) {
                $data['div_name'] = user_office_info()->division_name_bn;

                // Get Division
                // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
                $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', user_office_info()->division_id)->get();
            } else {
                $div_data = DB::table('division')->where('id', $request->division)->first();
                $data['div_name'] = $div_data->division_name_bn;

                // Get Division
                // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
                $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', $request->division)->get();
            }


            $data['year'] = $request->year;
            $data['month'] = $request->month;

            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;

            foreach ($data['districts'] as $key => $value) {
                $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['claimed'] = $this->payment_claimed_amount_count_by_district($value->id, $data);
                $data['results'][$key]['received'] = $this->payment_received_amount_count_by_district($value->id, $data);
            }

            $html = view('report.pdf_payment_by_district')->with($data);

            $this->generatePamentPDF($html);
        }

        if ($request->btnsubmit == 'pdf_payment_upazila') {

            if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 34 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8) {
                if (globalUserInfo()->role_id == 34) {
                    $request->validate(
                        [
                            'district' => 'required',
                        ],
                        [
                            'district.required' => 'জেলা নির্বাচন করুন',
                        ]
                    );
                } else {
                    $request->validate(
                        [
                            'division' => 'required',
                            'district' => 'required',
                        ],
                        [
                            'division.required' => 'বিভাগ নির্বাচন করুন',
                            'district.required' => 'জেলা নির্বাচন করুন',
                        ]
                    );
                }

                $data['page_title'] = 'উপজেলা ভিত্তিক অর্থ আদায়ের রিপোর্ট'; //exit;
                $dis_data = DB::table('district')->where('id', $request->district)->first();
                $data['dis_data'] = $dis_data->district_name_bn;

                // Get Division
                // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
                $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $request->district)->get();

                $data['year'] = $request->year;
                $data['month'] = $request->month;

                $data['date_start'] = $request->date_start;
                $data['date_end'] = $request->date_end;

                foreach ($data['upazilas'] as $key => $value) {
                    $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $data['results'][$key]['claimed'] = $this->payment_claimed_amount_count_by_upazila($value->id, $data);
                    $data['results'][$key]['received'] = $this->payment_received_amount_count_by_upazila($value->id, $data);
                }

                $html = view('report.pdf_payment_by_upazila')->with($data);

                $this->generatePamentPDF($html);
            }

            if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7) {

                $district_id = DB::table('court')->where('id', globalUserInfo()->court_id)->select('district_id')->first();
                $dis_data = DB::table('district')->where('id', $district_id->district_id)->first();
                $data['dis_data'] = $dis_data->district_name_bn;

                $data['page_title'] = 'উপজেলা ভিত্তিক অর্থ আদায়ের রিপোর্ট'; //exit;

                $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $district_id->district_id)->get();

                $data['year'] = $request->year;
                $data['month'] = $request->month;

                $data['date_start'] = $request->date_start;
                $data['date_end'] = $request->date_end;

                foreach ($data['upazilas'] as $key => $value) {
                    $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $data['results'][$key]['claimed'] = $this->payment_claimed_amount_count_by_upazila($value->id, $data);
                    $data['results'][$key]['received'] = $this->payment_received_amount_count_by_upazila($value->id, $data);
                }

                $html = view('report.pdf_payment_by_upazila')->with($data);

                $this->generatePamentPDF($html);
            }
        }


        if ($request->btnsubmit == 'pdf_num_division') {
            $data['page_title'] = 'বিভাগ ভিত্তিক রিপোর্ট'; //exit;

            // Get Division
            // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

            $data['year'] = $request->year;
            $data['month'] = $request->month;
            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;

            foreach ($data['divisions'] as $key => $value) {
                $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['ON_TRIAL_PREV_MONTH'] = $this->case_count_status_by_division('ON_TRIAL', $value->id, $data, 'ON_TRIAL_PREV_MONTH');
                $data['results'][$key]['TOTAL_LOAN_PREV_MONTH'] = $this->case_count_status_by_division('ON_TRIAL', $value->id, $data, 'TOTAL_LOAN_PREV_MONTH');
                $data['results'][$key]['ON_TRIAL_CRNT_MONTH'] = $this->case_count_status_by_division('ON_TRIAL', $value->id, $data, 'ON_TRIAL_CRNT_MONTH');
                $data['results'][$key]['TOTAL_LOAN_CRNT_MONTH'] = $this->case_count_status_by_division('ON_TRIAL', $value->id, $data, 'TOTAL_LOAN_CRNT_MONTH');
                $data['results'][$key]['TOTAL_CLOSE_CASE'] = $this->case_count_status_by_division('CLOSED', $value->id, $data, 'TOTAL_CLOSE_CASE');
                $data['results'][$key]['TOTAL_COLLECT_CRNT_MONTH'] = $this->case_count_status_by_division('ON_TRIAL', $value->id, $data, 'TOTAL_COLLECT_CRNT_MONTH');
            }

            $html = view('report.pdf_num_division')->with($data);

            $this->generatePDF($html);
        }

        if ($request->btnsubmit == 'pdf_num_district') {
            $data['page_title'] = 'জেলা ভিত্তিক রিপোর্ট'; //exit;

            if (globalUserInfo()->role_id != 34) {
                // Validation
                $request->validate(
                    ['division' => 'required'],
                    ['division.required' => 'বিভাগ নির্বাচন করুন']
                );
            }


            $data['year'] = $request->year;
            $data['month'] = $request->month;

            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;

            // dd($data['div_name']);
            if (globalUserInfo()->role_id == 34) {
                $data['div_name'] = user_office_info()->division_name_bn;
                $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', user_office_info()->division_id)->get();
            } else {
                $div_data = DB::table('division')->where('id', $request->division)->first();
                $data['div_name'] = $div_data->division_name_bn;
                $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', $request->division)->get();
            }


            foreach ($data['districts'] as $key => $value) {
                $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['ON_TRIAL_PREV_MONTH'] = $this->case_count_status_by_district('ON_TRIAL', $value->id, $data, 'ON_TRIAL_PREV_MONTH');
                $data['results'][$key]['TOTAL_LOAN_PREV_MONTH'] = $this->case_count_status_by_district('ON_TRIAL', $value->id, $data, 'TOTAL_LOAN_PREV_MONTH');
                $data['results'][$key]['ON_TRIAL_CRNT_MONTH'] = $this->case_count_status_by_district('ON_TRIAL', $value->id, $data, 'ON_TRIAL_CRNT_MONTH');
                $data['results'][$key]['TOTAL_LOAN_CRNT_MONTH'] = $this->case_count_status_by_district('ON_TRIAL', $value->id, $data, 'TOTAL_LOAN_CRNT_MONTH');
                $data['results'][$key]['TOTAL_CLOSE_CASE'] = $this->case_count_status_by_district('CLOSED', $value->id, $data, 'TOTAL_CLOSE_CASE');
                $data['results'][$key]['TOTAL_COLLECT_CRNT_MONTH'] = $this->case_count_status_by_district('ON_TRIAL', $value->id, $data, 'TOTAL_COLLECT_CRNT_MONTH');
            }

            $html = view('report.pdf_num_district')->with($data);

            $this->generatePDF($html);
        }

        if ($request->btnsubmit == 'pdf_num_upazila') {
            if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 34 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8) {
                $data['page_title'] = 'উপজেলা ভিত্তিক রিপোর্ট'; //exit;
                // dd($request->division);

                if (globalUserInfo()->role_id == 34) {
                    $request->validate(
                        [
                            'district' => 'required',
                        ],
                        [
                            'district.required' => 'জেলা নির্বাচন করুন',
                        ]
                    );
                } else {
                    $request->validate(
                        [
                            'division' => 'required',
                            'district' => 'required',
                        ],
                        [
                            'division.required' => 'বিভাগ নির্বাচন করুন',
                            'district.required' => 'জেলা নির্বাচন করুন',
                        ]
                    );
                }

                $dis_data = DB::table('district')->where('id', $request->district)->first();
                $data['dis_data'] = $dis_data->district_name_bn;

                $data['year'] = $request->year;
                $data['month'] = $request->month;
                $data['date_start'] = $request->date_start;
                $data['date_end'] = $request->date_end;



                $data['upazilas'] = DB::table('upazila')->select('id', 'district_id', 'upazila_name_bn')->where('district_id', $request->district)->get();


                foreach ($data['upazilas'] as $key => $value) {
                    $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $data['results'][$key]['ON_TRIAL_PREV_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'ON_TRIAL_PREV_MONTH');
                    $data['results'][$key]['TOTAL_LOAN_PREV_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'TOTAL_LOAN_PREV_MONTH');
                    $data['results'][$key]['ON_TRIAL_CRNT_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'ON_TRIAL_CRNT_MONTH');
                    $data['results'][$key]['TOTAL_LOAN_CRNT_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'TOTAL_LOAN_CRNT_MONTH');
                    $data['results'][$key]['TOTAL_CLOSE_CASE'] = $this->case_count_status_by_upazila('CLOSED', $value->id, $data, 'TOTAL_CLOSE_CASE');
                    $data['results'][$key]['TOTAL_COLLECT_CRNT_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'TOTAL_COLLECT_CRNT_MONTH');
                }

                $html = view('report.pdf_num_upazila')->with($data);

                $this->generatePDF($html);
            }
            if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7) {
                $data['page_title'] = 'উপজেলা ভিত্তিক রিপোর্ট'; //exit;
                $district_id = DB::table('court')->where('id', globalUserInfo()->court_id)->select('district_id')->first();
                $dis_data = DB::table('district')->where('id', $district_id->district_id)->first();
                $data['dis_data'] = $dis_data->district_name_bn;

                $data['year'] = $request->year;
                $data['month'] = $request->month;
                $data['date_start'] = $request->date_start;
                $data['date_end'] = $request->date_end;



                $data['upazilas'] = DB::table('upazila')->select('id', 'district_id', 'upazila_name_bn')->where('district_id', $district_id->district_id)->get();


                foreach ($data['upazilas'] as $key => $value) {
                    $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $data['results'][$key]['ON_TRIAL_PREV_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'ON_TRIAL_PREV_MONTH');
                    $data['results'][$key]['TOTAL_LOAN_PREV_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'TOTAL_LOAN_PREV_MONTH');
                    $data['results'][$key]['ON_TRIAL_CRNT_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'ON_TRIAL_CRNT_MONTH');
                    $data['results'][$key]['TOTAL_LOAN_CRNT_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'TOTAL_LOAN_CRNT_MONTH');
                    $data['results'][$key]['TOTAL_CLOSE_CASE'] = $this->case_count_status_by_upazila('CLOSED', $value->id, $data, 'TOTAL_CLOSE_CASE');
                    $data['results'][$key]['TOTAL_COLLECT_CRNT_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'TOTAL_COLLECT_CRNT_MONTH');
                }

                $html = view('report.pdf_num_upazila')->with($data);

                $this->generatePDF($html);
            }
        }

        if ($request->btnsubmit == 'pdf_new_report_division') {
            $data['page_title'] = 'বিভাগ ভিত্তিক রিপোর্ট'; //exit;

            // Get Division
            // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
            if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8) {
                $data['division']=$request->division;
            }
            if (globalUserInfo()->role_id == 34 ) {
                $data['division']=user_division();
            }
            
            $data['year'] = $request->year;
            $data['month'] = $request->month;
            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;
            if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8) {
                $request->validate(
                    ['division' => 'required', 'date_start' => 'required', 'date_end' => 'required'],
                    ['division.required' => ' বিভাগ নির্বাচন করুন','date_start.required' => ' শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => ' শেষের তারিখ নির্বাচন করুন']
                );
            }

            if (globalUserInfo()->role_id == 34) {
                $request->validate(
                    [ 'date_start' => 'required', 'date_end' => 'required'],
                    ['date_start.required' => ' শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => ' শেষের তারিখ নির্বাচন করুন']
                );
            }
            

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));

      
            $startDate = new \DateTime($dateFrom);
            $endDate = new \DateTime($dateTo); 
     
            $dateArray = [];

            while ($endDate >= $startDate) {
                $dateArray[] = $endDate->format('Y-m-d');
                $endDate->modify('-1 day'); 
            }

         
            foreach ($dateArray as $key => $value) {
   
                $data['results'][$key]['date_range'] = $value;
                $data['results'][$key]['submit_by_org'] = DB::table('gcc_appeals')->where('division_id', $request->division)->where('case_date', $value)->count();

                $present_by_gco_asst_query = DB::table('gcc_appeals')
                    ->join('cer_asst_notes_modified', 'gcc_appeals.id', '=', 'cer_asst_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('cer_asst_notes_modified.conduct_date', $value)
                    ->whereNotIn('cer_asst_notes_modified.appeal_id', function($query) use ($value) {
                        $query->select('appeal_id')
                            ->from('cer_asst_notes_modified')
                            ->where('conduct_date', '<', $value); 
                    })
                    ->select('gcc_appeals.id as gcc_appeal_id', 'cer_asst_notes_modified.appeal_id')
                    ->groupBy('cer_asst_notes_modified.appeal_id')
                    ->havingRaw('COUNT(cer_asst_notes_modified.appeal_id) = 1') 
                    ->get();

                $data['results'][$key]['present_by_gco_asst'] = $present_by_gco_asst_query->count();

                $accept_by_gco_query = DB::table('gcc_appeals')
                    ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_notes_modified.conduct_date', $value) 
                    ->whereNotIn('gcc_notes_modified.appeal_id', function($query) use ($value) {
                        $query->select('appeal_id')
                            ->from('gcc_notes_modified')
                            ->where('conduct_date', '<', $value); 
                    })
                    ->select('gcc_notes_modified.appeal_id')
                    ->groupBy('gcc_notes_modified.appeal_id')
                    ->havingRaw('COUNT(gcc_notes_modified.appeal_id) = 1') 
                    ->get();

                $data['results'][$key]['accept_by_gco'] = $accept_by_gco_query->count();

                $today_action_query = DB::table('gcc_appeals')
                    ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_notes_modified.conduct_date', $value) 
                    ->whereExists(function($query) use ($value) {
                        $query->select(DB::raw(1))
                            ->from('gcc_notes_modified as earlier')
                            ->whereColumn('earlier.appeal_id', 'gcc_notes_modified.appeal_id')
                            ->where('earlier.conduct_date', '<', $value); 
                    })
                    ->select('gcc_notes_modified.appeal_id')
                    ->groupBy('gcc_notes_modified.appeal_id') 
                    ->get();

               
                $data['results'][$key]['today_action'] = $today_action_query->count();

                $total_claimed_amount = DB::table('gcc_appeals')->where('division_id', $request->division)->where('case_date', $value);
                $data['results'][$key]['total_claimed_amount']=$total_claimed_amount->sum('loan_amount');

                $total_recieved_amount = DB::table('gcc_appeals')
                    ->join('gcc_payment_lists', 'gcc_appeals.id', 'gcc_payment_lists.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_payment_lists.paid_date', $value)
                    ->select('gcc_payment_lists.paid_loan_amount')->get();
              

                $data['results'][$key]['total_recieved_amount']=$total_recieved_amount->sum('paid_loan_amount');
 
            }
            // dd($data['results']);
            $html = view('report.pdf_new_report_division')->with($data);

            $this->generatePDF($html);
        }

        if ($request->btnsubmit == 'pdf_new_report_district') {
            $data['page_title'] = 'জেলা ভিত্তিক রিপোর্ট'; //exit;
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

            if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8) {
                $data['division']=$request->division;
                $data['district']=$request->district;
            }
            if (globalUserInfo()->role_id == 34 ) {
                $data['division']=user_division();
                $data['district']=$request->district;
            }
            if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7) {
                $data['division']=user_division();
                $data['district']=user_district()->id;
            }
         
            $data['year'] = $request->year;
            $data['month'] = $request->month;
            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;
            if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8) {
                $request->validate(
                    ['division' => 'required', 'district' => 'required', 'date_start' => 'required', 'date_end' => 'required'],
                    ['division.required' => ' বিভাগ নির্বাচন করুন', 'district.required' => ' জেলা নির্বাচন করুন', 'date_start.required' => ' শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => ' শেষের তারিখ নির্বাচন করুন']
                );
            }
            if (globalUserInfo()->role_id == 34) {
                $request->validate(
                    [ 'district' => 'required', 'date_start' => 'required', 'date_end' => 'required'],
                    [ 'district.required' => ' জেলা নির্বাচন করুন', 'date_start.required' => ' শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => ' শেষের তারিখ নির্বাচন করুন']
                );
            }
            if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7) {
                $request->validate(
                    [  'date_start' => 'required', 'date_end' => 'required'],
                    [  'date_start.required' => ' শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => ' শেষের তারিখ নির্বাচন করুন']
                );
            }

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));

      
            $startDate = new \DateTime($dateFrom);
            $endDate = new \DateTime($dateTo); 
     
            $dateArray = [];

            while ($endDate >= $startDate) {
                $dateArray[] = $endDate->format('Y-m-d');
                $endDate->modify('-1 day'); 
            }

         
            foreach ($dateArray as $key => $value) {
              
                $data['results'][$key]['date_range'] = $value;
                $data['results'][$key]['submit_by_org'] = DB::table('gcc_appeals')->where('division_id', $request->division)->where('district_id', $request->district)->where('case_date', $value)->count();

                $present_by_gco_asst_query = DB::table('gcc_appeals')
                    ->join('cer_asst_notes_modified', 'gcc_appeals.id', '=', 'cer_asst_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $request->district)
                    ->where('cer_asst_notes_modified.conduct_date', $value)
                    ->whereNotIn('cer_asst_notes_modified.appeal_id', function($query) use ($value) {
                        $query->select('appeal_id')
                            ->from('cer_asst_notes_modified')
                            ->where('conduct_date', '<', $value); 
                    })
                    ->select('gcc_appeals.id as gcc_appeal_id', 'cer_asst_notes_modified.appeal_id')
                    ->groupBy('cer_asst_notes_modified.appeal_id')
                    ->havingRaw('COUNT(cer_asst_notes_modified.appeal_id) = 1') 
                    ->get();

                $data['results'][$key]['present_by_gco_asst'] = $present_by_gco_asst_query->count();

                $accept_by_gco_query = DB::table('gcc_appeals')
                    ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $request->district)
                    ->where('gcc_notes_modified.conduct_date', $value) 
                    ->whereNotIn('gcc_notes_modified.appeal_id', function($query) use ($value) {
                        $query->select('appeal_id')
                            ->from('gcc_notes_modified')
                            ->where('conduct_date', '<', $value); 
                    })
                    ->select('gcc_notes_modified.appeal_id')
                    ->groupBy('gcc_notes_modified.appeal_id')
                    ->havingRaw('COUNT(gcc_notes_modified.appeal_id) = 1') 
                    ->get();

                $data['results'][$key]['accept_by_gco'] = $accept_by_gco_query->count();

                $today_action_query = DB::table('gcc_appeals')
                    ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $request->district)
                    ->where('gcc_notes_modified.conduct_date', $value) 
                    ->whereExists(function($query) use ($value) {
                        $query->select(DB::raw(1))
                            ->from('gcc_notes_modified as earlier')
                            ->whereColumn('earlier.appeal_id', 'gcc_notes_modified.appeal_id')
                            ->where('earlier.conduct_date', '<', $value); 
                    })
                    ->select('gcc_notes_modified.appeal_id')
                    ->groupBy('gcc_notes_modified.appeal_id') 
                    ->get();

               
                $data['results'][$key]['today_action'] = $today_action_query->count();

                $total_claimed_amount = DB::table('gcc_appeals')->where('division_id', $request->division)->where('district_id', $request->district)->where('case_date', $value);
                $data['results'][$key]['total_claimed_amount']=$total_claimed_amount->sum('loan_amount');

                $total_recieved_amount = DB::table('gcc_appeals')
                    ->join('gcc_payment_lists', 'gcc_appeals.id', 'gcc_payment_lists.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $request->district)
                    ->where('gcc_payment_lists.paid_date', $value)
                    ->select('gcc_payment_lists.paid_loan_amount')->get();
              

                $data['results'][$key]['total_recieved_amount']=$total_recieved_amount->sum('paid_loan_amount');
 
            }
            // dd($data['results']);
            $html = view('report.pdf_new_report_district')->with($data);

            $this->generatePDF($html);
        }

        if ($request->btnsubmit == 'pdf_new_report_upazila') {
            $data['page_title'] = 'উপজেলা ভিত্তিক রিপোর্ট'; //exit;

            // Get Division
            // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
            if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8) {
                $data['division']=$request->division;
                $data['district']=$request->district;
            }
            if (globalUserInfo()->role_id == 34 ) {
                $data['division']=user_division();
                $data['district']=$request->district;
            }
            if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7) {
                $data['division']=user_division();
                $data['district']=user_district()->id;
            }
            // dd($data);
            $data['upazila']=$request->upazila;
            $data['year'] = $request->year;
            $data['month'] = $request->month;
            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;
            if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 25 || globalUserInfo()->role_id == 8) {
                $request->validate(
                    ['division' => 'required', 'district' => 'required', 'upazila' => 'required', 'date_start' => 'required', 'date_end' => 'required'],
                    ['division.required' => ' বিভাগ নির্বাচন করুন', 'district.required' => ' জেলা নির্বাচন করুন', 'upazila.required' => ' উপজেলা নির্বাচন করুন', 'date_start.required' => ' শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => ' শেষের তারিখ নির্বাচন করুন']
                );
            }
            if (globalUserInfo()->role_id == 34) {
                $request->validate(
                    [ 'district' => 'required', 'upazila' => 'required', 'date_start' => 'required', 'date_end' => 'required'],
                    ['district.required' => ' জেলা নির্বাচন করুন', 'upazila.required' => ' উপজেলা নির্বাচন করুন', 'date_start.required' => ' শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => ' শেষের তারিখ নির্বাচন করুন']
                );
            }
            if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7) {
                $request->validate(
                    [ 'upazila' => 'required', 'date_start' => 'required', 'date_end' => 'required'],
                    ['upazila.required' => ' উপজেলা নির্বাচন করুন', 'date_start.required' => ' শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => ' শেষের তারিখ নির্বাচন করুন']
                );
            }

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));

      
            $startDate = new \DateTime($dateFrom);
            $endDate = new \DateTime($dateTo); 
     
            $dateArray = [];

            while ($endDate >= $startDate) {
                $dateArray[] = $endDate->format('Y-m-d');
                $endDate->modify('-1 day'); 
            }

         
            foreach ($dateArray as $key => $value) {
              
                $data['results'][$key]['date_range'] = $value;
                $data['results'][$key]['submit_by_org'] = DB::table('gcc_appeals')->where('division_id', $request->division)->where('district_id', $request->district)->where('upazila_id', $request->upazila)->where('case_date', $value)->count();

                $present_by_gco_asst_query = DB::table('gcc_appeals')
                    ->join('cer_asst_notes_modified', 'gcc_appeals.id', '=', 'cer_asst_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $request->district)
                    ->where('gcc_appeals.upazila_id', $request->upazila)
                    ->where('cer_asst_notes_modified.conduct_date', $value)
                    ->whereNotIn('cer_asst_notes_modified.appeal_id', function($query) use ($value) {
                        $query->select('appeal_id')
                            ->from('cer_asst_notes_modified')
                            ->where('conduct_date', '<', $value); 
                    })
                    ->select('gcc_appeals.id as gcc_appeal_id', 'cer_asst_notes_modified.appeal_id')
                    ->groupBy('cer_asst_notes_modified.appeal_id')
                    ->havingRaw('COUNT(cer_asst_notes_modified.appeal_id) = 1') 
                    ->get();

                $data['results'][$key]['present_by_gco_asst'] = $present_by_gco_asst_query->count();

                $accept_by_gco_query = DB::table('gcc_appeals')
                    ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $request->district)
                    ->where('gcc_appeals.upazila_id', $request->upazila)
                    ->where('gcc_notes_modified.conduct_date', $value) 
                    ->whereNotIn('gcc_notes_modified.appeal_id', function($query) use ($value) {
                        $query->select('appeal_id')
                            ->from('gcc_notes_modified')
                            ->where('conduct_date', '<', $value); 
                    })
                    ->select('gcc_notes_modified.appeal_id')
                    ->groupBy('gcc_notes_modified.appeal_id')
                    ->havingRaw('COUNT(gcc_notes_modified.appeal_id) = 1') 
                    ->get();

                $data['results'][$key]['accept_by_gco'] = $accept_by_gco_query->count();

                $today_action_query = DB::table('gcc_appeals')
                    ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $request->district)
                    ->where('gcc_appeals.upazila_id', $request->upazila)
                    ->where('gcc_notes_modified.conduct_date', $value) 
                    ->whereExists(function($query) use ($value) {
                        $query->select(DB::raw(1))
                            ->from('gcc_notes_modified as earlier')
                            ->whereColumn('earlier.appeal_id', 'gcc_notes_modified.appeal_id')
                            ->where('earlier.conduct_date', '<', $value); 
                    })
                    ->select('gcc_notes_modified.appeal_id')
                    ->groupBy('gcc_notes_modified.appeal_id') 
                    ->get();

               
                $data['results'][$key]['today_action'] = $today_action_query->count();

                $total_claimed_amount = DB::table('gcc_appeals')->where('division_id', $request->division)->where('district_id', $request->district)->where('upazila_id', $request->upazila)->where('case_date', $value);
                $data['results'][$key]['total_claimed_amount']=$total_claimed_amount->sum('loan_amount');

                $total_recieved_amount = DB::table('gcc_appeals')
                    ->join('gcc_payment_lists', 'gcc_appeals.id', 'gcc_payment_lists.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $request->district)
                    ->where('gcc_appeals.upazila_id', $request->upazila)
                    ->where('gcc_payment_lists.paid_date', $value)
                    ->select('gcc_payment_lists.paid_loan_amount')->get();
              

                $data['results'][$key]['total_recieved_amount']=$total_recieved_amount->sum('paid_loan_amount');
 
            }
            // dd($data['results']);
            $html = view('report.pdf_new_report_upazila')->with($data);

            $this->generatePDF($html);
        }

        //daily report
        if ($request->btnsubmit == 'pdf_daily_division') {
            $data['page_title'] = 'বিভাগ ভিত্তিক রিপোর্ট'; //exit;

            // Get Division
            // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

            $data['year'] = $request->year;
            $data['month'] = $request->month;
            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;
            $today = date('Y-m-d');
            $data['today']=$today;
            foreach ($data['divisions'] as $key => $value) {
                $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['submit_by_org'] = DB::table('gcc_appeals')->where('division_id', $value->id)->where('case_date', $today)->count();
                $present_by_gco_asst_query = DB::table('gcc_appeals')
                    ->join('cer_asst_notes_modified', 'gcc_appeals.id', '=', 'cer_asst_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id',$value->id)
                    ->where('cer_asst_notes_modified.conduct_date', $today)
                    ->select('gcc_appeals.id as gcc_appeal_id', 'cer_asst_notes_modified.appeal_id')
                    ->groupBy('cer_asst_notes_modified.appeal_id')
                    ->havingRaw('COUNT(cer_asst_notes_modified.appeal_id) = 1') 
                    ->get();

                $data['results'][$key]['present_by_gco_asst'] = $present_by_gco_asst_query->count();
             
                $accept_by_gco_query = DB::table('gcc_appeals')
                    ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $value->id)
                    ->where('gcc_notes_modified.conduct_date', $today) 
                    ->select('gcc_notes_modified.appeal_id')
                    ->groupBy('gcc_notes_modified.appeal_id')
                    ->havingRaw('COUNT(gcc_notes_modified.appeal_id) = 1') 
                    ->get();

                $data['results'][$key]['accept_by_gco'] = $accept_by_gco_query->count();

                $today_action_query = DB::table('gcc_appeals')
                    ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $value->id)
                    ->where('gcc_notes_modified.conduct_date', $today) 
                    ->select('gcc_notes_modified.appeal_id')
                    ->groupBy('gcc_notes_modified.appeal_id') 
                    ->get();

               
                $data['results'][$key]['today_action'] = $today_action_query->count();

                $total_claimed_amount = DB::table('gcc_appeals')->where('division_id', $value->id)->where('case_date', $today);
                $data['results'][$key]['total_claimed_amount']=$total_claimed_amount->sum('loan_amount');

                $total_recieved_amount = DB::table('gcc_appeals')
                    ->join('gcc_payment_lists', 'gcc_appeals.id', 'gcc_payment_lists.appeal_id')
                    ->where('gcc_appeals.division_id', $value->id)
                    ->where('gcc_payment_lists.paid_date', $today)
                    ->select('gcc_payment_lists.paid_loan_amount')->get();
              

                $data['results'][$key]['total_recieved_amount']=$total_recieved_amount->sum('paid_loan_amount');
            }
           
            $html = view('report.pdf_daily_division')->with($data);

            $this->generatePDF($html);
        }

        if ($request->btnsubmit == 'pdf_daily_district') {
            $data['page_title'] = 'জেলা ভিত্তিক রিপোর্ট'; //exit;

            if (globalUserInfo()->role_id != 34) {
                // Validation
                $request->validate(
                    ['division' => 'required'],
                    ['division.required' => 'বিভাগ নির্বাচন করুন']
                );
            }


            $data['year'] = $request->year;
            $data['month'] = $request->month;

            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;
            $today = date('Y-m-d');
            $data['today']=$today;
            // dd($data['div_name']);
            if (globalUserInfo()->role_id == 34) {
                $data['div_name'] = user_office_info()->division_name_bn;
                $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', user_office_info()->division_id)->get();
            } else {
                $div_data = DB::table('division')->where('id', $request->division)->first();
                $data['div_name'] = $div_data->division_name_bn;
                $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', $request->division)->get();
            }


            foreach ($data['districts'] as $key => $value) {
                $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['submit_by_org'] = DB::table('gcc_appeals')->where('division_id', $request->division)->where('district_id', $value->id)->where('case_date', $today)->count();

                $present_by_gco_asst_query = DB::table('gcc_appeals')
                    ->join('cer_asst_notes_modified', 'gcc_appeals.id', '=', 'cer_asst_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $value->id)
                    ->where('cer_asst_notes_modified.conduct_date', $today)
                    ->select('gcc_appeals.id as gcc_appeal_id', 'cer_asst_notes_modified.appeal_id')
                    ->groupBy('cer_asst_notes_modified.appeal_id')
                    ->havingRaw('COUNT(cer_asst_notes_modified.appeal_id) = 1') 
                    ->get();

                $data['results'][$key]['present_by_gco_asst'] = $present_by_gco_asst_query->count();
    
                $accept_by_gco_query = DB::table('gcc_appeals')
                    ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $value->id)
                    ->where('gcc_notes_modified.conduct_date', $today) 
                    ->select('gcc_notes_modified.appeal_id')
                    ->groupBy('gcc_notes_modified.appeal_id')
                    ->havingRaw('COUNT(gcc_notes_modified.appeal_id) = 1') 
                    ->get();

                $data['results'][$key]['accept_by_gco'] = $accept_by_gco_query->count();

                $today_action_query = DB::table('gcc_appeals')
                    ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $value->id)
                    ->where('gcc_notes_modified.conduct_date', $today) 
                    ->select('gcc_notes_modified.appeal_id')
                    ->groupBy('gcc_notes_modified.appeal_id') 
                    ->get();

               
                $data['results'][$key]['today_action'] = $today_action_query->count();

                $total_claimed_amount = DB::table('gcc_appeals')->where('division_id', $request->division)->where('district_id', $value->id)->where('case_date', $today);
                $data['results'][$key]['total_claimed_amount']=$total_claimed_amount->sum('loan_amount');

                $total_recieved_amount = DB::table('gcc_appeals')
                    ->join('gcc_payment_lists', 'gcc_appeals.id', 'gcc_payment_lists.appeal_id')
                    ->where('gcc_appeals.division_id', $request->division)
                    ->where('gcc_appeals.district_id', $value->id)
                    ->where('gcc_payment_lists.paid_date', $today)
                    ->select('gcc_payment_lists.paid_loan_amount')->get();
              

                $data['results'][$key]['total_recieved_amount']=$total_recieved_amount->sum('paid_loan_amount');
            }
            // dd($data);
            $html = view('report.pdf_daily_district')->with($data);

            $this->generatePDF($html);
        }

        if ($request->btnsubmit == 'pdf_daily_upazila') {
           
                $data['page_title'] = 'উপজেলা ভিত্তিক রিপোর্ট'; //exit;
                // dd($request->division);

                if (globalUserInfo()->role_id == 34) {
                    $request->validate(
                        [
                            'district' => 'required',
                        ],
                        [
                            'district.required' => 'জেলা নির্বাচন করুন',
                        ]
                    );
                } else {
                    $request->validate(
                        [
                            'division' => 'required',
                            'district' => 'required',
                        ],
                        [
                            'division.required' => 'বিভাগ নির্বাচন করুন',
                            'district.required' => 'জেলা নির্বাচন করুন',
                        ]
                    );
                }

                $dis_data = DB::table('district')->where('id', $request->district)->first();
                $data['dis_data'] = $dis_data->district_name_bn;

                $data['year'] = $request->year;
                $data['month'] = $request->month;
                $data['date_start'] = $request->date_start;
                $data['date_end'] = $request->date_end;
                $today = date('Y-m-d');
                $data['today']=$today;
                
                $data['div_name'] = get_divison_name($request->division)->division_name_bn;
                $data['districts'] = get_district_name($request->district)->district_name_bn;
               
                $data['upazilas'] = DB::table('upazila')->select('id', 'district_id', 'upazila_name_bn')->where('district_id', $request->district)->get();


                foreach ($data['upazilas'] as $key => $value) {
                    $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $data['results'][$key]['submit_by_org'] = DB::table('gcc_appeals')->where('division_id', $request->division)->where('district_id', $request->district)->where('upazila_id', $value->id)->where('case_date', $today)->count();

                    $present_by_gco_asst_query = DB::table('gcc_appeals')
                        ->join('cer_asst_notes_modified', 'gcc_appeals.id', '=', 'cer_asst_notes_modified.appeal_id')
                        ->where('gcc_appeals.division_id', $request->division)
                        ->where('gcc_appeals.district_id', $request->district)
                        ->where('gcc_appeals.upazila_id', $value->id)
                        ->where('cer_asst_notes_modified.conduct_date', $today)
                        ->select('gcc_appeals.id as gcc_appeal_id', 'cer_asst_notes_modified.appeal_id')
                        ->groupBy('cer_asst_notes_modified.appeal_id')
                        ->havingRaw('COUNT(cer_asst_notes_modified.appeal_id) = 1') 
                        ->get();

                    $data['results'][$key]['present_by_gco_asst'] = $present_by_gco_asst_query->count();

                    $accept_by_gco_query = DB::table('gcc_appeals')
                        ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                        ->where('gcc_appeals.division_id', $request->division)
                        ->where('gcc_appeals.district_id', $request->district)
                        ->where('gcc_appeals.upazila_id', $value->id)
                        ->where('gcc_notes_modified.conduct_date', $today) 
                        ->select('gcc_notes_modified.appeal_id')
                        ->groupBy('gcc_notes_modified.appeal_id')
                        ->havingRaw('COUNT(gcc_notes_modified.appeal_id) = 1') 
                        ->get();

                    $data['results'][$key]['accept_by_gco'] = $accept_by_gco_query->count();

                    $today_action_query = DB::table('gcc_appeals')
                        ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                        ->where('gcc_appeals.division_id', $request->division)
                        ->where('gcc_appeals.district_id', $request->district)
                        ->where('gcc_appeals.upazila_id', $value->id)
                        ->where('gcc_notes_modified.conduct_date', $today) 
                        ->select('gcc_notes_modified.appeal_id')
                        ->groupBy('gcc_notes_modified.appeal_id') 
                        ->get();

                
                    $data['results'][$key]['today_action'] = $today_action_query->count();

                    $total_claimed_amount = DB::table('gcc_appeals')->where('division_id', $request->division)->where('district_id', $request->district)->where('upazila_id', $value->id)->where('case_date', $today);
                    $data['results'][$key]['total_claimed_amount']=$total_claimed_amount->sum('loan_amount');

                    $total_recieved_amount = DB::table('gcc_appeals')
                        ->join('gcc_payment_lists', 'gcc_appeals.id', 'gcc_payment_lists.appeal_id')
                        ->where('gcc_appeals.division_id', $request->division)
                        ->where('gcc_appeals.district_id', $request->district)
                        ->where('gcc_appeals.upazila_id', $value->id)
                        ->where('gcc_payment_lists.paid_date', $today)
                        ->select('gcc_payment_lists.paid_loan_amount')->get();
                

                    $data['results'][$key]['total_recieved_amount']=$total_recieved_amount->sum('paid_loan_amount');
                }

                $html = view('report.pdf_daily_upazila')->with($data);

                $this->generatePDF($html);
            
            // if (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7) {
            //     $data['page_title'] = 'উপজেলা ভিত্তিক রিপোর্ট'; //exit;
            //     $district_id = DB::table('court')->where('id', globalUserInfo()->court_id)->select('district_id')->first();
            //     $dis_data = DB::table('district')->where('id', $district_id->district_id)->first();
            //     $data['dis_data'] = $dis_data->district_name_bn;

            //     $data['year'] = $request->year;
            //     $data['month'] = $request->month;
            //     $data['date_start'] = $request->date_start;
            //     $data['date_end'] = $request->date_end;



            //     $data['upazilas'] = DB::table('upazila')->select('id', 'district_id', 'upazila_name_bn')->where('district_id', $district_id->district_id)->get();


            //     foreach ($data['upazilas'] as $key => $value) {
            //         $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
            //         $data['results'][$key]['id'] = $value->id;
            //         $data['results'][$key]['ON_TRIAL_PREV_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'ON_TRIAL_PREV_MONTH');
            //         $data['results'][$key]['TOTAL_LOAN_PREV_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'TOTAL_LOAN_PREV_MONTH');
            //         $data['results'][$key]['ON_TRIAL_CRNT_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'ON_TRIAL_CRNT_MONTH');
            //         $data['results'][$key]['TOTAL_LOAN_CRNT_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'TOTAL_LOAN_CRNT_MONTH');
            //         $data['results'][$key]['TOTAL_CLOSE_CASE'] = $this->case_count_status_by_upazila('CLOSED', $value->id, $data, 'TOTAL_CLOSE_CASE');
            //         $data['results'][$key]['TOTAL_COLLECT_CRNT_MONTH'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'TOTAL_COLLECT_CRNT_MONTH');
            //     }

            //     $html = view('report.pdf_num_upazila')->with($data);

            //     $this->generatePDF($html);
            // }
        }

        if ($request->btnsubmit == 'pdf_case') {
            //exit;
            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;
            $data['division'] = $request->division;
            $data['district'] = $request->district;
            $data['year'] = $request->year;
            $data['month'] = $request->month;
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
            // Validation
            $request->validate(
                ['date_start' => 'required', 'date_end' => 'required'],
                ['date_start.required' => 'মামলা শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => 'মামলা শেষের তারিখ নির্বাচন করুন']
            );
            if (globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 8 || globalUserInfo()->role_id == 25) {
                $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
                foreach ($data['divisions'] as $key => $value) {
                    $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $data['results'][$key]['RUNNING_CASE_AT_GCO'] = $this->case_count_status_by_divisions('ON_TRIAL', $value->id, $data, 'RUNNING_CASE_AT_GCC');
                    $data['results'][$key]['RUNNING_APPEAL_CASE_AT_ADC'] = 0;
                    $data['results'][$key]['RUNNING_APPEAL_CASE_AT_ADIVC'] = 0;
                    $data['results'][$key]['RUNNING_APPRAL_CASE_AT_LAB'] = 0;
                    $data['results'][$key]['PANDING_CASE_AT_GCO'] = $this->case_count_status_by_divisions('SEND_TO_GCO', $value->id, $data, 'PANDING_CASE_AT_GCO');
                    // dd($data['results'][$key]['PANDING_CASE_AT_GCO']);

                    $data['results'][$key]['PANDING_CASE_AT_ASST_GCO'] = $this->case_count_status_by_divisions('SEND_TO_ASST_GCO', $value->id, $data, 'PANDING_CASE_AT_ASST_GCO');
                    $data['results'][$key]['CLOSED_APPRAL_CASE_AT_LAB'] = 0;
                    $data['results'][$key]['CLOSED_APPEAL_CASE_AT_ADIVC'] = 0;
                    $data['results'][$key]['CLOSED_APPEAL_CASE_AT_ADC'] = 0;
                    $data['results'][$key]['CLOSED_CASE_AT_GCC'] = $this->case_count_status_by_divisions('CLOSED', $value->id, $data, 'CLOSED_CASE_AT_GCC');
                }
                $data['page_title'] = 'আদালত ভিত্তিক বিভাগের রিপোর্ট';
                $html = view('report.pdf_case_div')->with($data);
            } elseif (globalUserInfo()->role_id == 34) {
                $office_info = get_office_by_id(globalUserInfo()->office_id);
                $data['districts'] = DB::table('district')
                    ->where('district.division_id', user_office_info()->division_id)->select('id', 'district_name_bn')->get();
                foreach ($data['districts'] as $key => $value) {
                    $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $data['results'][$key]['RUNNING_CASE_AT_GCO'] = $this->case_count_status_by_district('ON_TRIAL', $value->id, $data, 'RUNNING_CASE_AT_GCO');
                    $data['results'][$key]['RUNNING_APPEAL_CASE_AT_ADC'] = 0;
                    $data['results'][$key]['RUNNING_APPEAL_CASE_AT_ADIVC'] = 0;
                    $data['results'][$key]['PANDING_CASE_AT_GCO'] = $this->case_count_status_by_district('SEND_TO_GCO', $value->id, $data, 'PANDING_CASE_AT_GCO');
                    // dd($data['results'][$key]['PANDING_CASE_AT_GCO']);

                    $data['results'][$key]['PANDING_CASE_AT_ASST_GCO'] = $this->case_count_status_by_district('SEND_TO_ASST_GCO', $value->id, $data, 'PANDING_CASE_AT_ASST_GCO');
                    $data['results'][$key]['CLOSED_APPEAL_CASE_AT_ADIVC'] = 0;
                    $data['results'][$key]['CLOSED_APPEAL_CASE_AT_ADC'] = 0;
                    $data['results'][$key]['CLOSED_CASE_AT_GCC'] = $this->case_count_status_by_district('CLOSED', $value->id, $data, 'CLOSED_CASE_AT_GCC');
                }
                $data['page_title'] = 'আদালত ভিত্তিক জেলার রিপোর্ট';
                $html = view('report.pdf_case_dis')->with($data);
            } elseif (globalUserInfo()->role_id == 6 || globalUserInfo()->role_id == 7) {
                $data['upazila'] = DB::table('upazila')
                    ->where('upazila.district_id', user_office_info()->district_id)->select('id', 'upazila_name_bn')->get();
                foreach ($data['upazila'] as $key => $value) {
                    $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                    $data['results'][$key]['id'] = $value->id;
                    $data['results'][$key]['RUNNING_CASE_AT_GCO'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data, 'RUNNING_CASE_AT_GCO');
                    $data['results'][$key]['RUNNING_APPEAL_CASE_AT_ADC'] = 0;
                    $data['results'][$key]['PANDING_CASE_AT_GCO'] = $this->case_count_status_by_upazila('SEND_TO_GCO', $value->id, $data, 'PANDING_CASE_AT_GCO');

                    $data['results'][$key]['PANDING_CASE_AT_ASST_GCO'] = $this->case_count_status_by_upazila('SEND_TO_ASST_GCO', $value->id, $data, 'PANDING_CASE_AT_ASST_GCO');
                    $data['results'][$key]['CLOSED_APPEAL_CASE_AT_ADC'] = 0;
                    $data['results'][$key]['CLOSED_CASE_AT_GCC'] = $this->case_count_status_by_upazila('CLOSED', $value->id, $data, 'CLOSED_CASE_AT_GCC');
                }
                $data['page_title'] = 'আদালত ভিত্তিক উপজেলার রিপোর্ট';

                $html = view('report.pdf_case_upa')->with($data);
            }
            $this->generatePDF($html);
        }
    }

    public function new_report_by_division($data)
    {

        
    }

    public function case_list_filter($data)
    {
        $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
        $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));

        // Query
        $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status', 'ON_TRIAL')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $ON_TRIAL = $query->count();



        $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status', 'SEND_TO_GCO')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $SEND_TO_GCO = $query->count();


        $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status', 'SEND_TO_ASST_GCO')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $SEND_TO_ASST_GCO = $query->count();



        $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status', 'SEND_TO_DC')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $SEND_TO_DC = $query->count();



        $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status', 'SEND_TO_DIV_COM')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $SEND_TO_DIV_COM = $query->count();



        $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status', 'SEND_TO_LAB_CM')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $SEND_TO_LAB_CM = $query->count();



        $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status', 'CLOSED')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $CLOSED = $query->count();





        $query = DB::table('gcc_appeals')
            ->select('gcc_appeals.id', 'gcc_appeals.case_no', 'gcc_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'gcc_appeals.case_date')
            ->join('district', 'gcc_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'gcc_appeals.division_id', '=', 'division.id')
            ->where('gcc_appeals.appeal_status', 'REJECTED')
            ->orderBy('id', 'DESC');
        // ->where('gcc_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('gcc_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('gcc_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('gcc_appeals.upazila_id', $data['upazila']);
        }
        $REJECTED = $query->count();

        $data = [
            'ON_TRIAL' => $ON_TRIAL,
            'SEND_TO_GCO' => $SEND_TO_GCO,
            'SEND_TO_ASST_GCO' => $SEND_TO_ASST_GCO,
            'SEND_TO_DC' => $SEND_TO_DC,
            'SEND_TO_DIV_COM' => $SEND_TO_DIV_COM,
            'SEND_TO_LAB_CM' => $SEND_TO_LAB_CM,
            'CLOSED' => $CLOSED,
            'REJECTED' => $REJECTED

        ];

        return $data;
    }

    public function case_count_status_by_upazila($status, $id, $data, $query = null)
    {
        if ($query == 'ON_TRIAL_PREV_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $prevmonth = date('Y-m-01');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.upazila_id', $id)
                ->where('gcc_notes_modified.conduct_date', '<=', $prevmonth)
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'TOTAL_LOAN_PREV_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }
            // $today_date=date('Y-m-d');
            $prevmonth = date('Y-m-01');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.upazila_id', $id)
                ->where('gcc_notes_modified.conduct_date', '<=', $prevmonth)
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            // dd($query->count());
            return $query->sum('gcc_appeals.loan_amount');
            // return $query;
        }

        if ($query == 'ON_TRIAL_CRNT_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.upazila_id', $id)
                ->whereBetween('gcc_notes_modified.conduct_date', [$strt, $end])
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'TOTAL_LOAN_CRNT_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.upazila_id', $id)
                ->whereBetween('gcc_notes_modified.conduct_date', [$strt, $end])
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->sum('gcc_appeals.loan_amount');
        }

        if ($query == 'TOTAL_CLOSE_CASE') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->where('gcc_appeals.upazila_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'TOTAL_COLLECT_CRNT_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->join('gcc_payment_lists', 'gcc_appeals.id', '=', 'gcc_payment_lists.appeal_id')
                ->where('gcc_appeals.upazila_id', $id)
                ->whereBetween('gcc_payment_lists.paid_date', [$strt, $end])
                ->groupBy('gcc_payment_lists.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->sum('paid_loan_amount');
        }

        if ($query == 'RUNNING_CASE_AT_GCO') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->where('gcc_appeals.upazila_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'PANDING_CASE_AT_GCO') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->where('gcc_appeals.upazila_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'PANDING_CASE_AT_ASST_GCO') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->where('gcc_appeals.upazila_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'CLOSED_CASE_AT_GCC') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->where('gcc_appeals.upazila_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }
    }

    public function case_count_status_by_district($status, $id, $data, $query = null)
    {
        if ($query == 'ON_TRIAL_PREV_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $prevmonth = date('Y-m-01');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.district_id', $id)
                ->where('gcc_notes_modified.conduct_date', '<=', $prevmonth)
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'TOTAL_LOAN_PREV_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }
            // $today_date=date('Y-m-d');
            $prevmonth = date('Y-m-01');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.district_id', $id)
                ->where('gcc_notes_modified.conduct_date', '<=', $prevmonth)
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            // dd($query->count());
            return $query->sum('gcc_appeals.loan_amount');
            // return $query;
        }

        if ($query == 'ON_TRIAL_CRNT_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.district_id', $id)
                ->whereBetween('gcc_notes_modified.conduct_date', [$strt, $end])
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'TOTAL_LOAN_CRNT_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.district_id', $id)
                ->whereBetween('gcc_notes_modified.conduct_date', [$strt, $end])
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->sum('gcc_appeals.loan_amount');
        }

        if ($query == 'TOTAL_CLOSE_CASE') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->where('gcc_appeals.district_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'TOTAL_COLLECT_CRNT_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->join('gcc_payment_lists', 'gcc_appeals.id', '=', 'gcc_payment_lists.appeal_id')
                ->where('gcc_appeals.district_id', $id)
                ->whereBetween('gcc_payment_lists.paid_date', [$strt, $end])
                ->groupBy('gcc_payment_lists.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->sum('paid_loan_amount');
        }
        if ($query == 'RUNNING_CASE_AT_GCO') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)->where('gcc_appeals.district_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }
            // dd($query->toSql());
            return $query->count();
        }
        if ($query == 'PANDING_CASE_AT_GCO') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)->where('gcc_appeals.district_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }
        if ($query == 'PANDING_CASE_AT_ASST_GCO') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)->where('gcc_appeals.district_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }
        if ($query == 'CLOSED_CASE_AT_GCC') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)->where('gcc_appeals.district_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }
    }
    public function case_count_status_by_division($status, $id, $data, $query = null)
    {

        if ($query == 'ON_TRIAL_PREV_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $prevmonth = date('Y-m-01');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.division_id', $id)
                ->where('gcc_notes_modified.conduct_date', '<=', $prevmonth)
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'TOTAL_LOAN_PREV_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }
            // $today_date=date('Y-m-d');
            $prevmonth = date('Y-m-01');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.division_id', $id)
                ->where('gcc_notes_modified.conduct_date', '<=', $prevmonth)
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            // dd($query->count());
            return $query->sum('gcc_appeals.loan_amount');
            // return $query;
        }

        if ($query == 'ON_TRIAL_CRNT_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.division_id', $id)
                ->whereBetween('gcc_notes_modified.conduct_date', [$strt, $end])
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'TOTAL_LOAN_CRNT_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->join('gcc_notes_modified', 'gcc_appeals.id', '=', 'gcc_notes_modified.appeal_id')
                ->where('gcc_appeals.division_id', $id)
                ->whereBetween('gcc_notes_modified.conduct_date', [$strt, $end])
                ->groupBy('gcc_notes_modified.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->sum('gcc_appeals.loan_amount');
        }

        if ($query == 'TOTAL_CLOSE_CASE') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)
                ->where('gcc_appeals.division_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'TOTAL_COLLECT_CRNT_MONTH') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->join('gcc_payment_lists', 'gcc_appeals.id', '=', 'gcc_payment_lists.appeal_id')
                ->where('gcc_appeals.division_id', $id)
                ->whereBetween('gcc_payment_lists.paid_date', [$strt, $end])
                ->groupBy('gcc_payment_lists.appeal_id');
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->sum('paid_loan_amount');
        }
    }

    public function case_count_status_by_divisions($status, $id, $data, $query = null)
    {

        if ($query == 'RUNNING_CASE_AT_GCC') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $prevmonth = date('Y-m-01');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)->where('division_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }
            // dd($query->toSql());
            return $query->count();
        }

        if ($query == 'PANDING_CASE_AT_GCO') {

            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }
            // $today_date=date('Y-m-d');
            $prevmonth = date('Y-m-01');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)->where('division_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }

        if ($query == 'PANDING_CASE_AT_ASST_GCO') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)->where('division_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }
        if ($query == 'CLOSED_CASE_AT_GCC') {
            if (isset($data['date_start']) && isset($data['date_end'])) {

                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
            } else {
                $dateFrom = 0;
                $dateTo = 0;
            }

            $strt = date('Y-m-01');
            $end = date('Y-m-d');

            // dd($id);
            $query = DB::table('gcc_appeals')
                ->where('gcc_appeals.appeal_status', $status)->where('division_id', $id);
            if ($dateFrom != 0 && $dateTo != 0) {
                $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
            }

            return $query->count();
        }
    }




    public function payment_claimed_amount_count_by_division($id, $data)
    {
        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;
        }
        $query = DB::table('gcc_appeals')->where('division_id', $id)->whereNotIn('appeal_status', ['REJECTED', 'DRAFT']);
        // dd($dateFrom);
        if ($dateFrom != 0 && $dateTo != 0) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->sum('loan_amount');
        // return $query;
    }


    public function payment_received_amount_count_by_division($id, $data)
    {
        // dd($id);
        $query = DB::table('gcc_appeals')->where('division_id', $id)->whereNotIn('appeal_status', ['REJECTED'])->select('id');
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        $appealId = $query->get();

        $sum = 0;
        foreach ($appealId as $value) {
            $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');
            $sum = $sum + $query;
        }

        return $sum;
        // return $query;
    }



    public function payment_claimed_amount_count_by_district($id, $data)
    {
        // dd($id);
        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;
        }
        $query = DB::table('gcc_appeals')->where('district_id', $id)->whereNotIn('appeal_status', ['REJECTED']);
        if ($dateFrom != 0 && $dateTo != 0) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->sum('loan_amount');
        // return $query;
    }



    public function payment_received_amount_count_by_district($id, $data)
    {
        $query = DB::table('gcc_appeals')->where('district_id', $id)->whereNotIn('appeal_status', ['REJECTED'])->select('id');
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        $appealId = $query->get();

        $sum = 0;
        foreach ($appealId as $value) {
            $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');
            $sum = $sum + $query;
        }

        return $sum;
    }






    public function payment_claimed_amount_count_by_upazila($id, $data)
    {
        // dd($id);
        if (isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        } else {
            $dateFrom = 0;
            $dateTo = 0;
        }
        $query = DB::table('gcc_appeals')->where('upazila_id', $id)->whereNotIn('appeal_status', ['REJECTED']);
        if ($dateFrom != 0 && $dateTo != 0) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->sum('loan_amount');
        // return $query;
    }



    public function payment_received_amount_count_by_upazila($id, $data)
    {
        
        $query = DB::table('gcc_appeals')->where('upazila_id', $id)->whereNotIn('appeal_status', ['REJECTED'])->select('id');
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            // dd($dateFrom);
            $query->whereBetween('gcc_appeals.case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        $appealId = $query->get();

        $sum = 0;
        foreach ($appealId as $value) {
            $query = DB::table('gcc_payment_lists')->where('appeal_id', $value->id)->sum('paid_loan_amount');
            $sum = $sum + $query;
        }

        return $sum;
    }


    public function generatePDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-L',
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }


    public function generatePamentPDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->btnsubmit == 'pdf_division') {
            $data['page_title'] = 'বিভাগ ভিত্তিক রিপোর্ট'; //exit;
            $html = view('report.pdf_division')->with($data);
            // echo 'hello';

            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 12,
                'default_font' => 'kalpurush',
            ]);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //    public function index()
    //    {
    //       //
    //    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
