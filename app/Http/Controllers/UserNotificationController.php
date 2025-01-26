<?php

namespace App\Http\Controllers;

use App\Models\CaseHearing;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RM_CaseHearing;
use App\Models\CaseRegister;
use Psr\Http\Message\RequestInterface;

class UserNotificationController extends Controller
{
    public function results_completed()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();

        // All user list
        $query = DB::table('case_register')
        ->orderBy('id','DESC')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->join('district', 'case_register.district_id', '=', 'district.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        ->select('case_register.*', 'court.court_name', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn')
        ->where('case_register.status', '!=', 1);

        //Add Conditions
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $query->whereBetween('case_register.case_date', [$dateFrom, $dateTo]);
        }
        if(!empty($_GET['role'])) {
            $query->where('case_register.action_user_group_id','=',$_GET['role']);
        }
        if(!empty($_GET['court'])) {
            $query->where('case_register.court_id','=',$_GET['court']);
        }
        if(!empty($_GET['case_no'])) {
            $query->where('case_register.case_number','=',$_GET['case_no']);
        }
        if(!empty($_GET['division'])) {
            $query->where('case_register.division_id','=',$_GET['division']);
        }
        if(!empty($_GET['district'])) {
            $query->where('case_register.district_id','=',$_GET['district']);
        }
        if(!empty($_GET['upazila'])) {
            $query->where('case_register.upazila_id','=',$_GET['upazila']);
        }
        if(!empty($_GET['gp'])) {
            $query->where('case_register.gp_user_id','=',$_GET['gp']);
        }
        $cases = $query->paginate(10);
        // Dorpdown
        $upazilas = NULL;
        $courts = DB::table('court')->select('id', 'court_name')->get();
        $divisions = DB::table('division')->select('id', 'division_name_bn')->get();
        $user_role = DB::table('role')->select('id', 'role_name')->get();

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            $upazilas = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11 || $roleID == 12){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
        }

        $gp_users = DB::table('users')->select('id', 'name')->where('role_id', 13)->get();

        $page_title = 'ফলাফল সম্পন্ন মামলা';
        return view('case.index', compact(['page_title', 'cases', 'divisions', 'upazilas', 'courts', 'gp_users', 'user_role']))
        ->with('i', (request()->input('page',1) - 1) * 10);
    }

    public function newSFdetails($id)
    {
        // $data['sflog'] = DB::table('case_sf_log')->select('case_sf_log.case_id', 'case_sf_log.sf_log_details')->where('case_sf_log.id', '=', $id)->first();
        // dd($data['sflog']->sf_log_details);

        // dd($id);
        $data['info'] = DB::table('case_register')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->leftJoin('users', 'case_register.gp_user_id', '=', 'users.id')
        ->join('division', 'case_register.division_id', '=', 'division.id')
        ->join('district', 'case_register.district_id', '=', 'district.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        ->join('role', 'case_register.action_user_group_id', '=', 'role.id')
        ->join('case_status', 'case_register.cs_id', '=', 'case_status.id')
        ->join('case_badi', 'case_register.id', '=', 'case_badi.case_id')
        ->join('case_bibadi', 'case_register.id', '=', 'case_bibadi.case_id')
        ->select('case_register.*', 'court.court_name','users.name', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'mouja.mouja_name_bn', 'case_status.status_name', 'role.role_name', 'case_badi.badi_name', 'case_badi.badi_spouse_name', 'case_badi.badi_address', 'case_bibadi.bibadi_name', 'case_bibadi.bibadi_spouse_name', 'case_bibadi.bibadi_address')
        ->where('case_register.id', '=', $id)
        ->first();

        $data['badis'] = DB::table('case_badi')
        ->join('case_register', 'case_badi.case_id', '=', 'case_register.id')
        ->select('case_badi.*')
        ->where('case_badi.case_id', '=', $id)
        ->get();

        $data['bibadis'] = DB::table('case_bibadi')
        ->join('case_register', 'case_bibadi.case_id', '=', 'case_register.id')
        ->select('case_bibadi.*')
        ->where('case_bibadi.case_id', '=', $id)
        ->get();

        // Get SF Signature
        $data['sf_signatures'] = DB::table('case_sf_log')
        ->select('case_sf_log.user_id', 'users.name', 'role.role_name', 'office.office_name_bn', 'users.signature')
        ->join('users', 'users.id', '=', 'case_sf_log.user_id')
        ->join('role', 'role.id', '=', 'users.role_id')
        ->join('office', 'office.id', '=', 'users.office_id')
        ->where('case_sf_log.case_id', '=', $id)
        ->groupBy('case_sf_log.user_id')
        ->get();

        $data['sf'] = DB::table('case_sf')
        ->select('case_sf.*')
        ->where('case_sf.case_id', '=', $id)
        ->first();


        $data['page_title'] = 'মামলার এস এফ লগের বিস্তারিত তথ্য'; //exit;
        return view('UserNotification.sf_details')->with($data);
    }

    public function hearing_date(Request $request)
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();

        $query = DB::table('case_hearing')
        ->orderBy('id','DESC')
        ->join('case_register', 'case_register.id', '=', 'case_hearing.case_id')
        ->select('case_hearing.*')
        ->where('case_register.status', 1)
        ->distinct('case_hearing.case_id');
        // ->unique('case_hearing.case_id');
         $query->get();

        $cases = CaseHearing::orderby('id', 'DESC')
        ->whereHas( 'case_register', function ($query) {
            $query->where('case_register.status', 1);
        })->groupBy('case_id')->get();

        //Add Conditions
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $query->whereBetween('case_register.case_date', [$dateFrom, $dateTo]);
        }
        if(!empty($_GET['role'])) {
            $query->where('case_register.action_user_group_id','=',$_GET['role']);
        }
        if(!empty($_GET['court'])) {
            $query->where('case_register.court_id','=',$_GET['court']);
        }
        if(!empty($_GET['case_no'])) {
            $query->where('case_register.case_number','=',$_GET['case_no']);
        }
        if(!empty($_GET['division'])) {
            $query->where('case_register.division_id','=',$_GET['division']);
        }
        if(!empty($_GET['district'])) {
            $query->where('case_register.district_id','=',$_GET['district']);
        }
        if(!empty($_GET['upazila'])) {
            $query->where('case_register.upazila_id','=',$_GET['upazila']);
        }
        if(!empty($_GET['gp'])) {
            $query->where('case_register.gp_user_id','=',$_GET['gp']);
        }
        // $cases = $query->paginate(10);
        // Dorpdown
        $upazilas = NULL;
        $courts = DB::table('court')->select('id', 'court_name')->get();
        $divisions = DB::table('division')->select('id', 'division_name_bn')->get();
        $user_role = DB::table('role')->select('id', 'role_name')->get();

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            $upazilas = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11 || $roleID == 12){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
        }

        $gp_users = DB::table('users')->select('id', 'name')->where('role_id', 13)->get();

        $page_title = 'শুনানির তারিখ নির্ধারণ করা হয়েছে';
        return view('UserNotification.index', compact(['page_title', 'cases', 'divisions', 'upazilas', 'courts', 'gp_users', 'user_role']))
        ->with('i', (request()->input('page',1) - 1) * 10);
    }

    public function rm_hearing_date()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();

        $query = DB::table('r_m__case_hearings')
        ->orderBy('id','DESC')
        ->join('r_m__case_rgisters', 'r_m__case_rgisters.id', '=', 'r_m__case_hearings.rm_case_id')
        ->select('r_m__case_hearings.*')
        ->where('r_m__case_rgisters.status', 1)
        ->distinct('r_m__case_hearings.rm_case_id');
        // ->unique('case_hearing.rm_case_id');
         $query->get();

        $cases = RM_CaseHearing::orderby('id', 'DESC')
        ->whereHas( 'rm_case_rgister', function ($query) {
            $query->where('status', 1);
        })->groupBy('rm_case_id')->get();
        // $mk = 'p';
        // foreach($cases as $cas){
        //     $mk .= $cas->id;
        // }
        // return $mk;

        //Add Conditions
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $query->whereBetween('r_m__case_rgisters.case_date', [$dateFrom, $dateTo]);
        }
        if(!empty($_GET['role'])) {
            $query->where('r_m__case_rgisters.action_user_group_id','=',$_GET['role']);
        }
        if(!empty($_GET['court'])) {
            $query->where('r_m__case_rgisters.court_id','=',$_GET['court']);
        }
        if(!empty($_GET['case_no'])) {
            $query->where('r_m__case_rgisters.case_number','=',$_GET['case_no']);
        }
        if(!empty($_GET['division'])) {
            $query->where('r_m__case_rgisters.division_id','=',$_GET['division']);
        }
        if(!empty($_GET['district'])) {
            $query->where('r_m__case_rgisters.district_id','=',$_GET['district']);
        }
        if(!empty($_GET['upazila'])) {
            $query->where('r_m__case_rgisters.upazila_id','=',$_GET['upazila']);
        }
        if(!empty($_GET['gp'])) {
            $query->where('r_m__case_rgisters.gp_user_id','=',$_GET['gp']);
        }
        // $cases = $query->paginate(10);
        // Dorpdown
        $upazilas = NULL;
        $courts = DB::table('court')->select('id', 'court_name')->get();
        $divisions = DB::table('division')->select('id', 'division_name_bn')->get();
        $user_role = DB::table('role')->select('id', 'role_name')->get();

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            $upazilas = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11 || $roleID == 12){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
        }

        $gp_users = DB::table('users')->select('id', 'name')->where('role_id', 13)->get();

        $page_title = 'শুনানির তারিখ নির্ধারণ করা হয়েছে';
        return view('UserNotification.rm_index', compact(['page_title', 'cases', 'divisions', 'upazilas', 'courts', 'gp_users', 'user_role']))
        ->with('i', (request()->input('page',1) - 1) * 10);
    }

    public function newSFlist()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();

        $query = DB::table('case_hearing')
        ->orderBy('id','DESC')
        ->join('case_register', 'case_register.id', '=', 'case_hearing.case_id')
        ->select('case_hearing.*')
        ->where('case_register.is_sf', 1)
        ->where('case_register.status', 1);
         $query->get();

        $cases = CaseRegister::orderby('id', 'DESC')
        ->where('case_register.status', 1)
        ->where('case_register.is_sf', 1)
        ->get();
        // $mk = 'p';
        // foreach($cases as $cas){
        //     $mk .= $cas->id;
        // }
        // return $mk;

        //Add Conditions
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $query->whereBetween('case_register.case_date', [$dateFrom, $dateTo]);
        }
        if(!empty($_GET['role'])) {
            $query->where('case_register.action_user_group_id','=',$_GET['role']);
        }
        if(!empty($_GET['court'])) {
            $query->where('case_register.court_id','=',$_GET['court']);
        }
        if(!empty($_GET['case_no'])) {
            $query->where('case_register.case_number','=',$_GET['case_no']);
        }
        if(!empty($_GET['division'])) {
            $query->where('case_register.division_id','=',$_GET['division']);
        }
        if(!empty($_GET['district'])) {
            $query->where('case_register.district_id','=',$_GET['district']);
        }
        if(!empty($_GET['upazila'])) {
            $query->where('case_register.upazila_id','=',$_GET['upazila']);
        }
        if(!empty($_GET['gp'])) {
            $query->where('case_register.gp_user_id','=',$_GET['gp']);
        }
        // $cases = $query->paginate(10);
        // Dorpdown
        $upazilas = NULL;
        $courts = DB::table('court')->select('id', 'court_name')->get();
        $divisions = DB::table('division')->select('id', 'division_name_bn')->get();
        $user_role = DB::table('role')->select('id', 'role_name')->get();

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            $upazilas = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11 || $roleID == 12){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
        }

        $gp_users = DB::table('users')->select('id', 'name')->where('role_id', 13)->get();

        $page_title = 'নতুন এস এফ';
        return view('UserNotification.newSF_list', compact(['page_title', 'cases', 'divisions', 'upazilas', 'courts', 'gp_users', 'user_role']))
        ->with('i', (request()->input('page',1) - 1) * 10);
    }
}
