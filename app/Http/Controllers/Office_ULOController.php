<?php

namespace App\Http\Controllers;

use \Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator,Redirect,Response;

class Office_ULOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        $data['page_title']= 'মৌজা ভিত্তিক ইউনিয়ন ভূমি অফিসের তালিকা';
        $query = DB::table('mouja_ulo')
                ->join('division', 'mouja_ulo.division_id', '=', 'division.id')
                ->join('district', 'mouja_ulo.district_id', '=', 'district.id')
                ->join('upazila', 'mouja_ulo.upazila_id', '=', 'upazila.id')
                ->join('office', 'mouja_ulo.ulo_office_id', '=', 'office.id')
                ->select('mouja_ulo.*', 'office.office_name_bn', 'upazila.upazila_name_bn', 'district.district_name_bn', 'division.division_name_bn');
                // ->where('mouja_ulo.district_id', 38)

        // Check User Role ID
        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $query->where('mouja_ulo.district_id','=', $officeInfo->district_id);
        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11){
            $query->where('mouja_ulo.upazila_id','=', $officeInfo->upazila_id);
        }elseif($roleID == 12){
            $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
            // dd($moujaIDs);
            // print_r($moujaIDs); exit;
            $query->where('mouja_ulo.mouja_id', $moujaIDs);
        }

        // $cases = $query->paginate(10);

        //Add Conditions

        if(!empty($_GET['division'])) {
            $query->where('mouja_ulo.division_id','=',$_GET['division']);
        }
        if(!empty($_GET['district'])) {
            $query->where('mouja_ulo.district_id','=',$_GET['district']);
        }
        if(!empty($_GET['upazila'])) {
            $query->where('mouja_ulo.upazila_id','=',$_GET['upazila']);
        }
        if(!empty($_GET['ulo'])) {
            // dd(1);
            $query->where('mouja_ulo.ulo_office_id','=',$_GET['ulo']);
        }

        $data['offices'] = $query->paginate(10)->withQueryString();
        // dd($data['offices']);
        // Dorpdown
        $data['upazilas'] = NULL;
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }

        return view('office_ulo.index')
        ->with($data)
        ->with('i', (request()->input('page',1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

         // dd($request->input('upazila'));
        //

        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();

        $data['page_title']= 'নতুন মৌজা ভিত্তিক ইউনিয়ন ভূমি অফিস এন্ট্রি ফরম';
        $data['offices'] = 0;
        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
                if($request->input('upazila') != NULL){
                    $query = DB::table('mouja')
                            ->select('mouja.*',/* 'office.office_name_bn',*/ 'upazila.upazila_name_bn', 'district.district_name_bn', 'division.division_name_bn')
                            ->join('division', 'mouja.division_id', '=', 'division.id')
                            ->join('district', 'mouja.district_id', '=', 'district.id')
                            ->join('upazila', 'mouja.upazila_id', '=', 'upazila.id')
                            // ->join('office', 'mouja.ulo_office_id', '=', 'office.id')
                            ->where('mouja.division_id','=',$officeInfo->division_id)
                            ->where('mouja.district_id','=',$officeInfo->district_id)
                            ->where('mouja.upazila_id','=',$_GET['upazila']);

                    $data['offices'] = $query->get();

                    // ULO Office Dropdown By Upazila from Office Table
                    $data['ulos'] = DB::table('office')->select('id', 'office_name_bn')->where('upazila_id', $_GET['upazila'])->where('level', 6)->get();

                }
        }else{
            if($request->input('upazila') != NULL){
                    $query = DB::table('mouja')
                            ->select('mouja.*',/* 'office.office_name_bn',*/ 'upazila.upazila_name_bn', 'district.district_name_bn', 'division.division_name_bn')
                            ->join('division', 'mouja.division_id', '=', 'division.id')
                            ->join('district', 'mouja.district_id', '=', 'district.id')
                            ->join('upazila', 'mouja.upazila_id', '=', 'upazila.id')
                            // ->join('office', 'mouja.ulo_office_id', '=', 'office.id')
                            ->where('mouja.division_id','=',$_GET['division'])
                            ->where('mouja.district_id','=',$_GET['district'])
                            ->where('mouja.upazila_id','=',$_GET['upazila']);

                    $data['offices'] = $query->get();

                    // ULO Office Dropdown By Upazila from Office Table
                    $data['ulos'] = DB::table('office')->select('id', 'office_name_bn')->where('upazila_id', $_GET['upazila'])->where('level', 6)->get();

                }
        }
        // Dorpdown
        $data['upazilas'] = NULL;
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }

        return view('office_ulo.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd(1);
              /* $division_id = $request->input('division');
               $district_id = $_GET['district'];
               $upazila_id = $_GET['upazila'];

                dd($division_id);*/
         $offices = $request->input('office_id');
        $upazila_office = DB::table('office')->select('parent')->where('id', $offices)->first()->parent;
    // dd($upazila_office);
        $request->validate([
            'office_id' => 'required',
            'mouja_id' => 'required',
            'division' => 'required',
            'district' => 'required',
            'upazila' => 'required',
        ],
        [
            'office_id.required' => 'ইউনিয়ন ভূমি অফিসের নাম নির্বাচন করুন',
            'mouja_id.required' => 'মৌজা নির্বাচন করুন',
        ]);
        $moujas = $request->input('mouja_id');

        for ($i=0; $i<sizeof($moujas); $i++) {
            $mouja_info = DB::table('mouja')->select('id','jl_no','mouja_name_bn','upazila_id','district_id','division_id')->where('id', $moujas[$i])->first();
            // dd($mouja_info);

            $dynamic_data = [
                'upazila_office_id'  => $upazila_office,
                'ulo_office_id '  => $request->input('office_id'),
                'mouja_id '  => $mouja_info->id,
                'mouja_jl_no '  => $mouja_info->jl_no,
                'upazila_id '  => $mouja_info->upazila_id,
                'division_id '  => $mouja_info->district_id,
                'district_id '  => $mouja_info->division_id,

            ];
          /*  echo "<pre>";
            print_r($dynamic_data);*/
            DB::table('mouja_ulo')->insert($dynamic_data);
        }
            return view('office_ulo.index');
            // exit('Your DATA will be inserted soon');



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
        $data['offices'] = DB::table('mouja_ulo')
        ->select('mouja_ulo.*')
        /*->where('district_id', 38)*/
        ->where('mouja_ulo.id', $id)
        ->get();
        $data['districts'] = DB::table('district')
        ->join('division', 'district.division_id', '=', 'division.id')
        ->select('district.*','division.division_name_bn')
        /*->where('district.id', 38)*/
        ->get(); 
        $data['upazila'] = DB::table('upazila')
        ->select('id', 'upazila_name_bn')
        /*->where('district_id', 38)*/
        ->get(); 

        $data['page_title'] = 'ইউএলও ভিত্তিক মৌজা সংশোধন ফরম';

         // dd( $data['offices']);

        return view('office_ulo.edit')->with($data);
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

        $validator = $request->validate([
            'division_id' => 'required',
            'district_id' => 'required',
            'upazila_id' => 'required',
            'mouja_name' => 'required',
            'status' => 'required'
        ]);
        $data = [
           'division_id' => $request->division_id, 
           'district_id' => $request->district_id, 
           'upazila_id' => $request->upazila_id, 
           'mouja_name' => $request->mouja_name, 
           'status' => $request->status,  
        ];

        DB::table('mouja_ulo')
            ->where('id', $id)
            ->update($data);

        return redirect()->route('ulo')
            ->with('success', 'মৌজা সফলভাবে সংশোধন করা হয়েছে');
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

    public function getDependentDistrict($id)
    {
        $subcategories = DB::table("district")->where("division_id",$id)->pluck("district_name_bn","id");
        return json_encode($subcategories);
    }
    public function getDependentUpazila($id)
    {
        $subcategories = DB::table("upazila")->where("district_id",$id)->pluck("upazila_name_bn","id");
        return json_encode($subcategories);
    }
    public function getDependentULO($id)
    {
        $subcategories = DB::table("office")->where("upazila_id",$id)->where("level",6)->pluck("office_name_bn","id");
        return json_encode($subcategories);
    }
    public function getDependentMouja($id)
    {
        $subcategories = DB::table("mouja")->where("upazila_id",$id)->pluck("mouja_name_bn","id");
        return json_encode($subcategories);
    }
}
