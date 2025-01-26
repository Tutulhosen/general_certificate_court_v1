<?php

namespace App\Http\Controllers;

use App\Models\CaseRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function databaseCaseCheck(){
        return $caseData = CaseRegister::orderby('is_win', 'DESC')
        ->select('id', 'ref_id', 'is_lost_appeal', 'is_win', 'case_result', 'status')
        ->where('is_lost_appeal', 1)
        ->where('ref_id', null)
        ->get();
        // return $caseData = CaseRegister::orderby('is_win', 'DESC')->get();
    }
    public function databaseDataUpdated(){
        $caseData = CaseRegister::orderby('is_win', 'DESC')
        ->select('id', 'ref_id', 'is_lost_appeal', 'is_win', 'case_result', 'status')
        ->where('is_lost_appeal', 1)
        ->where('ref_id', null)
        ->get();

        foreach($caseData as $key => $case){
            $case = CaseRegister::findOrFail($case->id);
            $case->is_win = 2;
            $case->case_result = 0;
            $case->status = 2;
            $case->save();
        }

        return 'success';

    }

    public function index()
    {

        // $user = Auth::user();
        // $id = Auth::id();
        // dd($id);
        return view('home');
        /* return view('dashboard.index');*/
        // return redirect('/dashboard');
    }
}
