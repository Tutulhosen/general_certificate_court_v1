<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Action;
use App\Models\CaseRegister;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonController;
use App\Models\AtCaseHearing;
use App\Models\AtCaseRegister;
use App\Models\CaseHearing;
use App\Models\CaseSF;
use App\Models\CaseSFlog;
use App\Models\Role;
use App\Models\AtCaseSFlog;
use App\Models\AtCaseSF;
use App\Models\Division;
// use Validator, Input, Redirect;
use Illuminate\Support\Facades\Validator;
// use Mpdf\Mpdf;

class AtCaseActionController extends Controller
{
    public function pdf_sf($id){
        $userID = Auth::user()->id;
        $officeInfo = user_office_info();

        $data['info'] = DB::table('case_register')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        // ->join('case_type', 'case_register.ct_id', '=', 'case_type.id') 'case_type.ct_name',
        ->join('case_status', 'case_register.cs_id', '=', 'case_status.id')
        // ->leftJoin('case_badi', 'case_register.id', '=', 'case_badi.case_id')
        // ->leftJoin('case_bibadi', 'case_register.id', '=', 'case_bibadi.case_id')
        ->select('case_register.*', 'court.court_name', 'upazila.upazila_name_bn', 'mouja.mouja_name_bn', 'case_status.status_name')
        ->where('case_register.id', '=', $id)
        ->first();

        //dd($data['info']);

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

        $data['surveys'] = DB::table('case_survey')
        ->join('case_register', 'case_survey.case_id', '=', 'case_register.id')
        ->join('survey_type', 'case_survey.st_id', '=', 'survey_type.id')
        ->join('land_type', 'case_survey.lt_id', '=', 'land_type.id')
        ->select('case_survey.*','survey_type.st_name','land_type.lt_name')
        ->where('case_survey.case_id', '=', $id)
        ->get();

        // Get User Sign
        /*$data['user'] = DB::table('users')
        ->select('signature')
        ->where('id', '=', $userID)
        ->first();*/
        // Get SF Details
        $data['sf'] = DB::table('case_sf')
        ->orderBy('id', 'DESC')
        ->select('case_sf.*')
        ->where('case_sf.case_id', '=', $id)
        ->first();

        // Get Upazila based Role Signature

        $data['upazila_signatures'] = DB::table('users')
        ->select('users.name', 'role.role_name', 'office.office_name_bn', 'users.signature')
        ->join('role', 'role.id', '=', 'users.role_id')
        ->join('office', 'office.id', '=', 'users.office_id')
        ->where('office.upazila_id', '=', $data['info']->upazila_id)
        ->whereIn( 'users.role_id', [9, 10, 11, 12])
        // ->groupBy('users.id')
        ->get();
        // dd($data['upazila_signatures']);
        // Get SF Signature

       /* $data['sf_signatures'] = DB::table('case_sf_log')
        ->select('case_sf_log.user_id', 'users.name', 'role.role_name', 'office.office_name_bn', 'users.signature')
        ->join('users', 'users.id', '=', 'case_sf_log.user_id')
        ->join('role', 'role.id', '=', 'users.role_id')
        ->join('office', 'office.id', '=', 'users.office_id')
        ->where('case_sf_log.case_id', '=', $id)
        ->groupBy('case_sf_log.user_id')
        ->get();*/
        // dd($data['info']);

        // Generate PDF
        $data['id'] = $id;
        $data['page_title'] = 'এস এফ প্রতিবেদন'; //exit;
        $html = view('action.pdf_sf')->with($data);
        // echo 'hello';

        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font'      => 'kalpurush'
            ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function details($id)
    {
        // return 'minar';
        // $roleID = Auth::user()->role_id;
        // $officeInfo = user_office_info();

        $data['info'] = AtCaseRegister::findOrFail($id);
        $data['roles'] = Role::all();
        $data['AtCaseSF'] = AtCaseSF::orderby('id', 'DESC')->where('at_case_id', $data['info']->id)->first();


        // $data['info'] = DB::table('case_register')
        //     ->join('court', 'case_register.court_id', '=', 'court.id')
        //     ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        //     ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        //     ->join('role', 'case_register.action_user_group_id', '=', 'role.id')
        //     ->join('case_status', 'case_register.cs_id', '=', 'case_status.id')
        //     ->select('case_register.*', 'court.court_name', 'upazila.upazila_name_bn', 'mouja.mouja_name_bn', 'role.role_name', 'case_status.status_name')
        //     ->where('case_register.id', '=', $id)
        //     ->first();


        // $data['surveys'] = DB::table('case_survey')
        // ->join('case_register', 'case_survey.case_id', '=', 'case_register.id')
        // ->join('survey_type', 'case_survey.st_id', '=', 'survey_type.id')
        // ->join('land_type', 'case_survey.lt_id', '=', 'land_type.id')
        // ->select('case_survey.*','survey_type.st_name','land_type.lt_name')
        // ->where('case_survey.case_id', '=', $id)
        // ->get();

        // // Get SF Details
        // $data['sf'] = DB::table('case_sf')
        // ->select('case_sf.*')
        // ->orderBy('id', 'DESC')
        // ->where('case_sf.case_id', '=', $id)
        // ->first();
        // // dd($data['info']);

        // // Get Upazila based Role Signature
        // $roleGroup = ['9','10','11','12'];

        // $data['upazila_signatures'] = DB::table('users')
        // ->select('users.name', 'role.role_name', 'office.office_name_bn', 'users.signature')
        // ->join('role', 'role.id', '=', 'users.role_id')
        // ->join('office', 'office.id', '=', 'users.office_id')
        // ->where('office.upazila_id','=',$data['info']->upazila_id)
        // ->whereIn( 'users.role_id', [9, 10, 11, 12])
        // // ->groupBy('users.id')
        // ->get();


        // // Get SF Details
        // $data['logs'] = DB::table('case_log')
        // ->select('case_log.comment', 'case_log.created_at', 'case_status.status_name', 'role.role_name', 'users.name')
        // ->join('case_status', 'case_status.id', '=', 'case_log.status_id')
        // ->leftJoin('role', 'case_log.send_user_group_id', '=', 'role.id')
        // ->join('users', 'case_log.user_id', '=', 'users.id')
        // ->where('case_log.case_id', '=', $id)
        // ->orderBy('case_log.id', 'desc')
        // ->get();
        // // dd($data['sf']);

        // // Get SF Details
        // $data['hearings'] = DB::table('case_hearing')
        // ->select('case_hearing.*')
        // ->where('case_hearing.case_id', '=', $id)
        // ->orderBy('case_hearing.id', 'desc')
        // ->get();

        // Get Case Forward Map
        // Current Role ID
        $roleID = Auth::user()->role_id;
        $data['forward_map'] = DB::table('case_forward_map')
        ->where('case_forward_map.sender_role_id', '=', $roleID)
        ->first();
        // dd($data['forward_map']);

        // Dropdown
        // Roles
        // $data['roles'] = DB::table('role')
        // ->select('id', 'role_name')
        // ->where('in_action', '=', 1)
        // ->orderBy('sort_order', 'asc')
        // ->get();

        // // User
        // $data['users'] = DB::table('users')
        // ->select('id', 'name')
        // ->where('users.role_id', '=', 14)
        // ->get();

        // // Court
        // $data['court'] = DB::table('court')
        // ->select('id', 'court_name')
        // ->where('court.district_id','=', $officeInfo->district_id)
        // ->get();

        // // Case Status
        // $data['case_status'] = DB::table('case_status')
        // ->get();

        // // Case Condition
        // $data['case_condition'] = DB::table('case_condition')
        // ->select('id', 'condition_name')
        // ->get();

        // // Reference Case Details

        // if($data['info']->ref_id){
        //     $data['ref_case'] = DB::table('case_register')
        //     ->select('case_register.id','case_register.is_sf','case_register.sf_report','case_register.is_win','case_register.in_favour_govt')
        //     ->where('case_register.id', '=', $data['info']->ref_id)
        //     ->first();

        //     //refrence case hearing

        //     $data['ref_case_hearings'] = DB::table('case_hearing')
        //     ->select('case_hearing.*')
        //     ->where('case_hearing.case_id', '=', $data['info']->ref_id)
        //     ->orderBy('case_hearing.id', 'desc')
        //     ->get();

        // }

        // dd($data['ref_case']);
        // return $data;


        $data['page_title'] = 'মামলার বিস্তারিত তথ্য'; //exit;
        return view('at_case.action.case_details')->with($data);
    }

    public function receive($statusID)
    {
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();

        // echo $roleID = Auth::user()->role_id; exit;
        // dd($officeInfo);
        $query= DB::table('case_register')
        ->orderBy('id','DESC')
        ->join('court', 'case_register.court_id', '=', 'court.id')
        ->join('district', 'case_register.district_id', '=', 'district.id')
        ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        ->select('case_register.*', 'court.court_name', 'mouja.mouja_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn')
        ->where('case_register.cs_id', '=', $statusID)
        ->where('case_register.action_user_group_id', '=', $roleID);

        // ->where('case_register.district_id','=', $officeInfo->district_id)
        // Check User Role ID
        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $query->where('case_register.district_id','=', $officeInfo->district_id);
            //$query->where('case_register.district_id','=', $officeInfo->district_id);
        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11){
            // dd($officeInfo->upazila_id);
            $query->where('case_register.upazila_id','=', $officeInfo->upazila_id);
            // $query->where('case_register.upazila_id','=', $officeInfo->upazila_id);
        }elseif($roleID == 12){
            $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
           // dd($moujaIDs);
           /*
            print_r($moujaIDs); exit;*/
            $query->whereIn('case_register.mouja_id', $moujaIDs);
        }
        // $query->where('case_register.action_user_group_id', '=', Auth::user()->role_id);
        $data['cases'] = $query->get();
        // dd($data['cases']);

        // return view('dashboard.receive', compact('page_title', 'cases'))
        // ->with('i', (request()->input('page',1) - 1) * 5);

        // All user list
        // $cases = CaseRegister::latest()->paginate(10);
        // $data['page_title'] = 'নতুন মামলা রেজিস্টার এন্ট্রি ফরম'; //exit;

        $data['page_title'] = 'মামলার তালিকা';
        return view('action.receive')->with($data);
    }


    public function get_mouja_by_ulo_office_id($officeID){
        return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
        // return DB::table('mouja_ulo')->select('mouja_id')->where('ulo_office_id', $officeID)->get();
        // return DB::table('division')->select('id', 'division_name_bn')->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_sf(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'sf_details' => 'required',
        ],
        [
            'sf_details.required'=> 'কারণ দর্শানো নোটিশের প্যারা ভিত্তিক জবাব লিখুন',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        // User Info
        $user = Auth::user();

        // Inputs
        $caseID = $request->case_id;
        $sfDetails = $request->sf_details;

        //case activity log start
        // $old_case_data = CaseRegister::findOrFail($caseID);
        // $old_CaseSFlog = CaseSFlog::orderby('id', 'DESC')
        //     ->where('case_id', $caseID)
        //     ->where('user_id', $user->id)
        //     ->first();
        //case activity log End

        // Insert data into at_case_sf table
        $sf_data = [
            'at_case_id'       => $caseID,
            'sf_details'    => $sfDetails,
            'user_id'       => $user->id,
        ];
        AtCaseSF::insert($sf_data);

        // Insert data at_case_sf_log Table
        $sf_log_data = [
            'at_case_id'       => $caseID,
            'sf_log_details'=> $sfDetails,
            'user_id'       => $user->id,
        ];
        AtCaseSFlog::insert($sf_log_data);

        // Update Case Register (is_sf(1), status(2), updated_at) table
        // $case_data = [
        //     'is_sf'     => 1,
        //     //'status'       => 2,
        //     //'updated_at'    => date('Y-m-d H:i:s'),
        // ];
        // DB::table('case_register')->where('id', $caseID)->update($case_data);

        //========= Case Activity Log -  start ============
        // $caseOldData = [];
        // $caseOldData = array_merge( $caseOldData, [
        // ['case_datas' => [
        //     'is_sf'     => $old_case_data->is_sf
        //     ]],
        // ]);
        // $caseNewData = [];
        // $caseNewData = array_merge( $caseNewData, [
        //     ['sf_data' => [$sf_data]],
        //     ['sf_log_data' => [$sf_log_data]],
        //     ['case_data' => [$case_data]],
        // ]);
        // $cs_activity_data['case_register_id'] = $caseID;
        // $cs_activity_data['activity_type'] = 'Create';
        // $cs_activity_data['message'] = 'এস এফ ফাইল তৈরী করা হয়েছে';
        // $cs_activity_data['old_data'] =json_encode($caseOldData);
        // $cs_activity_data['new_data'] = json_encode($caseNewData);
        // case_activity_logs($cs_activity_data);
        //========= Case Activity Log  End ==========

        //========== return new sf for instant view========
        // $data['info'] = DB::table('case_register')
        // ->join('court', 'case_register.court_id', '=', 'court.id')
        // ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        // ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        // ->join('role', 'case_register.action_user_group_id', '=', 'role.id')
        // ->join('case_status', 'case_register.cs_id', '=', 'case_status.id')
        // ->select('case_register.*', 'court.court_name', 'upazila.upazila_name_bn', 'mouja.mouja_name_bn', 'role.role_name', 'case_status.status_name')
        // ->where('case_register.id', '=', $caseID)
        // ->first();

        // $data['badis'] = DB::table('case_badi')
        // ->join('case_register', 'case_badi.case_id', '=', 'case_register.id')
        // ->select('case_badi.*')
        // ->where('case_badi.case_id', '=', $caseID)
        // ->get();

        // $data['bibadis'] = DB::table('case_bibadi')
        // ->join('case_register', 'case_bibadi.case_id', '=', 'case_register.id')
        // ->select('case_bibadi.*')
        // ->where('case_bibadi.case_id', '=', $caseID)
        // ->get();

        // $data['sf'] = DB::table('case_sf')
        // ->orderBy('id', 'DESC')
        // ->select('case_sf.*')
        // ->where('case_sf.case_id', '=', $caseID)
        // ->first();

        // $data['sf_signatures'] = DB::table('case_sf_log')
        // ->select('case_sf_log.user_id', 'users.name', 'role.role_name', 'office.office_name_bn', 'users.signature')
        // ->join('users', 'users.id', '=', 'case_sf_log.user_id')
        // ->join('role', 'role.id', '=', 'users.role_id')
        // ->join('office', 'office.id', '=', 'users.office_id')
        // ->where('case_sf_log.case_id', '=', $caseID)
        // ->groupBy('case_sf_log.user_id')
        // ->get();
        // $data['numb'] = random_int(100, 999);
        // $returnHTML = view('action.inc_case_details._return_sf')->with($data)->render();
         //========== end return new sf for instant view========

        // return response()->json(['success'=>'Data is successfully added','sfdata'=>'Data is successfully added', 'html' => $returnHTML]);
        return response()->json(['success'=>'Data is successfully added','sfdata'=>'Data is successfully added', 'html' => 'success']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit_sf(Request $request)
    {


        // return response()->json(['success'=>'Data is successfully updated','sfdata'=> 'SF Details', 'html' => $request->all()]);

        $validator = Validator::make($request->all(), [
            'sf_details' => 'required',
        ],
        [
            'sf_details.required'=> 'কারণ দর্শানো নোটিশের প্যারা ভিত্তিক জবাব লিখুন',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        // User Info
        $user = Auth::user();

        // // Inputs
        // $caseID = $request->case_id;
        // $sfID = $request->sf_id;
        // $sfDetails = $request->sf_details;

        // //Old Data
        // $oldCaseSF = CaseSF::findOrFail($sfID);
        // $old_case_data = CaseRegister::findOrFail($caseID);
        // $input = $request->all();
        // dd($sfDetails);

        // Get Previous SF Data
        // $sf_data = DB::table('case_sf')->select('case_sf.*')->where('case_sf.case_id', '=', $id)->first();

        // Update Case SF table


        // Insert data case_sf_log Table
        $sf_log_data = [
            'at_case_id'       => $request->case_id,
            'sf_log_details'=> $request->sf_details,
            'user_id'       => $user->id,
        ];
        AtCaseSFlog::insert($sf_log_data);


        //========= Case Activity Log -  start ============
        // $caseOldData = [];
        // $caseOldData = array_merge( $caseOldData, [
        //     ['case_datas' => [
        //         'is_sf'     => $old_case_data->is_sf
        //     ]],
        // ]);
        // $caseNewData = [];
        // $caseNewData = array_merge( $caseNewData, [
        //     ['sf_data' => [$sf_data]],
        //     ['sf_log_data' => [$sf_log_data]]
        // ]);
        // $cs_activity_data['case_register_id'] = $caseID;
        // $cs_activity_data['activity_type'] = 'Update';
        // $cs_activity_data['message'] = 'এস এফ ফাইল আপডেট করা হয়েছে';
        // $cs_activity_data['old_data'] =json_encode($caseOldData);
        // $cs_activity_data['new_data'] = json_encode($caseNewData);
        // case_activity_logs($cs_activity_data);
        //========= Case Activity Log  End ==========

        // $data['info'] = DB::table('case_register')
        // ->join('court', 'case_register.court_id', '=', 'court.id')
        // ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        // ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        // ->join('role', 'case_register.action_user_group_id', '=', 'role.id')
        // ->join('case_status', 'case_register.cs_id', '=', 'case_status.id')
        // ->select('case_register.*', 'court.court_name', 'upazila.upazila_name_bn', 'mouja.mouja_name_bn', 'role.role_name', 'case_status.status_name')
        // ->where('case_register.id', '=', $caseID)
        // ->first();

        // $data['badis'] = DB::table('case_badi')
        // ->join('case_register', 'case_badi.case_id', '=', 'case_register.id')
        // ->select('case_badi.*')
        // ->where('case_badi.case_id', '=', $caseID)
        // ->get();

        // $data['bibadis'] = DB::table('case_bibadi')
        // ->join('case_register', 'case_bibadi.case_id', '=', 'case_register.id')
        // ->select('case_bibadi.*')
        // ->where('case_bibadi.case_id', '=', $caseID)
        // ->get();

        // $data['sf'] = DB::table('case_sf')
        // ->orderBy('id', 'DESC')
        // ->select('case_sf.*')
        // ->where('case_sf.case_id', '=', $caseID)
        // ->first();

        // $data['sf_signatures'] = DB::table('case_sf_log')
        // ->select('case_sf_log.user_id', 'users.name', 'role.role_name', 'office.office_name_bn', 'users.signature')
        // ->join('users', 'users.id', '=', 'case_sf_log.user_id')
        // ->join('role', 'role.id', '=', 'users.role_id')
        // ->join('office', 'office.id', '=', 'users.office_id')
        // ->where('case_sf_log.case_id', '=', $caseID)
        // ->groupBy('case_sf_log.user_id')
        // ->get();
        // $data['numb'] = random_int(100, 999);
        // $returnHTML = view('action.inc_case_details._return_sf')->with($data)->render();
         //========== end return new sf for instant view========

        return response()->json(['success'=>'Data is successfully updated','sfdata'=> 'SF Details', 'html' => 'Success']);
    }

    /*
    public function hearing_add()
    {

        dd($request->all());


        $validator = \Validator::make($request->all(), [
            'hearing_date' => 'required',
            'hearing_comment' => 'required',
            'hearing_report' => 'required|mimes:pdf|max:10240',
            ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        // User Info
        $user = Auth::user();

        // Inputs
        $caseID = $request->case_id;
        // $hearingDate = $request->hearing_date;
        // Convert DB date formate
        $hearingDate = str_replace('/', '-', $request->hearing_date);
        $hearingComment = $request->hearing_comment;
        // $input = $request->all();
        // dd($request->all());

        //File Upload
        if($request->file('hearing_report')){
            $fileName = $caseID.'_'.time().'.'.$request->hearing_report->getClientOriginalExtension();
            $request->hearing_report->move(public_path('uploads/hearing'), $fileName);
        }else{
            $fileName = NULL;
        }

        // Insert data into case_sf table
        $hearing_data = [
        'case_id'       => $caseID,
        'hearing_date'  => date("Y-m-d", strtotime($hearingDate)),
        'hearing_file' => $fileName,
        'hearing_comment' => $hearingComment,
        'user_id'       => $user->id,
        'created_at'    => date('Y-m-d H:i:s'),
        ];
        // dd($hearing_data);
        DB::table('case_hearing')->insert($hearing_data);
        // dd($sf_data);

        /*
        // Update Case Register (is_sf(1), status(2), updated_at) table
        $case_data = [
        'is_sf'     => 1,
        //'status'       => 2,
        //'updated_at'    => date('Y-m-d H:i:s'),
        ];
        DB::table('case_register')->where('id', $caseID)->update($case_data);*/

        /*
        return response()->json(['success'=>'Data is successfully added','sfdata'=>'Data is successfully added']);
    }
    */


    /**
     * Show the application .
     *
     * @return \Illuminate\Http\Response
     */
    public function hearing_store(Request $request)
    {
        dd('hello');
        dd($request->all());

        // User Info

        $validator = Validator::make($request->all(), [
            'hearing_date' => 'required',
            'hearing_report' => 'required|max:10240',
            ]);
        $userID = Auth::user()->id;
        $caseID = $request->case_id;
        $caseHeringOldData = CaseHearing::orderby('id', 'DESC')->where('case_id', $caseID)->first()->toArray();

        dd($request->file('hearing_report'));

        if ($request->hearing_report != NULL) {
            // store file into document folder
            // $file = $request->file->store('public/documents');

            // store file into public folder with rename
            $fileName = $caseID.'_'.time().'.'.request()->hearing_report->getClientOriginalExtension();
            $request->hearing_report->move(public_path('uploads/hearing_report'), $fileName);
            // dd($fileName);

            // Update Case Register (hearing_report, updated_at) table
            $case_data = [
            'case_id'         => $caseID,
            'hearing_date'    => $request->hearing_date,
            'hearing_comment' => $request->hearing_comment,
            'hearing_file'    => $fileName,
            'user_id'         => $userID,
            'created_at'      => date('Y-m-d H:i:s'),
            ];
            // dd($case_data);
            DB::table('case_hearing')->insert($case_data);

            //========= Case Activity Log -  start ============
            $caseOldData = [];
            $caseOldData = array_merge( $caseOldData, [
                ['case_hearing' => [$caseHeringOldData]],
            ]);
            $caseNewData = [];
            $caseNewData = array_merge( $caseNewData, [
                ['case_hearing' => [$case_data]],
            ]);
            $cs_activity_data['case_register_id'] = $caseID;
            $cs_activity_data['activity_type'] = 'Create';
            $cs_activity_data['message'] = 'হিয়ারিং তৈরী করা হয়েছে';
            $cs_activity_data['old_data'] =json_encode($caseOldData);
            $cs_activity_data['new_data'] = json_encode($caseNewData);
            case_activity_logs($cs_activity_data);
            //========= Case Activity Log  End ==========
            return Response()->json(["success" => true]);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function result_update(Request $request)
    {
        // return response()->json(['success'=>'Data is successfully updated', 'html' => '$returnHTML' ]);

        $validator = Validator::make($request->all(), [
            'is_win' => 'required',
            // 'condition_name' => 'required',
            'result_file' => 'required|mimes:pdf|max:10240',
            ],
            [
                // 'condition_name.required' => 'মামলার বর্তমান অবস্থা নির্বাচন করুন',
                'result_file.required' => 'ফলাফলের ফাইল নির্বাচন করুন',
                'result_file.mimes' => 'শুধু মাত্র পিডিএফ ফাইল নির্বাচন করুন',
                'result_file.max' => 'সর্বোচ্চ ফাইলের আকার: ১০২৪০ কে বি',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $caseID = $request->hide_case_id;
        // $caseResOldData = CaseRegister::findOrFail($caseID);
        if($request->file('result_file')){
            $path = 'uploads/at_case/result_file';
            $fileName = $caseID.'_'.time().'.'.request()->result_file->getClientOriginalExtension();
            $request->result_file->move(public_path($path), $fileName);
        }

        $result = [
            'result'  => $request->is_win,
            'result_file'  => $path . '/' . $fileName,
            'govt_lost_reason'  => $request->lost_reason,
            // 'status'  => $request->condition_name,
            'status'  =>  3,
            // 'is_lost_appeal'  => $request->condition_name == '2' ? '1' : '0',
            'in_favour_govt'  => $request->is_win,
            'updated_at'  => now(),
        ];
        AtCaseRegister::whereId($caseID)->update($result);
        // DB::table('case_register')->where('id', $caseID)->update($result);

        //========= Case Activity Log -  start ============
        // $caseOldData = [];
        // $caseOldData = array_merge( $caseOldData, [
        //     ['case_register' => [
        //         'is_win'  => $caseResOldData->is_win,
        //         'case_result'  => $request->is_win == 1 ? '1' : ($request->is_win == 2 ? '0' : null),
        //         'lost_reason'  => $caseResOldData->lost_reason,
        //         'status'  => $caseResOldData->status,
        //         'is_lost_appeal'  => $caseResOldData->is_lost_appeal,
        //         'in_favour_govt'  => $caseResOldData->in_favour_govt,
        //         'updated_at'  => $caseResOldData->updated_at,
        //         ]
        //     ],
        // ]);
        // $caseNewData = [];
        // $caseNewData = array_merge( $caseNewData, [
        //     ['case_register' => [$result]],
        // ]);
        // $cs_activity_data['case_register_id'] = $caseID;
        // $cs_activity_data['activity_type'] = 'Update';
        // $cs_activity_data['message'] = 'মামলার ফলাফল আপডেট করা হয়েছে';
        // $cs_activity_data['old_data'] =json_encode($caseOldData);
        // $cs_activity_data['new_data'] = json_encode($caseNewData);
        // case_activity_logs($cs_activity_data);
        //========= Case Activity Log  End ==========

        // $data['info'] = DB::table('case_register')
        // ->join('court', 'case_register.court_id', '=', 'court.id')
        // ->join('upazila', 'case_register.upazila_id', '=', 'upazila.id')
        // ->join('mouja', 'case_register.mouja_id', '=', 'mouja.id')
        // ->join('role', 'case_register.action_user_group_id', '=', 'role.id')
        // ->join('case_status', 'case_register.cs_id', '=', 'case_status.id')
        // ->select('case_register.*', 'court.court_name', 'upazila.upazila_name_bn', 'mouja.mouja_name_bn', 'role.role_name', 'case_status.status_name')
        // ->where('case_register.id', '=', $caseID)
        // ->first();

        // $data['case_condition'] = DB::table('case_condition')
        // ->select('id', 'condition_name')
        // ->get();

        // $returnHTML = view('action.inc_case_details._case_result')->with($data)->render();

        return response()->json(['success'=>'Data is successfully updated', 'html' => '$returnHTML' ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function file_store(Request $request)
    {
        /*
        $request->validate([
            'sf_report' => 'required|mimes:pdf|max:10240',
        ]);

        $title = time().'.'.request()->sf_report->getClientOriginalExtension();
        $request->sf_report->move(public_path('uploads'), $title);
        // $storeFile = new Post;
        // $storeFile->title = $title;
        // $storeFile->save();

        return response()->json(['success'=>'File Uploaded Successfully']);
        */

        // Validation
        request()->validate([
            'sf_report'  => 'required|mimes:pdf|max:10240',
            ]);

        // $input = $request->all();
        // dd($request->hide_case_id);
        $caseID = $request->hide_case_id;
        // $caseResOldData = CaseRegister::findOrFail($caseID);


        if ($files = $request->file('sf_report')) {
            // store file into public folder with rename
            $fileName = $caseID.'_'.time().'.'.request()->sf_report->getClientOriginalExtension();
            $request->sf_report->move(public_path('uploads/sf_report'), $fileName);

            // Update Case Register (sf_report, updated_at) table
            $case_data = [
                'sf_scan1'     => $fileName,
                'updated_at'  => now()
            ];
            AtCaseRegister::whereId($request->sf_id)->update($case_data);

            //========= Case Activity Log -  start ============
            // $caseOldData = [];
            // $caseOldData = array_merge( $caseOldData, [
            //     ['case_register' => [
            //         'sf_report'     => $caseResOldData->sf_report,
            //         'updated_at'    => $caseResOldData->updated_at,
            //         ]
            //     ],
            // ]);
            // $caseNewData = [];
            // $caseNewData = array_merge( $caseNewData, [
            //     ['case_register' => [$case_data]],
            // ]);
            // $cs_activity_data['case_register_id'] = $caseID;
            // $cs_activity_data['activity_type'] = 'Update';
            // $cs_activity_data['message'] = 'মামলার এস এফ রিপোর্ট আপলোড করা হয়েছে';
            // $cs_activity_data['old_data'] =json_encode($caseOldData);
            // $cs_activity_data['new_data'] = json_encode($caseNewData);
            // case_activity_logs($cs_activity_data);
            //========= Case Activity Log  End ==========

            $returnHTML = '<embed src="' . asset('uploads/sf_report/' . $fileName) .'" type="application/pdf" width="100%" height="600px" />';

            return Response()->json(["success" => true, "html" => $returnHTML ]);
        }

        return Response()->json(["success" => false]);
    }

    public function file_store_hearing(Request $request)
    {
        // Validation
        request()->validate([
            'hearing_report'  => 'required|mimes:pdf|max:10240',
            ]);

        $caseID = $request->hide_case_id;
        $userID = Auth::user()->id;

        $caseHeringOldData = CaseHearing::orderby('id', 'DESC')->where('case_id', $caseID)->first();

        // Convert DB date formate
        $hearing_date = str_replace('/', '-', $request->hearing_date);

        if ($files = $request->file('hearing_report')) {
            // store file into document folder
            // $file = $request->file->store('public/documents');

            // store file into public folder with rename
            $fileName = $caseID.'_'.time().'.'.request()->hearing_report->getClientOriginalExtension();
            $request->hearing_report->move(public_path('uploads/order'), $fileName);
            // dd($fileName);

            // Update Case Register (sf_report, updated_at) table
            /*$case_data = [
            'sf_report'     => $fileName,
            'updated_at'    => date('Y-m-d H:i:s'),
            ];
            DB::table('case_register')->where('id', $caseID)->update($case_data);*/

            $at_case_data = [
            'at_case_id' => $caseID,
            'hearing_date'    => date("Y-m-d", strtotime($hearing_date)),
            'comments' => $request->hearing_comment,
            'hearing_file'    => $fileName,
            'user_id'         => $userID,
            ];
            AtCaseHearing::insert($at_case_data);

            //========= Case Activity Log -  start ============
            // $caseOldData = [];
            // $caseOldData = array_merge( $caseOldData, [
            //     ['case_hearing' => [$caseHeringOldData ? $caseHeringOldData->toArray() : null ]],
            // ]);
            // $caseNewData = [];
            // $caseNewData = array_merge( $caseNewData, [
            //     ['case_hearing' => [$case_data]],
            // ]);
            // $cs_activity_data['case_register_id'] = $caseID;
            // $cs_activity_data['activity_type'] = 'Create';
            // $cs_activity_data['message'] = 'মামলার হিয়ারিং ফাইল আপলোড করা হয়েছে';
            // $cs_activity_data['old_data'] =json_encode($caseOldData);
            // $cs_activity_data['new_data'] = json_encode($caseNewData);
            // case_activity_logs($cs_activity_data);
            //========= Case Activity Log  End ==========

            $data['info'] = AtCaseRegister::findOrFail($caseID);
            $returnHTML = view('at_case.action.inc_case_details._single_hearing_data')->with($data)->render();

            return Response()->json(["success" => true, "html" => $returnHTML ]);
        }

        return Response()->json(["success" => false]);
    }

    public function file_save(Request $request)
    {
        /*
        $request->validate([
            'sf_report' => 'required|mimes:pdf|max:10240',
        ]);

        $title = time().'.'.request()->sf_report->getClientOriginalExtension();
        $request->sf_report->move(public_path('uploads'), $title);
        // $storeFile = new Post;
        // $storeFile->title = $title;
        // $storeFile->save();

        return response()->json(['success'=>'File Uploaded Successfully']);
        */

        // Validation
        request()->validate([
            'hearing_report'  => 'required|mimes:pdf|max:10240',
            ]);

        // $input = $request->all();
        // dd($request->hide_case_id);
        $caseID = $request->hide_case_id;

        if ($files = $request->file('hearing_report')) {
            // store file into document folder
            // $file = $request->file->store('public/documents');

            // store file into public folder with rename
            $fileName = $caseID.'_'.time().'.'.request()->hearing_report->getClientOriginalExtension();
            $request->hearing_report->move(public_path('uploads/hearing'), $fileName);
            // dd($fileName);

            // Update Case Register (sf_report, updated_at) table
            $case_data = [
            'hearing_report'     => $fileName,
            // 'updated_at'    => date('Y-m-d H:i:s'),
            ];
            DB::table('case_hearing')->insert($case_data);/*
            DB::table('case_register')->where('id', $caseID)->update($case_data);*/

            //========= Case Activity Log - start ============
            $caseRegisterData = [
                'hearing_report'     => '/uploads/hearing' . $fileName
            ];
            $cs_activity_data['case_register_id'] = $caseID;
            $cs_activity_data['activity_type'] = 'Update';
            $cs_activity_data['message'] = 'হিয়ারিং রিপোর্ট আপলোড করা হয়েছে';
            $cs_activity_data['old_data'] = null;
            $cs_activity_data['new_data'] = json_encode($caseRegisterData);
            case_activity_logs($cs_activity_data);
            // ========= Case Activity Log  End ==========

            return Response()->json(["success" => true]);

        }

        return Response()->json(["success" => false]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDependentCaseStatus($id)
    {
       $case_status = DB::table('case_status')->whereRaw("find_in_set('".$id."',role_access)")->get();
       // $case_status = DB::table('case_status')->whereIn('role_access',[$id])->get();
       return Response()->json(['success' => true, 'case_status' => $case_status]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // return $request;
        // Case forward to other office
        $validator = Validator::make($request->all(), [
            'group' => 'required',
            'status_id' => 'required',
            'comment' => 'required',
            ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $case_old_data = CaseRegister::findOrFail($request->case_id);

        // User Info
        $user = Auth::user();

        // Inputs
        $roleGroup = $request->group;
        $caseID = $request->case_id;
        $input = $request->all();
        // dd($input);

        // Get Case Data
        $case = DB::table('case_register')
        ->select('id', 'cs_id', 'court_id', 'case_number', 'case_date', 'ct_id', 'mouja_id', 'upazila_id', 'district_id', 'tafsil', 'chowhaddi', 'show_cause_file', 'created_at')
        ->where('id', $caseID)
        ->first();

        // Insert data into case_log table
        $log_data = [
        'case_id'       => $caseID,
        'status_id'     => $request->status_id,
        'user_id'       => $user->id,
        'send_user_group_id' => $user->role_id,
        'receive_user_group_id' => $roleGroup,
        'comment'       => $request->comment,
        'created_at'    => date('Y-m-d H:i:s'),
        ];
        $logID = DB::table('case_log')->insertGetId($log_data);
        // Book::create($input);
        // dd($data_case_log);

        // Update Case Register (cs_id, action_user_group_id, status(2), updated_at) table
        $case_data = [
        'cs_id'     => $request->status_id,
        'action_user_group_id' => $roleGroup,
        // 'status'       => 1,
        'updated_at'    => date('Y-m-d H:i:s'),
        ];
        DB::table('case_register')->where('id', $caseID)->update($case_data);


        //========= Case Activity Log -  start ============
        $caseOldData = [];
        $caseOldData = array_merge( $caseOldData, [
            ['case_datas' => [
                'cs_id'     => $case_old_data->cs_id,
                'action_user_group_id'     => $case_old_data->action_user_group_id,
                'updated_at'     => $case_old_data->updated_at,
            ]],
        ]);
        $caseRegister = [];
        $caseRegisterData = array_merge( $caseRegister, [
            ['case_datas' => $case_data],
            ['log_datas' => [
                'log_data' => $log_data,
                'case_log_id'=> $logID,
                ]]
        ]);
        $cs_activity_data['case_register_id'] = $caseID;
        $cs_activity_data['activity_type'] = 'Update';
        $cs_activity_data['message'] = 'মামলাটি প্রেরণ করা হয়েছে';
        $cs_activity_data['old_data'] =json_encode($caseOldData);
        $cs_activity_data['new_data'] = json_encode($caseRegisterData);
        case_activity_logs($cs_activity_data);
        //========= Case Activity Log  End ==========

        return response()->json(['success'=>'Data is successfully added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function show(Action $action)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function edit(Action $action)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Action $action)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function destroy(Action $action)
    {
        //
    }

    public function test_pdf(){

        $data['id'] = '007';
        $data['page_title'] = 'মামলার বিস্তারিত তথ্য'; //exit;
        $html = view('action.test')->with($data);
        // echo 'hello';

        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font'      => 'kalpurush'
            ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
    public function menu_1(){
        $categories = Division::all();
        return view('te', compact('categories'));
    }
}
