<?php

namespace App\Http\Controllers;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('setting.index');
    }

    //=====================Division====================//
    public function division_list()
    {
        //
        $data['division']= DB::table('division')
                        ->select('division.*')
                        ->get();
        $data['page_title'] = 'বিভাগের তালিকা';
        return view('setting.division_list')->with($data);
    }
    public function division_edit($id)
    {
        //
        $division= DB::table('division')
                        ->select('division.*')
                        ->where('division.id', $id)
                        ->first();
        $page_title = 'বিভাগের বিস্তারিত সংশোধন';
        return view('setting.division_edit', compact('division','page_title'));
    }

    public function division_update(Request $request, $id='')
    {
        $request->validate([
            'name_bn' => 'required'
        ]);
        $data = [
           'division_name_bn' => $request->name_bn,
           'division_bbs_code' => $request->bbs_code,
           'status' => $request->status,
        ];

        $ID = DB::table('division')
                ->where('id', $id)
                ->update($data);

        return redirect()->route('division')
            ->with('success', 'User data updated successfully');
    }
     //================== //Division====================// //=====================District====================//
    public function district_list()
    {
        //
        $district= DB::table('district')
                        ->join('division', 'district.division_id', '=', 'division.id')
                        ->select('district.*','division.division_name_bn')
                        ->orderBy('division_id', 'desc')
                        ->paginate(10);
        $page_title = 'জেলার তালিকা';

        return view('setting.district_list', compact(['district','page_title']))
        ->with('i', (request()->input('page',1) - 1) * 10);
    }
    public function district_edit($id)
    {
        //
        $district= DB::table('district')
                        ->select('district.*')
                        ->where('district.id', $id)
                        ->first();
        $page_title = 'জেলার বিস্তারিত সংশোধন';

        return view('setting.district_edit', compact('district','page_title'));
    }

    public function district_update(Request $request, $id='')
    {
        $request->validate([
            'name_bn' => 'required'
        ]);
        $data = [
           'district_name_bn' => $request->name_bn,
           'district_bbs_code' => $request->bbs_code,
           'status' => $request->status,
        ];

        $ID = DB::table('district')
                ->where('id', $id)
                ->update($data);

        return redirect()->route('district')
            ->with('success', 'User data updated successfully');
    }
     //================== //District====================//
     //=====================Upazila====================//
    public function upazila_list()
    {
        //
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();

        $query= DB::table('upazila')
                        ->join('district', 'upazila.district_id', '=', 'district.id')
                        ->select('upazila.*','district.district_name_bn')
                        ->orderBy('district_id', 'desc');
        if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13){
            $query->where('upazila.district_id','=', $officeInfo->district_id);
        }
        $upazila = $query->paginate(10);
        // dd($upazila);
        $page_title = 'উপজেলার তালিকা';

        return view('setting.upazila_list', compact(['upazila','page_title']))
        ->with('i', (request()->input('page',1) - 1) * 10);
    }
    public function upazila_edit($id)
    {
        //
        $upazila= DB::table('upazila')
                        ->select('upazila.*')
                        ->where('upazila.id', $id)
                        ->first();

        $page_title = 'উপজেলার বিস্তারিত সংশোধন';
        return view('setting.upazila_edit', compact('upazila','page_title'));
    }

    public function upazila_update(Request $request, $id='')
    {
        $request->validate([
            'name_bn' => 'required'
        ]);
        $data = [
           'upazila_name_bn' => $request->name_bn,
           'upazila_bbs_code' => $request->bbs_code,
           'status' => $request->status,
        ];

        $ID = DB::table('upazila')
                ->where('id', $id)
                ->update($data);

        return redirect()->route('upazila')
            ->with('success', 'User data updated successfully');
    }
     //================== //Upazila====================//
     //=====================Mouja====================//
    public function mouja_list()
    {
        //
        $mouja= DB::table('mouja')
                        ->leftjoin('district', 'mouja.district_id', '=', 'district.id')
                        ->leftjoin('division', 'mouja.division_id', '=', 'division.id')
                        ->leftjoin('upazila', 'mouja.upazila_id', '=', 'upazila.id')
                        ->select('mouja.*','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn')
                        // ->where('district_id', 38)
                        ->paginate(10);
        $page_title = 'মৌজার তালিকা';

        return view('setting.mouja_list', compact(['mouja','page_title']))
        ->with('i', (request()->input('page',1) - 1) * 10);
    }
    public function mouja_add()
    {
        $data['upazilas'] = DB::table('upazila')
        ->select('upazila.*')
        ->where('district_id', 38)
        ->get();
        $data['districts'] = DB::table('district')
        ->join('division', 'district.division_id', '=', 'division.id')
        ->select('district.*','division.division_name_bn')
        ->where('district.id', 38)
        ->get();
        $data['page_title'] = 'নতুন মৌজা এন্ট্রি ফরম';
        // dd($data);
        return view('setting.mouja_add')->with($data);;
    }
    public function mouja_save(Request $request)
    {
        //
        $validator = $request->validate([
            'division_id' => 'required',
            'district_id' => 'required',
            'upazila_id' => 'required',
            'mouja_name_bn' => 'required',
            'status' => 'required'
        ]);
        // dd($validator);
        /*if ($validator->fails()) {
            return redirect('/mouja/add')
                        ->withErrors($validator)
                        ->withInput();
        }*/

        DB::table('mouja')->insert([
           'division_id' => $request->division_id,
           'district_id' => $request->district_id,
           'upazila_id' => $request->upazila_id,
           'mouja_name_bn' => $request->mouja_name_bn,
           'status' => $request->status,
        ]);

        return redirect()->route('mouja')
            ->with('success', 'মৌজা সফলভাবে সংরক্ষণ করা হয়েছে');
        /*return view('setting.mouja_list');*/
    }
    public function mouja_edit($id)
    {
        //
        $data['upazilas'] = DB::table('upazila')
        ->select('upazila.*')
        /*->where('district_id', 38)*/
        ->get();
        $data['districts'] = DB::table('district')
        ->join('division', 'district.division_id', '=', 'division.id')
        ->select('district.*','division.division_name_bn')
        /*->where('district.id', 38)*/
        ->get();
        $data['mouja']= DB::table('mouja')
                        ->select('mouja.*')
                        ->where('mouja.id', $id)
                        ->first();
        $data['page_title'] = 'মৌজা সংশোধন ফরম';

       /* echo '<pre>';
        print_r($data['upazilas']);
        print_r($data['mouja']);
        exit(1);*/

        return view('setting.mouja_edit')->with($data);
    }

    public function mouja_update(Request $request, $id='')
    {
         $validator = $request->validate([
            'division_id' => 'required',
            'district_id' => 'required',
            'upazila_id' => 'required',
            'mouja_name_bn' => 'required',
            'status' => 'required'
        ]);
        $data = [
           'division_id' => $request->division_id,
           'district_id' => $request->district_id,
           'upazila_id' => $request->upazila_id,
           'mouja_name_bn' => $request->mouja_name_bn,
           'status' => $request->status,
        ];

        DB::table('mouja')
            ->where('id', $id)
            ->update($data);

        return redirect()->route('mouja')
            ->with('success', 'মৌজা সফলভাবে সংশোধন করা হয়েছে');
    }
     //================== //Mouja====================//
    //=====================Survey_Type====================//
    public function survey_type_list()
    {
        //
        $data['survey_type']= DB::table('survey_type')
                        ->select('survey_type.*')
                        ->get();
        $data['page_title'] = 'সার্ভের ধরণ তালিকা';

        return view('setting.survey_type_list')
        ->with($data);
    }
   /* public function survey_type_edit($id)
    {
        //
        $survey_type= DB::table('survey_type')
                        ->select('survey_type.*')
                        ->where('survey_type.id', $id)
                        ->first();

        return view('setting.survey_type_edit', compact('survey_type'));
    }

    public function survey_type_update(Request $request, $id='')
    {
        $request->validate([
            'name_bn' => 'required'
        ]);
        $data = [
           'survey_type_name_bn' => $request->name_bn,
           'survey_type_bbs_code' => $request->bbs_code,
           'status' => $request->status,
        ];

        $ID = DB::table('survey_type')
                ->where('id', $id)
                ->update($data);

        return redirect()->route('survey_type')
            ->with('success', 'User data updated successfully');
    }*/
     //================== //Survey_Type====================//
    //=====================Case_Type====================//
    public function case_type_list()
    {
        //
        $data['case_type']= DB::table('case_type')
                        ->select('case_type.*')
                        ->get();
        $data['page_title'] = 'মামলার ধরণ তালিকা';

        return view('setting.case_type_list')
        ->with($data);
    }
   /* public function case_type_edit($id)
    {
        //
        $case_type= DB::table('case_type')
                        ->select('case_type.*')
                        ->where('case_type.id', $id)
                        ->first();

        return view('setting.case_type_edit', compact('case_type'));
    }

    public function case_type_update(Request $request, $id='')
    {
        $request->validate([
            'name_bn' => 'required'
        ]);
        $data = [
           'case_type_name_bn' => $request->name_bn,
           'case_type_bbs_code' => $request->bbs_code,
           'status' => $request->status,
        ];

        $ID = DB::table('case_type')
                ->where('id', $id)
                ->update($data);

        return redirect()->route('case_type')
            ->with('success', 'User data updated successfully');
    }*/
     //================== //Case_Type====================//
    //=====================Case_Type====================//
    public function case_status_list()
    {
        //
        $data['case_status']= DB::table('case_status')
                        ->select('case_status.*')
                        ->get();
        $data['page_title'] = 'মামলার স্ট্যাটাস তালিকা';

        return view('setting.case_status_list')
        ->with($data);
    }
    public function case_status_details($id)
    {
        //
       $case_status = DB::table('case_status')->get();

        $data['case_status']= DB::table('case_status')
                ->select('case_status.*')
                ->where('case_status.id',$id)
                ->first();
        $roleIdArr = explode(',', $data['case_status']->role_access);
        $data['roles'] = DB::table('role')->whereIn('id', $roleIdArr )
                ->select('role_name')
                ->get();
                        // dd($data['role']);
        $data['page_title'] = 'মামলার স্ট্যাটাস এর বিস্তারিত';

        return view('setting.case_status_details')
        ->with($data);
    }
    public function case_status_add()
    {
        //
        $data['roles'] = DB::table('role')->select('id', 'role_name')->where('in_action', 1)->get();
        $data['page_title'] = 'মামলার স্ট্যাটাস এন্ট্রি ফরম';
        return view('setting.case_status_add')->with($data);
    }


    public function case_status_store(Request $request)
    {
        // dd($request->role_id());
        $request->validate([
            'status_name' => 'required',
            'templete' => 'required',
            'role_id' => 'required',
        ],
        [
            'status_name.required' => 'মামলার স্ট্যাটাস এন্ট্রি করুণ',
            'templete.required' => 'মামলার মন্তব্য এন্ট্রি করুণ',
            'role_id.required' => 'ইউজাররোল নির্বাচন করুন',
        ]);

        $roles = $request->input('role_id');
        $roles_implode = implode(",", $roles);

        $dynamic_data = [
            'status_name'  => $request->status_name,
            'status_templete'  => $request->templete,
            'role_access'  => $roles_implode,

        ];
        DB::table('case_status')->insert($dynamic_data);

         return redirect()->route('case-status')
            ->with('success', 'মামলার স্ট্যাটাস সফল ভাবে সংরক্ষণ করা হয়েছে');
    }


    public function case_status_edit($id)
    {
        //
        $data['roles'] = DB::table('role')->select('id', 'role_name')->where('in_action', 1)->get();
        $data['page_title'] = 'মামলার স্ট্যাটাস এন্ট্রি ফরম';

        $data['case_status']= DB::table('case_status')
                        ->select('case_status.*')
                        ->where('case_status.id', $id)
                        ->first();

        return view('setting.case_status_edit')->with($data);
    }

    public function case_status_update(Request $request, $id='')
    {
        $request->validate([
            'status_name' => 'required',
            'templete' => 'required',
            'role_id' => 'required',
        ],
        [
            'templete.required' => 'মামলার মন্তব্য এন্ট্রি করুণ',
            'status_name.required' => 'মামলার স্ট্যাটাস এন্ট্রি করুণ',
            'role_id.required' => 'ইউজাররোল নির্বাচন করুন',
        ]);

        $roles = $request->input('role_id');
        $roles_implode = implode(",", $roles);

        $dynamic_data = [
            'status_name'  => $request->status_name,
            'status_templete'  => $request->templete,
            'role_access'  => $roles_implode,

        ];

        $ID = DB::table('case_status')
                ->where('id', $id)
                ->update($dynamic_data);

        return redirect()->route('case-status')
            ->with('success', 'User data updated successfully');
    }
    /**/
     //================== //Case_Type====================//






        //=====================Court_type====================//
    public function court_type_list()
    {
        //
        $data['court_type']= DB::table('court_type')
                        ->select('court_type.*')
                        ->get();
        $data['page_title'] = 'কোর্টের ধরণ তালিকা';

        return view('setting.court_type_list')
        ->with($data);
    }
   /* public function court_type_edit($id)
    {
        //
        $court_type= DB::table('court_type')
                        ->select('court_type.*')
                        ->where('court_type.id', $id)
                        ->first();

        return view('setting.court_type_edit', compact('court_type'));
    }

    public function court_type_update(Request $request, $id='')
    {
        $request->validate([
            'name_bn' => 'required'
        ]);
        $data = [
           'court_type_name_bn' => $request->name_bn,
           'court_type_bbs_code' => $request->bbs_code,
           'status' => $request->status,
        ];

        $ID = DB::table('court_type')
                ->where('id', $id)
                ->update($data);

        return redirect()->route('court_type')
            ->with('success', 'User data updated successfully');
    }*/
     //================== //Court_type====================//


    //=====================Short Decisoin====================//
    public function shortDecision(Request $request)
    {
        $result = DB::table('gcc_case_shortdecisions')
                 ->select('gcc_case_shortdecisions.id','gcc_case_shortdecisions.delails','gcc_case_shortdecisions.case_short_decision','gcc_case_shortdecisions.active_status');

        if (!empty($request->search_short_order_name)) {
            $result= $result->where('gcc_case_shortdecisions.case_short_decision', 'LIKE', '%'.$request->search_short_order_name.'%')->orwhere('gcc_case_shortdecisions.delails', 'LIKE', '%'.$request->search_short_order_name.'%'); ; 
        }



        $data['shortDecision']=$result->paginate(15);

        // return $data;
        $data['page_title'] = 'সংক্ষিপ্ত আদেশ';
        return view('setting.short_decision')->with($data);
    }

    public function shortDecisionCreate()
    {
        $data['page_title'] = 'সংক্ষিপ্ত আদেশ তৈরি ';
        // return $data;
        return view('setting.short_decision_create')->with($data);
    }

    public function shortDecisionStore(Request $request)
    {
        // return $request;
        $request->validate([
            'case_short_decision'   => 'required',
            'delails'               => 'required',
        ]);

        $data = [
            'case_short_decision'   => $request->case_short_decision,
            'delails'               => $request->delails,
            'template_code'         =>$request->template_code, 
            'active_status'         => 1,
        ];

        $ID = DB::table('gcc_case_shortdecisions')->insert($data);

        return redirect()->route('settings.short-decision')->with('success', 'Short decision data updated successfully');
    }

    public function shortDecisionEdit($id)
    {
        $data['shortDecision'] = DB::table('gcc_case_shortdecisions')->where('gcc_case_shortdecisions.id', $id)->first();

        $data['page_title'] = 'সংক্ষিপ্ত আদেশ সংশোধন';
        // return $data;
        return view('setting.short_decision_edit')->with($data);
    }

    public function shortDecisionUpdate(Request $request, $id = '')
    {
        // return $request;
        $request->validate([
            'case_short_decision'   => 'required',
            'delails'   => 'required',
        ]);

        $data = [
            'case_short_decision'   => $request->case_short_decision,
            'delails'               => $request->delails,
            'template_code'         =>$request->template_code,
            'active_status'         => $request->active_status,
        ];

        $ID = DB::table('gcc_case_shortdecisions')->where('id', $id)->update($data);

        return redirect()->route('settings.short-decision')->with('success', 'Short decision data updated successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
