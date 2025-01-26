<?php

namespace App\Repositories;


use Mpdf\Tag\Select;
use App\Models\GccAttachment;
use App\Models\GccAppealCitizen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ArchiveRepository
{
    public static function get_court_info($court_id){
        $info= DB::table('court AS C')
        ->join('division AS A', 'C.division_id', '=', 'A.id')
        ->join('district AS B', 'C.district_id', '=', 'B.id')
        ->where('C.id', $court_id)
        ->select( 'A.division_name_bn AS div_name', 'B.district_name_bn AS dis_name','B.id AS dis_id','A.id AS div_id')
        ->first();

        return $info;
       
    }

    public static function get_court_upa_info($div_id, $dis_id){
        $info= DB::table('upazila')->where('division_id', $div_id)->where('district_id', $dis_id)->select('id as upa_id', 'upazila_name_bn as upa_name')->get();
        

        return $info;
       
    }

    public static function store_dismiss_case($request){
        // dd($request);
        $div_id= $request->div_section;
        $dis_id= $request->dis_section;
        $upa_id= $request->upa_section;
        $court_id= Auth::user()->court_id;
        $case_no= $request->caseNo;
        $appeal_date= $request->caseDate;
        $related_act= $request->lawSection;
        $org_type= $request->organization_type;
        $org_name= $request->org_name;
        $org_representative= $request->organization_employee;
        $representative_designation= $request->designation;
        $total_claim_amount= bn2en($request->totalLoanAmount);
        $claim_in_text= $request->totalLoanAmountText;
        $total_collect_amount= bn2en($request->totalcollectAmount);
        $collect_amount_text= $request->totalcollectAmountText;
        $last_order_date= $request->lastorderDate;
    
       
        if ($request->hasFile('attached_file')) {
            $file= $request->file('attached_file');
            $file_name = md5(time() . rand()) . '.' . $file->clientExtension();
            
            // $file->move(storage_path('app/public/adminUser'), $file_name);
            $file->move(public_path('archive_attached_file/'), $file_name);
           
        }else {
            $file_name=null;
        }

       $case_id= DB::table('archive_case')->insertGetId([
            'div_id' => $div_id,
            'dis_id' => $dis_id,
            'upa_id' => $upa_id,
            'court_id' => $court_id,
            'case_no' => $case_no,
            'appeal_date' => $appeal_date,
            'related_act' => $related_act,
            'org_type' => $org_type,
            'org_name' =>$org_name,
            'org_representative' =>$org_representative,
            'representative_designation' =>$representative_designation,
            'total_claim_amount' =>$total_claim_amount,
            'claim_in_text' =>$claim_in_text,
            'total_collect_amount' =>$total_collect_amount,
            'collect_amount_text' =>$collect_amount_text,
            'last_order_date' =>$last_order_date,
            'order_attached_file' =>$file_name,
        ]);

        return $case_id;
    }


    public static function storeAttachment($appName, $appealId, $causeListId, $captions)
    {
        
        $image = array(".jpg", ".jpeg", ".gif", ".png", ".bmp");
        $document = array(".doc", ".docx");
        $pdf = array(".pdf");
        $excel = array(".xlsx", ".xlsm", ".xltx", ".xltm");
        $text = array(".txt");
        $i = 0;
        $log_file_data=[];
        // $test = [];
        // ["file_name"]['name']
        if (!empty($_FILES['file_name'])) {
            foreach ($_FILES['file_name']["name"] as $key => $file) {
                $tmp_name = $_FILES['file_name']["tmp_name"][$key];
                $fileName = $_FILES['file_name']["name"][$key];
                $fileCategory = $captions[$i];
                
    
                if ($fileName != "" && $fileCategory != null) {
                    $fileName = strtolower($fileName);
                    $fileExtension = '.' . pathinfo($fileName, PATHINFO_EXTENSION);
    
                    $fileContentType = "";
                    if (in_array($fileExtension, $image)) {
                        $fileContentType = 'IMAGE';
                    }
                    if (in_array($fileExtension, $document)) {
                        $fileContentType = 'DOCUMENT';
                    }
                    if (in_array($fileExtension, $pdf)) {
                        $fileContentType = 'PDF';
                    }
                    if (in_array($fileExtension, $excel)) {
                        $fileContentType = 'EXCEL';
                    }
                    if (in_array($fileExtension, $text)) {
                        $fileContentType = 'TEXT';
                    }
    
                    $fileName = self::getGUID() . $fileExtension;
                    if ($fileContentType != "") {
                        $appealYear ='APPEAL - '. date('Y');
                        $appealID = 'AppealID - '.$appealId;
                        $causeListID = 'CauseListID - '.$causeListId;
    
                        $attachmentUrl = config('app.attachmentUrl');
    
                        $filePath = $attachmentUrl . $appName . '/' . $appealYear  . '/' . $appealID . '/' .$causeListID. '/';
                        // dd($filePath);
                        if (!is_dir($filePath)) {
                            mkdir($filePath,  0777, TRUE);
                        }
                       
                        DB::table('archive_case_file')->insert([
                            'archive_case_id'=>$appealId,
                            'file_headline'=>$fileName,
                            'file_path'=>$appName . '/' . $appealYear . '/' .$appealID. '/' .$causeListID. '/',
                            'file_category'=>$fileCategory,
                        ]);
                        move_uploaded_file($tmp_name, $filePath . $fileName);
                        $file_in_log=[
                             
                            'file_category'=>$fileCategory,
                            'file_name'=>$fileName,
                            'file_path' => $appName . '/' . $appealYear . '/' .$appealID. '/' .$causeListID. '/'
                        ];
                    }
                    array_push($log_file_data,$file_in_log);
                }
                $i++;
            }
        }
        
        // dd($test);
        return json_encode($log_file_data);
        
    }

    public static function getGUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function get_case_info(){

        
        $user = globalUserInfo();
        $user_role=$user->role_id;
        $user_court=$user->court_id;
        
        $court_info= ArchiveRepository::get_court_info($user_court);

    //    dd($court_info);

        $results = DB::table('archive_case')->orderby('id', 'desc');
        if ($user_role==28 || $user_role==27) {
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

        if ($user_role==6) {
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

        if ($user_role==2) {
            
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('appeal_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no']);
            }
            
        }
       
        
        
           
        
        return $results->paginate(10);
    }
    
    public static function old_dismiss_case_details($id){
        $data=DB::table('archive_case')->where('id', $id)->first();
        return $data;
    }

    public static function old_dismiss_case_attach_file($id){
        $file=DB::table('archive_case_file')->where('archive_case_id', $id)->get();
        return json_decode($file);
    }


}
