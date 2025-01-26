<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Court;
use App\Models\Appeal;
use App\Models\Citizen;
use App\Models\CauseList;
use App\Models\GccAppeal;
use App\Models\Attachment;
use App\Models\GccCauseList;
use Illuminate\Http\Request;
use App\Models\AppealCitizen;
use App\Models\GccAppealCitizen;
use App\Services\AdminAppServices;
use Illuminate\Support\Facades\DB;
use App\Services\ProjapotiServices;
use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AppealRepository;
use App\Repositories\CitizenRepository;
use App\Services\KharijTemplateService;
use Illuminate\Support\Facades\Session;
use App\Repositories\AppealerRepository;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\CauseListRepository;
use App\Repositories\LawBrokenRepository;
use App\Repositories\UserAgentRepository;
use App\Repositories\AttachmentRepository;
use App\Services\ShortOrderTemplateService;
use App\Repositories\AppealCitizenRepository;
use App\Repositories\LogManagementRepository;
use App\Repositories\CauseListShortDecisionRepository;
use App\Repositories\OrganizationCaseMappingRepository;

class CitizenAppealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // exit('hi');
        $results = GccAppeal::orderby('id', 'desc')
            ->whereHas('appealWithAppealCitizens', function ($query) {
                $query->where('citizen_id', Auth::user()->role_id);
            })
            ->paginate(20);
        // return $results->appealCitizens;
        $date = date('Y-m-d');
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }
        $page_title = 'মামলার তালিকা';
        //return view('appealList.appeallist')->with('date',$date);
        return view('citizen.caseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // old 20/06/2022
    public function creates()
    {
        // return GccAppeal::all();
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();
        $gcoList = User::where('office_id', $user->office_id)
            ->where('id', '!=', $user->id)
            ->get();

        $appealId = null;
        $data = [
            'districtId' => $officeInfo->district_id,
            'divisionId' => $officeInfo->division_id,
            'office_id' => $office_id,
            'appealId' => $appealId,
            'gcoList' => $gcoList,
            'office_name' => $officeInfo->office_name_bn,
        ];

        $page_title = 'সার্টিফিকেট রিকুইজিশন নিবন্ধন';
        return view('citizenAppealInitiate.appealCreates_21_06_22')->with(['data' => $data, 'page_title' => $page_title]);
    }

    public function create()
    {
        // return GccAppeal::all();
        $user = globalUserInfo();
      
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();
        $available_court = DB::table('court')->where('upazila_id',$officeInfo->upazila_id)->orWhere('level',1)->where('district_id',$officeInfo->district_id)->orderBy('id','desc')->get();

      
       $citizen_info=DB::table('gcc_citizens')->where('id','=',$user->citizen_id)->first();

       //dd($officeInfo->organization_routing_id);
        switch($officeInfo->organization_type)
        {
            case "BANK":
            $organization_type_bn_name='ব্যাংক';
            break;
            case "GOVERNMENT":
            $organization_type_bn_name='সরকারি প্রতিষ্ঠান';
            break;
            case "OTHER_COMPANY":
            $organization_type_bn_name='স্বায়ত্তশাসিত প্রতিষ্ঠান';
            break;   
        }      
        $appealId = null;
        $data = [
            'districtId' => $officeInfo->district_id,
            'divisionId' => $officeInfo->division_id,
            'office_id' => $office_id,
            'appealId' => $appealId,
            'organization_routing_id'=>$officeInfo->organization_routing_id,
            'organization_physical_address'=>$officeInfo->organization_physical_address,
            'organization_type'=>$officeInfo->organization_type,
            'organization_type_bn_name'=>$organization_type_bn_name,
            'available_court' => $available_court,
            'office_name' => $officeInfo->office_name_bn,
            'citizen_gender'=>$citizen_info->citizen_gender,
            'father'=>$citizen_info->father,
            'mother'=>$citizen_info->mother,
            'present_address'=>$citizen_info->present_address,
            'organization_employee_id'=>Auth::user()->organization_employee_id
        ];
       
        //dd($data);

        $page_title = 'সার্টিফিকেট রিকুইজিশন';
        return view('citizenAppealInitiate.appealCreate')->with(['data' => $data, 'page_title' => $page_title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return globalUserInfo(); 
        //  dd('mamlas data',$request->all());
        // dd('come');

         $all_request_nids=[];
            
            foreach($request->applicant['nid'] as $value_nid_single)
            {
                array_push($all_request_nids,$value_nid_single);
            }
            
                array_push($all_request_nids,$request->defaulter['nid']);
                
            
            if(count(array_unique($all_request_nids)) != count($all_request_nids))
            {
              
                return Redirect::back()->with('Errormassage', 'আপনি একই নাগরিককে একাধিকবার প্রাতিষ্ঠানিক প্রতিনিধি , অথবা ঋণগ্রহীতা হিসেবে যোগ করেছেন');
            }
            
            // if(bn2en($request->totalLoanAmount)>500000)
            // {
            //     return Redirect::back()->with('Errormassage', 'সার্টিফিকেট আদালতে ৫ লক্ষ টাকার বেশি অভিযোগ করা যায় না');
            // }
           
           
        //    $userWithRoleOrganizationApplicant=DB::table('users')->where('citizen_nid','=',$request->defaulter['nid'])->where('role_id','=',35)->first();
        //    if(!empty($userWithRoleOrganizationApplicant))
        //    {
        //     return Redirect::back()->with('Errormassage', 'ঋণগ্রহীতা ইতিমধ্যে, জেনারেল সার্টিফিকেট আদালত সিস্টেমে প্রাতিষ্ঠানিক প্রতিনিধি হিসেবে নিবন্ধিত আছেন এই ক্ষেত্রে  মামলা কারা যাবে না কারন একই সাথে একই জাতীয় পরিচয়পত্র দিয়ে প্রাতিষ্ঠানিক প্রতিনিধি ও ঋণগ্রহীতা তথা নাগরিক দুইটা role একই সাথে পরিচালনা করা সম্ভব না');
        //    }   
            DB::beginTransaction();
        try {
            $appealId = AppealRepository::storeAppealBYCitizen($request);
            // dd($appealId);exit;
            CitizenRepository::storeCitizen($request, $request->citizen, $appealId);
            OrganizationCaseMappingRepository::employeeOrgizationCaseMappingOnCaseCreate($appealId);

            if ($request->file_type && $_FILES['file_name']['name']) {
                $log_file_data=AttachmentRepository::storeAttachment('APPEAL', $appealId, $causeListId = date('Y-m-d'), $request->file_type,null);
               
            }
            else
            {
                $log_file_data=null;
            }
            LogManagementRepository::citizen_appeal_store($request, $appealId, $log_file_data);
          
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
        
            $flag = 'false';
            return redirect()
                ->back()
                ->with('error', 'তথ্য সংরক্ষণ করা হয়নি ');
        }
        
        return redirect('/citizen/appeal/pending_list')->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function show(Citizen $citizen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        $appeal = GccAppeal::findOrFail($id);
        $data = AppealRepository::getAllAppealInfo($id);
        $data['appeal'] = $appeal;
        $data['notes'] = $appeal->appealNotes;
        $data['districtId'] = $officeInfo->district_id;
        $data['divisionId'] = $officeInfo->division_id;
        $data['office_id'] = $office_id;
        $data['gcoList'] = User::where('office_id', $user->office_id)
            ->where('id', '!=', $user->id)
            ->get();

        $data['page_title'] = 'সার্টিফিকেট রিকুইজিশন সংশোধন';
        // return $data;
        return view('citizenAppealInitiate.appealEdit')->with($data);
    }

    public function kharij_application(Request $request)
    {
        // dd(1);
        // return $request;

        try {
            $appealId = AppealRepository::storeAppealForKharij($request);
            KharijTemplateService::generateKharijTemplate($request->kharij_reason, $appealId);

            $flag = 'true';

            $user = globalUserInfo();
            $activity = 'খারিজের আবেদন(সিটিজেন)</span>';
            $activity .= '<br>';
            $activity .= '<span>খারিজের কারন : '.$request->kharij_reason.'</span>';

            $obj = new UserAgentRepository();

            $browser = $obj->detect()->getInfo();
            date_default_timezone_set("Asia/Dhaka");
            $gcc_log_book = [
                'appeal_id' => $appealId,
                'user_id' => $user->id,
                'designation' => $user->designation,
                'activity' => $activity,
                'browser' => $browser,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            //dd($gcc_log_book);
            DB::table('gcc_log_book')->insert($gcc_log_book);
        } catch (\Exception $e) {
            dd($e);
            $flag = 'false';
        }
        return redirect('citizen/appeal/list');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Citizen $citizen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Citizen $citizen)
    {
        //
    }
}