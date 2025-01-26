<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SettingsController extends BaseController
{

    public function get_division_list()
    {
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();
        return $this->sendResponse($data, 'Division Data.');
    }

    public function get_district_list($division_id)
    {
        $data['district'] = DB::table('district')
            ->select('id', 'district_name_bn')
            ->where('division_id', $division_id)
            ->where('status', 1)
            ->get();
        return $this->sendResponse($data, 'District Data.');
    }

    public function get_upazila_list($district_id)
    {
        //
        $data = DB::table('upazila')
        ->select('id', 'upazila_name_bn')
        ->where('district_id', $district_id)
            ->where('status', 1)
            ->get();
        return $this->sendResponse($data, 'Upazila Data.');
    }

    public function get_court_list($district_id)
    {
        //
        $data['court'] = DB::table('court')
        ->select('id', 'court_name')
        ->where('district_id', $district_id)
        ->orWhere('district_id', NULL)
        ->get();

        return $this->sendResponse($data, 'Court Data.');
    }

    public function crpc_section_list()
    {
        //
        $data['crpc_section'] = DB::table('crpc_sections as crpc')
            ->leftjoin('crpc_section_details as crpcd', 'crpc.crpc_id', '=', 'crpcd.crpc_id')
            ->select('crpc.crpc_id', 'crpc.crpc_name', 'crpcd.crpc_details')
            ->groupBy('crpc.crpc_id')->get();

        return $this->sendResponse($data, 'Crpc section Data.');
    }



    // old
    //=====================Division====================//
    public function division_list()
    {
        //
        $data = DB::table('division')
            ->select('id', 'division_name_bn')
            ->where('status', 1)
            ->get();

        return $this->sendResponse($data, 'User Details.');
    }

    public function district_list($division_id)
    {
        //
        $data = DB::table('district')
            ->select('id', 'district_name_bn')
            ->where('division_id', $division_id)
            ->where('status', 1)
            ->get();
        return $this->sendResponse($data, 'User Details.');
    }

    public function upazila_list($district_id)
    {
        //
        $data = DB::table('upazila')
            ->select('id', 'upazila_name_bn')
            ->where('district_id', $district_id)
            ->where('status', 1)
            ->get();
        return $this->sendResponse($data, 'User Details.');
    }
    public function court_list($district_id)
    {
        //
        $data = DB::table('court')
            ->select('id', 'court_name')
            ->where('district_id', $district_id)
            ->orWhere('district_id', NULL)
            ->get();

        return $this->sendResponse($data, 'User Details.');
    }


    public function test()
    {
        // Counter
        $data['total_case'] = DB::table('case_register')->count();
        // dd($data);
        // echo 'Hellollll'; exit;
        return $this->sendResponse($data, 'test successfully.');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = CaseRegister::all();

        return $this->sendResponse(CaseResource::collection($items), 'Case retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $case = CaseRegister::create($input);

        return $this->sendResponse(new CaseResource($case), 'Case created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $case = CaseRegister::find($id);

        if (is_null($case)) {
            return $this->sendError('Case not found.');
        }

        return $this->sendResponse(new CaseResource($case), 'Case retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CaseRegister $case)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $case->name = $input['name'];
        $case->detail = $input['detail'];
        $case->save();

        return $this->sendResponse(new CaseResource($case), 'Case updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CaseRegister $case)
    {
        $case->delete();

        return $this->sendResponse([], 'Case deleted successfully.');
    }
}
