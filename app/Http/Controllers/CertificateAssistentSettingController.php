<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CertificateAssistentSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shortDecision(Request $request)
    {
        $result = DB::table('cer_asst_case_shortdecisions')
                  ->select('cer_asst_case_shortdecisions.id','cer_asst_case_shortdecisions.delails','cer_asst_case_shortdecisions.case_short_decision','cer_asst_case_shortdecisions.active_status');
        if (!empty($request->search_short_order_name)) {
            $result= $result->where('cer_asst_case_shortdecisions.case_short_decision', 'LIKE', '%'.$request->search_short_order_name.'%')->orWhere('cer_asst_case_shortdecisions.delails', 'LIKE', '%'.$request->search_short_order_name.'%');

        }                     

        // return $data;
        $data['shortDecision']=$result->paginate(15);
        $data['page_title'] = 'সার্টিফিকেট সহকারী কর্তৃক গৃহীত ব্যবস্থা';
        return view('setting.certificate_asst.short_decision')->with($data);
    }

    public function shortDecisionCreate()
    {
        $data['page_title'] = 'সার্টিফিকেট সহকারী কর্তৃক গৃহীত ব্যবস্থা তৈরি ';
        // return $data;
        return view('setting.certificate_asst.short_decision_create')->with($data);
    }

    public function shortDecisionStore(Request $request)
    {
        
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

        $ID = DB::table('cer_asst_case_shortdecisions')->insert($data);

        return redirect()->route('certificate_asst.short.decision')->with('success', 'Short decision data updated successfully');
    }

    public function shortDecisionEdit($id)
    {
        $data['shortDecision'] = DB::table('cer_asst_case_shortdecisions')->where('cer_asst_case_shortdecisions.id', $id)->first();

        $data['page_title'] = 'সার্টিফিকেট সহকারী কর্তৃক গৃহীত ব্যবস্থা সংশোধন';
        // return $data;
        return view('setting.certificate_asst.short_decision_edit')->with($data);
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

        $ID = DB::table('cer_asst_case_shortdecisions')->where('id', $id)->update($data);

        return redirect()->route('certificate_asst.short.decision')->with('success', 'Short decision data updated successfully');
    }


   
}
