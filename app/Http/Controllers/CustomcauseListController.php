<?php

namespace App\Http\Controllers;

use Svg\Tag\Rect;
use App\Models\User;
use App\Models\GccAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AppealRepository;
use App\Repositories\ArchiveRepository;
use App\Services\ShortOrderTemplateService;
use App\Http\Requests\StoreCausePostRequest;
use App\Repositories\AppealCitizenRepository;

class CustomcauseListController extends Controller
{
    //old case enrty from
    public function show_causelist()
    {

        $data['page_title'] = 'কজ লিস্ট';
        $user = globalUserInfo();
        $user_role = $user->role_id;
        $user_court = $user->court_id;

        $court_info = ArchiveRepository::get_court_info($user_court);

        //dd($court_info);

        $results = DB::table('custom_causelist')->orderby('id', 'desc');
        if ($user_role == 28 || $user_role == 27) {
            $results = $results->where('court_id', $user_court);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('appeal_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no']);
            }
        }

        if ($user_role == 6) {
            $results = $results->where('div_id', $court_info->div_id)->where('dis_id', $court_info->dis_id);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('appeal_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no']);
            }
        }

        if ($user_role == 2) {

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('appeal_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no']);
            }
        }

        $output = $results->paginate(10);

        $data['results'] = $output;
        return view('customCauselist.archive')->with($data);
    }

    //old dismiss case entry form
    public function show_old_dsimiss_case_entry_form()
    {

        $user = globalUserInfo();
        $court_id = $user->court_id;
        $court_info = ArchiveRepository::get_court_info($court_id);
        if ($court_info) {
            $upa_info = ArchiveRepository::get_court_upa_info($court_info->div_id, $court_info->dis_id);

            $data['upa_info'] = $upa_info;
        }

        $data['court_info'] = $court_info;

        $data['page_title'] = 'মামলা সংক্রান্ত তথ্য এন্ট্রি';
        $data['division'] = DB::table('division')->get();
        return view('customCauselist.archiving_form')->with($data);
    }

    //old dismiss case store
    public function case_store(StoreCausePostRequest $request)
    {
        // dd('come',$request->all());
        $data['page_title'] = 'মামলা এন্ট্রি';

        $div_id = $request->div_section;
        $dis_id = $request->dis_section;
        $upa_id = $request->upa_section;
        $court_id = Auth::user()->court_id;
        $case_no = $request->case_no;
        $appeal_date = $request->caseDate;
        $related_act = $request->lawSection;
        $org_type = $request->organization_type;
        $org_name = $request->org_name;
        $org_representative = $request->organization_employee;
        $representative_designation = $request->designation;
        $total_claim_amount = bn2en($request->totalLoanAmount);
        $claim_in_text = $request->totalLoanAmountText;
        $total_collect_amount = bn2en($request->totalcollectAmount);
        $collect_amount_text = $request->totalcollectAmountText;
        $last_order_date = $request->lastorderDate;





        // if ($request->hasFile('attached_file')) {
        //     $file= $request->file('attached_file');
        //     $file_name = md5(time() . rand()) . '.' . $file->clientExtension();

        //     // $file->move(storage_path('app/public/adminUser'), $file_name);
        //     $file->move(public_path('archive_attached_file/'), $file_name);

        // }else {
        $file_name = null;
        // }

        $case_id = DB::table('custom_causelist')->insertGetId([
            'div_id' => $div_id,
            'dis_id' => $dis_id,
            'upa_id' => $upa_id,
            'court_id' => $court_id,
            'case_no' => $case_no,
            'appeal_date' => $appeal_date,
            'related_act' => $related_act,
            'org_type' => $org_type,
            'org_name' => $org_name,
            'org_representative' => $org_representative,
            'representative_designation' => $representative_designation,
            'total_claim_amount' => $total_claim_amount,
            'claim_in_text' => $claim_in_text,
            'total_collect_amount' => $total_collect_amount,
            'collect_amount_text' => $collect_amount_text,
            'next_date' => $request->next_date,
            'last_order_date' => $last_order_date,
            'order_attached_file' => $file_name,
            'defaulter_name' => $request->defaulter_name,

        ]);
        // dd( $case_id);
        DB::table('causelist_order')->insertGetId([
            'causelist_id' =>  $case_id,
            'short_order_name' => $request->causeTitle,
            'last_order_date' => $request->lastorderDate,
            'next_date' => $request->next_date
        ]);

        DB::table('gcc_manual_causelist')->insertGetId([
            'causelist_id' =>  $case_id,
            'case_no' => $case_no,
            'court_id' => $court_id,
            'division_id' => $div_id,
            'district_id' => $dis_id,
            'upazila_id' => $upa_id,
            'next_date' => $last_order_date
        ]);



        // $case_id= ArchiveRepository::store_dismiss_case($request);
        // if ($case_id) {
        //     $allached_file= ArchiveRepository::storeAttachment('ARCHIVE_FILE', $case_id, $causeListId = date('Y-m-d'), $request->file_type);
        // }
        return redirect()->route('appeal.causelist.case.list')->with('success', 'সফলভাবে এন্ট্রি হয়েছে');
    }

    //old dismiss case details
    public function causelist_details($id)
    {
        $id = decrypt($id);
        $result = DB::table('custom_causelist')->where('id', $id)->first();

        $data['orderlist'] = DB::table('causelist_order')->where('causelist_id', $id)->get();

        // if ($case_details->id) {
        //     $attachmentList=ArchiveRepository::old_dismiss_case_attach_file($case_details->id);
        // }
        // $data['attachmentList']=$attachmentList;
        $data['page_title'] = 'কজ লিস্ট';
        $data['case_details'] = $result;
        return view('customCauselist.archive_details')->with($data);
    }

    public function causelist_edit($id)
    {

        $result = DB::table('custom_causelist')->where('id', $id)->first();
        $lastorder = DB::table('causelist_order')->where('causelist_id', $id)->orderBy('id', 'desc')->first();
        $page_title = 'কজ লিস্ট';
        $classEditdata = $result;

        // dd($lastorder);
        return view('customCauselist.edit', with(compact('classEditdata', 'lastorder', 'page_title')));
    }

    public function causelist_update(request $request)
    {

        $data = array(
            'last_order_date' => $request->lastorderDate,
            'next_date' => $request->next_date
        );
        DB::table('causelist_order')->insertGetId([
            'causelist_id' => $request->id,
            'short_order_name' => $request->causeTitle,
            'last_order_date' => $request->lastorderDate,
            'appeal_status' => $request->appeal_status,
            'next_date' => $request->next_date
        ]);

        $customcauselist = [
            'causelist_id' =>  $request->id,
            'next_date' => $request->next_date
        ];
        DB::table('gcc_manual_causelist')->where('causelist_id', $request->id)->update($customcauselist);
        // dd($data);
        DB::table('custom_causelist')->where('id', $request->id)->update($data);
        return redirect()->route('appeal.causelist.case.list')->with('success', 'সফলভাবে এন্ট্রি হয়েছে');
    }
    public function generate_pdf($id)
    {
        $id = decrypt($id);
        $case_details = ArchiveRepository::old_dismiss_case_details($id);
        if ($case_details->id) {
            $attachmentList = ArchiveRepository::old_dismiss_case_attach_file($case_details->id);
        }
        $data['attachmentList'] = $attachmentList;
        $data['page_title'] = 'পুরাতন নিষ্পত্তিকৃত মামলার বিবরণ';
        $data['case_details'] = $case_details;
        return view('archive.generate_pdf')->with($data);
    }


    public function case_tracking(Request $request)
    {

        $case_no =  $request->case_no;
        $user = globalUserInfo();
        if (!empty($case_no)) {
            // if (!empty($_GET['case_no'])) {
            //  $appeal = $appeal->where('case_no', 'like','%'. bn2en($_GET['case_no']) .'%')->orWhere('manual_case_no', 'like','%'. $_GET['case_no'].'%');
            // }

            $caseno = DB::table('gcc_appeals')->where('case_no', 'like', '%' . bn2en($_GET['case_no']) . '%')->orWhere('manual_case_no', 'like', '%' . $_GET['case_no'] . '%')->first();
            // dd($caseno);
            if (!empty($caseno)) {
                $id = $caseno->id;



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
                $data["gcoList"] = User::where('office_id', $user->office_id)->where('id', '!=', $user->id)->get();

                $data['shortOrderTemplateList'] = ShortOrderTemplateService::getShortOrderTemplateListByAppealId($id);
                $data['shortOrderTemplateList'] = DB::table('gcc_notes_modified')
                    ->where('gcc_notes_modified.appeal_id', $id)
                    ->join('gcc_case_shortdecisions', 'gcc_notes_modified.case_short_decision_id', '=', 'gcc_case_shortdecisions.id')
                    ->select('gcc_case_shortdecisions.case_short_decision', 'gcc_notes_modified.*')
                    ->get();
            }
        }

        $roleID = $user->role_id;

        // dd($roleID = $user->role_id);
        $data['roleID'] = $roleID;
        $data['page_title'] = 'মামলা ট্র্যাকিং';
        return view('citizen/casetraking')->with($data);
    }
    public function case_tracking_show()
    {
    }
}
