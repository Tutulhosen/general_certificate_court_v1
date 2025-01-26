<?php
/**
 * Created by PhpStorm.
 * User: pranab
 * Date: 11/17/17
 * Time: 5:59 PM
 */
namespace App\Repositories;


use App\Models\Appeal;
use App\Models\LawBroken;
use App\Models\RaiOrder;
use App\Services\AdminAppServices;
use App\Services\DataConversionService;
use App\Services\ProjapotiServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\GccAppeal;
use App\Models\GccWarrantExecutor;
use App\Models\GccCitizen;
use App\Models\User;

class WarrantExecutorRepository
{
    public static function multiexplode($delimiters, $string)
    {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }

    /*public static function checkAppealExist($appealId){
        if(isset($appealId)){
            $appeal=GccWarrantExecutor::select('id')->where('appeal_id', $appealId)->first();
        }else{
            $appeal=new GccWarrantExecutor();
        }
        return $appeal;
    }*/

    public static function storeWarrantExecutor($appealID, $warrantExecutorInfo){

        
        $user = globalUserInfo();
        try {
            $warrantExecutorID=GccWarrantExecutor::updateOrCreate(
                [       
                    'appeal_id'=>$appealID,
                    'name' => $warrantExecutorInfo->warrantExecutorName,
                    'organization'=>$warrantExecutorInfo->warrantExecutorInstituteName,
                    'designation'=>$warrantExecutorInfo->warrantExecutorDesignation,
                    'mobile'=>$warrantExecutorInfo->warrantExecutorMobile,
                    'email'=>$warrantExecutorInfo->warrantExecutorEmail,
                    'created_by'=>$user->id,
                    'updated_by'=>$user->id,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ]
            );
            
        } catch (\Exception $e) {
            dd($e);
            $warrantExecutorID=null;
        }
        return $warrantExecutorID;
    }


    public static function destroyAppeal($appealId){

        $appeal=EmAppeal::where('id',$appealId);
        $appeal->delete();
        return;
    }
}
