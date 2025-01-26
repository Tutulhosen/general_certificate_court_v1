<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\GccAppeal;
use App\Models\CaseHearing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use GrahamCampbell\ResultType\Result;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\AppealListRepository;
use App\Services\ShortOrderTemplateService;
use App\Repositories\CertificateAsstNoteRepository;
use App\Http\Resources\calendar\CaseHearingCollection;

class CauseListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $data['divisions'] = DB::table('division')
            ->select('id', 'division_name_bn')
            ->get();
        $division_name = null;
        $district_name = null;
        $court_name = null;

        $all_appeal = GccAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->whereIn('appeal_status', ['ON_TRIAL'])->get();
        $appeal_array = [];
        foreach ($all_appeal as $appeal_single) {
            $exists = DB::table('gcc_manual_causelist')->where('case_no', '=', $appeal_single->case_no)->first();

            if (empty($exists)) {
                // dd($appeal_single->case_no);
                DB::table('gcc_manual_causelist')->insert([
                    'case_no' => $appeal_single->case_no,
                    'appeal_id' => $appeal_single->id,
                    'court_id' => $appeal_single->court_id,
                    'division_id' => $appeal_single->division_id,
                    'district_id' => $appeal_single->district_id,
                    'upazila_id' => $appeal_single->upazila_id,
                    'next_date' => $appeal_single->next_date,
                    'type'     => 1
                ]);
            }
        }


        $causelistdata = DB::table('gcc_manual_causelist')
            ->leftJoin('gcc_appeals', 'gcc_appeals.id', '=', 'gcc_manual_causelist.appeal_id')
            ->leftJoin('custom_causelist', 'custom_causelist.id', '=', 'gcc_manual_causelist.causelist_id')
            ->select(
                'gcc_appeals.appeal_status',
                'gcc_appeals.next_date',
                'gcc_appeals.case_entry_type',
                'gcc_appeals.manual_case_no',
                'gcc_manual_causelist.case_no as caseno',
                'gcc_manual_causelist.appeal_id as appealid',
                'gcc_manual_causelist.type',
                'gcc_manual_causelist.causelist_id',
                'gcc_manual_causelist.division_id',
                'gcc_manual_causelist.district_id',
                'gcc_manual_causelist.court_id',
                'gcc_manual_causelist.next_date',
                'custom_causelist.defaulter_name',
                'custom_causelist.org_representative'
            );

        // dd($causelistdata->get());
        // dd($request->division);
        if (!empty($_GET['division'])) {
            $causelistdata = $causelistdata->where('gcc_manual_causelist.division_id', '=', $request->division);
        }
        if (!empty($_GET['district'])) {
            $causelistdata = $causelistdata->where('gcc_manual_causelist.district_id', '=', $_GET['district']);
        }
        if (!empty($_GET['court'])) {
            $causelistdata = $causelistdata->where('gcc_manual_causelist.court_id', '=', $_GET['court']);
        }

        if (!empty($_GET['case_no'])) {
            $causelistdata = $causelistdata->where('gcc_manual_causelist.case_no', 'like', '%' . bn2en($_GET['case_no']) . '%')->orWhere('manual_case_no', '=', $_GET['case_no']);
        }

        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $causelistdata = $causelistdata->whereBetween('gcc_manual_causelist.next_date', [$dateFrom, $dateTo]);
        }

        if (empty($_GET['division']) && empty($_GET['district']) && empty($_GET['court']) && empty($_GET['case_no']) && empty($_GET['date_start']) && empty($_GET['date_end'])) {
            $causelistdata = $causelistdata->where('gcc_manual_causelist.next_date', $dateFrom);
        }



        $data['causelistdata'] = $causelistdata->orderBy('gcc_manual_causelist.id', 'desc')->paginate(10)->withQueryString();

        $data['dateFrom'] = $dateFrom;
        $data['dateTo'] = $dateTo;
        $data['division_name'] = $division_name;
        $data['district_name'] = $district_name;
        $data['court_name'] = $court_name;
        $data['page_title'] = 'মামলার কার্যতালিকা';
        $data['running_case_paginate'] = DB::table('gcc_manual_causelist')->count();
        // dd($data);
        return view('causeList.appealCauseList1')->with($data);
    }
    public function indexdd()
    {

        $all_appeal = GccAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->whereIn('appeal_status', ['ON_TRIAL'])->get();

        $appeal_array = [];
        foreach ($all_appeal as $appeal_single) {
            $exists = DB::table('gcc_manual_causelist')->where('case_no', '=', $appeal_single->case_no)->first();

            if (empty($exists)) {
                // dd($appeal_single->case_no);
                DB::table('gcc_manual_causelist')->insert([
                    'case_no' => $appeal_single->case_no,
                    'appeal_id' => $appeal_single->id
                ]);
            }
        }


        //
        $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $data['divisions'] = DB::table('division')
            ->select('id', 'division_name_bn')
            ->get();
        $division_name = null;
        $district_name = null;
        $court_name = null;




        $custom_couselist = DB::table('custom_causelist');
        if (!empty($_GET['division'])) {
            $appeal =  $custom_couselist->where('div_id', '=', $_GET['division']);
        }
        if (!empty($_GET['district'])) {


            $appeal =  $custom_couselist->where('dis_id', '=', $_GET['district']);
        }
        if (!empty($_GET['court'])) {

            //dd($court_details);
            $appeal =  $custom_couselist->where('court_id', '=', $_GET['court']);
        }

        if (!empty($_GET['case_no'])) {
            $appeal =  $custom_couselist->where('case_no', 'like', '%' . bn2en($_GET['case_no']) . '%');
        }

        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $appeal =  $custom_couselist->whereBetween('last_order_date', [$dateFrom, $dateTo]);
        }


        if (empty($_GET['division']) && empty($_GET['district']) && empty($_GET['court']) && empty($_GET['case_no']) && empty($_GET['date_start']) && empty($_GET['date_end'])) {
            $appeal =  $custom_couselist->where('last_order_date', $dateFrom);
        }
        if (!empty($_GET['offset'])) {
            $offset = $_GET['offset'] - 1;
            $offset = $offset * 10;
            $custom_couselists = $appeal
                ->limit(10)
                ->offset($offset)
                ->get();
        } else {
            $offset = 0;
            $custom_couselists = $appeal
                ->get();
        }


        foreach ($custom_couselists  as $key => $value) {
            $notes = DB::table('causelist_order')->where('causelist_id', $value->id)->orderby('id', 'desc')->first();

            $customdata = [
                'next_date' => $value->last_order_date,
                'case_no' => $value->case_no,
                'manual_case_no' => '',
                'appeal_status' => '',
                'applicant_name' => 'one',
                'defaulter_name' => 'two',
                'case_date' => $value->appeal_date,
            ];

            if (isset($value) && !empty($value)) {
                $citizen_info = $customdata;
            } else {
                $citizen_info = null;
            }
            if (isset($notes) && !empty($notes)) {
                $notes = $notes;
            } else {
                $notes = null;
            }

            $lists['coselist1'][$key]['citizen_info'] = $citizen_info;
            $lists['coselist1'][$key]['notes'] = $notes;
        }

        $case_for_cose_list = AppealListRepository::case_for_cose_list_new();
        if (!empty($_GET['offset'])) {
            $offset = $_GET['offset'] - 1;
            $offset = $offset * 10;
            $case_for_cose_lists = $case_for_cose_list
                ->limit(8)
                ->offset($offset)
                ->get();
        } else {
            $offset = 0;
            $case_for_cose_lists = $case_for_cose_list
                ->limit(8)
                ->get();
        }

        $list = [];
        foreach ($case_for_cose_lists as $key => $value) {
            $citizen_info = AppealRepository::getCauselistCitizen($value->id);
            $notes = CertificateAsstNoteRepository::get_last_order_list($value->id);
            if (isset($citizen_info) && !empty($citizen_info)) {
                $citizen_info = $citizen_info;
            } else {
                $citizen_info = null;
            }
            if (isset($notes) && !empty($notes)) {
                $notes = $notes;
            } else {
                $notes = null;
            }

            $list['coselist2'][$key]['citizen_info'] = $citizen_info;
            $list['coselist2'][$key]['notes'] = $notes;
        }

        //    dd($lists['coselist1']);
        if (!empty($lists['coselist1']) && !empty($list['coselist2'])) {
            $cose_list =  array_merge($lists['coselist1'], $list['coselist2']);
            $data['cose_list'] = $cose_list;
            $calist =  count($cose_list);
        } elseif (empty($lists['coselist1']) && !empty($list['coselist2'])) {

            $data['cose_list'] = $list['coselist2'];
            $calist =  $case_for_cose_list->count();
        } else {
            $data['cose_list'] = [];
            $calist = $case_for_cose_list->count();
        }

        // dd( $data['cose_list']);
        $data['running_case_paginate'] = $calist; // $case_for_cose_list->count();

        // dd($case_for_cose_list);
        // $appeal = GccAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->whereIn('appeal_status', ['ON_TRIAL']);



        // if (!empty($_GET['division'])) {
        //     $division_name = DB::table('division')
        //         ->select('division_name_bn')
        //         ->where('id', $_GET['division'])
        //         ->first()->division_name_bn;

        //     $appeal = $appeal->where('division_id', '=', $_GET['division']);
        // }
        // if (!empty($_GET['district'])) {
        //     $district_name = DB::table('district')
        //         ->select('district_name_bn')
        //         ->where('id', $_GET['district'])
        //         ->first()->district_name_bn;

        //     $appeal = $appeal->where('district_id', '=', $_GET['district']);
        // }
        // if (!empty($_GET['court'])) {
        //     $court_details = DB::table('court')
        //         ->where('id', $_GET['court'])
        //         ->first();
        //     $court_name = $court_details->court_name;
        //     //dd($court_details);
        //     $appeal = $appeal->where('court_id', '=', $_GET['court']);
        // }
        // if (!empty($_GET['case_no'])) {
        //     $appeal = $appeal->where('case_no', 'like','%'. bn2en($_GET['case_no']) .'%')->orWhere('manual_case_no', 'like','%'. $_GET['case_no'].'%');
        // }

        // if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
        //     $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
        //     $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
        //     $appeal = $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
        // }

        // if (!empty($_GET['offset'])) {
        //     $offset = $_GET['offset'] - 1;
        //     $offset = $offset * 10;
        // } else {
        //     $offset = 0;
        // }

        // $data['running_case_paginate'] = $appeal->count();

        // $appeal = $appeal
        //     ->offset($offset)
        //     ->limit(10)
        //     ->get();

        //     if ($appeal != null || $appeal != '') {
        //     foreach ($appeal as $key => $value) {
        //         $citizen_info=AppealRepository::getCauselistCitizen($value->id);
        //         $notes=CertificateAsstNoteRepository::get_last_order_list($value->id);

        //         if(isset($citizen_info) && !empty($citizen_info))
        //         {
        //             $citizen_info=$citizen_info;
        //         }
        //         else
        //         {
        //             $citizen_info=null;
        //         }
        //         if(isset($notes) && !empty($notes))
        //         {
        //             $notes=$notes;
        //         }
        //         else
        //         {
        //             $notes=null;
        //         }

        //         $data['appeal'][$key]['citizen_info'] = $citizen_info;
        //         $data['appeal'][$key]['notes'] =$notes; 
        //         // $data["notes"] = $value->appealNotes;

        //     }
        // } else {

        //     $data['appeal'][$key]['citizen_info'] = '';
        //     $data['appeal'][$key]['notes'] = '';
        // }

        $data['dateFrom'] = $dateFrom;
        $data['dateTo'] = $dateTo;
        $data['division_name'] = $division_name;
        $data['district_name'] = $district_name;
        $data['court_name'] = $court_name;
        // $data['case_for_cose_list']=$case_for_cose_list;
        $data['page_title'] = 'মামলার কার্যতালিকা';

        // $data['offset_page'] = $offset;
        //dd($data);

        return view('causeList.appealCauseList')->with($data);
    }


    public function paginate_causelist_auth_user(Request $request)
    {
        $role_id = globalUserInfo()->role_id;

        $page_no = $request->page_no - 1;
        $offset = $page_no * 10;

        if ($role_id == 27 || $role_id == 28) {

            $appeal = GccAppeal::whereIn('appeal_status', ['ON_TRIAL'])
                ->where('court_id', '=', globalUserInfo()->court_id)
                ->offset($offset)
                ->limit(10)
                ->get();
        } elseif ($role_id == 36) {
            $appeal_no = DB::table('gcc_appeals')
                ->join('gcc_appeal_citizens', 'gcc_appeals.id', '=', 'gcc_appeal_citizens.appeal_id')
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
                ->whereIn('appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
                ->where('gcc_appeal_citizens.citizen_id', globalUserInfo()->citizen_id)
                ->select('gcc_appeals.id as appeal_id')
                ->get();

            $cause_list_ids = [];
            if (!empty($appeal_no)) {
                foreach ($appeal_no as $value) {
                    array_push($cause_list_ids, $value->appeal_id);
                }
            }

            $appeal = GccAppeal::whereIn('id', $cause_list_ids)
                ->offset($offset)
                ->limit(10)
                ->get();
        } elseif ($role_id == 35) {
            $appeal_no = DB::table('gcc_appeals')
                ->join('gcc_appeal_citizens', 'gcc_appeals.id', '=', 'gcc_appeal_citizens.appeal_id')
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [1])
                ->whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])
                ->where('gcc_appeal_citizens.citizen_id', globalUserInfo()->citizen_id)
                ->select('gcc_appeals.id as appeal_id')
                ->get();

            $cause_list_ids = [];
            if (!empty($appeal_no)) {
                foreach ($appeal_no as $value) {
                    array_push($cause_list_ids, $value->appeal_id);
                }
            }

            $appeal = GccAppeal::whereIn('id', $cause_list_ids)
                ->offset($offset)
                ->limit(10)
                ->get();
        }

        if ($appeal != null || $appeal != '') {
            foreach ($appeal as $key => $value) {
                $citizen_info = AppealRepository::getCauselistCitizen($value->id);
                $notes = CertificateAsstNoteRepository::get_last_order_list($value->id);
                if (isset($citizen_info) && !empty($citizen_info)) {
                    $citizen_info = $citizen_info;
                } else {
                    $citizen_info = null;
                }
                if (isset($notes) && !empty($notes)) {
                    $notes = $notes;
                } else {
                    $notes = null;
                }

                $appeal[$key]['citizen_info'] = $citizen_info;
                $appeal[$key]['notes'] = $notes;
                // $data["notes"] = $value->appealNotes;
            }
        } else {

            $appeal = [];
            //$appeal[$key]['notes'] = '';
        }
        //dd($appeal);

        $html = '';

        $html .= '<table class="table mb-6 font-size-h5">
       <thead class="thead-customStyleCauseList font-size-h6 text-center">
           <tr>
               <th scope="col" width="100">ক্রমিক নং</th>
               <th scope="col">মামলা নম্বর</th>
               <th scope="col">পক্ষ </th>
               <!-- <th scope="col">অ্যাডভোকেট </th> -->
               <th scope="col">পরবর্তী তারিখ</th>
               <th scope="col">সর্বশেষ আদেশ</th>
           </tr>
       </thead>';
        if (!empty($appeal)) {
            foreach ($appeal as $key => $value) {
                $html .= '<tbody>';
                $html .= '<tr>';
                $html .= '<td scope="row" class="text-center">' . en2bn($key + $offset + 1) . '</td>';
                $html .= '<td class="text-center">' . en2bn($value['citizen_info']['case_no']) . '</td>';
                $html .= '<td class="text-center">';
                if (isset($value['citizen_info']['applicant_name'])) {
                    $html .= $value['citizen_info']['applicant_name'];
                } else {
                    $html .= '---';
                }
                $html .= '<br> <b>vs</b><br>';
                if (isset($value['citizen_info']['defaulter_name'])) {
                    $html .= $value['citizen_info']['defaulter_name'];
                } else {
                    $html .= '---';
                }
                $html .= '</td>';

                if ($value['citizen_info']['appeal_status'] == 'ON_TRIAL' || $value['citizen_info']['appeal_status'] == 'ON_TRIAL_DM') {
                    if (date('Y-m-d', strtotime(now())) == $value['citizen_info']['next_date']) {
                        $html .= '<td class="blink_me text-danger"><span>*</span>' . en2bn($value['citizen_info']['next_date']) . '<span>*</span></td>';
                    } else {
                        $html .= '<td>' . en2bn($value['citizen_info']['next_date']) . '</td>';
                    }
                } else {
                    $html .= '<td class="text-danger">' . appeal_status_bng($value['citizen_info']['appeal_status']) . '</td>';
                }

                $html .= '<td class="text-center">';
                if (isset($value['notes']->short_order_name)) {
                    $html .= $value['notes']->short_order_name;
                } else {
                    $html .= '----';
                }
                $html .= '</td>';
                $html .= '</tr></tbody>';
            }
        } else {
            $html .= '<p>কোনো তথ্য খুঁজে পাওয়া যায় নি </p>';
        }

        return response()->json([
            'success' => 'success',
            'html' => $html,
        ]);
    }

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
