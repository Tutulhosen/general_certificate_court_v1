<?php

/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 12/22/17
 * Time: 10:36 AM
 */

namespace App\Http\Controllers\AppealInfo;


use App\Models\User;
use App\Models\GccAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\AppealRepository;
use App\Repositories\UserAgentRepository;
use App\Repositories\ShortOrderRepository;
use App\Http\Controllers\AppealBaseController;

class AppealViewController extends Controller
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
        return view('appealView.appealView')->with($data);
    }

    public function makeAutofillRuisition(Request $request)
    {
        $citizen_id = DB::table('gcc_appeal_citizens')->where('appeal_id', '=', $request->appeal_id)->where('citizen_type_id', '=', 2)->first();
        $case_data_mapping = DB::table('gcc_appeals')
            ->join('office', 'gcc_appeals.office_id', 'office.id')
            ->join('district', 'gcc_appeals.district_id', 'district.id')
            ->where('gcc_appeals.id', $request->appeal_id)->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')->first();

        $citizen_details = DB::table('gcc_citizens')->where('id', '=', $citizen_id->citizen_id)->first();

        $applicant_id = DB::table('gcc_appeal_citizens')->where('appeal_id', '=', $request->appeal_id)->where('citizen_type_id', '=', 1)->first();

        $applicat_details = DB::table('gcc_citizens')->where('id', '=', $applicant_id->citizen_id)->first();

        $message = '১৯১৩ সালের সরকারি পাওনা আইনের ৫(১) ও ৬ ধারা মোতাবেক ' . $applicat_details->citizen_name . ' ,(পিতা) ' . $applicat_details->father . ', প্রতিষ্ঠান ' . $case_data_mapping->office_name_bn . ', ঠিকানা ' . $case_data_mapping->organization_physical_address . ' ' . $case_data_mapping->district_name_bn . ' ,  জনাব ' . $citizen_details->citizen_name . ', (পিতা) ' . $citizen_details->father . ', ঠিকানা ' . $citizen_details->permanent_address . ' এর নিকট বকেয়া ' . en2bn($case_data_mapping->loan_amount) . ' (কথায়) ' . $case_data_mapping->loan_amount_text . '  টাকা আদায় করার জন্য এই কোর্টের বিজ্ঞ জেনারেল সার্টিফিকেট অফিসার বরাবর রিকুজিশান দাখিল করেছেন। রিকুইজিশানে দাবীকৃত টাকার পরিমাণ ' . en2bn($case_data_mapping->loan_amount) . ' (কথায়) ' . $case_data_mapping->loan_amount_text . '।';

        return response()->json([
            'success' => 'success',
            'message' => $message
        ]);
    }

    public function runningAppealViewPage($id)
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
        $data["districtId"] = $officeInfo->district_id;
        $data["divisionId"] = $officeInfo->division_id;
        $data["office_id"] = $office_id;
        $data["runningcommandList"] = DB::table("gcc_running_appeal_attachments")->where('attatch_type', 1)->where("appeal_id", $id)->select("*")->first();
        $data["runningorderTemplate"] = DB::table("gcc_running_appeal_attachments")->where('attatch_type', 2)->where("appeal_id", $id)->select("*")->get();
        $data["hajira"] = DB::table("gcc_running_appeal_attachments")->where('attatch_type', 3)->where("appeal_id", $id)->select("*")->first();
        $data["others"] = DB::table("gcc_running_appeal_attachments")->where('attatch_type', 4)->where("appeal_id", $id)->select("*")->get();
   


        $data['page_title'] = 'সার্টিফিকেট রিকুইজিশান এর  বিস্তারিত তথ্য';
        return view('appealView.runningview')->with($data);
    }
    public function runningAppealAttachmentCreate($id)
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
        $data["districtId"] = $officeInfo->district_id;
        $data["divisionId"] = $officeInfo->division_id;
        $data["office_id"] = $office_id;
        $data["runningcommandList"] = DB::table("gcc_running_appeal_attachments")->where('attatch_type', 1)->where("appeal_id", $id)->select("*")->first();
        $data["runningorderTemplate"] = DB::table("gcc_running_appeal_attachments")->where('attatch_type', 2)->where("appeal_id", $id)->select("*")->get();
        $data["attendance_list"] = DB::table("gcc_running_appeal_attachments")->where('attatch_type', 3)->where("appeal_id", $id)->select("*")->first();
        $data["onnanno_running_appeal_list"] = DB::table("gcc_running_appeal_attachments")->where('attatch_type', 4)->where("appeal_id", $id)->select("*")->get();
        $data['id'] = $id;
        $data['page_title'] = 'আদেশ নামা সংযুক্তি';
        // dd($data);    
        return view('appealView.runningAppealAttachment')->with($data);
    }
}