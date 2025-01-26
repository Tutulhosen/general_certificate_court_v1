<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 11/28/17
 * Time: 3:05 PM
 */
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminAppServices {
    public static function getThana($districtId){

        $thanas = DB::connection('mysql')
            ->table('geo_thanas')
            ->where('district_bbs_code', $districtId)
            ->get();
        return $thanas;
    }

    public static function getUpazilla($districtId){

        $upazillas = DB::connection('mysql')
            ->table('upazilas')
            ->where('zila_id', $districtId)
            ->get();
        return $upazillas;
    }

    public static function getLaw(){
        $laws = DB::connection('mysql')
            ->table('laws')
            ->where('application_code', 'ecourt_mobile')
            ->get();
        return $laws;
    }
    public static function getSectionByLawId($lawId){

        $sections=DB::connection('mysql')
            ->select(DB::raw(
                "SELECT
                    id,
                     CONCAT('ধারা : ',sec_number,'- ',sec_description) AS sec_description
                     FROM sections
                     WHERE law_id=$lawId"));

        return $sections;
    }

    public static function getLawBylawId($lawId){
        $law = DB::connection('mysql')
            ->table('laws')
            ->where('laws.id', $lawId)
            ->where('application_code', 'ecourt_mobile')
            ->first();
        return $law;
    }

    public static function getSectionBySectionId($sectionId){
        $section = DB::connection('mysql')
            ->table('sections')
            ->where('sections.id', $sectionId)
            ->first();
        return $section;
    }
    public static function getPermissionsByUserOfficeOrganogram($user){
        $permissions = DB::connection('mysql')
            ->table('user_roles')
            ->join('roles', 'roles.role_code', '=', 'user_roles.role_code')
            ->join('role_permissions', 'roles.role_code', '=', 'role_permissions.role_code')
            ->join('permissions', 'permissions.permission_code', '=', 'role_permissions.permission_code')
            ->select('permissions.*','roles.*')
            ->where('user_roles.office_id',$user->office_origin_id)
            ->where('user_roles.office_unit_id',$user->office_origin_unit_id)
            ->where('user_roles.office_unit_organogram_id',$user->ref_origin_unit_org_id)
            ->get();
        return $permissions;
    }

    public static function getOfficeInfoByRoleCode($roleCode){
        // $officeInfoList=DB::connection('mysql')
        //     ->table('roles')
        //     ->join('user_roles', 'user_roles.role_code', '=', 'roles.role_code')
        //     ->select('user_roles.office_id','user_roles.office_unit_id','user_roles.office_unit_organogram_id')
        //     ->where('roles.role_code',$roleCode)
        //     ->get();
        $officeInfoList= User::where('role_id',$roleCode)->get();

        return $officeInfoList;
    }

    public static function getHoliday($date){
        $section = DB::connection('mysql')
            ->table('holidays')
            ->where('holidays.date', $date)
            ->first();
        return $section;
    }
    //get locations
    public static function getDivisions(){
        $results = array();
        $divisions = DB::connection('mysql')
            ->table('divisions')
            ->get();

        foreach ($divisions as $division){
            $results[] = array('code' => $division->id, 'desc' => $division->division_name_bangla, 'name' => $division->division_name_english);
        }
        return $results;
    }


    public static function getZillasByDivisionId($divisionId){
        //bbs code division
        $results = array();
        $zillas = DB::connection('mysql')
            ->table('zillas')
            ->where('zillas.division_id', $divisionId)
            ->get();

        foreach ($zillas as $zilla){
            $results[] = array('code' => $zilla->id, 'desc' => $zilla->zila_name_bangla, 'name' => $zilla->zila_name_english);
        }
        return $results;
    }

    public static function getZillaByZillaId($zillaId){
        $zilla = DB::connection('mysql')
            ->table('zillas')
            ->where('zillas.id', $zillaId)
            ->first();
        return $zilla;
    }

    public static function getUpazillasByZillaId($zillaId){
        $results = array();
        $upazilas=DB::connection('mysql')
            ->table('upazilas')
            ->where('upazilas.zila_id', $zillaId)
            ->get();

        foreach ($upazilas as $upazila){
            $results[] = array('code' => $upazila->id, 'desc' => $upazila->upazila_name_bangla);
        }
        return $results;
    }

    public static function getCityCorporationsByZillaId($zillaId){
        $results = array();
        $cityCorporations=DB::connection('mysql')
            ->table('geo_citycorporations')
            ->where('geo_citycorporations.district_bbs_code', $zillaId)
            ->get();

        foreach ($cityCorporations as $cityCorporation){
            $results[] = array('code' => $cityCorporation->id, 'desc' => $cityCorporation->city_corporation_name_bng);
        }
        return $results;
    }

    public static function getMetropolitansByZillaId($zillaId){
        $results = array();
        $metropolitans=DB::connection('mysql')
            ->table('geo_metropolitans')
            ->where('geo_metropolitans.district_bbs_code', $zillaId)
            ->get();

        foreach ($metropolitans as $metropolitan){
            $results[] = array('code' => $metropolitan->id, 'desc' => $metropolitan->metropolitan_name_bng);
        }
        return $results;
    }

    public static function getThanasByZillaId($zillaId){
        $results = array();
        $thanas=DB::connection('mysql')
            ->table('geo_thanas')
            ->where('geo_thanas.district_bbs_code', $zillaId)
            ->get();

        foreach ($thanas as $thana){
            $results[] = array('code' => $thana->id, 'desc' => $thana->thana_name_bng);
        }
        return $results;
    }
    public static function getAllUserRole(){
        $roles = DB::connection('mysql')
            ->table('user_roles')
            ->get();
        return $roles;
    }
    public static function getSearchParamCondition($searchParameters)
    {
        $searchConditions = '';
        if (isset($searchParameters)) {
            if (isset($searchParameters['startDate'])) {
                if (isset($searchParameters['endDate'])) {
                    $endDate = date('Y-m-d',strtotime(trim($searchParameters['endDate'])));
                } else {
                    $endDate = date('Y-m-d', time());
                }
                $startDate = date('Y-m-d',strtotime(trim($searchParameters['startDate'])));

                $searchConditions .= "AND case_date BETWEEN '$startDate' AND '$endDate' ";
            }

            if (isset($searchParameters['divsionBbsCode'])) {
                $division = trim($searchParameters['divsionBbsCode']);
                $searchConditions .= "AND division_bbs_code='$division' ";
            }

            if (isset($searchParameters['districtBbsCode'])) {
                $zilla = trim($searchParameters['districtBbsCode']);
                $searchConditions .= "AND district_bbs_code='$zilla' ";
            }

        }
        return $searchConditions;
    }
    public static function getDashboardCountStatsBySearchParam($searchParameters){
        $searchConditions = self::getSearchParamCondition($searchParameters);
        $dashboardData=DB::connection('mysql')
            ->select(DB::raw(
                "SELECT
                      ifnull(sum(x.loan_amount),0) as loan_amount ,
                      ifnull(sum(x.paid_loan_amount),0) as paid_loan_amount,
                      ifnull(sum(x.total_case),0) as total_case,
                      ifnull(sum(x.closed_case),0) as closed_case
                FROM dashboard_stats as x
                WHERE
                  1=1
                  $searchConditions"
            ));

        return $dashboardData[0];
    }
    public static function getDashboardGroupWiseCountStatsBySearchParam($searchParameters){
        $searchConditions = '';
        $districtCaseConditions = '';
        $dateConditions = 'dashboard_stats';
        $joinConditions = 'LEFT JOIN dashboard_stats x on d.id = x.division_bbs_code';
        $conditionalSelect = "d.division_name_bangla as label_name";
        $conditionalGroupBy = "GROUP BY d.division_name_bangla";

        if (isset($searchParameters)) {
            if (isset($searchParameters['startDate'])) {
                if (isset($searchParameters['endDate'])) {
                    $endDate = date('Y-m-d',strtotime(trim($searchParameters['endDate'])));
                } else {
                    $endDate = date('Y-m-d', time());
                }
                $startDate = date('Y-m-d',strtotime(trim($searchParameters['startDate'])));

                $dateConditions = "(SELECT * FROM dashboard_stats WHERE case_date BETWEEN '$startDate' AND '$endDate' )";
            }

            if (isset($searchParameters['divsionBbsCode'])) {
                $division = trim($searchParameters['divsionBbsCode']);
                $searchConditions .= "AND d.id='$division' ";
                $conditionalSelect = "z.zila_name_bangla as label_name";
                $joinConditions="join zillas z on d.id = z.division_id LEFT JOIN $dateConditions x on d.id = x.division_bbs_code and z.id = x.district_bbs_code";
                $conditionalGroupBy = "GROUP BY z.zila_name_bangla";
            }

            if (isset($searchParameters['districtBbsCode'])) {
                $zilla = trim($searchParameters['districtBbsCode']);
                $conditionalSelect = "u.upazila_name_bangla as label_name";
                $joinConditions="join zillas z on d.id = z.division_id join upazilas u on z.id = u.zila_id LEFT JOIN $dateConditions x on d.id = x.division_bbs_code and z.id = x.district_bbs_code and u.id =x.upazila_bbs_code";
                $conditionalGroupBy = "GROUP BY u.upazila_name_bangla";
                $searchConditions .= "AND z.id='$zilla' ";
                $districtCaseConditions.="
                UNION
                SELECT
                  'জেলা কার্যালয়' as label_name,
                  ifnull(sum(x.loan_amount),0) as loan_amount ,
                  ifnull(sum(x.paid_loan_amount),0) as paid_loan_amount,
                  ifnull(sum(x.total_case),0) as total_case,
                  ifnull(sum(x.closed_case),0) as closed_case
                FROM divisions d
                  join zillas z on d.id = z.division_id LEFT JOIN $dateConditions x on d.id = x.division_bbs_code and z.id = x.district_bbs_code
                WHERE 1=1
                $searchConditions and x.upazila_bbs_code = 0 ";

            }

        }
        $dashboardData=DB::connection('mysql')
            ->select(DB::raw(
                "SELECT
                  $conditionalSelect,
                  ifnull(sum(x.loan_amount),0) as loan_amount ,
                  ifnull(sum(x.paid_loan_amount),0) as paid_loan_amount,
                  ifnull(sum(x.total_case),0) as total_case,
                  ifnull(sum(x.closed_case),0) as closed_case
                FROM divisions d
                   $joinConditions
                WHERE 1=1
                $searchConditions
                $conditionalGroupBy
                $districtCaseConditions"
            ));

        return $dashboardData;
    }

}
