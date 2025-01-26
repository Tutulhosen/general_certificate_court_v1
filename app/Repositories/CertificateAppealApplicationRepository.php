<?php
/**
 * Created by PhpStorm.
 * User: pranab
 * Date: 11/17/17
 * Time: 5:59 PM
 */
namespace App\Repositories;

use App\Models\CertificateAppealApplication;
use App\Services\AdminAppServices;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CertificateAppealApplicationRepository
{
    public static function storeApplication($applicationInfo,$appealId){
        $transactionStatus=true;

        $application = new CertificateAppealApplication();
        $application->applicantName = $applicationInfo->name;
        $application->organization = $applicationInfo->organization;
        $application->designation = $applicationInfo->designation;
        $application->phnNo = $applicationInfo->phnNo;
        $application->email = $applicationInfo->email;
        $application->division_id = $applicationInfo->divisionId;
        $application->divisionName = $applicationInfo->divisionName;
        $application->zilla_id = $applicationInfo->zillaId;
        $application->zillaName = $applicationInfo->zillaName;
        $application->upazilla_id = $applicationInfo->upazillaId;
        $application->upazillaName = $applicationInfo->upazillaName;
        $application->causeOfApplication = $applicationInfo->causeOfApplication;

        $application->appeal_id = $appealId;
        $application->caseNo = $applicationInfo->caseNo;
        $application->application_status = $applicationInfo->status;

        $application->created_at = date('Y-m-d H:i:s');
        $application->created_by = 'SYS-ADMIN';
        $application->updated_at = date('Y-m-d H:i:s');
        $application->updated_by = 'SYS-ADMIN';
        if (!$application->save()) {
            $transactionStatus = false;
        }
        return $transactionStatus;
    }
    public static function getAppealApplicationStats($request){

        //search parameter
        $searchParameters=$request->searchParameter;

        $caseNo=$searchParameters['caseNo'];
        $districtCode=$searchParameters['districtBbsCode'];

        $zilla=AdminAppServices::getZillaByZillaId($districtCode);
        $dbName=$zilla->zila_name_english;
        config(['database.connections.appeal.database' => 'CERTIFICATE_'.$dbName]);
        $appealsData=DB::reconnect('appeal')
            ->select(DB::raw(
                "SELECT application_status FROM certificate_appeal_applications WHERE caseNo='$caseNo' LIMIT 1"
            ));
//        $appeal=CertificateAppealApplication::where('case_no',$caseNo)->first();
        return $appealsData;
    }

    public static function getAppealApplicationListBySearchParam($request){

        //search parameter
        $searchParameters=$request->searchParameter;

        $startDate=$searchParameters['startDate'];
        $endDate=$searchParameters['endDate'];
        $caseNo=$searchParameters['caseNo'];

        $searchConditions="";
        if(isset($startDate)){
            if(isset($endDate)){
                $endDate = date('Y-m-d h:m:s',strtotime($endDate));
            }else{
                $endDate = date('Y-m-d h:m:s', time());
            }
            $startDate = date('Y-m-d h:m:s',strtotime($startDate));

            $searchConditions.="AND caa.created_at BETWEEN '$startDate' AND '$endDate' ";
        }
        if(isset($searchParameters['caseNo'])){
            $searchConditions.="AND caa.caseNo='$caseNo' ";
        }
        $appeals=DB::connection('appeal')
            ->select(DB::raw(
                "select
                      caa.id,
                      caa.applicantName,
                      caa.designation,
                      caa.organization,
                      caa.causeOfApplication,
                      caa.caseNo as case_no,
                      caa.application_status,
                      a.appeal_status,
                      a.gco_name,
                      caa.appeal_id
                FROM certificate_appeal_applications caa
                LEFT JOIN appeals a on a.id=caa.appeal_id
                WHERE 1=1 $searchConditions"
            ));

        return $appeals;
    }

}