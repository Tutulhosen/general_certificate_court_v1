<?php


namespace App\Repositories;


use Illuminate\Support\Facades\DB;
use App\Models\GccCaseShortdecisions;

class ShortOrderRepository
{
    public static function getShortOrderList(){
        $shortOrderList=GccCaseShortdecisions::where('active_status',1)->orderby('id', 'asc')->get();
        return $shortOrderList;
    }

   public static function getShortOrderListForCerAsst()
   {
    
    $shortOrderList=DB::table('cer_asst_case_shortdecisions')->where('active_status',1)->get();   
    return $shortOrderList;

   }


}
