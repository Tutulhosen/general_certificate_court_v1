<?php

namespace App\Http\Controllers;

use \Auth;
use App\Models\CaseRegister;
use App\Models\CaseBadi;
use App\Models\CaseBibadi;
use App\Models\CaseSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OtherCaseRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //============All Case list============//


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function writ_create()
    {
        //Auth User Info
        $userDivision = user_division();
        $userDistrict = user_district();

        // Dropdown List
        $data['courts'] = DB::table('court')
                ->select('id', 'court_name')
                ->where('district_id', $userDistrict)
                ->get();
        // $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['upazilas'] = DB::table('upazila')
                ->select('id', 'upazila_name_bn')
                ->where('district_id', $userDistrict)
                ->get();
        $data['case_types'] = DB::table('case_type')->select('id', 'ct_name')->get();
        $data['surveys'] = DB::table('survey_type')->select('id', 'st_name')->get();
        $data['land_types'] = DB::table('land_type')->select('id', 'lt_name')->get();

        // dd($data);
        // dd($case_type);
        // $data['subcategories'] = DB::table("mouja")->where("upazila_id",38)->pluck("mouja_name_bn","id");

        $data['page_title'] = 'Writ Case Entry Form'; //exit;
        // return view('otherCase.case_add', compact('page_title', 'case_type'));
        return view('otherCase.writ_create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function contempt_create()
    {
        //Auth User Info
        $userDivision = user_division();
        $userDistrict = user_district();

        // Dropdown List
        $data['courts'] = DB::table('court')
                ->select('id', 'court_name')
                ->where('district_id', $userDistrict)
                ->get();
        // $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['upazilas'] = DB::table('upazila')
                ->select('id', 'upazila_name_bn')
                ->where('district_id', $userDistrict)
                ->get();
        $data['case_types'] = DB::table('case_type')->select('id', 'ct_name')->get();
        $data['surveys'] = DB::table('survey_type')->select('id', 'st_name')->get();
        $data['land_types'] = DB::table('land_type')->select('id', 'lt_name')->get();

        // dd($data);
        // dd($case_type);
        // $data['subcategories'] = DB::table("mouja")->where("upazila_id",38)->pluck("mouja_name_bn","id");

        $data['page_title'] = 'Contempt Case Entry Form'; //exit;
        // return view('otherCase.case_add', compact('page_title', 'case_type'));
        return view('otherCase.contempt_create')->with($data);
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function review_create()
    {
        //Auth User Info
        $userDivision = user_division();
        $userDistrict = user_district();
   
        // Dropdown List
        $data['courts'] = DB::table('court')
                ->select('id', 'court_name')
                ->where('district_id', $userDistrict)
                ->get();
        // $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['upazilas'] = DB::table('upazila')
                ->select('id', 'upazila_name_bn')
                ->where('district_id', $userDistrict)
                ->get();
        $data['case_types'] = DB::table('case_type')->select('id', 'ct_name')->get();
        $data['surveys'] = DB::table('survey_type')->select('id', 'st_name')->get();
        $data['land_types'] = DB::table('land_type')->select('id', 'lt_name')->get();

        // dd($data);
        // dd($case_type);
        // $data['subcategories'] = DB::table("mouja")->where("upazila_id",38)->pluck("mouja_name_bn","id");

        $data['page_title'] = 'Review Case Entry Form'; //exit;
        // return view('otherCase.case_add', compact('page_title', 'case_type'));
        return view('otherCase.review_create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function administrative_create()
    {
        //Auth User Info
        $userDivision = user_division();
        $userDistrict = user_district();

        // Dropdown List
        $data['courts'] = DB::table('court')
                ->select('id', 'court_name')
                ->where('district_id', $userDistrict)
                ->get();
        // $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['upazilas'] = DB::table('upazila')
                ->select('id', 'upazila_name_bn')
                ->where('district_id', $userDistrict)
                ->get();
        $data['case_types'] = DB::table('case_type')->select('id', 'ct_name')->get();
        $data['surveys'] = DB::table('survey_type')->select('id', 'st_name')->get();
        $data['land_types'] = DB::table('land_type')->select('id', 'lt_name')->get();

        // dd($data);
        // dd($case_type);
        // $data['subcategories'] = DB::table("mouja")->where("upazila_id",38)->pluck("mouja_name_bn","id");

        $data['page_title'] = 'AT Case Entry Form'; //exit;
        // return view('otherCase.case_add', compact('page_title', 'case_type'));
        return view('otherCase.at_create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CaseRegister  $caseRegister
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CaseRegister  $caseRegister
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CaseRegister  $caseRegister
     * @return \Illuminate\Http\Response
     */

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    /*public function messages()
    {
        return [
        'court.required' => 'আদালতের নাম নির্বাচন করুন',
        'upazila.required' => 'উপজেলা নির্বাচন করুন',
        'mouja.required' => 'মৌজা নির্বাচন করুন',
        ];
    }*/

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

    public function getDependentMouja($id)
    {
        $subcategories = DB::table("mouja")->where("upazila_id",$id)->pluck("mouja_name_bn","id");
        return json_encode($subcategories);
    }

    public function getDependentGp($id)
    {
        $subcategories = DB::table("users")
        ->join('office', 'users.office_id', '=', 'office.id')
        ->leftJoin('district', 'office.district_id', '=', 'district.id')
        ->where("district.id",$id)->where("users.role_id",13)->pluck("users.name","users.id");
        return json_encode($subcategories);
    }

    public function ajaxBadiDelete($id)
    {
        // dd($id);
        // $this->CaseBadi->deleteBadi('id', $id);
        DB::table('case_badi')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function ajaxBibadiDelete($id)
    {
        // $this->Common_model->delete('pds_education', 'id', $id);
        DB::table('case_bibadi')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

    public function ajaxSurvayDelete($id)
    {
        // $this->Common_model->delete('pds_education', 'id', $id);
        DB::table('case_survey')->where('id',$id)->delete();
        echo 'This information remove from database.';
    }

}
