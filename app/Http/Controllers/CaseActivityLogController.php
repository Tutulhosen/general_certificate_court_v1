<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\CaseRegister;
use App\Models\CaseActivityLog;
use App\Models\CaseBadi;
use App\Models\CaseBibadi;
use App\Models\CaseSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CaseActivityLogController extends Controller
{
    public function index()
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
        ->select('case_register.*', 'court.court_name', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn');

        //Add Conditions
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
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

        // Check User Role ID
        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $query->where('case_register.district_id','=', $officeInfo->district_id);
        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11){
            $query->where('case_register.upazila_id','=', $officeInfo->upazila_id);
        }elseif($roleID == 12){
            $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
            $query->whereIn('case_register.mouja_id', [$moujaIDs]);
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

        $page_title = 'মামলা কার্যকলাপ নিরীক্ষা';
        return view('caseActivityLog.index', compact(['page_title', 'cases', 'divisions', 'upazilas', 'courts', 'gp_users', 'user_role']))
        ->with('i', (request()->input('page',1) - 1) * 10);
    }

    public function get_mouja_by_ulo_office_id($officeID){
        return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
    }

    public function sflog_details($id)
    {
        $data['sflog'] = CaseActivityLog::findOrFail($id);
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
        ->where('case_register.id', '=', $data['sflog']->case_register_id)
        ->first();


        $data['page_title'] = 'মামলার এস এফ লগের বিস্তারিত তথ্য'; //exit;
        return view('caseActivityLog.sflog_details')->with($data);
    }

    public function show($id)
    {
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

        $data['badis'] =DB::table('case_badi')
        ->join('case_register', 'case_badi.case_id', '=', 'case_register.id')
        ->select('case_badi.*')
        ->where('case_badi.case_id', '=', $id)
        ->get();

        $data['bibadis'] =DB::table('case_bibadi')
        ->join('case_register', 'case_bibadi.case_id', '=', 'case_register.id')
        ->select('case_bibadi.*')
        ->where('case_bibadi.case_id', '=', $id)
        ->get();

        $data['caseActivityLogs'] = CaseActivityLog::where('case_register_id', $id)->orderby('id', 'DESC')->get();

        $data['page_title'] = 'মামলার কার্যকলাপ নিরীক্ষার বিস্তারিত তথ্য'; //exit;
        return view('caseActivityLog.show')->with($data);
    }

    public function reg_case_details($id)
    {
        $data['caseActivityLog'] = CaseActivityLog::where('id', $id)->orderby('id', 'DESC')->first();

        $data['page_title'] = 'নিরীক্ষা মামলার বিস্তারিত তথ্য ';
        return view('caseActivityLog.caseDetails')->with($data);
    }
    public function getDependentDistrict($id)
    {
        $subcategories = DB::table("district")->where("division_id",$id)->pluck("district_name_bn","id");
        return json_encode($subcategories);
    }

    public function getDependentUpazila($id)
    {
        $subcategories = DB::table("upazila")->where("district_id",$id)->pluck("upazila_name_bn","id");
        return json_encode($subcategories);
    }

    public function getDependentCourt($id)
    {
        $subcategories = DB::table("court")->where("district_id",$id)->pluck("court_name","id");
        return json_encode($subcategories);
    }

    public function getDependentMouja($id)
    {
        $subcategories = DB::table("mouja")->where("upazila_id",$id)->pluck("mouja_name_bn","id");
        return json_encode($subcategories);
    }

    public function getDependentGp($id)
    {
        $subcategories = DB::table("users")
        ->join('office', 'users.office_id', '=', 'office.id')
        ->leftJoin('district', 'office.district_id', '=', 'district.id')
        ->where("district.id",$id)->where("users.role_id",13)->pluck("users.name","users.id");
        return json_encode($subcategories);
    }

    public function ajaxBadiDelete($id)
    {
        DB::table('case_badi')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function ajaxBibadiDelete($id)
    {
        DB::table('case_bibadi')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function ajaxSurvayDelete($id)
    {
        DB::table('case_survey')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function caseActivityPDFlog($id){
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

        $data['badis'] =DB::table('case_badi')
        ->join('case_register', 'case_badi.case_id', '=', 'case_register.id')
        ->select('case_badi.*')
        ->where('case_badi.case_id', '=', $id)
        ->get();

        $data['bibadis'] =DB::table('case_bibadi')
        ->join('case_register', 'case_bibadi.case_id', '=', 'case_register.id')
        ->select('case_bibadi.*')
        ->where('case_bibadi.case_id', '=', $id)
        ->get();

        $data['caseActivityLogs'] = CaseActivityLog::where('case_register_id', $id)->orderby('id', 'DESC')->get();

        $data['page_title'] = 'মামলার কার্যকলাপ নিরীক্ষার বিস্তারিত তথ্য'; //exit;

        $html = view('caseActivityLog.showPDF')->with($data);
         // Generate PDF
        $this->generatePDF($html);
    }

    public function generatePDF($html){
        $mpdf = new \Mpdf\Mpdf([
         'default_font_size' => 12,
         'default_font'      => 'kalpurush'
         ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
      }



}
