<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MyProfileController extends Controller
{
    public function index($user_id)
    {
        $userManagement = DB::table('users')
                        ->join('role', 'users.role_id', '=', 'role.id')
                        ->leftJoin('office', 'users.office_id', '=', 'office.id')
                        ->leftJoin('district', 'office.district_id', '=', 'district.id')
                        ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                        ->select('users.*', 'role.role_name', 'office.office_name_bn', 
                            'district.district_name_bn', 'upazila.upazila_name_bn')
                        ->where('users.id',$user_id)
                        ->first();
        
           

        $office_name = $userManagement->office_name_bn.', '.$userManagement->upazila_name_bn.', '.$userManagement->district_name_bn;
        
        if($userManagement->profile_pic != NULL)
        {
            if($userManagement->doptor_user_flag == 0)
            {
                 $profile_picture=url('/').'/uploads/profile/'.$userManagement->profile_pic;
            }
            else
            {
                $profile_picture=$userManagement->profile_pic;
                
            }
        }
        else
        {
            $profile_picture=url('/').'/uploads/profile/default.jpg';
        }
        
        if($userManagement->signature !=Null && $userManagement->doptor_user_flag == 1)
        {
            $signature=$userManagement->signature;
        }
        else if($userManagement->signature == !Null && $userManagement->doptor_user_flag == 0)
        {
            $signature=url('/').$userManagement->signature;
        }
        else
        {
            $signature=null;
        }

        

        return response()->json([
          'success'=>true,
          'data'=>[
            'name'=>isset($userManagement->name) ? $userManagement->name : null ,
            'username'=>isset($userManagement->username) ? $userManagement->username : null,
            'role_name'=>isset($userManagement->role_name) ? $userManagement->role_name : null,
            'mobile_no'=>isset($userManagement->mobile_no) ? $userManagement->mobile_no : null,
            'office_name'=>isset($office_name) ? $office_name : null,
            'email'=>isset($userManagement->email) ? $userManagement->email : null,
            'profile_picture'=>isset($profile_picture) ? $profile_picture : null,
            'signature'=>isset($signature) ? $signature : null,
          ]  
          
        ]);
    }
}
