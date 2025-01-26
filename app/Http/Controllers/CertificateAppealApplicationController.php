<?php
namespace App\Http\Controllers\CertificateAppealApplication;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use App\Repositories\CertificateAppealApplicationRepository;
use App\Services\AdminAppServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;


class CertificateAppealApplicationController extends Controller
{

    public function index()
    {
        if(Session::get('userInfo')){
            return redirect()->route('dashboard');
        }else{
            return view('certificateAppealApplication.publicHome');
        }
    }

    public function create()
    {
        return view('certificateAppealApplication.certificateAppealApplicationCreate');
    }
    public function getAppealApplicationStats(Request $request)
    {
        $flag='false';
        $appealApplicationStats=null;
        if($request->ajax()) {
            try{
                $appealApplicationStats=CertificateAppealApplicationRepository::getAppealApplicationStats($request);
                $appealApplicationStats = $appealApplicationStats[0];
                $flag = 'true';
            }
            catch (\Exception $e){
                $appealApplicationStats=null;
                $flag='false';
            }
        }
        return response()->json([
            'data' => $appealApplicationStats,
            'flag' => $flag,
        ]);
    }
    public function store(Request $request)
    {
        $flag='false';
        if($request->ajax()){
            try{
                $zilla=AdminAppServices::getZillaByZillaId($request->zillaId);
                $dbName=$zilla->zila_name_english;
                config(['database.connections.appeal.database' => 'CERTIFICATE_'.$dbName]);

                $caseNo = $request->caseNo;
                $appeal=Appeal::where('case_no',$caseNo)->first();
                if($appeal!=null){
                    if(CertificateAppealApplicationRepository::storeApplication($request, $appeal->id)){
                        $flag = 'true';
                    }
                }else{
                    $flag = 'null';
                }
            }catch (\Exception $e){
                $flag='false';
            }
        }

        return response()->json([
            'flag' => $flag,
        ]);
    }

}
