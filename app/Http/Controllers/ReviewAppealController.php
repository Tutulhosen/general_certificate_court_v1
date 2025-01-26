<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Appeal;
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
use Illuminate\Support\Facades\Session;
use App\Repositories\AppealerRepository;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\CauseListRepository;
use App\Repositories\LawBrokenRepository;
use App\Repositories\UserAgentRepository;
use App\Repositories\AttachmentRepository;
use App\Services\ShortOrderTemplateService;
use App\Repositories\AppealCitizenRepository;
use App\Repositories\CauseListShortDecisionRepository;

class ReviewAppealController extends Controller
{
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
    public function create($id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        // $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        $appeal = GccAppeal::findOrFail($id);
        $data = AppealRepository::getAllAppealInfo($id);
        $data['appeal']  = $appeal;
        $data["notes"] = $appeal->appealNotes;
        $data["districtId"]= $officeInfo->district_id;
        $data["divisionId"]=$officeInfo->division_id;
        // $data["office_id"] = $office_id;
        // $data["gcoList"] = User::where('office_id', $user->office_id)->where('id', '!=', $user->id)->get();
        $data['id']=$id;
        $data['page_title'] = 'সার্টিফিকেট মামলা রিভিউ আবেদন';
        // return $data;
        return view('reviewAppeal.reviewAppealCreate')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        //var_dump($_FILES);
        //exit();
        $this->validate($request,[
         'reviewAppliedTo'=>'required'
        ],
        [
            'reviewAppliedTo.required' => 'কার নিকট রিভিউ আবেদন করবেন তা নির্বাচন করুন !'
        ]);
        // return $request;
        $id = $request->appealId;
        $msg = 'মামলা সফলভাবে প্রেরণ করা হয়েছে!';
        $appeal = GccAppeal::findOrFail($id);
        $appeal->appeal_status=$request->status;
        $appeal->is_applied_for_review=1;
        $appeal->updated_at=date('Y-m-d H:i:s');
        $appeal->updated_by= globalUserInfo()->id;
        if($request->reviewAppliedTo == 'DC'){
            $appeal->reviewed_to_dc = 1;
        }elseif($request->reviewAppliedTo == 'DivCom') {
            $appeal->reviewed_to_divCom= 1;
        }elseif($request->reviewAppliedTo == 'LAB') {
            $appeal->reviewed_to_lab= 1;
        }
        $appeal->review_applied_by= globalUserInfo()->id;
        $appeal->save();

        $appealId=$id;
       

        $user = globalUserInfo();
        if($user->role_id == 35)
        {

            $activity = 'মামলার আপিল আবেদন করেছেন (প্রাতিষ্ঠানিক প্রতিনিধি)';
            $designation=$user->designation. '( প্রাতিষ্ঠানিক প্রতিনিধি )';
        }
        elseif($user->role_id == 36)      
        {
            $activity = 'মামলার আপিল আবেদন করেছেন ( নাগরিক )';
            $designation=$user->designation. '( নাগরিক )';
        }
        $to_whom_appeal = $request->reviewAppliedTo;
        switch ($to_whom_appeal) {
            case 'DC':
                $activity .= '<br>';
                $activity .= 'জেলা প্রশাসক বরাবর';
              break;
            case 'DivCom':
                $activity .= '<br>';
                $activity .= 'বিভাগীয় কমিশনার বরাবর';
              break;
            case 'LAB':
                $activity .= '<br>';
                $activity .= 'ভূমি আপিল বোর্ড চেয়ারম্যান বরাবর';
              break;
             
          } 


        $obj = new UserAgentRepository();

            $browser = $obj->detect()->getInfo();
            date_default_timezone_set('Asia/Dhaka');
            $gcc_log_book = [
                'appeal_id' => $appealId,
                'user_id' => $user->id,
                'designation' => $designation,
                'activity' => $activity,
                'browser' => $browser,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            DB::table('gcc_log_book')->insert($gcc_log_book);
        return redirect('/citizen/appeal/all_case')->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
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
