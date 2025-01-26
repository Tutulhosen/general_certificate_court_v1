<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OrganizationCaseMappingRepository
{

    public static function employeeOrgizationCaseMapping($office_id, $citizen_id, $user_id)
    {

        $all_cases = DB::table('gcc_appeals')->where('office_id', $office_id)->whereNotIn('appeal_status', ['REJECTED'])->select('gcc_appeals.id as appeal_id')->get();

        if (count($all_cases) > 0) {
            foreach ($all_cases as $key => $value) {
                $data = [
                    'appeal_id' => $value->appeal_id,
                    'citizen_id' => $citizen_id,
                    'citizen_type_id' => 1,
                    'created_by' => $user_id,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                DB::table('gcc_appeal_citizens')->insert($data);
            }
        }
    }
    public static function employeeOrgizationCaseMappingOnTrasferValidation()
    {

        return DB::table('users')
            ->where('role_id', 35)
            ->where('office_id', globalUserInfo()->office_id)
            ->count();

        //   $citizen_with_appeal=DB::table('gcc_appeal_citizens')->where('citizen_type_id',1)->where('citizen_id',globalUserInfo()->citizen_id)->get();

        //  foreach($citizen_with_appeal as $key=>$value)
        //  {
        //       DB::table('gcc_appeal_citizens')
        //       ->where('citizen_type_id',1)
        //       ->where('appeal_id',$value->appeal_id)->count();
        //  }
    }
    public static function employeeOrgizationCaseMappingOnTrasfer($office_id)
    {
        $user = globalUserInfo();

        DB::table('gcc_appeal_citizens')->where('citizen_type_id', 1)->where('citizen_id', $user->citizen_id)->delete();

        $all_cases = DB::table('gcc_appeals')->where('office_id', $office_id)->whereNotIn('appeal_status', ['REJECTED'])->select('gcc_appeals.id as appeal_id')->get();

        if (count($all_cases) > 0) {
            foreach ($all_cases as $key => $value) {

                $data = [
                    'appeal_id' => $value->appeal_id,
                    'citizen_id' => $user->citizen_id,
                    'citizen_type_id' => 1,
                    'created_by' => $user->id,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                DB::table('gcc_appeal_citizens')->insert($data);
            }
        }
    }
    public static function employeeOrgizationCaseMappingOnCaseCreate($appealId)
    {
        $user = globalUserInfo();
        $getCitizensWithSameOffice=DB::table('users')->where('office_id',$user->office_id)->get();
        foreach($getCitizensWithSameOffice as $key=>$value)
        {
            if(!empty($value->citizen_id) && $value->id !=$user->id)
            {
                $data = [
                    'appeal_id' => $appealId,
                    'citizen_id' => $value->citizen_id,
                    'citizen_type_id' => 1,
                    'created_by' => $user->id,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                DB::table('gcc_appeal_citizens')->insert($data);    
            }
        }
    }
}
