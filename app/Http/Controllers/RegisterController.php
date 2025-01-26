<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\GccAppeal;
use App\Repositories\AppealRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->orderby('id', 'desc');
        if(globalUserInfo()->role_id == 6)
        {
            
            $results =$results->where('district_id', user_district()->id);
        }
        if(globalUserInfo()->role_id == 34)
        {
            $results =$results->where('division_id', user_office_info()->division_id);
        }
        if(globalUserInfo()->role_id == 25)
        {
            $results =$results->where('updated_by', globalUserInfo()->id);
        }
        if(globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28)
        {
            $results =$results->where('district_id', user_district()->id)->where('court_id',globalUserInfo()->court_id);
        }
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results  = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
        }
        if(!empty($_GET['case_no'])) {
            $results = $results->where('case_no','=',$_GET['case_no']);
        }
        if(!empty($_GET['caseStatus'])) {
            if($_GET['caseStatus']='ON_TRIAL')
            {
                $caseStatus_array=['ON_TRIAL','ON_TRIAL_DC','ON_TRIAL_DIV_COM','ON_TRIAL_LAB_CM'];
            }
            else
            {
                $caseStatus_array=['CLOSED'];
            }
            $results = $results->whereIN('appeal_status',$caseStatus_array);
        }
        // return $results;
        $results=$results->paginate(30);
        
        $date=date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole=Auth::user()->role_id;
        $gcoUserName='';
        if($userRole=='GCO'){
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName=Auth::user()->username;
        }
        $page_title  = 'রেজিষ্টার';
        //return view('appealList.appeallist')->with('date',$date);
        return view('register.index', compact('date','gcoUserName','caseStatus', 'page_title', 'results'));
    }
    
    public function registerPrint(Request $request)
    {
        $req = $request->all();
        $results = GccAppeal::whereNotIn('appeal_status', ['DRAFT'])->orderby('id', 'desc')->get();
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = GccAppeal::orderby('id', 'desc')->whereBetween('case_date', [$dateFrom, $dateTo])->get();
        }
        if(!empty($_GET['case_no'])) {
            $results = GccAppeal::orderby('id', 'desc')->where('case_no','=',$_GET['case_no'])->get();
        }
        if(!empty($_GET['caseStatus'])) {
            // dd(1);
            $results = GccAppeal::orderby('id', 'desc')->where('appeal_status','=',$_GET['caseStatus'])->get();
        }
        // return $results;
        $date=date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole=Auth::user()->role_id;
        $gcoUserName='';
        if($userRole=='GCO'){
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName=Auth::user()->username;
        }
        $page_title  = 'রেজিষ্টার';
        //return view('appealList.appeallist')->with('date',$date);
        //return view('register.printView', compact('date','gcoUserName','caseStatus', 'page_title', 'req', 'results'));

        // return $results;
        $html = view('register.pdf_register',compact('date','gcoUserName','caseStatus', 'page_title', 'req', 'results'));
         

        $this->generatePDF($html);
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

    public function generatePDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4-L',
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
