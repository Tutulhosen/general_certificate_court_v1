<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AppealController extends Controller
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
    public function create()
    {
        //

        // Dropdown List
        // $data['case_types'] = RM_CaseType::whereRaw("FIND_IN_SET('$roleID',access_role)")->get();
        // $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
        $data['divisions'] = DB::table('division')
                ->select('id', 'division_name_bn')
                ->get();
        
        /*$data['districts'] = DB::table('district')
                ->select('id', 'district_name_bn')
                ->where('division_id', $userDivision)
                ->get();
      
         $data['upazilas'] = DB::table('upazila')
                ->select('id', 'upazila_name_bn')
                ->where('district_id', $userDistrict)
                ->get();*/
        
        /*$data['surveys'] = DB::table('survey_type')->select('id', 'st_name')->get();
        $data['land_types'] = DB::table('land_type')->select('id', 'lt_name')->get();
        */
        // dd($data);
        // dd($case_type);
        // $data['subcategories'] = DB::table("mouja")->where("upazila_id",38)->pluck("mouja_name_bn","id");

        $data['page_title'] = 'আপিল আবেদন তথ্য';
        return view('generalCertificateAppeal.create')->with($data);
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

    public function getDependentCourt($id)
    {
        $subcategories = DB::table("court")->where("district_id",$id)->pluck("court_name","id");
        return json_encode($subcategories);
    }
    public function getDependentOrganization(Request $request)
    {
        $office_information = DB::table("office")
        ->where("division_id",$request->division_id)
        ->where("district_id",$request->district_id)
        ->where("upazila_id",$request->upazila_id)
        ->where('organization_type',$request->organization_type)
        ->where('status',1)
        ->where('is_organization',1)
        ->select("office_name_bn","id", "organization_routing_id")
        ->get();
      
        return json_encode($office_information);
    }

    public function getdependentOfficeName($id)
    {
        $office_address_routing_no= DB::table("office")->where("id",$id)->select("office_name_bn","office_name_en","organization_physical_address","organization_routing_id")->first();
        return $office_address_routing_no;
    }
}
