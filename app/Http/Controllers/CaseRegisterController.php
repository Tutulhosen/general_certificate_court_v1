<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\CaseRegister;
use App\Models\CaseBadi;
use App\Models\CaseBibadi;
use App\Models\CaseSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CaseRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //============All Case list============//
    public function index()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        // dd($officeInfo);

        // All user list
        $query = DB::table('case_register')
        ->orderBy('id','DESC')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->join('district', 'case_register.district_id', '=', 'district.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        ->select('case_register.*', 'court.court_name', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn');
        // ->where('district_id',38)

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

        // Check User Role ID
        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13 || $roleID == 16){
            $query->where('case_register.district_id','=', $officeInfo->district_id);
        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11){
            $query->where('case_register.upazila_id','=', $officeInfo->upazila_id);
        }elseif($roleID == 12){
            $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
            // dd($moujaIDs);
            // print_r($moujaIDs); exit;
            $query->whereIn('case_register.mouja_id', [$moujaIDs]);
        }

        $cases = $query->paginate(10);


        // Dorpdown
        $upazilas = NULL;
        $courts = DB::table('court')->select('id', 'court_name')->get();
        $divisions = DB::table('division')->select('id', 'division_name_bn')->get();
        $user_role = DB::table('role')->select('id', 'role_name')->get();

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13 || $roleID == 16){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            $upazilas = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11 || $roleID == 12){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
        }

        $gp_users = DB::table('users')->select('id', 'name')->where('role_id', 13)->get();
        // $roleID = Auth::user()->role_id;
        // dd($data['courts']);

        $page_title = 'মামলা এন্ট্রি রেজিষ্টারের তালিকা';
        return view('case.index', compact(['page_title', 'cases', 'divisions', 'upazilas', 'courts', 'gp_users', 'user_role']))
        ->with('i', (request()->input('page',1) - 1) * 10);
        // return view('case.index')/*->with($data);*/
        // $cases = CaseRegister::latest()->paginate(10);
        // $page_title = 'মামলা এন্ট্রি রেজিষ্টারের তালিকা';

        // ->with('i', (request()->input('page',1) - 1) * 5);
    }

    //============Running Case list============//

    public function running_case()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        // dd($officeInfo);

        // All user list
        $query = DB::table('case_register')
        ->orderBy('id','DESC')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->join('district', 'case_register.district_id', '=', 'district.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        ->where('case_register.status',1)
        ->select('case_register.*', 'court.court_name', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn');

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

        // Check User Role ID
        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13 || $roleID == 16){
            $query->where('case_register.district_id','=', $officeInfo->district_id);
        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11){
            $query->where('case_register.upazila_id','=', $officeInfo->upazila_id);
        }elseif($roleID == 12){
            $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
            // dd($moujaIDs);
            // print_r($moujaIDs); exit;
            $query->where('case_register.mouja_id', $moujaIDs);
        }

        $cases = $query->paginate(10);


        // Dorpdown
        $upazilas = NULL;
        $courts = DB::table('court')->select('id', 'court_name')->get();
        $divisions = DB::table('division')->select('id', 'division_name_bn')->get();
        $user_role = DB::table('role')->select('id', 'role_name')->get();

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13 || $roleID == 16){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            $upazilas = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11 || $roleID == 12){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
        }

        $gp_users = DB::table('users')->select('id', 'name')->where('role_id', 13)->get();
        // $roleID = Auth::user()->role_id;
        // dd($data['courts']);

        $page_title = 'মামলা এন্ট্রি রেজিষ্টারের তালিকা';
        return view('case.index', compact(['page_title', 'cases', 'divisions', 'upazilas', 'courts', 'gp_users', 'user_role']))
        ->with('i', (request()->input('page',1) - 1) * 10);
        // return view('case.index')/*->with($data);*/
        // $cases = CaseRegister::latest()->paginate(10);
        // $page_title = 'মামলা এন্ট্রি রেজিষ্টারের তালিকা';

        // ->with('i', (request()->input('page',1) - 1) * 5);
    }

    //============Appeal Case list============//

    public function appeal_case()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        // dd($officeInfo);

        // All user list
        $query = DB::table('case_register')
        ->orderBy('id','DESC')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->join('district', 'case_register.district_id', '=', 'district.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->where('case_register.status',2)
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        ->select('case_register.*', 'court.court_name', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn');

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

        // Check User Role ID
        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13 || $roleID == 16){
            $query->where('case_register.district_id','=', $officeInfo->district_id);
        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11){
            $query->where('case_register.upazila_id','=', $officeInfo->upazila_id);
        }elseif($roleID == 12){
            $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
            // dd($moujaIDs);
            // print_r($moujaIDs); exit;
            $query->where('case_register.mouja_id', $moujaIDs);
        }

        $cases = $query->paginate(10);


        // Dorpdown
        $upazilas = NULL;
        $courts = DB::table('court')->select('id', 'court_name')->get();
        $user_role = DB::table('role')->select('id', 'role_name')->get();
        $divisions = DB::table('division')->select('id', 'division_name_bn')->get();

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            $upazilas = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11 || $roleID == 12){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
        }

        $gp_users = DB::table('users')->select('id', 'name')->where('role_id', 13)->get();
        // $roleID = Auth::user()->role_id;
        // dd($data['courts']);

        $page_title = 'মামলা এন্ট্রি রেজিষ্টারের তালিকা';
        return view('case.index', compact(['page_title', 'cases', 'divisions', 'upazilas', 'courts', 'gp_users', 'user_role']))
        ->with('i', (request()->input('page',1) - 1) * 10);
        // return view('case.index')/*->with($data);*/
        // $cases = CaseRegister::latest()->paginate(10);
        // $page_title = 'মামলা এন্ট্রি রেজিষ্টারের তালিকা';

        // ->with('i', (request()->input('page',1) - 1) * 5);
    }

    //============Complete Case list============//

    public function complete_case()
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        // dd($officeInfo);

        // All user list
        $query = DB::table('case_register')
        ->orderBy('id','DESC')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->join('district', 'case_register.district_id', '=', 'district.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->where('case_register.status',3)
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        ->select('case_register.*', 'court.court_name', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn');

        //Add Conditions
        if(!empty($_GET['role'])) {
            $query->where('case_register.action_user_group_id','=',$_GET['role']);
        }
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $query->whereBetween('case_register.case_date', [$dateFrom, $dateTo]);
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
        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13 || $roleID == 16){
            $query->where('case_register.district_id','=', $officeInfo->district_id);
        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11){
            $query->where('case_register.upazila_id','=', $officeInfo->upazila_id);
        }elseif($roleID == 12){
            $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
            // dd($moujaIDs);
            // print_r($moujaIDs); exit;
            $query->where('case_register.mouja_id', $moujaIDs);
        }

        $cases = $query->paginate(10);


        // Dorpdown
        $upazilas = NULL;
        $courts = DB::table('court')->select('id', 'court_name')->get();
        $user_role = DB::table('role')->select('id', 'role_name')->get();
        $divisions = DB::table('division')->select('id', 'division_name_bn')->get();

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13 || $roleID == 16){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            $upazilas = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11 || $roleID == 12){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
        }

        $gp_users = DB::table('users')->select('id', 'name')->where('role_id', 13)->get();
        // $roleID = Auth::user()->role_id;
        // dd($data['courts']);

        $page_title = 'মামলা এন্ট্রি রেজিষ্টারের তালিকা';
        return view('case.index', compact(['page_title', 'cases', 'divisions', 'upazilas', 'courts', 'gp_users', 'user_role']))
        ->with('i', (request()->input('page',1) - 1) * 10);
        // return view('case.index')/*->with($data);*/
        // $cases = CaseRegister::latest()->paginate(10);
        // $page_title = 'মামলা এন্ট্রি রেজিষ্টারের তালিকা';

        // ->with('i', (request()->input('page',1) - 1) * 5);
    }

    public function get_mouja_by_ulo_office_id($officeID){
        return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
        // return DB::table('mouja_ulo')->select('mouja_id')->where('ulo_office_id', $officeID)->get();
        // return DB::table('division')->select('id', 'division_name_bn')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Auth User Info
        $userDivision = user_division();
        $userDistrict = user_district();
        // dd($officeInfo);
        // Dropdown List
        $data['courts'] = DB::table('court')
                ->select('id', 'court_name')
                ->where('district_id', $userDistrict)
                ->get();
        // $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['upazilas'] = DB::table('upazila')
                ->select('id', 'upazila_name_bn')
                ->where('district_id', $userDistrict)
                ->get();
        $data['case_types'] = DB::table('case_type')->select('id', 'ct_name')->get();
        $data['surveys'] = DB::table('survey_type')->select('id', 'st_name')->get();
        $data['land_types'] = DB::table('land_type')->select('id', 'lt_name')->get();

        // dd($data);
        // dd($case_type);
        // $data['subcategories'] = DB::table("mouja")->where("upazila_id",38)->pluck("mouja_name_bn","id");

        $data['page_title'] = 'নতুন মামলা রেজিস্টার এন্ট্রি ফরম'; //exit;
        // return view('case.case_add', compact('page_title', 'case_type'));
        return view('case.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
        // $name = $request->input('name');

        //Auth User Info
        $userDivision = user_division();
        $userDistrict = user_district();

        // Form validation
        $request->validate([
            'court' => 'required',
            'upazila' => 'required',
            'mouja' => 'required',
            // 'case_type' => 'required',
            'case_no' => 'required',
            'case_date' => 'required',
            'show_cause' => 'required|mimes:pdf|max:10240',
            ],
            [
            'court.required' => 'আদালতের নাম নির্বাচন করুন',
            'upazila.required' => 'উপজেলা নির্বাচন করুন',
            'mouja.required' => 'মৌজা নির্বাচন করুন',
            // 'case_type.required' => 'মামলার ধরণ নির্বাচন করুন',
            'case_no.required' => 'মামলা নং নির্বাচন করুন',
            'case_date.required' => 'মামলা রুজুর তারিখ নির্বাচন করুন',
            'show_cause.required' => 'কারণ দর্শানোর নোটিশ পিডিএফ ফাইল ফরমেটে নির্বাচন করুন',
            ]);

        // Dynamic form validation
        if($request->input('badi_name')){
            foreach($request->input('badi_name') as $key => $val)
            {
                $request->validate([
                    'badi_name.'.$key => 'required',
                    'badi_spouse_name.'.$key => '',
                    'badi_address.'.$key => '',
                    ]);
            }
        }

        // dd($request->all());
        // $input = $request->all();

        // File upload
        if($request->show_cause != NULL){
            $fileName = $request->court.'_'.time().'.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/show_cause/'), $fileName);
        }else{
            $fileName = NULL;
        }

        // Convert DB date formate
        $caseDate = $request->case_date;
        $date_format = str_replace('/', '-', $caseDate);

        // Make case_register table data array
        $data = [
        'cs_id'         => 1,
        'court_id'      => $request->court,
        'case_number'   => $request->case_no,
        'case_date'     => date("Y-m-d", strtotime($date_format)),
        'action_user_group_id' => 5,
        'ct_id'         => $request->case_type,
        'mouja_id'      => $request->mouja,
        'upazila_id'    => $request->upazila,
        'district_id'   => $userDistrict,
        'division_id'   => $userDivision,
        'tafsil'        => $request->tafsil,
        'chowhaddi'     => $request->chowhaddi,
        'comments'      => $request->comments,
        'show_cause_file' => $fileName,
        'user_id'       => Auth::id(),
        'created_at'    => date('Y-m-d H:i:s'),
        ];

        // $badi = $request->input('badi_name');
        // dd($data);

        // Inser to DB
        // CaseRegister::create($data);
        $ID = DB::table('case_register')->insertGetId($data);

        // Insert Badi Table
        for ($i=0; $i<sizeof($request->input('badi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $ID,
            'badi_name'     => $_POST['badi_name'][$i],
            'badi_spouse_name' => $_POST['badi_spouse_name'][$i],
            'badi_address'   => $_POST['badi_address'][$i],
            ];
            DB::table('case_badi')->insert($dynamic_data);
        }

        // Insert Bibadi Table
        for ($i=0; $i<sizeof($request->input('bibadi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $ID,
            'bibadi_name'     => $_POST['bibadi_name'][$i],
            'bibadi_spouse_name' => $_POST['bibadi_spouse_name'][$i],
            'bibadi_address'   => $_POST['bibadi_address'][$i],
            ];
            DB::table('case_bibadi')->insert($dynamic_data);
        }

        // Insert Bibadi Table
        for ($i=0; $i<sizeof($request->input('st_id')); $i++) {
            $dynamic_data = [
            'case_id'       => $ID,
            'st_id'         => $_POST['st_id'][$i],
            'khotian_no'    => $_POST['khotian_no'][$i],
            'daag_no'       => $_POST['daag_no'][$i],
            'lt_id'         => $_POST['lt_id'][$i],
            'land_size'     => $_POST['land_size'][$i],
            'land_demand'   => $_POST['land_demand'][$i],
            ];
            DB::table('case_survey')->insert($dynamic_data);
        }

        // Insert data into case_log table
        $log_data = [
            'case_id'       => $ID,
            'status_id'     => 1,
            'user_id'       => Auth::id(),
            // 'send_user_group_id' => $user->role_id,
            'receive_user_group_id' =>  Auth::user()->role_id,
            'created_at'    => date('Y-m-d H:i:s'),
            ];
        DB::table('case_log')->insert($log_data);

        //========= Case Activity Log -  start ============
        $caseRegister = CaseRegister::findOrFail($ID)->toArray();
        $caseRegisterData = array_merge( $caseRegister, [
            'show_cause' => 'uploads/show_cause/'.$fileName,
            'badi' => [
                'badi_name'     => $request->badi_name,
                'badi_spouse_name' => $request->badi_spouse_name,
                'badi_address'   => $request->badi_address,
            ],
            'bibadi' => [
                'bibadi_name'     => $request->bibadi_name,
                'bibadi_spouse_name' => $request->bibadi_spouse_name,
                'bibadi_address'   => $request->bibadi_address,
            ],
            'case_survey' => [
                'st_id' => $request->st_id,
                'khotian_no' => $request->khotian_no,
                'daag_no' => $request->daag_no,
                'lt_id'  => $request->lt_id,
                'land_size'   => $request->land_size,
                'land_demand'   => $request->land_demand,
            ],
        ]);
        $cs_activity_data['case_register_id'] = $ID;
        $cs_activity_data['activity_type'] = 'Create';
        $cs_activity_data['message'] = 'নতুন মামলা রেজিস্ট্রেশন করা হয়েছে';
        $cs_activity_data['old_data'] = null;
        $cs_activity_data['new_data'] = json_encode($caseRegisterData);
        case_activity_logs($cs_activity_data);
        // ========= Case Activity Log  End ==========

        // return redirect('case');
        return redirect()->route('case')
        ->with('success', 'মামলার তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে');
    }

    public function sflog_details($id)
    {
        $data['sflog'] = DB::table('case_sf_log')->select('case_sf_log.case_id', 'case_sf_log.sf_log_details')->where('case_sf_log.id', '=', $id)->first();
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
        ->where('case_register.id', '=', $data['sflog']->case_id)
        ->first();


        $data['page_title'] = 'মামলার এস এফ লগের বিস্তারিত তথ্য'; //exit;
        return view('case.sflog_details')->with($data);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CaseRegister  $caseRegister
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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

        // dd($data['info']);

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

        $data['surveys'] =DB::table('case_survey')
        ->join('case_register', 'case_survey.case_id', '=', 'case_register.id')
        ->join('survey_type', 'case_survey.st_id', '=', 'survey_type.id')
        ->join('land_type', 'case_survey.lt_id', '=', 'land_type.id')
        ->select('case_survey.*','survey_type.st_name','land_type.lt_name')
        ->where('case_survey.case_id', '=', $id)
        ->get();

        $data['sf_logs'] = DB::table('case_sf_log')
        ->select('case_sf_log.*', 'users.name')
        ->join('users', 'users.id', '=', 'case_sf_log.user_id')
        ->where('case_sf_log.case_id', '=', $id)
        ->get();

        // dd($data['info']);

        $data['page_title'] = 'মামলার বিস্তারিত তথ্য'; //exit;
        return view('case.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CaseRegister  $caseRegister
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $userDivision = user_division();
        $userDistrict = user_district();
        // ->where('id',$id)->first();
        $data['info'] = DB::table('case_register')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        // ->join('case_type', 'case_register.ct_id', '=', 'case_type.id')
        ->join('case_status', 'case_register.cs_id', '=', 'case_status.id')
        ->select('case_register.*', 'court.court_name', 'upazila.upazila_name_bn', 'mouja.mouja_name_bn',  'case_status.status_name')
        ->where('case_register.id', $id)
        ->first();
        // dd($data['info']->id);

        $data['badis_list'] =DB::table('case_badi')
        ->join('case_register', 'case_badi.case_id', '=', 'case_register.id')
        ->select('case_badi.*')
        ->where('case_badi.case_id', '=', $id)
        ->get();

        $data['bibadis_list'] =DB::table('case_bibadi')
        ->join('case_register', 'case_bibadi.case_id', '=', 'case_register.id')
        ->select('case_bibadi.*')
        ->where('case_bibadi.case_id', '=', $id)
        ->get();

        $data['survey_list'] =DB::table('case_survey')
        ->join('case_register', 'case_survey.case_id', '=', 'case_register.id')
        ->join('survey_type', 'case_survey.st_id', '=', 'survey_type.id')
        ->join('land_type', 'case_survey.lt_id', '=', 'land_type.id')
        ->select('case_survey.*','survey_type.st_name','land_type.lt_name')
        ->where('case_survey.case_id', '=', $id)
        ->get();

        // dd($data['surveys'][0]);

        // Dropdown List
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
        $data['courts'] = DB::table('court')->select('id', 'court_name')
                ->where('district_id', $userDistrict)
                ->get();
        $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id' , $userDivision)->get();
        $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $userDistrict)->get();
        // dd( $data['upazilas']);
        $data['moujas'] = DB::table('mouja')->select('id', 'mouja_name_bn')->where('upazila_id', $data['info']->upazila_id)->get();
        $data['case_types'] = DB::table('case_type')->select('id', 'ct_name')->get();
        $data['surveys'] = DB::table('survey_type')->select('id', 'st_name')->get();
        $data['land_types'] = DB::table('land_type')->select('id', 'lt_name')->get();

        $data['page_title'] = ' মামলা সংশোধন ফরম'; //exit;

        // return view('case.case_add', compact('page_title', 'case_type'));
        return view('case.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CaseRegister  $caseRegister
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id='')
    {
        // dd($request->all());
        //Auth User Info
        $userDivision = user_division();
        $userDistrict = user_district();

        $case_old_data = CaseRegister::findOrFail($id)->toArray();

        $case_id = DB::table('case_register')->where('id', $id)->get();

        $request->validate([
            'court' => 'required',
            'upazila' => 'required',
            'mouja' => 'required',
            // 'case_type' => 'required',
            'case_no' => 'required',
            'case_date' => 'required',
            'show_cause' => 'mimes:pdf|max:10240',
            ],
            [
            'court.required' => 'আদালতের নাম নির্বাচন করুন',
            'upazila.required' => 'উপজেলা নির্বাচন করুন',
            'mouja.required' => 'মৌজা নির্বাচন করুন',
            // 'case_type.required' => 'মামলার ধরণ নির্বাচন করুন',
            'case_no.required' => 'মামলা নং নির্বাচন করুন',
            'case_date.required' => 'মামলা রুজুর তারিখ নির্বাচন করুন',
            'show_cause.required' => 'কারণ দর্শানোর নোটিশ পিডিএফ ফাইল ফরমেটে নির্বাচন করুন',
            ]);

        // Dynamic form validation
        if($request->input('badi_name')){
            foreach($request->input('badi_name') as $key => $val)
            {
                $request->validate([
                    'badi_name.'.$key => 'required',
                    'badi_spouse_name.'.$key => '',
                    'badi_address.'.$key => '',
                    ]);
            }
        }

        // dd($request->all());
        // $input = $request->all();
        // dd($request->all());

        // File upload
        if($request->has('show_cause')){
            $fileName = $request->court.'_'.time().'.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/show_cause/'), $fileName);
        }else{
            $fileName = $case_id[0]->show_cause_file;
        }

        // Convert DB date formate
        $caseDate = $request->case_date;
        $date_format = str_replace('/', '-', $caseDate);

        // Make case_register table data array
        $data = [
        'court_id'      => $request->court,
        'case_number'   => $request->case_no,
        'case_date'     => date("Y-m-d", strtotime($date_format)),
        // 'ct_id'         => $request->case_type,
        'mouja_id'      => $request->mouja,
        'upazila_id'    => $request->upazila,
        'district_id'   => $userDistrict,
        'division_id'   => $userDivision,
        'tafsil'        => $request->tafsil,
        'chowhaddi'     => $request->chowhaddi,
        'comments'      => $request->comments,
        'show_cause_file' => $fileName,
        'user_id'       => Auth::id(),
        'updated_at'    => date('Y-m-d H:i:s'),
        ];

        // $badi = $request->input('badi_name');
        // dd($data);

        // Inser to DB
        // CaseRegister::create($data);
        $ID = DB::table('case_register')
        ->where('id', $id)
        ->update($data);

        // dd($request->input('badi_name'));

        // Badi
        for ($i=0; $i<sizeof($request->input('badi_name')); $i++) {
            // dd($request->all());
            DB::table('case_badi')->updateOrInsert(
                ['id' => $request->input('hide_badi_id')[$i]],
                [
                'case_id'           => $id,
                'badi_name'         => $request->input('badi_name')[$i],
                'badi_spouse_name'  => $request->input('badi_spouse_name')[$i],
                'badi_address'      => $request->input('badi_address')[$i],
                ]
                );
        }

        //=======================Badi======================//
        // for ($i=0; $i<sizeof($request->input('badi_name')); $i++) {
        //     $dynamic_data = [
        //     'case_id'       => $id,
        //     'badi_name'     => $request->input('badi_name')[$i],
        //     'badi_spouse_name' => $request->input('badi_spouse_name')[$i],
        //     'badi_address'   => $request->input('badi_address')[$i],
        //     ];
        //     $case_badi = DB::table('case_badi')->select('id')->where('case_id',$id)->get();
        // }

        // $case_badi = DB::table('case_badi')->select('id','badi_name')->where('case_id',$id)->get();
        // $db_case_badi=count($case_badi);

        // foreach ($case_badi as $key => $value) {
        //     $dynamic_data = [
        //     'case_id'       => $id,
        //     'badi_name'     => $request->input('badi_name')[$key],
        //     'badi_spouse_name' => $request->input('badi_spouse_name')[$key],
        //     'badi_address'   => $request->input('badi_address')[$key],
        //     ];
        //     $case_badi = DB::table('case_badi')->where('id',$value->id)->update($dynamic_data);
        // }

        // for ($i=$db_case_badi; $i<sizeof($request->input('badi_name')); $i++) {
        //     $dynamic_data = [
        //     'case_id'       => $id,
        //     'badi_name'     => $request->input('badi_name')[$i],
        //     'badi_spouse_name' => $request->input('badi_spouse_name')[$i],
        //     'badi_address'   => $request->input('badi_address')[$i],
        //     ];
        //     CaseBadi::create($dynamic_data);
        // }

        //===================Bibadi=====================//

        // Bibadi
        for ($i=0; $i<sizeof($request->input('bibadi_name')); $i++) {
            // dd($request->all());
            DB::table('case_bibadi')->updateOrInsert(
                ['id' => $request->input('hide_bibadi_id')[$i]],
                [
                'case_id'       => $id,
                'bibadi_name'     => $request->input('bibadi_name')[$i],
                'bibadi_spouse_name' => $request->input('bibadi_spouse_name')[$i],
                'bibadi_address'   => $request->input('bibadi_address')[$i],
                ]
                );
        }


        /*for ($i=0; $i<sizeof($request->input('bibadi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $id,
            'bibadi_name'     => $request->input('bibadi_name')[$i],
            'bibadi_spouse_name' => $request->input('bibadi_spouse_name')[$i],
            'bibadi_address'   => $request->input('bibadi_address')[$i],
            ];
            $case_bibadi = DB::table('case_bibadi')->select('id')->where('case_id',$id)->get();
        }

        $case_bibadi = DB::table('case_bibadi')->select('id','bibadi_name')->where('case_id',$id)->get();
        $db_case_bibadi=count($case_bibadi);

        foreach ($case_bibadi as $key => $value) {
            $dynamic_data = [
            'case_id'       => $id,
            'bibadi_name'     => $request->input('bibadi_name')[$key],
            'bibadi_spouse_name' => $request->input('bibadi_spouse_name')[$key],
            'bibadi_address'   => $request->input('bibadi_address')[$key],
            ];
            $case_bibadi = DB::table('case_bibadi')->where('id',$value->id)->update($dynamic_data);
        }

        for ($i=$db_case_bibadi; $i<sizeof($request->input('bibadi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $id,
            'bibadi_name'     => $request->input('bibadi_name')[$i],
            'bibadi_spouse_name' => $request->input('bibadi_spouse_name')[$i],
            'bibadi_address'   => $request->input('bibadi_address')[$i],
            ];
            CaseBibadi::create($dynamic_data);
        }*/

        //===================Survey=====================//


        // Survey
        for ($i=0; $i<sizeof($request->input('khotian_no')); $i++) {
            // dd($request->all());
            DB::table('case_survey')->updateOrInsert(
                ['id' => $request->input('hide_survey_id')[$i]],
                [
                'case_id'       => $id,
                'st_id'         => $request->input('st_id')[$i],
                'khotian_no'    => $request->input('khotian_no')[$i],
                'daag_no'       => $request->input('daag_no')[$i],
                'lt_id'         => $request->input('lt_id')[$i],
                'land_size'     => $request->input('land_size')[$i],
                'land_demand'   => $request->input('land_demand')[$i],
                ]
                );
        }
        /*
        for ($i=0; $i<sizeof($request->input('khotian_no')); $i++) {
            $dynamic_data = [
            'case_id'       => $id,
            'st_id'         => $request->input('st_id')[$i],
            'khotian_no'    => $request->input('khotian_no')[$i],
            'daag_no'       => $request->input('daag_no')[$i],
            'lt_id'         => $request->input('lt_id')[$i],
            'land_size'     => $request->input('land_size')[$i],
            'land_demand'   => $request->input('land_demand')[$i],
            ];
            $case_survey = DB::table('case_survey')->select('id')->where('case_id',$id)->get();
        }

        $case_survey = DB::table('case_survey')->select('id','khotian_no')->where('case_id',$id)->get();
        $db_case_survey = count($case_survey);

        foreach ($case_survey as $key => $value) {
            $dynamic_data = [
            'case_id'       => $id,
            'st_id'         => $request->input('st_id')[$key],
            'khotian_no'    => $request->input('khotian_no')[$key],
            'daag_no'       => $request->input('daag_no')[$key],
            'lt_id'         => $request->input('lt_id')[$key],
            'land_size'     => $request->input('land_size')[$key],
            'land_demand'   => $request->input('land_demand')[$key],
            ];
            $case_survey = DB::table('case_survey')->where('id',$value->id)->update($dynamic_data);
        }

        for ($i=$db_case_survey; $i<sizeof($request->input('st_id')); $i++) {
            $dynamic_data = [
            'case_id'       => $id,
            'st_id'         => $request->input('st_id')[$i],
            'khotian_no'    => $request->input('khotian_no')[$i],
            'daag_no'       => $request->input('daag_no')[$i],
            'lt_id'         => $request->input('lt_id')[$i],
            'land_size'     => $request->input('land_size')[$i],
            'land_demand'   => $request->input('land_demand')[$i],
            ];
            CaseSurvey::create($dynamic_data);
        }*/
        // dd(1);

        //========= Case Activity Log -  start ============
        $caseRegister = CaseRegister::findOrFail($id)->toArray();
        $caseRegisterData = array_merge( $caseRegister, [
            'show_cause' => 'uploads/show_cause/'.$fileName,
            'badi' => [
                'badi_name'     => $request->badi_name,
                'badi_spouse_name' => $request->badi_spouse_name,
                'badi_address'   => $request->badi_address,
            ],
            'bibadi' => [
                'bibadi_name'     => $request->bibadi_name,
                'bibadi_spouse_name' => $request->bibadi_spouse_name,
                'bibadi_address'   => $request->bibadi_address,
            ],
            'case_survey' => [
                'st_id' => $request->st_id,
                'khotian_no' => $request->khotian_no,
                'daag_no' => $request->daag_no,
                'lt_id'  => $request->lt_id,
                'land_size'   => $request->land_size,
                'land_demand'   => $request->land_demand,
            ],
        ]);
        $cs_activity_data['case_register_id'] = $id;
        $cs_activity_data['activity_type'] = 'Update';
        $cs_activity_data['message'] = 'রেজিস্ট্রার মামলা আপডেট করা হয়েছে';
        $cs_activity_data['old_data'] = json_encode($case_old_data);
        $cs_activity_data['new_data'] = json_encode($caseRegisterData);
        case_activity_logs($cs_activity_data);
        // ========= Case Activity Log  End ==========

        return redirect()->route('case')
        ->with('success', 'মামলার তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে');
    }


    /**************************************************************/
    /********************* Old Case Register **********************/
    /**************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function old_case()
     {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        // dd($officeInfo);

        // All user list
        $query = DB::table('case_register')
        ->orderBy('id','DESC')
        ->where('is_old', 1)
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->join('district', 'case_register.district_id', '=', 'district.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        ->select('case_register.*', 'court.court_name', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn');
        // ->where('district_id',38)

        //Add Conditions
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $query->whereBetween('case_register.case_date', [$dateFrom, $dateTo]);
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
            // dd($moujaIDs);
            // print_r($moujaIDs); exit;
            $query->where('case_register.mouja_id', $moujaIDs);
        }

        $cases = $query->paginate(10);


        // Dorpdown
        $upazilas = NULL;
        $courts = DB::table('court')->select('id', 'court_name')->get();
        $divisions = DB::table('division')->select('id', 'division_name_bn')->get();
        $user_role = DB::table('role')->select('id', 'role_name')->get();

        // dd($user_role);

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            $upazilas = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11 || $roleID == 12){
            $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
        }

        $gp_users = DB::table('users')->select('id', 'name')->where('role_id', 13)->get();
        // $roleID = Auth::user()->role_id;
        // dd($data['courts']);

        $page_title = 'পুরাতন মামলা এন্ট্রি রেজিষ্টারের তালিকা';
        return view('case.old', compact(['page_title', 'cases', 'divisions', 'upazilas', 'courts', 'gp_users', 'user_role']))
        ->with('i', (request()->input('page',1) - 1) * 10);
        // return view('case.index')/*->with($data);*/
        // $cases = CaseRegister::latest()->paginate(10);
        // $page_title = 'মামলা এন্ট্রি রেজিষ্টারের তালিকা';

        // ->with('i', (request()->input('page',1) - 1) * 5);
    }

    public function old_case_create()
    {
        $userDistrict = user_district();
        // Dropdown List
        $data['courts'] = DB::table('court')->select('id', 'court_name')
                ->where('district_id', $userDistrict)
                ->get();
        $data['upazilas'] = DB::table('upazila')
                ->select('id', 'upazila_name_bn')
                ->where('district_id', $userDistrict)
                ->get();
        /*$data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();*/
        $data['case_types'] = DB::table('case_type')->select('id', 'ct_name')->get();
        $data['surveys'] = DB::table('survey_type')->select('id', 'st_name')->get();
        $data['land_types'] = DB::table('land_type')->select('id', 'lt_name')->get();

        // dd($case_type);
        // $data['subcategories'] = DB::table("mouja")->where("upazila_id",38)->pluck("mouja_name_bn","id");

        $data['page_title'] = 'পুরাতন মামলা রেজিস্টার এন্ট্রি ফরম'; //exit;
        // return view('case.case_add', compact('page_title', 'case_type'));
        return view('case.old_case_create')->with($data);
    }

    public function old_case_store(Request $request)
    {
        $userDivision = user_division();
        $userDistrict = user_district();
        // $name = $request->input('name');
        // Form validation
        $request->validate([
            'court' => 'required',
            'upazila' => 'required',
            'mouja' => 'required',
            // 'case_type' => 'required',
            'case_no' => 'required',
            'case_date' => 'required',
            'show_cause' => 'required|mimes:pdf|max:10240',
            ],
            [
            'court.required' => 'আদালতের নাম নির্বাচন করুন',
            'upazila.required' => 'উপজেলা নির্বাচন করুন',
            'mouja.required' => 'মৌজা নির্বাচন করুন',
            // 'case_type.required' => 'মামলার ধরণ নির্বাচন করুন',
            'case_no.required' => 'মামলা নং নির্বাচন করুন',
            'case_date.required' => 'মামলা রুজুর তারিখ নির্বাচন করুন',
            'show_cause.required' => 'কারণ দর্শানোর নোটিশ পিডিএফ ফাইল ফরমেটে নির্বাচন করুন',
            ]);

        // Dynamic form validation
        if($request->input('badi_name')){
            foreach($request->input('badi_name') as $key => $val)
            {
                $request->validate([
                    'badi_name.'.$key => 'required',
                    'badi_spouse_name.'.$key => '',
                    'badi_address.'.$key => '',
                    ]);
            }
        }

        // dd($request->all());
        // $input = $request->all();

        // File upload
        $show_cause_file = NULL;
        $power_attorney_file = NULL;
        $order_file = NULL;
        $appeal_sc_file = NULL;
        $sf_report = NULL;

        if($request->show_cause != NULL){
            $show_cause_file = $request->court.'_'.time().'_sc.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/show_cause'), $show_cause_file);
        }
         // File upload of power of attorney
        if($request->power_attorney_file != NULL){
            $power_attorney_file = $request->court.'_'.time().'_pof.'.$request->power_attorney_file->extension();
            $request->power_attorney_file->move(public_path('uploads/power_of_attorney'), $power_attorney_file);
        }
        // File upload of order
        if($request->order_file != NULL){
            $order_file = $request->court.'_'.time().'_odr.'.$request->order_file->extension();
            $request->order_file->move(public_path('uploads/order'), $order_file);
        }
         // File upload of appeal sc
        if($request->appeal_sc_file != NULL){
            $appeal_sc_file = $request->court.'_'.time().'_asc.'.$request->appeal_sc_file->extension();
            $request->appeal_sc_file->move(public_path('uploads/appeal_sc'), $appeal_sc_file);
        }
         // File upload of sf_report
        if($request->sf_report != NULL){
            $sf_report = $request->court.'_'.time().'_sfr.'.$request->sf_report->extension();
            $request->sf_report->move(public_path('uploads/sf_report'), $sf_report);
        }

        // Convert DB date formate
        $caseDate = $request->case_date;
        $case_Date = str_replace('/', '-', $caseDate);
        $orderdate = $request->order_date;
        $orde_rdate = str_replace('/', '-', $orderdate);
        $nextassign_date = $request->next_assign_date;
        $next_assign_date = str_replace('/', '-', $nextassign_date);
        $pastorder_date = $request->past_order_date;
        $past_order_date = str_replace('/', '-', $pastorder_date);
        $screceiving_date = $request->sc_receiving_date;
        $sc_receiving_date = str_replace('/', '-', $screceiving_date);
        $senddate_rm_ac = $request->send_date_rm_ac;
        $send_date_rm_ac = str_replace('/', '-', $senddate_rm_ac);
        $senddate_ac_ulo = $request->send_date_ac_ulo;
        $send_date_ac_ulo = str_replace('/', '-', $senddate_ac_ulo);
        $senddate_sf_ulo_ac = $request->send_date_sf_ulo_ac;
        $send_date_sf_ulo_ac = str_replace('/', '-', $senddate_sf_ulo_ac);
        $senddate_ans_ac_rm = $request->send_date_ans_ac_rm;
        $send_date_ans_ac_rm = str_replace('/', '-', $senddate_ans_ac_rm);
        $senddate_sf_rm_adc = $request->send_date_sf_rm_adc;
        $send_date_sf_rm_adc = str_replace('/', '-', $senddate_sf_rm_adc);

        // Make case_register table data array
        $data = [
        'cs_id'                 => 1,
        'is_old'                => 1,
        'action_user_group_id'  => 5,
        'court_id'              => $request->court,
        'case_result'           => $request->case_result,
        'traditional_remedies'  => $request->traditional_remedies,
        'is_lost_appeal'        => $request->is_lost_appeal,
        'lost_reason'           => $request->lost_reason,
        'gp_user_id'            => $request->gp_user_id,
        'case_result'           => $request->case_result,
        'case_number'           => $request->case_no,
        'case_date'             => date("Y-m-d", strtotime($case_Date)),
        'order_date'            => date("Y-m-d", strtotime($orderdate)),
        'next_assign_date'      => date("Y-m-d", strtotime($next_assign_date)),
        'past_order_date'       => date("Y-m-d", strtotime($past_order_date)),
        'sc_receiving_date'     => date("Y-m-d", strtotime($sc_receiving_date)),
        'send_date_rm_ac'       => date("Y-m-d", strtotime($send_date_rm_ac)),
        'send_date_ac_ulo'      => date("Y-m-d", strtotime($send_date_ac_ulo)),
        'send_date_sf_ulo_ac'   => date("Y-m-d", strtotime($send_date_sf_ulo_ac)),
        'send_date_ans_ac_rm'   => date("Y-m-d", strtotime($send_date_ans_ac_rm)),
        'send_date_sf_rm_adc'   => date("Y-m-d", strtotime($send_date_sf_rm_adc)),
        'case_date'             => date("Y-m-d", strtotime($case_Date)),
        'case_date'             => date("Y-m-d", strtotime($case_Date)),
        // 'ct_id'                 => $request->case_type,
        'mouja_id'              => $request->mouja,
        'upazila_id'            => $request->upazila,
        'district_id'           => $userDistrict,
        'division_id'           => $userDivision,
        'tafsil'                => $request->tafsil,
        'chowhaddi'             => $request->chowhaddi,
        'comments'              => $request->comments,
        'show_cause_file'       => $show_cause_file,
        'power_attorney_file'   => $power_attorney_file,
        'order_file'            => $order_file,
        'appeal_sc_file'        => $appeal_sc_file,
        'sf_report'             => $sf_report,
        'user_id'               => Auth::id(),
        'created_at'            => date('Y-m-d H:i:s'),
        ];

        // $badi = $request->input('badi_name');
        // dd($data);

        // Inser to DB
        // CaseRegister::create($data);
        $ID = DB::table('case_register')->insertGetId($data);

        // Insert Badi Table
        for ($i=0; $i<sizeof($request->input('badi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $ID,
            'badi_name'     => $_POST['badi_name'][$i],
            'badi_spouse_name' => $_POST['badi_spouse_name'][$i],
            'badi_address'   => $_POST['badi_address'][$i],
            ];
            DB::table('case_badi')->insert($dynamic_data);
        }

        // Insert Bibadi Table
        for ($i=0; $i<sizeof($request->input('bibadi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $ID,
            'bibadi_name'     => $_POST['bibadi_name'][$i],
            'bibadi_spouse_name' => $_POST['bibadi_spouse_name'][$i],
            'bibadi_address'   => $_POST['bibadi_address'][$i],
            ];
            DB::table('case_bibadi')->insert($dynamic_data);
        }

        // Insert Bibadi Table
        for ($i=0; $i<sizeof($request->input('st_id')); $i++) {
            $dynamic_data = [
            'case_id'       => $ID,
            'st_id'         => $_POST['st_id'][$i],
            'khotian_no'    => $_POST['khotian_no'][$i],
            'daag_no'       => $_POST['daag_no'][$i],
            'lt_id'         => $_POST['lt_id'][$i],
            'land_size'     => $_POST['land_size'][$i],
            'land_demand'   => $_POST['land_demand'][$i],
            ];
            DB::table('case_survey')->insert($dynamic_data);
        }

        //========= Case Activity Log -  start ============
        $caseRegister = CaseRegister::findOrFail($ID)->toArray();
        $caseRegisterData = array_merge( $caseRegister, [
            'badi' => [
                'badi_name'     => [$request->badi_name],
                'badi_spouse_name' => [$request->badi_spouse_name],
                'badi_address'   => [$request->badi_address],
            ],
            'bibadi' => [
                'bibadi_name'     => [$request->bibadi_name],
                'bibadi_spouse_name' => [$request->bibadi_spouse_name],
                'bibadi_address'   => [$request->bibadi_address],
            ],
            'case_survey' => [
                'st_id' => [$request->st_id],
                'khotian_no' => [$request->khotian_no],
                'daag_no' => [$request->daag_no],
                'lt_id'  => [$request->lt_id],
                'land_size'   => [$request->land_size],
                'land_demand'   => [$request->land_demand],
            ],
        ]);
        $cs_activity_data['case_register_id'] = $ID;
        $cs_activity_data['activity_type'] = 'Create';
        $cs_activity_data['message'] = 'পুরাতন মামলা রেজিস্ট্রেশন করা হয়েছে';
        $cs_activity_data['old_data'] = null;
        $cs_activity_data['new_data'] = json_encode($caseRegisterData);
        case_activity_logs($cs_activity_data);
        // ========= Case Activity Log  End ==========


        // return redirect('case');
        return redirect()->route('case.old')
        ->with('success', 'মামলার তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে');
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\CaseRegister  $caseRegister
    * @return \Illuminate\Http\Response
    */
    public function old_case_edit($id)
    {
        $userDistrict = user_district();
        $userDivision = user_division();
        // ->where('id',$id)->first();
        $data['info'] = DB::table('case_register')
        ->leftJoin('court', 'case_register.court_id', '=', 'court.id')
        ->leftJoin('users', 'case_register.gp_user_id', '=', 'users.id')
        ->leftJoin('division', 'case_register.division_id', '=', 'division.id')
        ->leftJoin('district', 'case_register.district_id', '=', 'district.id')
        ->leftJoin('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->leftJoin('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        ->leftJoin('case_type', 'case_register.ct_id', '=', 'case_type.id')
        ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
        ->leftJoin('case_badi', 'case_register.id', '=', 'case_badi.case_id')
        ->leftJoin('case_bibadi', 'case_register.id', '=', 'case_bibadi.case_id')
        ->select('case_register.*', 'court.court_name','users.name', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'mouja.mouja_name_bn', 'case_type.ct_name', 'case_status.status_name', 'case_badi.badi_name', 'case_badi.badi_spouse_name', 'case_badi.badi_address', 'case_bibadi.bibadi_name', 'case_bibadi.bibadi_spouse_name', 'case_bibadi.bibadi_address')
        ->where('case_register.id', '=', $id)
        ->first();
        // dd($data['info']);

        $data['badis_list'] =DB::table('case_badi')
        ->join('case_register', 'case_badi.case_id', '=', 'case_register.id')
        ->select('case_badi.*')
        ->where('case_badi.case_id', '=', $id)
        ->get();

        $data['bibadis_list'] =DB::table('case_bibadi')
        ->join('case_register', 'case_bibadi.case_id', '=', 'case_register.id')
        ->select('case_bibadi.*')
        ->where('case_bibadi.case_id', '=', $id)
        ->get();

        $data['survey_list'] =DB::table('case_survey')
        ->join('case_register', 'case_survey.case_id', '=', 'case_register.id')
        ->join('survey_type', 'case_survey.st_id', '=', 'survey_type.id')
        ->join('land_type', 'case_survey.lt_id', '=', 'land_type.id')
        ->select('case_survey.*','survey_type.st_name','land_type.lt_name')
        ->where('case_survey.case_id', '=', $id)
        ->get();

        $data['divisions'] = DB::table('division')
        ->select('id', 'division_name_bn')
        ->get();


        // Dropdown List
        $data['courts'] = DB::table('court')->select('id', 'court_name')
                ->where('district_id', $userDistrict)
                ->get();
        $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id' , $userDivision)->get();
        $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $userDistrict)->get();
        $data['moujas'] = DB::table('mouja')->select('id', 'mouja_name_bn')->where('upazila_id', $data['info']->upazila_id)->get();
        $data['user'] = DB::table('users')
        ->select('users.name','users.id')
        ->join('office', 'users.office_id', '=', 'office.id')
        ->leftJoin('district', 'office.district_id', '=', 'district.id')
        ->where("district.id",$data['info']->district_id)->where("users.role_id",13)
        ->get();
        $data['case_types'] = DB::table('case_type')->select('id', 'ct_name')->get();
        $data['surveys'] = DB::table('survey_type')->select('id', 'st_name')->get();
        $data['land_types'] = DB::table('land_type')->select('id', 'lt_name')->get();

        $data['page_title'] = ' মামলা সংশোধন ফরম'; //exit;
        // return view('case.case_add', compact('page_title', 'case_type'));
        return view('case.old_case_edit')->with($data);
    }


    public function old_case_update(Request $request, $id='')
    {
        $userDivision = user_division();
        $userDistrict = user_district();
        // $name = $request->input('name');
        // Form validation
        $old_case_id = DB::table('case_register')->where('id', $id)->get();
        $case_old_data = CaseRegister::findOrFail($id)->toArray();
        // dd($old_case_id[0]->show_cause_file);

        $request->validate([
            'court' => 'required',
            'upazila' => 'required',
            'mouja' => 'required',
            // 'case_type' => 'required',
            'case_no' => 'required',
            'case_date' => 'required',
            'show_cause' => 'mimes:pdf|max:10240',
            ],
            [
            'court.required' => 'আদালতের নাম নির্বাচন করুন',
            'upazila.required' => 'উপজেলা নির্বাচন করুন',
            'mouja.required' => 'মৌজা নির্বাচন করুন',
            // 'case_type.required' => 'মামলার ধরণ নির্বাচন করুন',
            'case_no.required' => 'মামলা নং নির্বাচন করুন',
            'case_date.required' => 'মামলা রুজুর তারিখ নির্বাচন করুন',
            'show_cause.required' => 'কারণ দর্শানোর নোটিশ পিডিএফ ফাইল ফরমেটে নির্বাচন করুন',
            ]);

        // Dynamic form validation
        if($request->input('badi_name')){
            foreach($request->input('badi_name') as $key => $val)
            {
                $request->validate([
                    'badi_name.'.$key => 'required',
                    'badi_spouse_name.'.$key => '',
                    'badi_address.'.$key => '',
                    ]);
            }
        }

        // dd($request);
        // $input = $request->all();

        // File upload
        if($request->has('show_cause')){
            $show_cause_file = $request->court.'_'.time().'_sc.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/show_cause'), $show_cause_file);
        }else{
            $show_cause_file = $old_case_id[0]->show_cause_file;
        }
         // File upload of power of attorney

        if($request->has('power_attorney_file')){
            $power_attorney_file = $request->court.'_'.time().'_pof.'.$request->power_attorney_file->extension();
            $request->power_attorney_file->move(public_path('uploads/power_of_attorney'), $power_attorney_file);
        }else{
            $power_attorney_file = $old_case_id[0]->power_attorney_file;
        }
        // File upload of order
        if($request->has('order_file')){
            $order_file = $request->court.'_'.time().'_odr.'.$request->order_file->extension();
            $request->order_file->move(public_path('uploads/order'), $order_file);
        }else{
            $order_file = $old_case_id[0]->order_file;
        }
         // File upload of appeal sc
        if($request->has('appeal_sc_file')){
            $appeal_sc_file = $request->court.'_'.time().'_asc.'.$request->appeal_sc_file->extension();
            $request->appeal_sc_file->move(public_path('uploads/appeal_sc'), $appeal_sc_file);
        }else{
            $appeal_sc_file = $old_case_id[0]->appeal_sc_file;
        }
         // File upload of sf_report
        if($request->has('sf_report')){
            $sf_report = $request->court.'_'.time().'_sfr.'.$request->sf_report->extension();
            $request->sf_report->move(public_path('uploads/sf_report'), $sf_report);
        }else{
            $sf_report = $old_case_id[0]->sf_report;
        }

        // Convert DB date formate
        $caseDate = $request->case_date;
        $case_Date = str_replace('/', '-', $caseDate);
        $orderdate = $request->order_date;
        $orde_rdate = str_replace('/', '-', $orderdate);
        $nextassign_date = $request->next_assign_date;
        $next_assign_date = str_replace('/', '-', $nextassign_date);
        $pastorder_date = $request->past_order_date;
        $past_order_date = str_replace('/', '-', $pastorder_date);
        $screceiving_date = $request->sc_receiving_date;
        $sc_receiving_date = str_replace('/', '-', $screceiving_date);
        $senddate_rm_ac = $request->send_date_rm_ac;
        $send_date_rm_ac = str_replace('/', '-', $senddate_rm_ac);
        $senddate_ac_ulo = $request->send_date_ac_ulo;
        $send_date_ac_ulo = str_replace('/', '-', $senddate_ac_ulo);
        $senddate_sf_ulo_ac = $request->send_date_sf_ulo_ac;
        $send_date_sf_ulo_ac = str_replace('/', '-', $senddate_sf_ulo_ac);
        $senddate_ans_ac_rm = $request->send_date_ans_ac_rm;
        $send_date_ans_ac_rm = str_replace('/', '-', $senddate_ans_ac_rm);
        $senddate_sf_rm_adc = $request->send_date_sf_rm_adc;
        $send_date_sf_rm_adc = str_replace('/', '-', $senddate_sf_rm_adc);

        // Make case_register table data array
        $data = [
        // 'cs_id'         => 1,
        // 'is_old'         => 1,
        'court_id'              => $request->court,
        'case_result'           => $request->case_result,
        'traditional_remedies'  => $request->traditional_remedies,
        'is_lost_appeal'        => $request->is_lost_appeal,
        'lost_reason'           => $request->lost_reason,
        'gp_user_id'            => $request->gp_user_id,
        'case_result'           => $request->case_result,
        'case_number'           => $request->case_no,
        'case_date'             => date("Y-m-d", strtotime($case_Date)),
        'order_date'            => date("Y-m-d", strtotime($orderdate)),
        'next_assign_date'      => date("Y-m-d", strtotime($next_assign_date)),
        'past_order_date'       => date("Y-m-d", strtotime($past_order_date)),
        'sc_receiving_date'     => date("Y-m-d", strtotime($sc_receiving_date)),
        'send_date_rm_ac'       => date("Y-m-d", strtotime($send_date_rm_ac)),
        'send_date_ac_ulo'      => date("Y-m-d", strtotime($send_date_ac_ulo)),
        'send_date_sf_ulo_ac'   => date("Y-m-d", strtotime($send_date_sf_ulo_ac)),
        'send_date_ans_ac_rm'   => date("Y-m-d", strtotime($send_date_ans_ac_rm)),
        'send_date_sf_rm_adc'   => date("Y-m-d", strtotime($send_date_sf_rm_adc)),
        'case_date'             => date("Y-m-d", strtotime($case_Date)),
        'case_date'             => date("Y-m-d", strtotime($case_Date)),
        // 'ct_id'                 => $request->case_type,
        'mouja_id'              => $request->mouja,
        'upazila_id'            => $request->upazila,
        'district_id'           => $userDistrict,
        'division_id'           => $userDivision,
        'tafsil'                => $request->tafsil,
        'chowhaddi'             => $request->chowhaddi,
        'comments'              => $request->comments,
        'show_cause_file'       => $show_cause_file,
        'power_attorney_file'   => $power_attorney_file,
        'order_file'            => $order_file,
        'appeal_sc_file'        => $appeal_sc_file,
        'sf_report'             => $sf_report,
        'user_id'               => Auth::id(),
        'updated_at'            => date('Y-m-d H:i:s'),
        ];
        // $badi = $request->input('badi_name');
        // dd($data);

        // Inser to DB
        // CaseRegister::create($data);
        $ID = DB::table('case_register')
        ->where('id', $id)
        ->update($data);

        //====================================Badi==================================//

        // Badi
        for ($i=0; $i<sizeof($request->input('badi_name')); $i++) {
            // dd($request->all());
            DB::table('case_badi')->updateOrInsert(
                ['id' => $request->input('hide_badi_id')[$i]],
                [
                'case_id'           => $id,
                'badi_name'         => $request->input('badi_name')[$i],
                'badi_spouse_name'  => $request->input('badi_spouse_name')[$i],
                'badi_address'      => $request->input('badi_address')[$i],
                ]
            );
        }

        /*for ($i=0; $i<sizeof($request->input('badi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $id,
            'badi_name'     => $request->input('badi_name')[$i],
            'badi_spouse_name' => $request->input('badi_spouse_name')[$i],
            'badi_address'   => $request->input('badi_address')[$i],
            ];
            $case_badi = DB::table('case_badi')->select('id')->where('case_id',$id)->get();
        }

        $case_badi = DB::table('case_badi')->select('id','badi_name')->where('case_id',$id)->get();
        $db_case_badi=count($case_badi);

        foreach ($case_badi as $key => $value) {
            $dynamic_data = [
            'case_id'       => $id,
            'badi_name'     => $request->input('badi_name')[$key],
            'badi_spouse_name' => $request->input('badi_spouse_name')[$key],
            'badi_address'   => $request->input('badi_address')[$key],
            ];
            $case_badi = DB::table('case_badi')->where('id',$value->id)->update($dynamic_data);
        }

        for ($i=$db_case_badi; $i<sizeof($request->input('badi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $id,
            'badi_name'     => $request->input('badi_name')[$i],
            'badi_spouse_name' => $request->input('badi_spouse_name')[$i],
            'badi_address'   => $request->input('badi_address')[$i],
            ];
            CaseBadi::create($dynamic_data);
        }*/

        //====================================Bibadi==================================//

        // Bibadi
        for ($i=0; $i<sizeof($request->input('bibadi_name')); $i++) {
            // dd($request->all());
            DB::table('case_bibadi')->updateOrInsert(
                ['id' => $request->input('hide_bibadi_id')[$i]],
                [
                'case_id'       => $id,
                'bibadi_name'     => $request->input('bibadi_name')[$i],
                'bibadi_spouse_name' => $request->input('bibadi_spouse_name')[$i],
                'bibadi_address'   => $request->input('bibadi_address')[$i],
                ]
                );
        }
        /* for ($i=0; $i<sizeof($request->input('bibadi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $id,
            'bibadi_name'     => $request->input('bibadi_name')[$i],
            'bibadi_spouse_name' => $request->input('bibadi_spouse_name')[$i],
            'bibadi_address'   => $request->input('bibadi_address')[$i],
            ];
            $case_bibadi = DB::table('case_bibadi')->select('id')->where('case_id',$id)->get();
        }

        $case_bibadi = DB::table('case_bibadi')->select('id','bibadi_name')->where('case_id',$id)->get();
        $db_case_bibadi=count($case_bibadi);

        foreach ($case_bibadi as $key => $value) {
            $dynamic_data = [
            'case_id'       => $id,
            'bibadi_name'     => $request->input('bibadi_name')[$key],
            'bibadi_spouse_name' => $request->input('bibadi_spouse_name')[$key],
            'bibadi_address'   => $request->input('bibadi_address')[$key],
            ];
            $case_bibadi = DB::table('case_bibadi')->where('id',$value->id)->update($dynamic_data);
        }

        for ($i=$db_case_bibadi; $i<sizeof($request->input('bibadi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $id,
            'bibadi_name'     => $request->input('bibadi_name')[$i],
            'bibadi_spouse_name' => $request->input('bibadi_spouse_name')[$i],
            'bibadi_address'   => $request->input('bibadi_address')[$i],
            ];
            CaseBibadi::create($dynamic_data);
        }*/
        //====================================Survey==================================//

        // Survey

        for ($i=0; $i<sizeof($request->input('khotian_no')); $i++) {
            // dd($request->all());
            DB::table('case_survey')->updateOrInsert(
                ['id' => $request->input('hide_survey_id')[$i]],
                [
                'case_id'       => $id,
                'st_id'         => $request->input('st_id')[$i],
                'khotian_no'    => $request->input('khotian_no')[$i],
                'daag_no'       => $request->input('daag_no')[$i],
                'lt_id'         => $request->input('lt_id')[$i],
                'land_size'     => $request->input('land_size')[$i],
                'land_demand'   => $request->input('land_demand')[$i],
                ]
                );
        }
        /*for ($i=0; $i<sizeof($request->input('khotian_no')); $i++) {
            $dynamic_data = [
            'case_id'       => $id,
            'st_id'         => $request->input('st_id')[$i],
            'khotian_no'    => $request->input('khotian_no')[$i],
            'daag_no'       => $request->input('daag_no')[$i],
            'lt_id'         => $request->input('lt_id')[$i],
            'land_size'     => $request->input('land_size')[$i],
            'land_demand'   => $request->input('land_demand')[$i],
            ];
            $case_survey = DB::table('case_survey')->select('id')->where('case_id',$id)->get();
        }

        $case_survey = DB::table('case_survey')->select('id','khotian_no')->where('case_id',$id)->get();
        $db_case_survey=count($case_survey);

        foreach ($case_survey as $key => $value) {
            $dynamic_data = [
            'case_id'       => $id,
            'st_id'         => $request->input('st_id')[$key],
            'khotian_no'    => $request->input('khotian_no')[$key],
            'daag_no'       => $request->input('daag_no')[$key],
            'lt_id'         => $request->input('lt_id')[$key],
            'land_size'     => $request->input('land_size')[$key],
            'land_demand'   => $request->input('land_demand')[$key],
            ];
            $case_survey = DB::table('case_survey')->where('id',$value->id)->update($dynamic_data);
        }

        for ($i=$db_case_survey; $i<sizeof($request->input('st_id')); $i++) {
        // dd($id);

            $dynamic_data = [
            'case_id'       => $id,
            'st_id'         => $request->input('st_id')[$i],
            'khotian_no'    => $request->input('khotian_no')[$i],
            'daag_no'       => $request->input('daag_no')[$i],
            'lt_id'         => $request->input('lt_id')[$i],
            'land_size'     => $request->input('land_size')[$i],
            'land_demand'   => $request->input('land_demand')[$i],
            ];
            CaseSurvey::create($dynamic_data);
        }*/

        // return redirect('case');

        //========= Case Activity Log -  start ============
        $caseRegister = CaseRegister::findOrFail($id)->toArray();
        $caseRegisterData = array_merge( $caseRegister, [
            'badi' => [
                'badi_name'     => $request->badi_name,
                'badi_spouse_name' => $request->badi_spouse_name,
                'badi_address'   => $request->badi_address,
            ],
            'bibadi' => [
                'bibadi_name'     => $request->bibadi_name,
                'bibadi_spouse_name' => $request->bibadi_spouse_name,
                'bibadi_address'   => $request->bibadi_address,
            ],
            'case_survey' => [
                'st_id' => $request->st_id,
                'khotian_no' => $request->khotian_no,
                'daag_no' => $request->daag_no,
                'lt_id'  => $request->lt_id,
                'land_size'   => $request->land_size,
                'land_demand'   => $request->land_demand,
            ],
        ]);
        $cs_activity_data['case_register_id'] = $id;
        $cs_activity_data['activity_type'] = 'Update';
        $cs_activity_data['message'] = 'পুরাতন মামলা আপডেট করা হয়েছে';
        $cs_activity_data['old_data'] = json_encode($case_old_data);
        $cs_activity_data['new_data'] = json_encode($caseRegisterData);
        case_activity_logs($cs_activity_data);
        // ========= Case Activity Log  End ==========

        return redirect()->route('case.old')
        ->with('success', 'মামলার তথ্য সফলভাবে সিষ্টেম আপডেট করা হয়েছে');
    }


    /**************************************************************/
    /********************* Appeal Case Register *******************/
    /**************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CaseRegister  $caseRegister
     * @return \Illuminate\Http\Response
     */
    public function create_appeal_case($id)
    {
        // ->where('id',$id)->first();
        $data['info'] = DB::table('case_register')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        // ->join('case_type', 'case_register.ct_id', '=', 'case_type.id')
        ->join('case_status', 'case_register.cs_id', '=', 'case_status.id')
        ->select('case_register.*', 'court.court_name', 'upazila.upazila_name_bn', 'mouja.mouja_name_bn', 'case_status.status_name')
        ->where('case_register.id', $id)
        ->first();
        // dd($data['info']->id);

        $data['badis_list'] =DB::table('case_badi')
        ->join('case_register', 'case_badi.case_id', '=', 'case_register.id')
        ->select('case_badi.*')
        ->where('case_badi.case_id', '=', $id)
        ->get();

        $data['bibadis_list'] =DB::table('case_bibadi')
        ->join('case_register', 'case_bibadi.case_id', '=', 'case_register.id')
        ->select('case_bibadi.*')
        ->where('case_bibadi.case_id', '=', $id)
        ->get();

        $data['survey_list'] =DB::table('case_survey')
        ->join('case_register', 'case_survey.case_id', '=', 'case_register.id')
        ->join('survey_type', 'case_survey.st_id', '=', 'survey_type.id')
        ->join('land_type', 'case_survey.lt_id', '=', 'land_type.id')
        ->select('case_survey.*','survey_type.st_name','land_type.lt_name')
        ->where('case_survey.case_id', '=', $id)
        ->get();

        // dd($data['surveys'][0]);

        // Dropdown List
        $data['courts'] = DB::table('court')->select('id', 'court_name')->get();
        $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', 38)->get();
        $data['moujas'] = DB::table('mouja')->select('id', 'mouja_name_bn')->where('upazila_id', $data['info']->upazila_id)->get();
        $data['case_types'] = DB::table('case_type')->select('id', 'ct_name')->get();
        $data['surveys'] = DB::table('survey_type')->select('id', 'st_name')->get();
        $data['land_types'] = DB::table('land_type')->select('id', 'lt_name')->get();

        $data['page_title'] = 'নতুন আপিল মামলার এন্ট্রি ফরম'; //exit;

        // return view('case.case_add', compact('page_title', 'case_type'));
        return view('case.create_appeal_case')->with($data);
    }



    public function store_appeal_case(Request $request, $id = '')
    {
        // $name = $request->input('name');

        /*$id = 'id';*/
        // dd($id);
        //Auth User Info
        $ref_case_num = DB::table('case_register')->select('case_number')->where('id', $id)->first()->case_number;
        // dd($ref_case_num);
        $userDivision = user_division();
        $userDistrict = user_district();
        // Form validation
        $request->validate([
            'court' => 'required',
            'upazila' => 'required',
            'mouja' => 'required',
            // 'case_type' => 'required',
            'case_no' => 'required',
            'case_date' => 'required',
            'show_cause' => 'required|mimes:pdf|max:10240',
            ],
            [
            'court.required' => 'আদালতের নাম নির্বাচন করুন',
            'upazila.required' => 'উপজেলা নির্বাচন করুন',
            'mouja.required' => 'মৌজা নির্বাচন করুন',
            'case_type.required' => 'মামলার ধরণ নির্বাচন করুন',
            'case_no.required' => 'মামলা নং নির্বাচন করুন',
            'case_date.required' => 'মামলা রুজুর তারিখ নির্বাচন করুন',
            'show_cause.required' => 'কারণ দর্শানোর নোটিশ পিডিএফ ফাইল ফরমেটে নির্বাচন করুন',
            ]);

        // Dynamic form validation
        if($request->input('badi_name')){
            foreach($request->input('badi_name') as $key => $val)
            {
                $request->validate([
                    'badi_name.'.$key => 'required',
                    'badi_spouse_name.'.$key => '',
                    'badi_address.'.$key => '',
                    ]);
            }
        }

        // dd($request->all());
        // $input = $request->all();

        // File upload
        if($request->show_cause != NULL){
            $fileName = $request->court.'_'.time().'.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/show_cause'), $fileName);
        }else{
            $fileName = NULL;
        }

        // Convert DB date formate
        $caseDate = $request->case_date;
        $date_format = str_replace('/', '-', $caseDate);

        // Make case_register table data array
        $data = [
        'cs_id'         => 1,
        'is_lost_appeal'=> 1,
        'action_user_group_id' => Auth::user()->role_id,
        'ref_id'        => $id,
        'ref_case_no'   => $ref_case_num,
        'court_id'      => $request->court,
        'case_number'   => $request->case_no,
        'case_date'     => date("Y-m-d", strtotime($date_format)),
        // 'ct_id'         => $request->case_type,
        'mouja_id'      => $request->mouja,
        'upazila_id'    => $request->upazila,
        'district_id'   => $userDistrict,
        'division_id'   => $userDivision,
        'tafsil'        => $request->tafsil,
        'chowhaddi'     => $request->chowhaddi,
        'comments'      => $request->comments,
        'show_cause_file' => $fileName,
        'user_id'       => Auth::id(),
        'created_at'    => date('Y-m-d H:i:s'),
        ];

        // $badi = $request->input('badi_name');
        // dd($data);

        // Inser to DB
        // CaseRegister::create($data);
        $ID = DB::table('case_register')->insertGetId($data);

        // Insert Badi Table
        for ($i=0; $i<sizeof($request->input('badi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $ID,
            'badi_name'     => $_POST['badi_name'][$i],
            'badi_spouse_name' => $_POST['badi_spouse_name'][$i],
            'badi_address'   => $_POST['badi_address'][$i],
            ];
            DB::table('case_badi')->insert($dynamic_data);
        }

        // Insert Bibadi Table
        for ($i=0; $i<sizeof($request->input('bibadi_name')); $i++) {
            $dynamic_data = [
            'case_id'       => $ID,
            'bibadi_name'     => $_POST['bibadi_name'][$i],
            'bibadi_spouse_name' => $_POST['bibadi_spouse_name'][$i],
            'bibadi_address'   => $_POST['bibadi_address'][$i],
            ];
            DB::table('case_bibadi')->insert($dynamic_data);
        }

        // Insert Bibadi Table
        for ($i=0; $i<sizeof($request->input('st_id')); $i++) {
            $dynamic_data = [
            'case_id'       => $ID,
            'st_id'         => $_POST['st_id'][$i],
            'khotian_no'    => $_POST['khotian_no'][$i],
            'daag_no'       => $_POST['daag_no'][$i],
            'lt_id'         => $_POST['lt_id'][$i],
            'land_size'     => $_POST['land_size'][$i],
            'land_demand'   => $_POST['land_demand'][$i],
            ];
            DB::table('case_survey')->insert($dynamic_data);
        }

        // Change Case Status 'Appeal' reference case id
        $data=[
            'status'  => 2,
        ];
        $ID = DB::table('case_register')
        ->where('id', $id)
        ->update($data);
        // return redirect('case');

        //========= Case Activity Log -  start ============
        $caseRegister = CaseRegister::findOrFail($id)->toArray();
        $caseRegisterData = array_merge( $caseRegister, [
            'badi' => [
                'badi_name'     => [$request->badi_name],
                'badi_spouse_name' => [$request->badi_spouse_name],
                'badi_address'   => [$request->badi_address],
            ],
            'bibadi' => [
                'bibadi_name'     => [$request->bibadi_name],
                'bibadi_spouse_name' => [$request->bibadi_spouse_name],
                'bibadi_address'   => [$request->bibadi_address],
            ],
            'case_survey' => [
                'st_id' => [$request->st_id],
                'khotian_no' => [$request->khotian_no],
                'daag_no' => [$request->daag_no],
                'lt_id'  => [$request->lt_id],
                'land_size'   => [$request->land_size],
                'land_demand'   => [$request->land_demand],
            ],
        ]);
        $cs_activity_data['case_register_id'] = $ID;
        $cs_activity_data['activity_type'] = 'Create';
        $cs_activity_data['message'] = 'আপিল মামলা রেজিস্ট্রেশন করা হয়েছে ';
        $cs_activity_data['old_data'] = null;
        $cs_activity_data['new_data'] = json_encode($caseRegisterData);
        case_activity_logs($cs_activity_data);
        // ========= Case Activity Log  End ==========
        return redirect()->route('case')
        ->with('success', 'মামলার তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে');
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CaseRegister  $caseRegister
     * @return \Illuminate\Http\Response
     */
    public function destroy(CaseRegister $caseRegister)
    {
        //
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    /*public function messages()
    {
        return [
        'court.required' => 'আদালতের নাম নির্বাচন করুন',
        'upazila.required' => 'উপজেলা নির্বাচন করুন',
        'mouja.required' => 'মৌজা নির্বাচন করুন',
        ];
    }*/

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
        // dd($id);
        // $this->CaseBadi->deleteBadi('id', $id);
        DB::table('case_badi')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function ajaxBibadiDelete($id)
    {
        // $this->Common_model->delete('pds_education', 'id', $id);
        DB::table('case_bibadi')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function ajaxSurvayDelete($id)
    {
        // $this->Common_model->delete('pds_education', 'id', $id);
        DB::table('case_survey')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

}
