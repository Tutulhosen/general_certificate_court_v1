<?php
/**
 * Created by PhpStorm.
 * User: destructor
 * Date: 11/29/2017
 * Time: 9:51 PM
 */
namespace App\Repositories;

use App\Appeal;

use App\Models\GccCitizenAttendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CitizenAttendanceRepository
{

    public static function saveCitizenAttendance($citizenAttendance){
        $transactionStatus=true;
        foreach ($citizenAttendance as $citizen) {
            if($citizen['id']!=null){
                $citizenAttendanceData = self::getCitizenAttendance($citizen['id']);
                $citizenAttendanceData->attendance = $citizen['attendance'];
            }else{
                $citizenAttendanceData = new GccCitizenAttendance();
                $citizenAttendanceData->appeal_id = $citizen['appealId'];
                $citizenAttendanceData->citizen_id = $citizen['citizenId'];
                $citizenAttendanceData->attendance_date = date('Y-m-d',strtotime($citizen['attendanceDate']));
                // $citizenAttendanceData->attendance = $citizen['attendance'];
                $citizenAttendanceData->attendance = (isset($citizen['attendance'])?$citizen['attendance']:'');
                $citizenAttendanceData->created_at = date('Y-m-d H:i:s');
                $citizenAttendanceData->created_by = globalUserInfo()->id;
                // $citizenAttendanceData->created_by = Session::get('userInfo')->username;
                $citizenAttendanceData->updated_at = date('Y-m-d H:i:s');
                $citizenAttendanceData->updated_by = globalUserInfo()->id;
                // $citizenAttendanceData->updated_by = Session::get('userInfo')->username;
            }
            if (!$citizenAttendanceData->save()) {
                $transactionStatus = false;
                break;
            }
        }
        return $transactionStatus;
    }
    public static function getCitizenAttendance($citizenAttendanceId){
        $citizenAttendance=GccCitizenAttendance::find($citizenAttendanceId);
        return $citizenAttendance;
    }
    public static function getCitizenAttendanceByParameter($appealId,$citizenId,$attendanceDate){
        // dd(GccCitizenAttendance::all());
        $citizenAttendances=GccCitizenAttendance::where('appeal_id',$appealId)
            ->where('citizen_id',$citizenId)
            ->where('attendance_date',$attendanceDate)
            ->first();
        return $citizenAttendances;
    }
    public static function deletCitizenAttendanceByPreviousCaseDate($attendanceDate,$appealId){
        $citizenAttendances=GccCitizenAttendance::where('attendance_date',$attendanceDate)->where('appeal_id',$appealId)->get();
        foreach ($citizenAttendances as $citizenAttendance){
            $citizenAttendance=GccCitizenAttendance::find($citizenAttendance->id);
            $citizenAttendance->delete();
        }
        return;
    }
    public static function getCitizenAttendanceByAppealId($appealId){

        $citizenAttendances=DB::connection('mysql')
            ->select(DB::raw(
                "select
                  ca.citizen_name,
                  ca.citizen_designation,
                  ca.id as citizenId,
                  ca.id as citizenAttendanceId,
                  ca.attendance,
                  ca.attendance_date,
                  ca.citizen_role
                from gcc_citizen_attendances ca
                where ca.appeal_id=$appealId;
                "
            ));
            // dd($citizenAttendances  );
            // $citizenAttendances = GccCitizenAttendance::all();
            // $citizenAttendances = GccCitizenAttendance::where('appeal_id', $appealId)->get();

        return $citizenAttendances;
    }
    public static function storeAttendenceByCertAsst($citizenAttendance)
    {
         
         foreach($citizenAttendance['citizen_name'] as $key=>$value)
         {
              $data=[
                'appeal_id'=>$citizenAttendance['appealId'][$key],
                'citizen_id'=>$citizenAttendance['citizenId'][$key],
                'citizen_name'=>$citizenAttendance['citizen_name'][$key],
                'citizen_role'=>$citizenAttendance['citizen_role'][$key],
                'attendance'=>$citizenAttendance['attendance'][$key],
                'attendance_date'=>$citizenAttendance['attendanceDate'][$key],    
                'created_at'=>$citizenAttendance['attendanceDate'][$key],
                'citizen_designation'=>DB::table('gcc_citizens')->where('id',$citizenAttendance['citizenId'][$key])->select('designation')->first()->designation,
                'created_by'=>globalUserInfo()->id,  
              ];
              DB::table('gcc_citizen_attendances')->insert($data);
         }
    }
}
