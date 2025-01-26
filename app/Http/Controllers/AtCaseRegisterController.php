<?php

namespace App\Http\Controllers;

use \Auth;
use App\Models\AtCaseBadi;
use App\Models\AtCaseRegister;
use App\Models\AtCaseBibadi;
use App\Models\Court;
use App\Models\JudgePanel;
use App\Models\AtCaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtCaseRegisterController extends Controller
{
    //
    public function index()
    {
        $data['cases'] =  AtCaseRegister::orderby('id','DESC')->paginate(10);
        
        $data['page_title'] =   'AT Case List';
        // return $atcases;
        // return $data['cases'];
        // dd($data['cases']);
        return view('at_case.at_case_register.index')->with($data);
    }

    public function create()
    {
        //Auth User Info
        // $userDivision = user_division();
        // $userDistrict = user_district();

        // Dropdown List

        $data['advocates'] = DB::table('users')
                ->select('id', 'name')
                ->where('role_id','=', 20)
                ->get();
        $data['courts'] = Court::select('id', 'court_name')
                // ->where('district_id', $userDistrict)
                ->get();

        $data['page_title'] = 'AT Case Entry Form';
        // dd($data);
        return view('at_case.at_case_register.create')->with($data);
    }

    public function store(Request $request)
    {
        // return $request->badi_name[0];
        // return $request->all();
        
        // File upload
        $filePath = 'uploads/at_case/notice/';
        if($request->show_cause != NULL){
            $fileName = $request->court.'_'.time().'.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/at_case/notice/'), $fileName);
        }else{
            $fileName = NULL;
        }

        //Case Date
        $caseDate = $request->case_date;
        $date_format = str_replace('/', '-', $caseDate);
        $atCase_date = date("Y-m-d", strtotime($date_format));
        //SF Deadline
        $sfDate = $request->case_date;
        $sf_date_format = str_replace('/', '-', $sfDate);
        $atCase_sf_date = date("Y-m-d", strtotime($sf_date_format));
        //Order Date
        $sfDate = $request->case_date;
        $sf_date_format = str_replace('/', '-', $sfDate);
        $atCase_sf_date = date("Y-m-d", strtotime($sf_date_format));

        // dd($atCase_date);

        $atcase = new AtCaseRegister();
        $atcase->court_id = $request->court;
        $atcase->division_id = $request->division;
        $atcase->district_id = $request->district;
        $atcase->case_no = $request->case_no;
        $atcase->case_date = $atCase_date;
        $atcase->case_reason = $request->case_reason;
        $atcase->comments = $request->comments;
        $atcase->notice_file = $filePath.'/'.$fileName;
        $atcase->advocate_id = $request->advocate;
        $atcase->sf_deadline = $atCase_sf_date;

        if($atcase->save()){
            foreach($request->badi_name as $key => $val)
            {
                $atcaseBadi = new AtCaseBadi();
                $atcaseBadi->at_case_id = $atcase->id;
                $atcaseBadi->name = $request->badi_name[$key];
                $atcaseBadi->designation = $request->badi_spouse_name[$key];
                $atcaseBadi->address = $request->badi_address[$key];
                $atcaseBadi->save();
            }

            foreach($request->bibadi_name as $key => $val)
            {
                $atcaseBibadi = new AtCaseBibadi();
                $atcaseBibadi->at_case_id = $atcase->id;
                $atcaseBibadi->name = $request->bibadi_name[$key];
                $atcaseBibadi->designation = $request->bibadi_spouse_name[$key];
                $atcaseBibadi->address = $request->bibadi_address[$key];
                $atcaseBibadi->save();
            }

            foreach($request->justis_name as $key => $val)
            {
                $judge = new JudgePanel();
                $judge->at_case_id = $atcase->id;
                $judge->justis_name = $request->justis_name[$key];
                $judge->designation = $request->justis_designation[$key];
                $judge->save();
            }


            foreach($request->witness_name as $key => $val)
            {
                //Order Date
                $orderDate = $request->witness_address[$key];
                $order_date_format = str_replace('/', '-', $orderDate);
                $atCase_order_date = date("Y-m-d", strtotime($order_date_format));

                $judge = new AtCaseOrder();
                $judge->at_case_id = $atcase->id;
                $judge->order_by = $request->witness_name[$key];
                $judge->section =  $request->witness_name[$key];;
                $judge->date = $atCase_order_date;
                $judge->save();
            }


        }

        // $userDivision = user_division();
        // $userDistrict = user_district();

        // return 'success';
        return redirect()->route('atcase.index')
        ->with('success', 'মামলার তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে');
        return view('at_case.at_case_register.index');
    }

    public function show($id)
    {
        /*$data['info'] =  AtCaseRegister::where('at_case_register.id',$id)->join('court', 'at_case_register.court_id', '=', 'court.id')
                                        ->join('district', 'at_case_register.district_id', '=', 'district.id')
                                        ->join('division', 'at_case_register.division_id', '=', 'division.id');*/
        $data['info'] = AtCaseRegister::where('id',$id)->first();
        $data['badis'] = AtCaseBadi::where('at_case_id',$id)->get();
        $data['bibadis'] = AtCaseBibadi::where('at_case_id',$id)->get();
        $data['orders'] = AtCaseOrder::where('at_case_id',$id)->get();
        $data['judges'] = JudgePanel::where('at_case_id',$id)->get();
        // dd($data['badis']) ;                               
        $data['page_title'] =   'AT Case Details';
        // return $atcases;
        return view('at_case.at_case_register.show')->with($data);
    }

    public function edit($id)
    {

        $data['advocates'] = DB::table('users')
                ->select('id', 'name')
                ->where('role_id','=', 20)
                ->get();
        $data['courts'] = Court::select('id', 'court_name')
                // ->where('district_id', $userDistrict)
                ->get();

        $data['info'] = AtCaseRegister::where('id',$id)->first();
        $data['badis'] = AtCaseBadi::where('at_case_id',$id)->get();
        $data['bibadis'] = AtCaseBibadi::where('at_case_id',$id)->get();
        $data['orders'] = AtCaseOrder::where('at_case_id',$id)->get();
        $data['judges'] = JudgePanel::where('at_case_id',$id)->get();
        $data['page_title'] = 'AT Case Edit Form';
        return view('at_case.at_case_register.edit')->with($data);






        //Auth User Info
        // $userDivision = user_division();
        // $userDistrict = user_district();

        // Dropdown List
        // $data['info'] = AtCaseRegister::where('id',$id)->first();
        // $data['badis'] = AtCaseBadi::where('at_case_id',$id)->get();
        // $data['bibadis'] = AtCaseBibadi::where('at_case_id',$id)->get();
        // $data['advocates'] = DB::table('users')
        //         ->select('id', 'name')
        //         ->where('role_id','=', 20)
        //         ->get();
        // $data['courts'] = Court::select('id', 'court_name')
        //         // ->where('district_id', $userDistrict)
        //         ->get();

        // $data['surveys'] = [];
        // $data['page_title'] = 'AT Case Entry Form';
        // dd($data);
        return view('at_case.at_case_register.edit')->with($data);
    }

    public function update(Request $request, $id='')
    {
        // return $request->badi_name[0];
        // return $request->all();
        
        $case_id = AtCaseRegister::where('id',$id)->get();
        // File upload
        $filePath = 'uploads/at_case/notice/';
       /* if($request->show_cause != NULL){
            $fileName = $request->court.'_'.time().'.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/at_case/notice/'), $fileName);
        }else{
            $fileName = NULL;
        }*/

        // File upload
        if($request->has('show_cause')){
            $fileName = $request->court.'_'.time().'.'.$request->show_cause->extension();
            $request->show_cause->move(public_path('uploads/at_case/notice/'), $fileName);
        }else{
            $fileName = $case_id[0]->notice_file;
        }

        //Case Date
        $caseDate = $request->case_date;
        $date_format = str_replace('/', '-', $caseDate);
        $atCase_date = date("Y-m-d", strtotime($date_format));
        //SF Deadline
        $sfDate = $request->case_date;
        $sf_date_format = str_replace('/', '-', $sfDate);
        $atCase_sf_date = date("Y-m-d", strtotime($sf_date_format));
        //Order Date
        $sfDate = $request->case_date;
        $sf_date_format = str_replace('/', '-', $sfDate);
        $atCase_sf_date = date("Y-m-d", strtotime($sf_date_format));

        // dd($atCase_date);

        $atcase =AtCaseRegister::findOrFail($id);
        $atcase->court_id = $request->court;
        $atcase->division_id = $request->division;
        $atcase->district_id = $request->district;
        $atcase->case_no = $request->case_no;
        $atcase->case_date = $atCase_date;
        $atcase->case_reason = $request->case_reason;
        $atcase->comments = $request->comments;
        if($request->has('show_cause')){
            $atcase->notice_file = $filePath.'/'.$fileName;
        }else{
            $atcase->notice_file = $fileName;
        }
        $atcase->advocate_id = $request->advocate;
        $atcase->sf_deadline = $atCase_sf_date;

        if($atcase->save()){
            for ($i=0; $i<sizeof($request->input('badi_name')); $i++)
            // foreach($request->badi_name as $key => $val)
            {

                DB::table('at_case_badi')->updateOrInsert(
                ['id' => $request->input('hide_badi_id')[$i]],
                [
                'at_case_id'   => $id,
                'name'         => $request->input('badi_name')[$i],
                'designation'  => $request->input('badi_spouse_name')[$i],
                'address'      => $request->input('badi_address')[$i],
                ]
                );
            }

            for ($i=0; $i<sizeof($request->input('bibadi_name')); $i++)
            // foreach($request->bibadi_name as $key => $val)
            {
               DB::table('at_case_bibadi')->updateOrInsert(
                ['id' => $request->input('hide_bibadi_id')[$i]],
                [
                'at_case_id'      => $id,
                'name'            => $request->input('bibadi_name')[$i],
                'designation'     => $request->input('bibadi_spouse_name')[$i],
                'address'         => $request->input('bibadi_address')[$i],
                ]
                );
            }

            for ($i=0; $i<sizeof($request->input('justis_name')); $i++) 
            // foreach($request->justis_name as $key => $val)
            {
                DB::table('judge_panel')->updateOrInsert(
                    ['id' => $request->input('hide_justis_id')[$i]],
                    [
                    'at_case_id'      => $id,
                    'justis_name'     => $request->input('justis_name')[$i],
                    'designation'     => $request->input('justis_designation')[$i],
                    
                    ]
                );
            }


            for ($i=0; $i<sizeof($request->input('witness_name')); $i++) 
            // foreach($request->witness_name as $key => $val)
            {
                //Order Date
                $orderDate = $request->witness_address[$i];
                $order_date_format = str_replace('/', '-', $orderDate);
                $atCase_order_date = date("Y-m-d", strtotime($order_date_format));

                // dd($request->all());
                DB::table('at_case_order')->updateOrInsert(
                    ['id' => $request->input('hide_witness_id')[$i]],
                    [
                    'at_case_id'      => $id,
                    'order_by'        => $request->input('witness_name')[$i],
                    'section'         => $request->input('witness_designation')[$i],
                    'date'            => $atCase_order_date,
                    
                    ]
                );
            }


        }

        // $userDivision = user_division();
        // $userDistrict = user_district();

        // return 'success';
        return redirect()->route('atcase.index')
        ->with('success', 'মামলার তথ্য সফলভাবে সিষ্টেম সংরক্ষণ করা হয়েছে');
        return view('at_case.at_case_register.index');
    }


    public function ajaxBadiDelete($id)
    {
        // dd($id);
        // $this->CaseBadi->deleteBadi('id', $id);
        DB::table('at_case_badi')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function ajaxBibadiDelete($id)
    {
        // $this->Common_model->delete('pds_education', 'id', $id);
        DB::table('at_case_bibadi')->where('id',$id)->delete();
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
