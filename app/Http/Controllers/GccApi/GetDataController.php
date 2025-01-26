<?php

namespace App\Http\Controllers\GccApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\TokenVerificationTrait;
use App\Http\Controllers\Api\BaseController as BaseController;

class GetDataController extends Controller
{
    use TokenVerificationTrait;
    //get gcc role
    public function gccRole(Request $request){
            
            $secrate_key = 'gcc-court-key';
            // $token=$request->token;
            $from_request= $request->Header('secrate_key');
           
            if ($secrate_key === $from_request) {
                $role=DB::table('role')->whereIn('id', [6,7,27,28])
                ->get();

                return $role;
            }else {
                return "Invalid Request";
            }
            
    }
}
