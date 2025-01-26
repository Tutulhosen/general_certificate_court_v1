<?php

namespace App\Http\Controllers\AppealInfo;


use App\Models\User;
use App\Models\GccAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\AppealRepository;
use App\Repositories\UserAgentRepository;
use App\Repositories\ShortOrderRepository;
use App\Services\ShortOrderTemplateService;
use App\Http\Controllers\AppealBaseController;

class CitizenAppealViewController extends Controller
{
    // public $permissionCode='certificateView';

    // public function showAppealViewPage(Request $request)
    // {
    //     $appealId=$request->id;

    //     return view('appealView.appealView')->with('appealId',$appealId);

    // }
    public function showAppealViewPage($id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        $appeal = GccAppeal::findOrFail($id);
        $data = AppealRepository::getAllAppealInfo($id);
        $data['appeal']  = $appeal;
        $data["notes"] = $appeal->appealNotes;
        $data["districtId"]= $officeInfo->district_id;
        $data["divisionId"]=$officeInfo->division_id;
        $data["office_id"] = $office_id;
       

        $data['page_title'] = 'সার্টিফিকেট রিকুইজিশান এর  বিস্তারিত তথ্য';
        // return $data;
       // dd($data);

        return view('citizenappealView.appealView')->with($data);
    }


    public function showAppealTrakingPage($id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        $appeal = GccAppeal::findOrFail($id);
        $data = AppealRepository::getAllAppealInfo($id);
        $data['appeal']  = $appeal;
        $data["notes"] = $appeal->appealNotes;
        $data["districtId"]= $officeInfo->district_id;
        $data["divisionId"]=$officeInfo->division_id;
        $data["office_id"] = $office_id;
        $data["gcoList"] = User::where('office_id', $user->office_id)->where('id', '!=', $user->id)->get();

        // $data['shortOrderTemplateList'] = ShortOrderTemplateService::getShortOrderTemplateListByAppealId($id);
        $data['shortOrderTemplateList'] = DB::table('gcc_notes_modified')
                                            ->where('gcc_notes_modified.appeal_id',$id)
                                            ->join('gcc_case_shortdecisions', 'gcc_notes_modified.case_short_decision_id', '=', 'gcc_case_shortdecisions.id')
                                            ->select('gcc_case_shortdecisions.case_short_decision','gcc_notes_modified.*')
                                            ->get();
        // dd($data);
        $data['page_title'] = 'মামলা ট্র্যাকিং';
        // return $data['shortOrderTemplateList'];
        return view('citizenappealView.appealCaseTraking')->with($data);
    }



}
