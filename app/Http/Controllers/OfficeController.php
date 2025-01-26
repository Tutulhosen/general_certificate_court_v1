<?php

namespace App\Http\Controllers;

use \Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator,Redirect,Response;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        // dd($officeInfo);
        $data['page_title']= 'অফিস সেটিং তালিকা';
        $query= DB::table('office')
                ->leftjoin('division', 'office.division_id', '=', 'division.id')
                ->leftjoin('district', 'office.district_id', '=', 'district.id')
                ->leftjoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                ->where('is_gcc', 1)
                ->select('office.*', 'upazila.upazila_name_bn', 'district.district_name_bn', 'division.division_name_bn');
        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $query->where('office.district_id','=', $officeInfo->district_id);
        }elseif($roleID == 9 || $roleID == 10 || $roleID == 11){
            $query->where('office.upazila_id','=', $officeInfo->upazila_id);    
        }/*elseif($roleID == 12){
            $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
            // dd($moujaIDs);
            // print_r($moujaIDs); exit;
            $query->where('office.mouja_id', $moujaIDs);    
        }   */     

        //Add Conditions 

        if(!empty($_GET['division'])) {
        $query->where('office.division_id','=',$_GET['division']);
        }
        if(!empty($_GET['district'])) {
            $query->where('office.district_id','=',$_GET['district']);
        }
        if(!empty($_GET['upazila'])) {
            $query->where('office.upazila_id','=',$_GET['upazila']);
        }
        

        $data['offices'] = $query->paginate(10)->withQueryString();
        // dd($data['offices']);
        // Dorpdown
        // $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
        $data['upazilas'] = NULL;
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
                       // dd(1);
            $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

        }

        return view('office.index')
        ->with($data)
        ->with('i', (request()->input('page',1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        //
        if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4 ){
            $data['division']= DB::table('division')
                            ->select('division.*')
                            ->get();
            $data['court_type']= DB::table('court_type')
                            ->select('court_type.*')
                            ->get();
            $data['page_title'] = 'নতুন অফিস এন্ট্রি ফরম';
        }elseif($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13) {

            $data['district']= DB::table('district')
                            ->select('district.*')
                            ->where('id',$officeInfo->district_id)
                            ->get();
            /*$data['court_type']= DB::table('court_type')
                            ->select('court_type.*')
                            ->get();*/
            $data['page_title'] = 'নতুন অফিস এন্ট্রি ফরম';

        }   
        // dd($data); 

        return view('office.add')->with($data);
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
        // dd($request->all());
        $roleID = Auth::user()->role_id;
        // dd($roleID);
        // $officeInfo = user_office_info();
        //
        // if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4 ){
            $validator = $request->validate([
                'division' => 'required',
                // 'district' => 'required',
                'office_lavel' => 'required',
                'office_name' => 'required',
                'status' => 'required'
            ]);
            DB::table('office')->insert([
               'division_id' => $request->division, 
               'district_id' => $request->district,
               'upazila_id' => $request->upazila,
               'level' => $request->office_lavel, 
               'office_name_bn' => $request->office_name,
               'status' => $request->status, 
               'is_gcc' => 1, 
            ]);
        // }
        return redirect()->route('office')
            ->with('success', 'অফিস সফলভাবে সংরক্ষণ করা হয়েছে');
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
       $data['offices'] = DB::table('office')
        ->select('office.*')
        /*->where('district_id', 38)*/
        ->where('office.id', $id)
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

        $data['page_title'] = 'নতুন অফিস এন্ট্রি ফরম';

         // dd( $data['offices']);

        return view('office.edit')->with($data);
        
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
            'office_name_bn' => 'required',
            'status' => 'required'
        ]);
        $data = [
           'division_id' => $request->division_id, 
           'district_id' => $request->district_id, 
           'upazila_id' => $request->upazila_id, 
           'office_name_bn' => $request->office_name_bn, 
           'status' => $request->status,  
        ];

        DB::table('office')
            ->where('id', $id)
            ->update($data);

        return redirect()->route('office')
            ->with('success', 'অফিস সফলভাবে সংশোধন করা হয়েছে');
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
    public function getDependentMouja($id)
    {
        $subcategories = DB::table("mouja")->where("upazila_id",$id)->pluck("mouja_name_bn","id");
        return json_encode($subcategories);
    }


}
