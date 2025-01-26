<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 12/22/17
 * Time: 10:58 AM
 */

namespace App\Repositories;


use App\Models\CaseDecision;
use Illuminate\Support\Facades\DB;

class CaseDecisionRepository
{
    public static function getCaseDecisionById($caseDecisionId){
        $caseDecision=CaseDecision::find($caseDecisionId);
        return $caseDecision;
    }

    public static function getRayShortDecisionInfoByAppealId($appealId,$caseShortDecisionId){
        $rayOrderListInfo =DB::connection('appeal')
            ->select(DB::raw(
                "SELECT * FROM cause_lists cl
                    JOIN causelist_caseshortdecisions ccd ON ccd.cause_list_id=cl.id
                    JOIN case_shortdecisions cd ON ccd.case_shortdecision_id=cd.id
                    WHERE cl.appeal_id=$appealId AND ccd.case_shortdecision_id=$caseShortDecisionId
                    ORDER BY cl.id DESC"

            ));
        return $rayOrderListInfo;
    }

}