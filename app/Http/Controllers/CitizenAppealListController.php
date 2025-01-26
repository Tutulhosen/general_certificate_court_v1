<?php

namespace App\Http\Controllers;

use App\Models\GccAppeal;
use App\Repositories\AppealRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class citizenAppealListController extends Controller
{
    public $permissionCode = 'certificateList';

    public function index(Request $request)
    {
        $user = globalUserInfo();

        if ($user->role_id == 35) {
            $total_case = [];
            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [1,2,5])
                ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif ($user->role_id == 36) {
            $total_case = [];
            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
                ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        }

        $date = date($request->date);
        $caseStatus = 1;
        $userRole = $user->role_id;
        $gcoUserName = '';

        $page_title = 'চলমান মামলার তালিকা';
        return view('citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function all_case(Request $request)
    {
        $user = globalUserInfo();

        if (globalUserInfo()->role_id == 35) {
            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [1,2,5])
                ->whereIn('gcc_appeals.appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif ($user->role_id == 36) {
            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
                ->whereIn('gcc_appeals.appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        }

        $date = date($request->date);
        $caseStatus = 1;
        $userRole = $user->role_id;
        $gcoUserName = '';
        // return $results;
        $page_title = 'সকল মামলার তালিকা';

        return view('citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function pending_list(Request $request)
    {
        $user = globalUserInfo();
// dd($user);
        if ($user->role_id == 35) {
            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [1,2,5])
                ->whereIn('gcc_appeals.appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM','SEND_TO_GCO', 'SEND_TO_ASST_GCO'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif ($user->role_id == 36) {
            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
                ->whereIn('gcc_appeals.appeal_status', ['SEND_TO_DIV_COM', 'SEND_TO_DC', 'SEND_TO_LAB_CM'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        }

        $date = date($request->date);
        $caseStatus = 1;
        $userRole = $user->role_id;
        $gcoUserName = '';

        $page_title = 'গ্রহণের জন্য অপেক্ষমান রিকুইজিশনের তালিকা';
        return view('citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
    public function closed_list(Request $request)
    {
        $user = globalUserInfo();

        if ($user->role_id == 35) {
            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [1,2,5])
                ->whereIn('gcc_appeals.appeal_status', ['CLOSED'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif ($user->role_id == 36) {
            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
                ->whereIn('gcc_appeals.appeal_status', ['CLOSED'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        }

        $date = date($request->date);
        $caseStatus = 1;
        $userRole = $user->role_id;
        $gcoUserName = '';
        $page_title = 'নিষ্পত্তি মামলার তালিকা';
        return view('citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
    public function trial_date_list(Request $request)
    {
        $user = globalUserInfo();
        $appeal_no = array();
        if ($user->role_id == 35) {

            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [1,2,5])
                ->where('is_hearing_required', 1)
                ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->where('next_date', date('Y-m-d', strtotime(now())));
            $results = $results->paginate(10);

        } else {
            $total_case = [];

            $appeal_ids_from_db = DB::table('gcc_appeal_citizens')
                ->join('gcc_citizens', 'gcc_citizens.id', '=', 'gcc_appeal_citizens.citizen_id')
                ->join('gcc_appeals', 'gcc_appeal_citizens.appeal_id', 'gcc_appeals.id')
                ->where('gcc_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('gcc_appeal_citizens.citizen_type_id', [2, 5])
                ->where('is_hearing_required', 1)
                ->whereIn('gcc_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DC', 'ON_TRIAL_LAB_CM', 'ON_TRIAL_DIV_COM'])
                ->select('gcc_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = GccAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->where('next_date', date('Y-m-d', strtotime(now())));
            $results = $results->paginate(10);
        }
        // dd($results);
        $date = date($request->date);
        $caseStatus = 1;
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Auth::user()->username;
        }
        $page_title = 'শুনানির তারিখ হয়েছে এমন মামলার তালিকা';
        return view('citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function draft_list(Request $request)
    {
        $user = globalUserInfo();
        $results = GccAppeal::orderby('id', 'DESC')->where('created_by', $user->id)->where('appeal_status', 'DRAFT')->paginate(10);

        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = GccAppeal::orderby('case_date', 'ASC')->where('created_by', $user->id)->where('appeal_status', 'DRAFT')->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(10);
        }
        if (!empty($_GET['case_no'])) {
            $results = GccAppeal::orderby('case_date', 'ASC')->where('created_by', $user->id)->where('appeal_status', 'DRAFT')->where('case_no', '=', $_GET['case_no'])->paginate(10);
        }
        // return $results->appealCitizens;
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }
        $page_title = 'খসড়া মামলার তালিকা';
        // return view('citizenAppealList.appeallist')->with('date',$date);
        return view('citizenAppealList.appealDraftList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
    public function rejected_list(Request $request)
    {
        $user = globalUserInfo();
        $results = GccAppeal::orderby('case_date', 'ASC')->where('created_by', $user->id)->where('appeal_status', 'REJECTED')->paginate(20);
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = GccAppeal::orderby('case_date', 'ASC')->where('created_by', $user->id)->where('appeal_status', 'REJECTED')->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(10);
        }
        if (!empty($_GET['case_no'])) {
            $results = GccAppeal::orderby('case_date', 'ASC')->where('created_by', $user->id)->where('appeal_status', 'REJECTED')->where('case_no', '=', $_GET['case_no'])->paginate(10);
        }
        $date = date($request->date);
        $caseStatus = 1;
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Auth::user()->username;
        }
        $page_title = 'বর্জনকৃত মামলার তালিকা';
        // return $results;
        return view('citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function postponed_list(Request $request)
    {
        $user = globalUserInfo();
        $results = GccAppeal::orderby('case_date', 'ASC')->where('created_by', $user->id)->where('appeal_status', 'POSTPONED')->paginate(20);
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = GccAppeal::orderby('case_date', 'ASC')->where('appeal_status', 'POSTPONED')->whereBetween('case_date', [$dateFrom, $dateTo])->where('created_by', $user->id)->paginate(10);
        }
        if (!empty($_GET['case_no'])) {
            $results = GccAppeal::orderby('case_date', 'ASC')->where('created_by', $user->id)->where('appeal_status', 'POSTPONED')->where('case_no', '=', $_GET['case_no'])->paginate(10);
        }
        // return $results->appealCitizens;
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }
        $page_title = ' মুলতবি মামলার তালিকা';
        //return view('citizenAppealList.appeallist')->with('date',$date);
        return view('citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function appealData(Request $request)
    {
        $user = globalUserInfo();
        $usersPermissions = Session::get('userPermissions');
        $appeals = AppealRepository::getAppealListBySearchParam($request);

        return response()->json([
            'data' => $appeals,
            'userPermissions' => $usersPermissions,
            'userName' => Session::get('userInfo')->username,

        ]);
    }

    public function closedList(Request $request)
    {
        $date = date($request->date);
        $caseStatus = 3;
        $userRole = Session::get('userRole');
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Session::get('userInfo')->username;
        }
        return view('citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus'));

    }

    public function postponedList(Request $request)
    {
        $date = date($request->date);
        $caseStatus = 2;
        $userRole = Session::get('userRole');
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Session::get('userInfo')->username;
        }
        return view('citizenAppealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus'));
    }
}