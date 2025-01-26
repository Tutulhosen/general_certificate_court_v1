<?php

/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 12/12/17
 * Time: 12:56 PM
 */

namespace App\Http\Controllers;

use App\Models\GccAppeal;
use App\Repositories\AppealListRepository;
use App\Repositories\AppealRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AppealListController extends Controller
{
    public $permissionCode = 'certificateList';

    public function index(Request $request)
    {

        $date = date($request->date);
        $caseStatus = 1;
        $userRole = globalUserInfo()->role_id;
        // dd($userRole);
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Auth::user()->username;
        }
        if ($userRole == 6) {
            // $results=[];
            $page_title = 'চলমান আপিল মামলার তালিকা';
        } else {
            $page_title = 'চলমান মামলার তালিকা';
        }
        $results = AppealListRepository::RoleWaysRunningAppealList();
        //    dd($date);
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function all_case(Request $request)
    {
        // dd(1);
        $date = date($request->date);
        $caseStatus = 1;
        $userRole = globalUserInfo()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Auth::user()->username;
        }
        $results = AppealListRepository::RoleWaysAllAppealList();
        $page_title = 'সকল মামলার তালিকা';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
    public function pending_list(Request $request)
    {
        $date = date($request->date);
        $caseStatus = 'PENDING';
        $userRole = globalUserInfo()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Auth::user()->username;
        }
        $results = AppealListRepository::RoleWaysPendingAppealList();
        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {

            $page_title = 'গ্রহণের জন্য অপেক্ষমান রিকুইজিশনের তালিকা';
        } else {
            $page_title = 'গ্রহণের জন্য অপেক্ষমান মামলার তালিকা';
        }
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
    public function closed_list(Request $request)
    {
        $results = AppealListRepository::RoleWaysClosedAppealList();
        // dd($request);
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;

        $gcoUserName = '';
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }
        $page_title = 'নিষ্পত্তিকৃত মামলার তালিকা';
        //return view('appealList.appeallist')->with('date',$date);
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
    public function trial_date_list(Request $request)
    {
        $results = AppealListRepository::RoleWaysTrialAppealList();
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
        $page_title = ' শুনানির তারিখ হয়েছে এমন মামলার তালিকা';
        //return view('appealList.appeallist')->with('date',$date);
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
    public function appeal_with_action_required(Request $request)
    {

        $results = AppealListRepository::RoleWaysActionRequiredAppealList();
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
        $page_title = ' চলমান মামলাতে পদক্ষেপ নিতে হবে';
        //return view('appealList.appeallist')->with('date',$date);
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function draft_list(Request $request)
    {
        $date = date($request->date);
        $caseStatus = 1;
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Auth::user()->username;
        }
        $results = AppealListRepository::RoleWaysDraftAppealList();
        $page_title = 'খসড়া মামলার তালিকা';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
    public function rejected_list(Request $request)
    {
        $results = GccAppeal::orderby('id', 'desc')->where('appeal_status', 'REJECTED');

        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {
            $results = $results->where('court_id', globalUserInfo()->court_id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 6) {
            $results = $results->where('district_id', user_district()->id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 34) {
            $results = $results->where('division_id', user_office_info()->division_id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 25) {
            $results = $results->where('updated_by', globalUserInfo()->id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } else {
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('appeal_status', 'REJECTED')->where('case_no', '=', $_GET['case_no']);
            }
        }

        $results = $results->paginate(10);

        $date = date($request->date);
        $caseStatus = 1;
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Auth::user()->username;
        }
        $page_title = 'বর্জনকৃত মামলার তালিকা';
        // return $results;
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function postponed_list(Request $request)
    {
        $results = GccAppeal::orderby('id', 'desc')
            ->where('appeal_status', 'POSTPONED')
            ->paginate(20);
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = GccAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'POSTPONED')
                ->whereBetween('case_date', [$dateFrom, $dateTo])
                ->paginate(10);
        }
        if (!empty($_GET['case_no'])) {
            $results = GccAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'POSTPONED')
                ->where('case_no', '=', $_GET['case_no'])
                ->paginate(10);
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
        //return view('appealList.appeallist')->with('date',$date);
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function arrest_warrent_list(Request $request)
    {
        // $results = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->paginate(20);
        $results = DB::table('gcc_case_shortdecision_templates')
            ->join('gcc_appeals', 'gcc_case_shortdecision_templates.appeal_id', '=', 'gcc_appeals.id')
            ->select('gcc_case_shortdecision_templates.appeal_id', 'gcc_case_shortdecision_templates.template_name', 'gcc_case_shortdecision_templates.template_full', 'gcc_appeals.*')
            ->where('gcc_case_shortdecision_templates.case_shortdecision_id', 7)
            ->orderby('gcc_appeals.id', 'DESC')
            ->paginate(10);
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = DB::table('gcc_case_shortdecision_templates')
                ->join('gcc_appeals', 'gcc_case_shortdecision_templates.appeal_id', '=', 'gcc_appeals.id')
                ->select('gcc_case_shortdecision_templates.appeal_id', 'gcc_case_shortdecision_templates.template_name', 'gcc_case_shortdecision_templates.template_full', 'gcc_appeals.*')
                ->where('gcc_case_shortdecision_templates.case_shortdecision_id', 7)
                ->whereBetween('gcc_appeals.next_date', [$dateFrom, $dateTo])
                ->orderby('gcc_appeals.id', 'DESC')
                ->paginate(10);
        }
        if (!empty($_GET['case_no'])) {
            $results = DB::table('gcc_case_shortdecision_templates')
                ->join('gcc_appeals', 'gcc_case_shortdecision_templates.appeal_id', '=', 'gcc_appeals.id')
                ->select('gcc_case_shortdecision_templates.appeal_id', 'gcc_case_shortdecision_templates.template_name', 'gcc_case_shortdecision_templates.template_full', 'gcc_appeals.*')
                ->where('gcc_case_shortdecision_templates.case_shortdecision_id', 7)
                ->where('gcc_appeals.case_no', '=', $_GET['case_no'])
                ->orderby('gcc_appeals.id', 'DESC')
                ->paginate(10);
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
        $page_title = ' গ্রেপ্তারি পরোয়ানা জারি হয়েছে এমন মামলার তালিকা';
        // return $results;
        //return view('appealList.appeallist')->with('date',$date);
        return view('appealList.appealCasewiseWarrentList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
    public function crock_order_list(Request $request)
    {
        // $results = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->paginate(20);
        $results = DB::table('gcc_case_shortdecision_templates')
            ->join('gcc_appeals', 'gcc_case_shortdecision_templates.appeal_id', '=', 'gcc_appeals.id')
            ->select('gcc_case_shortdecision_templates.appeal_id', 'gcc_case_shortdecision_templates.template_name', 'gcc_case_shortdecision_templates.template_full', 'gcc_appeals.*')
            ->where('gcc_case_shortdecision_templates.case_shortdecision_id', 9)
            ->orderby('gcc_appeals.id', 'DESC')
            ->paginate(20);
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = DB::table('gcc_case_shortdecision_templates')
                ->join('gcc_appeals', 'gcc_case_shortdecision_templates.appeal_id', '=', 'gcc_appeals.id')
                ->select('gcc_case_shortdecision_templates.appeal_id', 'gcc_case_shortdecision_templates.template_name', 'gcc_case_shortdecision_templates.template_full', 'gcc_appeals.*')
                ->where('gcc_case_shortdecision_templates.case_shortdecision_id', 9)
                ->whereBetween('gcc_appeals.next_date', [$dateFrom, $dateTo])
                ->orderby('gcc_appeals.id', 'DESC')
                ->paginate(10);
        }
        if (!empty($_GET['case_no'])) {
            $results = DB::table('gcc_case_shortdecision_templates')
                ->join('gcc_appeals', 'gcc_case_shortdecision_templates.appeal_id', '=', 'gcc_appeals.id')
                ->select('gcc_case_shortdecision_templates.appeal_id', 'gcc_case_shortdecision_templates.template_name', 'gcc_case_shortdecision_templates.template_full', 'gcc_appeals.*')
                ->where('gcc_case_shortdecision_templates.case_shortdecision_id', 9)
                ->where('gcc_appeals.case_no', '=', $_GET['case_no'])
                ->orderby('gcc_appeals.id', 'DESC')
                ->paginate(10);
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
        $page_title = ' অস্থাবর সম্পত্তি ক্রোকের আদেশ হয়েছে এমন মামলার তালিকা';
        // return $results;
        //return view('appealList.appeallist')->with('date',$date);
        return view('appealList.appealCasewiseCrockList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function review_appeal_list(Request $request)
    {
        // $results = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->paginate(20);
        $results = GccAppeal::orderby('id', 'desc')
            ->whereIn('appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM'])
            ->where('court_id', globalUserInfo()->court_id)
            ->where('is_applied_for_review', 1)
            ->paginate(10);
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = GccAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM'])
                ->where('court_id', globalUserInfo()->court_id)
                ->where('is_applied_for_review', 1)
                ->whereBetween('gcc_appeals.next_date', [$dateFrom, $dateTo])
                ->paginate(10);
        }
        if (!empty($_GET['case_no'])) {
            $results = GccAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_LAB_CM'])
                ->where('court_id', globalUserInfo()->court_id)
                ->where('is_applied_for_review', 1)
                ->where('gcc_appeals.case_no', '=', $_GET['case_no'])
                ->paginate(10);
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
        $page_title = ' রিভিউ এর জন্য আবেদন করেছে এমন মামলা ';
        // return $results;
        //return view('appealList.appeallist')->with('date',$date);
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function appealData(Request $request)
    {
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
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus'));
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
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus'));
    }


    public function currentAppealEntryList(Request $request)
    {


        $date = date($request->date);
        $caseStatus = 1;
        $userRole = globalUserInfo()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Auth::user()->username;
        }

        $results = GccAppeal::orderby('id', 'desc');

        if (globalUserInfo()->role_id == 28) {
            $results = $results->where('case_entry_type','RUNNING')->whereIn('appeal_status', ['DRAFT_FOR_RUNNING_ENTRY_CASE'])->where('court_id', globalUserInfo()->court_id);
        }
        if (!empty($_GET['case_no'])) {
            $results = $results->where('case_no', 'LIKE', '%' . $_GET['case_no'] . '%')->orWhere('manual_case_no', 'LIKE', '%' . $_GET['case_no'] . '%');
        }
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
        }

        $results = $results->paginate(10);


        $page_title = 'পুরাতন চলমান মামলার তালিকা';

        return view('appealList.currentAppealEntryList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
}