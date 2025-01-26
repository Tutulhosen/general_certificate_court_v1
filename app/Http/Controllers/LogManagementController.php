<?php

namespace App\Http\Controllers;

use App\Models\GccAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use App\Repositories\AppealRepository;

class LogManagementController extends Controller
{
    public function index()
    {  
        
      
        // $district_id = DB::table('court')->where('id', globalUserInfo()->court_id)->select('district_id')->first();
        // $dis_data = DB::table('district')->where('id', $district_id->district_id)->first();
 
        if(globalUserInfo()->role_id == 2 || globalUserInfo()->role_id == 8 || globalUserInfo()->role_id == 25){
            $cases = DB::table('gcc_appeals')
            ->orderBy('id','DESC')
            ->join('court', 'gcc_appeals.court_id', '=', 'court.id')
            ->join('division', 'court.division_id', '=', 'division.id')
            ->join('district', 'court.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->select('gcc_appeals.*', 'court.court_name','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn')
            ->paginate(10);
        

        }elseif(globalUserInfo()->role_id == 34){
            $cases = DB::table('gcc_appeals')
            ->orderBy('id','DESC')
            ->join('court', 'gcc_appeals.court_id', '=', 'court.id')
            ->join('division', 'court.division_id', '=', 'division.id')
            ->join('district', 'court.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->where('district.division_id', user_office_info()->division_id)
            ->select('gcc_appeals.*', 'court.court_name','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn')
            ->paginate(10);
            
        }elseif(globalUserInfo()->role_id == 6 ||  globalUserInfo()->role_id == 7 ){
            $office_info = get_office_by_id(globalUserInfo()->office_id);
            $distric_id = DB::table('district')
            ->where('id', '=', $office_info->district_id)
            ->first();
            $cases = DB::table('gcc_appeals')
            ->orderBy('id','DESC')
            ->join('court', 'gcc_appeals.court_id', '=', 'court.id')
            ->join('division', 'court.division_id', '=', 'division.id')
            ->join('district', 'court.district_id', '=', 'district.id')
            ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
            ->where('district.id', $distric_id->id)
            ->select('gcc_appeals.*', 'court.court_name','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn')
            ->paginate(10);

        }
        


        $page_title='মামলা কার্যকলাপ নিরীক্ষা';
        return view('logManagement.index',compact(['cases','page_title']));
    }
    public function log_index_search(Request $request)
    {
        $query = DB::table('gcc_appeals')
        ->orderBy('id','DESC')
        ->join('court', 'gcc_appeals.court_id', '=', 'court.id')
        ->join('division', 'court.division_id', '=', 'division.id')
        ->join('district', 'court.district_id', '=', 'district.id')
        ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
        ->select('gcc_appeals.*', 'court.court_name','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn');
        if (!empty($request->case_no)) {

            $query->where('case_no', $request->case_no);
        }
        $cases=$query->paginate(10);
        $page_title='মামলা কার্যকলাপ নিরীক্ষা';
        return view('logManagement.index',compact(['cases','page_title']));
    }
    public function log_index_single($id)
    {
        $id = decrypt($id);

        // $user = globalUserInfo();
        // $office_id = $user->office_id;
        // $roleID = $user->role_id;
        // $officeInfo = user_office_info();

         $appeal = GccAppeal::findOrFail($id);

         //dd($appeal);
         $data = AppealRepository::getAllAppealInfo($id);
          
         //dd($data);
        // $data['appeal']  = $appeal;
        // $data["notes"] = $appeal->appealNotes;
        // $data["districtId"]= $officeInfo->district_id;
        // $data["divisionId"]=$officeInfo->division_id;
        // $data["office_id"] = $office_id;
        // $data["gcoList"] = User::where('office_id', $user->office_id)->where('id', '!=', $user->id)->get();

        $info = DB::table('gcc_appeals')
        ->join('court', 'gcc_appeals.court_id', '=', 'court.id')
        ->join('division', 'court.division_id', '=', 'division.id')
        ->join('district', 'court.district_id', '=', 'district.id')
        ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
        ->select('gcc_appeals.*', 'court.court_name','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn')
        ->where('gcc_appeals.id','=',  $id)
        ->first();
         
        $data['info']=$info;
        $data['page_title'] = 'মামলার কার্যকলাপ নিরীক্ষার বিস্তারিত তথ্য';
        // return $data;
        $data['apepal_id']=encrypt($id);  
        $case_details=DB::table('gcc_log_book')->where('appeal_id','=',$id)->orderBy('id','desc')->get();
        $data['case_details']=$case_details;

        //dd($data);
        return view('logManagement.log')->with($data);
    }
    public function create_log_pdf($id)
    {
         
        $id = decrypt($id);

        // $user = globalUserInfo();
        // $office_id = $user->office_id;
        // $roleID = $user->role_id;
        // $officeInfo = user_office_info();

         $appeal = GccAppeal::findOrFail($id);

         //dd($appeal);
         $data = AppealRepository::getAllAppealInfo($id);
          
         //dd($data);
        // $data['appeal']  = $appeal;
        // $data["notes"] = $appeal->appealNotes;
        // $data["districtId"]= $officeInfo->district_id;
        // $data["divisionId"]=$officeInfo->division_id;
        // $data["office_id"] = $office_id;
        // $data["gcoList"] = User::where('office_id', $user->office_id)->where('id', '!=', $user->id)->get();

        $info = DB::table('gcc_appeals')
        ->join('court', 'gcc_appeals.court_id', '=', 'court.id')
        ->join('division', 'court.division_id', '=', 'division.id')
        ->join('district', 'court.district_id', '=', 'district.id')
        ->join('upazila', 'gcc_appeals.upazila_id', '=', 'upazila.id')
        ->select('gcc_appeals.*', 'court.court_name','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn')
        ->where('gcc_appeals.id','=',  $id)
        ->first();
         
        $data['info']=$info;
        $data['page_title'] = 'মামলার কার্যকলাপ নিরীক্ষার বিস্তারিত তথ্য';
        // return $data;
        $data['apepal_id']=encrypt($id);  
        $case_details=DB::table('gcc_log_book')->where('appeal_id','=',$id)->orderBy('id','desc')->get();
        $data['case_details']=$case_details;

        //dd($data);

        //return view('report.pdf_log_management')->with($data);

        $html = view('report.pdf_log_management')->with($data);

        $this->generatePamentPDF($html);
    }
    public function generatePamentPDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
    public function log_details_single_by_id($id)
    {
        //dd(decrypt($id));
        $log_details_single_by_id=DB::table('gcc_log_book')->where('id',decrypt($id))->first();
        $data['log_details_single_by_id']=$log_details_single_by_id;
        $data['page_title'] = 'মামলার বিস্তারিত তথ্য';
    
        return view('logManagement.log_details_single_by_id')->with($data);

    }
}
