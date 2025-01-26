<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArchiveCasePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\ArchiveRepository;
use App\Repositories\AppealCitizenRepository;

class ArchiveController extends Controller
{
    //old case enrty from
    public function show_old_dismiss_case(){

        $data['page_title'] = 'পুরাতন নিষ্পত্তিকৃত মামলা';
        $results= ArchiveRepository::get_case_info();
        $data['results']=$results;
        return view('archive.archive')->with($data);
       
    }

    //old dismiss case entry form
    public function show_old_dsimiss_case_entry_form(){
        $user = globalUserInfo();
        $court_id = $user->court_id;
        $court_info= ArchiveRepository::get_court_info($court_id);
        if ($court_info) {
            $upa_info= ArchiveRepository::get_court_upa_info($court_info->div_id, $court_info->dis_id);
   
            $data['upa_info']= $upa_info;
        }
        
        $data['court_info']= $court_info;
    
        $data['page_title'] = 'পুরাতন নিষ্পত্তিকৃত মামলা এন্ট্রি';
        $data['division'] = DB::table('division')->get();
        return view('archive.archiving_form')->with($data);
    }

    //old dismiss case store
    public function old_dsimiss_case_store(StoreArchiveCasePostRequest $request){
        // dd('come',$request->all());
        $data['page_title'] = 'পুরাতন নিষ্পত্তিকৃত মামলা এন্ট্রি';
        $case_id= ArchiveRepository::store_dismiss_case($request);
        if ($case_id) {
            $allached_file= ArchiveRepository::storeAttachment('ARCHIVE_FILE', $case_id, $causeListId = date('Y-m-d'), $request->file_type);
        }
        return redirect()->route('appeal.old.dismiss.case')->with('success', 'সফলভাবে এন্ট্রি হয়েছে');
    }

    //old dismiss case details
    public function old_dsimiss_case_details($id){
        $id = decrypt($id);
        $case_details = ArchiveRepository::old_dismiss_case_details($id);
        if ($case_details->id) {
            $attachmentList=ArchiveRepository::old_dismiss_case_attach_file($case_details->id);
        }
        $data['attachmentList']=$attachmentList;
        $data['page_title'] = 'পুরাতন নিষ্পত্তিকৃত মামলার বিবরণ';
        $data['case_details']=$case_details;
        return view('archive.archive_details')->with($data);
    }

    public function generate_pdf($id){
        $id = decrypt($id);
        $case_details = ArchiveRepository::old_dismiss_case_details($id);
        if ($case_details->id) {
            $attachmentList=ArchiveRepository::old_dismiss_case_attach_file($case_details->id);
        }
        $data['attachmentList']=$attachmentList;
        $data['page_title'] = 'পুরাতন নিষ্পত্তিকৃত মামলার বিবরণ';
        $data['case_details']=$case_details;
        return view('archive.generate_pdf')->with($data);
    }
}