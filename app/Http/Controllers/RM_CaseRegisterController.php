<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\RM_CaseBadi;
use App\Models\RM_CaseRgister;
use App\Models\RM_CaseBibadi;
use App\Models\RM_OtherFiles;
use App\Models\RM_CaseType;
use App\Models\RM_CaseLog;
use App\Models\Court;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Mouja;
use App\Models\JudgePanel;
use App\Models\AtCaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RM_CaseRegisterController extends Controller
{
    //
    public function index()
    {
        $officeInfo = user_office_info();
        $roleID = Auth::user()->role_id;
        
        $query =  RM_CaseRgister::orderby('id','DESC');

        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $query->whereBetween('.case_date', [$dateFrom, $dateTo]);
        }
       
        if(!empty($_GET['case_no'])) {
            $query->where('r_m__case_rgisters.case_no','=',$_GET['case_no']);
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
        if($roleID == 5 || $roleID == 7){
            $query->where('district_id',$officeInfo->district_id)->orderby('id','DESC');
        }elseif($roleID == 9 || $roleID == 21){
            $query->where('upazila_id',$officeInfo->upazila_id)->orderby('id','DESC');
        }

        $data['cases'] = $query->paginate(10);

          // Dorpdown
        $data['upazilas'] = NULL;
        // $data['courts'] = DB::table('court')->select('id', 'court_name')->get();
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
        $data['user_role'] = DB::table('role')->select('id', 'role_name')->get();
        if($roleID == 22 || $roleID == 23){
            $data['districts'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', $officeInfo->division_id)->get();
        }
        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13 || $roleID == 16){
            // $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }
        $data['page_title'] =   'ভূমি রাজস্ব মামলা এন্ট্রি রেজিষ্টারের তালিকা';
        // return $atcases;
        // return $data['cases'];
        // dd($data['cases']);
        return view('rm_case.rm_case_register.index')->with($data);
    }
    public function index_old()
    {
        $officeInfo = user_office_info();
        $roleID = Auth::user()->role_id;

        if($roleID == 2 || $roleID == 22 || $roleID == 23 || $roleID == 24 || $roleID == 25 || $roleID == 1){

            $data['cases'] =  RM_CaseRgister::orderby('id','DESC')->paginate(10);

        }elseif($roleID == 5 || $roleID == 7){
            $data['cases'] =  RM_CaseRgister::where('district_id',$officeInfo->district_id)->orderby('id','DESC')->paginate(10);
        }elseif($roleID == 9 || $roleID == 21){
            $data['cases'] =  RM_CaseRgister::where('upazila_id',$officeInfo->upazila_id)->orderby('id','DESC')->paginate(10);
        }



        $data['page_title'] =   'ভূমি রাজস্ব মামলা এন্ট্রি রেজিষ্টারের তালিকা';
        // return $atcases;
        // return $data['cases'];
        // dd($data['cases']);
        return view('rm_case.rm_case_register.index')->with($data);
    }

    public function create()
    {
        $roleID = Auth::user()->role_id;
        if( $roleID != 24){
            $userDivision = user_division();
        }
        if($roleID != 22 && $roleID != 24){
            $userDistrict = user_district();
        }
        if ($roleID != 5 && $roleID != 22 && $roleID != 24 ) {
            $userUpazila = user_upazila();
            // $data['moujas'] = Mouja::where('upazila_id', $userUpazila)->get();
        }
        // Dropdown List
        $data['case_types'] = RM_CaseType::whereRaw("FIND_IN_SET('$roleID',access_role)")->get();
        // $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
        if($roleID == 24){

            $data['divisions'] = DB::table('division')
                ->select('id', 'division_name_bn')
                ->get();
        }
        if($roleID == 22){

            $data['districts'] = DB::table('district')
                ->select('id', 'district_name_bn')
                ->where('division_id', $userDivision)
                ->get();
        }
        if($roleID == 5){

            $data['upazilas'] = DB::table('upazila')
                ->select('id', 'upazila_name_bn')
                ->where('district_id', $userDistrict)
                ->get();
        }
        $data['surveys'] = DB::table('survey_type')->select('id', 'st_name')->get();
        $data['land_types'] = DB::table('land_type')->select('id', 'lt_name')->get();

        // dd($data);
        // dd($case_type);
        // $data['subcategories'] = DB::table("mouja")->where("upazila_id",38)->pluck("mouja_name_bn","id");

        $data['page_title'] = 'নতুন ভূমি রাজস্ব মামলা রেজিস্টার এন্ট্রি ফরম';
        return view('rm_case.rm_case_register.create')->with($data);
    }

    public function store(Request $request)
    {
        // return $request;

        $roleID = Auth::user()->role_id;
        if( $roleID != 24){
            $userDivision = user_division();
        }else{
            $userDivision =$request->division;
        }
        if($roleID != 22 && $roleID != 24){
            $userDistrict = user_district();
        }else{
            $userDistrict =$request->district;
        }
        if ($roleID != 5 && $roleID != 22 && $roleID != 24 ) {
            $userUpazila = user_upazila();
        }else{
            $userUpazila = $request->upazila;
        }

         $request->validate([
            'case_type' => 'required',
            'case_no' => 'required',
            'case_date' => 'required',
            'show_cause' => 'required|mimes:pdf|max:10240',
            ],
            [
            'case_type.required' => 'মামলার ধরণ নির্বাচন করুন',
            'case_no.required' => 'মামলা নং নির্বাচন করুন',
            'case_date.required' => 'মামলা রুজুর তারিখ নির্বাচন করুন',
            'show_cause.required' => 'কারণ দর্শানোর নোটিশ পিডিএফ ফাইল ফরমেটে নির্বাচন করুন',
            ]);
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
        if($request->input('bibadi_name')){
            foreach($request->input('bibadi_name') as $key => $val)
            {
                $request->validate([
                    'bibadi_name.'.$key => 'required',
                    'bibadi_spouse_name.'.$key => '',
                    'bibadi_address.'.$key => '',
                    ]);
            }
        }

        // File upload
        $filePath = 'uploads/rm_case/arji/';
        if($request->show_cause != NULL){
            $fileName = $request->court.'_'.time().'.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/rm_case/arji/'), $fileName);
        }else{
            $fileName = NULL;
        }

        //Case Data
        $caseDate = $request->case_date;
        $date_format = str_replace('/', '-', $caseDate);
        $atCase_date = date("Y-m-d", strtotime($date_format));

        $rmcase = new RM_CaseRgister();
        $rmcase->action_user_role_id = Auth::user()->role_id;
        $rmcase->user_id = Auth::user()->id;
        $rmcase->status = 1;
        $rmcase->division_id = $userDivision;
        $rmcase->district_id = $userDistrict;
        $rmcase->upazila_id = $userUpazila;
        // $rmcase->mouja_id = $request->mouja;
        $rmcase->case_no = $request->case_no;
        $rmcase->case_date = $atCase_date;
        $rmcase->case_type_id = $request->case_type;
        $rmcase->comments = $request->comments;
        $rmcase->case_status_id = 21;
        $rmcase->arji_file = $filePath.$fileName;

        if($rmcase->save()){
            foreach($request->badi_name as $key => $val)
            {
                $rmcaseBadi = new RM_CaseBadi();
                $rmcaseBadi->rm_case_id = $rmcase->id;
                $rmcaseBadi->name = $request->badi_name[$key];
                $rmcaseBadi->spouse_name = $request->badi_spouse_name[$key];
                $rmcaseBadi->address = $request->badi_address[$key];
                $rmcaseBadi->save();
            }


            foreach($request->bibadi_name as $key => $val)
            {
                $rmcaseBibadi = new RM_CaseBibadi();
                $rmcaseBibadi->rm_case_id = $rmcase->id;
                $rmcaseBibadi->name = $request->bibadi_name[$key];
                $rmcaseBibadi->spouse_name = $request->bibadi_spouse_name[$key];
                $rmcaseBibadi->address = $request->bibadi_address[$key];
                $rmcaseBibadi->save();
            }

            $files = [];
            // return $request->file_name;
            foreach($request->file_type as $key => $val)
            {
                $filePath = 'uploads/rm_case/others/';
                if($request->file_name[$key] != NULL){
                    $otherfileName = $userDivision.'_'.time().'.'.rand().'.'.$request->file_name[$key]->extension();
                    $request->file_name[$key]->move(public_path('uploads/rm_case/others/'), $otherfileName);
                }/*else{
                    $otherfileName = NULL;
                }*/
                $files[] = $otherfileName;
                // return $files;
                $rmcaseBadi = new RM_OtherFiles();
                $rmcaseBadi->rm_case_id = $rmcase->id;
                $rmcaseBadi->file_type = $request->file_type[$key];
                $rmcaseBadi->file_name = $filePath.$files[$key];
                $rmcaseBadi->save();
            }
        }

        $log_data = [
            'rm_case_id'       => $rmcase->id,
            'case_status_id'     => 21,
            'user_id'       => Auth::user()->id,
            // 'sender_user_role_id' => $user->role_id,
            'receiver_user_role_id' => Auth::user()->role_id,
            // 'comments'       => $request->comment,
        ];
        RM_CaseLog::insert($log_data);

        //========= RM Case Activity Log -  start ============
        $caseRegister = RM_CaseRgister::findOrFail($rmcase->id)->toArray();
        $caseRegisterData = array_merge( $caseRegister, [
            'badi' => RM_CaseBadi::where('rm_case_id', $rmcase->id)->get()->toArray(),
            'bibadi' => RM_CaseBadi::where('rm_case_id', $rmcase->id)->get()->toArray(),
            'log_data' => RM_CaseLog::where('rm_case_id', $rmcase->id)->get()->toArray(),
        ]);
        // return $caseRegisterData;
        $cs_activity_data['rm_case_id'] = $rmcase->id;
        $cs_activity_data['activity_type'] = 'create';
        $cs_activity_data['message'] = 'নতুন রাজস্ব মামলা রেজিস্ট্রেশন করা হয়েছে';
        $cs_activity_data['old_data'] = null;
        $cs_activity_data['new_data'] = json_encode($caseRegisterData);
        RM_case_activity_logs($cs_activity_data);
        // ========= RM Case Activity Log  End ==========


        return redirect()->route('rmcase.index')
        ->with('success', 'মামলার তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে');
        return view('rm_case.rm_case_register.index');
    }

    public function show($id)
    {
        /*$data['info'] =  AtCaseRegister::where('at_case_register.id',$id)->join('court', 'at_case_register.court_id', '=', 'court.id')
                                        ->join('district', 'at_case_register.district_id', '=', 'district.id')
                                        ->join('division', 'at_case_register.division_id', '=', 'division.id');*/
        $data['info'] = RM_CaseRgister::where('id',$id)->first();
        $data['badis'] = RM_CaseBadi::where('rm_case_id',$id)->get();
        $data['bibadis'] = RM_CaseBibadi::where('rm_case_id',$id)->get();
        $data['files'] = RM_OtherFiles::where('rm_case_id',$id)->get();
        // $data['judges'] = JudgePanel::where('at_case_id',$id)->get();
        // dd($data['badis']) ;
        $data['page_title'] =   'রাজস্ব মামলার বিস্তারিত তথ্য';
        // return $atcases;
        return view('rm_case.rm_case_register.show')->with($data);
    }

    public function edit($id)
    {
        $roleID = Auth::user()->role_id;
        $userDivision = user_division();
        $data['info'] = RM_CaseRgister::where('id',$id)->first();
        if ($roleID == 5) {
            // code...
        $userDistrict = user_district();
        }else{

        $userDistrict =$data['info']->district_id;
        }

        $roleID = Auth::user()->role_id;
        if( $roleID != 24){
            $userDivision = user_division();
        }
        if($roleID != 22 && $roleID != 24){
            $userDistrict = user_district();
        }
        if ($roleID != 5 && $roleID != 22 && $roleID != 24 ) {
            $userUpazila = user_upazila();
            // $data['moujas'] = Mouja::where('upazila_id', $userUpazila)->get();
        }
        // Dropdown List
        $data['case_types'] = RM_CaseType::whereRaw("FIND_IN_SET('$roleID',access_role)")->get();
        // $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
        if($roleID == 24){

            $data['divisions'] = DB::table('division')
                ->select('id', 'division_name_bn')
                ->get();
            $data['districts'] = DB::table('district')
                ->select('id', 'district_name_bn')
                ->where('division_id', $userDivision)
                ->get();
            $data['upazilas'] = DB::table('upazila')
                ->select('id', 'upazila_name_bn')
                // ->where('district_id', $data['districts'])
                ->get();
        }
        if($roleID == 22){

            $data['districts'] = DB::table('district')
                ->select('id', 'district_name_bn')
                ->where('division_id', $userDivision)
                ->get();
        }
        if($roleID == 5){

            $data['upazilas'] = DB::table('upazila')
                ->select('id', 'upazila_name_bn')
                ->where('district_id', $userDistrict)
                ->get();
        }

        // $data['districts'] = District::where('division_id', $userDivision)->get();
        // $data['upazilas'] = Upazila::where('district_id', $userDistrict)->get();
        // $data['moujas'] = Mouja::where('upazila_id', $data['info']->upazila_id)->get();
        $data['badis'] = RM_CaseBadi::where('rm_case_id',$id)->get();
        $data['bibadis'] = RM_CaseBibadi::where('rm_case_id',$id)->get();
        $data['files'] = RM_OtherFiles::where('rm_case_id',$id)->get();
        $data['case_types'] = RM_CaseType::whereRaw("FIND_IN_SET('$roleID',access_role)")->get();
        $data['page_title'] = 'রাজস্ব মামলা সংশোধন ফরম';
        return view('rm_case.rm_case_register.edit')->with($data);
    }

    public function update(Request $request, $id='')
    {
        // return $request;
        $roleID = Auth::user()->role_id;
        $userDivision = user_division();
        // $userDistrict = user_district();
        if ($roleID == 5 || $roleID == 21) {
            $userDistrict = user_district();
        }else{
            $userDistrict =$request->district;
        }
        $userUpazila = null;
        if ($roleID == 21) {
            $userUpazila = user_upazila();
        } else{
            $userUpazila = $request->upazila;
        }

        // return $request->badi_name[0];
        // return $request->all();

        $request->validate([
            // 'court' => 'required',
            // 'upazila' => 'required',
            // 'mouja' => 'required',
            'case_type' => 'required',
            'case_no' => 'required',
            'case_date' => 'required',
            'show_cause' => 'nullable|mimes:pdf|max:10240',
            ],
            [
            // 'court.required' => 'আদালতের নাম নির্বাচন করুন',
            // 'upazila.required' => 'উপজেলা নির্বাচন করুন',
            // 'mouja.required' => 'মৌজা নির্বাচন করুন',
            'case_type.required' => 'মামলার ধরণ নির্বাচন করুন',
            'case_no.required' => 'মামলা নং নির্বাচন করুন',
            'case_date.required' => 'মামলা রুজুর তারিখ নির্বাচন করুন',
            'show_cause.required' => 'কারণ দর্শানোর নোটিশ পিডিএফ ফাইল ফরমেটে নির্বাচন করুন',
            ]);

        $case_id = RM_CaseRgister::where('id',$id)->get();
        // File upload
        $filePath = 'uploads/rm_case/arji/';
       /* if($request->show_cause != NULL){
            $fileName = $request->court.'_'.time().'.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/at_case/notice/'), $fileName);
        }else{
            $fileName = NULL;
        }*/

        // File upload
        if($request->has('show_cause')){
            $fileName = $request->court.'_'.time().'.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/rm_case/arji/'), $fileName);
        }else{
            $fileName = $case_id[0]->arji_file;
        }

        //Case Date
        $caseDate = $request->case_date;
        $date_format = str_replace('/', '-', $caseDate);
        $atCase_date = date("Y-m-d", strtotime($date_format));
        //SF Deadline


        $rmcase =RM_CaseRgister::findOrFail($id);
        $rmcase->action_user_role_id = Auth::user()->role_id;
        $rmcase->division_id = $userDivision;
        $rmcase->district_id = $userDistrict;
        $rmcase->upazila_id = $userUpazila;
        // $rmcase->mouja_id = $request->mouja;
        $rmcase->case_no = $request->case_no;
        $rmcase->case_date = $atCase_date;
        $rmcase->case_type_id = $request->case_type;
        $rmcase->comments = $request->comments;
        if($request->has('show_cause')){
            $rmcase->arji_file = $filePath.'/'.$fileName;
        }else{
            $rmcase->arji_file = $fileName;
        }

        if($rmcase->save()){
            for ($i=0; $i<sizeof($request->input('badi_name')); $i++)
            {
                DB::table('r_m__case_badis')->updateOrInsert(
                ['id' => $request->input('hide_badi_id')[$i]],
                [
                'rm_case_id'   => $id,
                'name'         => $request->input('badi_name')[$i],
                'spouse_name'  => $request->input('badi_spouse_name')[$i],
                'address'      => $request->input('badi_address')[$i],
                ]
                );
            }

            for ($i=0; $i<sizeof($request->input('bibadi_name')); $i++)
            {
                // dd($i);
               DB::table('r_m__case_bibadis')->updateOrInsert(
                ['id' => $request->input('hide_bibadi_id')[$i]],
                [
                'rm_case_id'      => $id,
                'name'            => $request->input('bibadi_name')[$i],
                'spouse_name'     => $request->input('bibadi_spouse_name')[$i],
                'address'         => $request->input('bibadi_address')[$i],
                ]
                );
            }

            if($request->file_name != NULL){
                foreach($request->file_type as $key => $val)
                {
                    $filePath = 'uploads/rm_case/others/';
                    if($request->file_name[$key] != NULL){
                        $otherfileName = $userDivision.'_'.time().'.'.rand(5,9999).'.'.$request->file_name[$key]->extension();
                        $request->file_name[$key]->move(public_path('uploads/rm_case/others/'), $otherfileName);
                    }
                    $OtherFile = new RM_OtherFiles();
                    $OtherFile->rm_case_id = $rmcase->id;
                    $OtherFile->file_type = $request->file_type[$key];
                    $OtherFile->file_name = $filePath.$otherfileName;
                    $OtherFile->save();
                }
            }


           


        }

        //========= RM Case Activity Log -  start ============
        $caseRegister = RM_CaseRgister::findOrFail($rmcase->id)->toArray();
        $caseRegisterData = array_merge( $caseRegister, [
            'badi' => RM_CaseBadi::where('rm_case_id', $rmcase->id)->get()->toArray(),
            'bibadi' => RM_CaseBadi::where('rm_case_id', $rmcase->id)->get()->toArray(),
            'log_data' => RM_CaseLog::where('rm_case_id', $rmcase->id)->get()->toArray(),
        ]);
        // return $caseRegisterData;
        $cs_activity_data['rm_case_id'] = $rmcase->id;
        $cs_activity_data['activity_type'] = 'update';
        $cs_activity_data['message'] = 'রাজস্ব মামলা আপডেট করা হয়েছে';
        $cs_activity_data['old_data'] = null;
        $cs_activity_data['new_data'] = json_encode($caseRegisterData);
        RM_case_activity_logs($cs_activity_data);
        // ========= RM Case Activity Log  End ==========

        return redirect()->route('rmcase.index')
        ->with('success', 'রাজস্ব মামলার তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে');
        return view('rm_case.rm_case_register.index');
    }


    public function create_appeal($id)
    {
        $roleID = Auth::user()->role_id;
        $data['info'] = RM_CaseRgister::where('id',$id)->first();
        $userDivision = user_division();
        if ($roleID == 5) {
            // code...
        $userDistrict = user_district();
        }else{

        $userDistrict =$data['info']->district_id;
        }

        $data['info'] = RM_CaseRgister::where('id',$id)->first();
        $data['districts'] = District::where('division_id', $userDivision)->get();
        $data['upazilas'] = Upazila::where('district_id', $data['info']->district_id)->get();
        $data['moujas'] = Mouja::where('upazila_id', $data['info']->upazila_id)->get();
        $data['badis'] = RM_CaseBadi::where('rm_case_id',$id)->get();
        $data['bibadis'] = RM_CaseBibadi::where('rm_case_id',$id)->get();
        $data['case_types'] = RM_CaseType::whereRaw("FIND_IN_SET('$roleID',access_role)")->get();
        $data['page_title'] = 'রাজস্ব আপিল মামলা এন্ট্রি ফরম';
        return view('rm_case.rm_case_register.create_appeal')->with($data);
    }


    public function store_appeal(Request $request, $id = '')
    {
        $roleID = Auth::user()->role_id;
        $userDivision = user_division();
        // $userDistrict = user_district();
        if ($roleID == 5 || $roleID == 21) {
            $userDistrict = user_district();
        }else{
            $userDistrict =$request->district;
        }
        $userUpazila = null;
        if ($roleID == 21) {
            $userUpazila = user_upazila();
        } else{
            $userUpazila = $request->upazila;
        }

        // return $request->badi_name[0];
        $request->validate([
            // 'court' => 'required',
            // 'upazila' => 'required',
            // 'mouja' => 'required',
            'case_type' => 'required',
            'case_no' => 'required',
            'case_date' => 'required',
            'show_cause' => 'required|mimes:pdf|max:10240',
            ],
            [
            // 'court.required' => 'আদালতের নাম নির্বাচন করুন',
            // 'upazila.required' => 'উপজেলা নির্বাচন করুন',
            // 'mouja.required' => 'মৌজা নির্বাচন করুন',
            'case_type.required' => 'মামলার ধরণ নির্বাচন করুন',
            'case_no.required' => 'মামলা নং নির্বাচন করুন',
            'case_date.required' => 'মামলা রুজুর তারিখ নির্বাচন করুন',
            'show_cause.required' => 'কারণ দর্শানোর নোটিশ পিডিএফ ফাইল ফরমেটে নির্বাচন করুন',
            ]);

        $ref_case_num = RM_CaseRgister::findOrFail($id)->case_no;
        // dd($ref_case_num);
        // File upload
        $filePath = 'uploads/rm_case/appeal/';
        if($request->show_cause != NULL){
            $fileName = $request->court.'_'.time().'.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/rm_case/appeal/'), $fileName);
        }else{
            $fileName = NULL;
        }

        //Case Date
        $caseDate = $request->case_date;
        $date_format = str_replace('/', '-', $caseDate);
        $atCase_date = date("Y-m-d", strtotime($date_format));

        $rmcasePre =RM_CaseRgister::findOrFail($id);
        $rmcasePre->is_appeal = 1;
        $rmcasePre->save();
        // dd(Auth::user()->role_id);
        $rmcase = new RM_CaseRgister();
        $rmcase->action_user_role_id = Auth::user()->role_id;
        $rmcase->user_id = Auth::user()->id;
        $rmcase->status = 1;
        $rmcase->rm_case_ref_id = $id;
        $rmcase->ref_rm_case_no = $ref_case_num;
        $rmcase->division_id = $userDivision;
        $rmcase->district_id = $userDistrict;
        $rmcase->upazila_id = $request->upazila;
        $rmcase->mouja_id = $request->mouja;
        $rmcase->case_no = $request->case_no;
        $rmcase->case_date = $atCase_date;
        $rmcase->case_type_id = $request->case_type;
        $rmcase->case_status_id = 21;
        $rmcase->comments = $request->comments;
        $rmcase->arji_file = $filePath.'/'.$fileName;

        if($rmcase->save()){
            foreach($request->badi_name as $key => $val)
            {
                $rmcaseBadi = new RM_CaseBadi();
                $rmcaseBadi->rm_case_id = $rmcase->id;
                $rmcaseBadi->name = $request->badi_name[$key];
                $rmcaseBadi->spouse_name = $request->badi_spouse_name[$key];
                $rmcaseBadi->address = $request->badi_address[$key];
                $rmcaseBadi->save();
            }

            foreach($request->bibadi_name as $key => $val)
            {
                $rmcaseBibadi = new RM_CaseBibadi();
                $rmcaseBibadi->rm_case_id = $rmcase->id;
                $rmcaseBibadi->name = $request->bibadi_name[$key];
                $rmcaseBibadi->spouse_name = $request->bibadi_spouse_name[$key];
                $rmcaseBibadi->address = $request->bibadi_address[$key];
                $rmcaseBibadi->save();
            }

            $files = [];
            // return $request->file_name;
            foreach($request->file_type as $key => $val)
            {
                $filePath = 'uploads/rm_case/others/';
                if($request->file_name[$key] != NULL){
                    $otherfileName = $userDivision.'_'.time().'.'.rand().'.'.$request->file_name[$key]->extension();
                    $request->file_name[$key]->move(public_path('uploads/rm_case/others/'), $otherfileName);
                }/*else{
                    $otherfileName = NULL;
                }*/
                $files[] = $otherfileName;
                // return $files;
                $rmcaseBadi = new RM_OtherFiles();
                $rmcaseBadi->rm_case_id = $rmcase->id;
                $rmcaseBadi->file_type = $request->file_type[$key];
                $rmcaseBadi->file_name = $filePath.$files[$key];
                $rmcaseBadi->save();
            }


        }


        $data=[
            'status'  => 2,
        ];
        $ID = RM_CaseRgister::where('id', $id)->update($data);

        // $userDivision = user_division();
        // $userDistrict = user_district();

        // return 'success';
        return redirect()->route('rmcase.index')
        ->with('success', 'রাজস্ব মামলার তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে');
        return view('rm_case.rm_case_register.index');
    }


    public function ajaxBadiDelete($id)
    {
        // dd($id);
        // $this->CaseBadi->deleteBadi('id', $id);
        DB::table('r_m__case_badis')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function ajaxBibadiDelete($id)
    {
        // $this->Common_model->delete('pds_education', 'id', $id);
        DB::table('r_m__case_bibadis')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function ajaxFileDelete($id)
    {
        // dd($id);
        // $this->Common_model->delete('pds_education', 'id', $id);
        DB::table('r_m__other_files')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function ajaxOrderDelete($id)
    {
        // dd($id);
        // $this->Common_model->delete('pds_education', 'id', $id);
        DB::table('at_case_order')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function ajaxJudgeDelete($id)
    {
        // $this->Common_model->delete('pds_education', 'id', $id);
        DB::table('judge_panel')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }


}
