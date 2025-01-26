<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 12/12/17
 * Time: 1:37 PM
 */

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProjapotiServices
{

    public static function getPermittedApps(){
        $token = self::getToken();

        $organogramID=Session::get('userInfo')->office_unit_organogram_id;

        $url = config('app.oisfUrl')."identity/designation/".$organogramID."/apps";
        $client = curl_init($url);
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Bearer '. $token['token'] // <---
        );
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($client, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($client);
        $apps = json_decode($response, true);
        return $apps;
    }

    public static function getUserListByDistrictAndOrganogramOriginId($roleOfficeInfoList,$districtId, $officeId){
        $officeUnitOrganogramOriginArray=[];
        //prepare $officeUnitOrganogramOriginArray
        foreach ($roleOfficeInfoList as $roleOfficeInfo){
            $officeUnitOrganogramOriginArray[]=$roleOfficeInfo->office_unit_organogram_id;
        }
        // $userList=DB::connection('projapoti')
        //             ->table('users')
        //             ->leftJoin('employee_records', 'employee_records.id', '=', 'users.employee_record_id')
        //             ->leftJoin('employee_offices', 'employee_offices.employee_record_id', '=','employee_records.id' )
        //             ->leftJoin('offices', 'offices.id', '=','employee_offices.office_id' )
        //             ->leftJoin('office_units', 'office_units.id', '=','employee_offices.office_unit_id' ,'AND','office_units.office_id', '=','employee_offices.office_id')
        //             ->leftJoin('office_unit_organograms', 'office_unit_organograms.id', '=','employee_offices.office_unit_organogram_id')
        //             ->leftJoin('office_origins', 'office_origins.id', '=','offices.office_origin_id' )
        //             ->leftJoin('office_origin_units', 'office_origin_units.id', '=','office_units.office_origin_unit_id')
        //             ->leftJoin('office_origin_unit_organograms', 'office_origin_unit_organograms.id', '=','office_unit_organograms.ref_origin_unit_org_id',
        //                 'AND','office_origins.office_unit_id','=','employee_offices.office_unit_id','AND','office_origins.office_id','=','employee_offices.office_id')
        //             ->leftJoin('geo_districts', 'geo_districts.id', '=','offices.geo_district_id',
        //                 'AND','office_unit_organograms.office_unit_id','=','employee_offices.office_unit_id','AND','office_unit_organograms.office_id','=','employee_offices.office_id')
        //             ->where('geo_districts.bbs_code', $districtId)
        //             ->where('offices.id', $officeId)
        //             ->where('employee_offices.status', 1)
        //             ->where('users.active', 1)
        //             ->whereIn('office_unit_organograms.ref_origin_unit_org_id',$officeUnitOrganogramOriginArray )
        //             ->select('users.username','employee_records.name_bng','employee_records.identity_no','offices.geo_upazila_id','offices.office_origin_id','offices.id as office_id')
        //             ->groupBy('users.username','employee_records.name_bng','employee_records.identity_no','offices.geo_upazila_id','offices.office_origin_id','office_id')
        //             ->get();
        $userList = User::where('office_id', $officeId)
            ->whereHas('office', function($query) use ($districtId){
                // $query->where('distirct_id', '=', $districtId);
            })
            ->get();
        // dd($userList);
        return $userList;

    }
    public static function getUserListByDistrictAndOrganogramOriginIdByAPI($roleOfficeInfoList,$districtId){
        //prepare $officeUnitOrganogramOriginString
        $userLists= array();
        $officeUnitOrganograms='';
        foreach ($roleOfficeInfoList as $roleOfficeInfo){
            $officeUnitOrganograms .= $roleOfficeInfo->office_unit_organogram_id."+";
        }
        $token = self::getToken();
        $url = config('app.oisfUrl')."employee/group?bbscode=".$districtId."&officeunitorganograms=".$officeUnitOrganograms;
        $client = curl_init($url);
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Bearer '. $token['token'] // <---
        );
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($client, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($client);
        $userList = json_decode($response, true);
        foreach ($userList as $user){
            array_push($userLists,(object)$user);
        }
        return $userLists;
    }

    public static function getUserByUsername($username){

    $user = DB::connection('projapoti')
        ->table('users')
        ->leftJoin('employee_records', 'employee_records.id', '=', 'users.employee_record_id')
        ->leftJoin('employee_offices', 'employee_offices.employee_record_id', '=', 'employee_records.id')
        ->leftJoin('offices', 'offices.id', '=', 'employee_offices.office_id')
        ->leftJoin('geo_divisions', 'geo_divisions.id', '=', 'offices.geo_division_id')
        ->leftJoin('geo_districts', 'geo_districts.id', '=', 'offices.geo_district_id')
        ->leftJoin('geo_upazilas', 'geo_upazilas.id', '=', 'offices.geo_upazila_id')
        ->leftJoin(
            'office_units', 'office_units.id', '=', 'employee_offices.office_unit_id',
            'AND','office_units.office_id','=','employee_offices.office_id'
        )
        ->leftJoin(
            'office_unit_organograms', 'office_unit_organograms.id', '=', 'employee_offices.office_unit_organogram_id',
            'AND','office_unit_organograms.office_unit_id','=','employee_offices.office_unit_id',
            'AND','office_unit_organograms.office_id','=','employee_offices.office_id'
        )
        ->select('users.employee_record_id AS EmpID', 'users.username',
            'employee_records.name_bng','employee_records.personal_email',
            'employee_offices.office_id', 'offices.office_name_bng',
            'employee_offices.office_unit_id','office_units.unit_name_bng',
            'employee_offices.office_unit_organogram_id','office_unit_organograms.designation_level',
            'office_unit_organograms.designation_bng', 'offices.office_origin_id',
            'offices.geo_district_id','geo_districts.district_name_bng',
            'geo_districts.district_name_eng','geo_districts.bbs_code as districtId',
            'offices.geo_upazila_id', 'geo_upazilas.upazila_name_bng',
            'geo_upazilas.upazila_name_eng', 'geo_upazilas.bbs_code as upazilaId',
            'office_units.office_origin_unit_id','office_unit_organograms.ref_origin_unit_org_id',
            'users.active', 'users.is_admin','geo_divisions.division_name_bng AS divisionName','geo_divisions.bbs_code AS divisionBbsCode','office_unit_organograms.id AS officeUnitOrganogramId')
        ->where('users.username', $username)
        ->where('employee_offices.status', 1)
        ->where('users.active', 1)
        ->get();

    return $user;
    }
    public static function getUserListByLoginUsername($officeId,$officeUnitId,$designationLabel){
        $dmList=DB::connection('projapoti')
            ->table('employee_offices')
            ->join('office_unit_organograms', 'office_unit_organograms.id', '=', 'employee_offices.office_unit_organogram_id')
            ->join('employee_records', 'employee_records.id', '=','employee_offices.employee_record_id' )
            ->where('office_unit_organograms.office_id', $officeId)
            ->where('office_unit_organograms.office_unit_id', $officeUnitId)
            ->where('office_unit_organograms.designation_level', $designationLabel)
            ->get();
        return $dmList;

    }


    public static function getUserByUsernameToken ($username,$token)
    {
        $url = config('app.oisfUrl')."employee/details/".$username;
        $client = curl_init($url);
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Bearer '. $token['token'] // <---
        );
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($client, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($client);
        $user = json_decode($response, true);
        return $user;
    }
    public static function generateTokenForApi(){
        $url = config('app.oisfUrl')."token/create";
        $client = curl_init($url);
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Secret '. config('app.oisfSecret') // <---
        );
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($client, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($client, CURLOPT_POST, true);

        $response = curl_exec($client);
        return json_decode($response, true);

    }
    public static function userArrayCreate($userName,$apiReturnedData){
        $user=array();
        $user['username'] = $userName;
        $user['name_bng'] = $apiReturnedData['name_bng'];
        $user['personal_email'] = $apiReturnedData['personal_email'];
        $user['office_id'] = $apiReturnedData['office_id'];
        $user['office_name_bng'] = $apiReturnedData['office_name_bng'];
        $user['office_unit_id'] = $apiReturnedData['office_unit_id'];
        $user['unit_name_bng'] = $apiReturnedData['unit_name_bng'];
        $user['office_unit_organogram_id'] = $apiReturnedData['office_unit_organogram_id'];
        $user['designation_level'] = $apiReturnedData['designation_level'];
        $user['designation_bng'] = $apiReturnedData['designation_bng'];
        $user['office_origin_id'] = $apiReturnedData['office_origin_id'];
        $user['geo_district_id'] = $apiReturnedData['geo_district_id'];
        $user['district_name_bng'] = $apiReturnedData['district_name_bng'];
        $user['district_name_eng'] = $apiReturnedData['district_name_eng'];
        $user['geo_upazila_id'] = $apiReturnedData['geo_upazila_id'];
        $user['upazila_name_bng'] = $apiReturnedData['upazila_name_bng'];
        $user['upazila_name_eng'] = $apiReturnedData['upazila_name_eng'];
        $user['office_origin_unit_id'] = $apiReturnedData['office_origin_unit_id'];
        $user['ref_origin_unit_org_id'] = $apiReturnedData['ref_origin_unit_org_id'];
//        $user['active'] = $apiReturnedData['active'];
        $user['is_admin'] = $apiReturnedData['is_admin'];
        $user['officeUnitOrganogramId'] = $apiReturnedData['officeUnitOrganogramId'];
        $user['divisionBbsCode'] = $apiReturnedData['divisionBbsCode'];

        // districtId as districtBbsCode
        $user['districtId'] = $apiReturnedData['districtBbsCode'];
        // upazilaId as upazilaBbsCode
        $user['upazilaId'] = $apiReturnedData['upazilaBbsCode'];
        // divisionName as division_name_bng
        $user['divisionName'] = $apiReturnedData['division_name_bng'];

        return (object) $user;
    }

    /**
     * @return mixed
     */
    public static function getToken ()
    {
        $url = config('app.oisfUrl') . "token/get";
        $client = curl_init($url);
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Secret ' . config('app.oisfSecret') // <---
        );
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($client, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($client);
        $httpcode = curl_getinfo($client, CURLINFO_HTTP_CODE);
        if ($httpcode != 200){
            return self::generateTokenForApi();
        }
        return json_decode($response, true);
    }
    /**
     * @param $userName
     * @return array
     */
    public static function getPermisionWiseUser ($userName)
    {
        $userlist= array();
        $roles = AdminAppServices::getAllUserRole();

        // Api Implementation Start
        $token = ProjapotiServices::getToken();
        $apiReturnedData = ProjapotiServices::getUserByUsernameToken($userName, $token);
        foreach ($apiReturnedData as $userData) {
            $user = ProjapotiServices::userArrayCreate($userName, $userData);
            // filter out by role assigned
            foreach ($roles as $role) {
                if ($role->office_id == $user->office_origin_id && $role->office_unit_id == $user->office_origin_unit_id && $role->office_unit_organogram_id == $user->ref_origin_unit_org_id) {
                    array_push($userlist, $user);
                    break;
                }
            }
        }
        return $userlist;
    }

    public static function getPermisionWiseUserLocalDb ($userName)
    {
        $userlist= array();
        $roles = AdminAppServices::getAllUserRole();

        $returnedData = ProjapotiServices::getUserByUsername($userName);
        foreach ($returnedData as $userData) {
            /*$user = ProjapotiServices::userArrayCreate($userName, $userData);*/
            // filter out by role assigned
            foreach ($roles as $role) {
                if ($role->office_id == $userData->office_origin_id && $role->office_unit_id == $userData->office_origin_unit_id && $role->office_unit_organogram_id == $userData->ref_origin_unit_org_id) {
                    array_push($userlist, $userData);
                    break;
                }
            }
        }
        return $userlist;
    }

}
