<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class CdapUserManagementRepository
{
   
    public static function create_token()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://idp-api.live.mygov.bd/token/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => ['client_id' => 'mJcxZMNVQYjUnmwFoeMu', 'api_key' => 'Uwyz29VV9F.BMrZAmYT80'],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }
    public static function call_login_curl($token, $password, $mobile)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://idp-api.live.mygov.bd/user/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => ['token' => $token, 'password' => $password, 'mobile' => $mobile],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }
    public static function create_cdap_user_citizen_with_login($data_from_cdap)
    {

        $mobile_int_2_str = (string)$data_from_cdap['data']['mobile'];
        if(strlen( $mobile_int_2_str) == 10)
        {

            $mobile_number_reshaped='0'.$mobile_int_2_str;
        }
        else
        {
            $mobile_number_reshaped= $mobile_int_2_str;
        }

        $gcc_citizens_array = [
            'citizen_name' => $data_from_cdap['data']['name'],
            'citizen_phone_no' => $mobile_number_reshaped,
            'citizen_NID' => $data_from_cdap['data']['nid'],
            'citizen_birth_reg_no' => $data_from_cdap['data']['brn'],
            'citizen_gender' => strtoupper($data_from_cdap['data']['gender']),
            'father' => $data_from_cdap['data']['father_name'],
            'mother' => $data_from_cdap['data']['mother_name'],
            'email' => $data_from_cdap['data']['email'], 
            'dob' => $data_from_cdap['data']['date_of_birth'],
            'present_address' =>$data_from_cdap['data']['pre_address'],
            'permanent_address' =>$data_from_cdap['data']['per_address'],
        ];

        $nid_exits=DB::table('gcc_citizens')->where('citizen_NID',$data_from_cdap['data']['nid'])->first();
            
        
        if(!empty($nid_exits))
        {
            DB::table('gcc_citizens')->where('citizen_NID',$data_from_cdap['data']['nid'])->update($gcc_citizens_array);
            $created_citigen_ID=$nid_exits->id;
        }
        else
        {
            
            $created_citigen_ID = DB::table('gcc_citizens')->insertGetId($gcc_citizens_array);
            
        }


        date_default_timezone_set('Asia/Dhaka');

        $cdap_users_array = [
            'citizen_id' => $data_from_cdap['data']['id'],
            'mobile' => $mobile_number_reshaped,
            'email' => $data_from_cdap['data']['email'],
            'nid' => $data_from_cdap['data']['nid'],
            'name' => $data_from_cdap['data']['name'],
            'name_en' => $data_from_cdap['data']['name_en'],
            'mother_name' => $data_from_cdap['data']['mother_name'],
            'mother_name_en' => $data_from_cdap['data']['mother_name_en'],
            'father_name' => $data_from_cdap['data']['father_name'],
            'father_name_en' => $data_from_cdap['data']['father_name_en'],
            'present_address' =>$data_from_cdap['data']['pre_address'],
            'permanent_address' =>$data_from_cdap['data']['per_address'],
            'spouse_name' => $data_from_cdap['data']['spouse_name'],
            'spouse_name_en' => $data_from_cdap['data']['spouse_name_en'],
            'gender' => $data_from_cdap['data']['gender'],
            'nationality' => $data_from_cdap['data']['nationality'],
            'date_of_birth' => $data_from_cdap['data']['date_of_birth'],
            'occupation' => $data_from_cdap['data']['occupation'],
            'photo' => null,
            'email_verify' => $data_from_cdap['data']['email_verify'],
            'nid_verify' => $data_from_cdap['data']['nid_verify'],
            'brn' => $data_from_cdap['data']['brn'],
            'brn_verify' => $data_from_cdap['data']['brn_verify'],
            'passport' => $data_from_cdap['data']['passport'],
            'passport_verify' => $data_from_cdap['data']['passport_verify'],
            'tin' => $data_from_cdap['data']['tin'],
            'tin_verify' => $data_from_cdap['data']['tin_verify'],
            'bin' => $data_from_cdap['data']['bin'],
            'bin_verify' => $data_from_cdap['data']['bin_verify'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
        ];

        $created_cdap_user_ID = DB::table('cdap_users')->insertGetId($cdap_users_array);

        $user_table_array = [
            'name' => $data_from_cdap['data']['name'],
            'username' => 'CDAP_' . $data_from_cdap['data']['id'],
            'cdap_user_id' => $created_cdap_user_ID,
            'is_cdap_user' => 1,
            'role_id' => 36,
            'mobile_no' => $mobile_number_reshaped,
            'email' => $data_from_cdap['data']['email'],
            'profile_image' => null,
            'password' => Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'),
            'citizen_id' => $created_citigen_ID,
            'citizen_nid' => $data_from_cdap['data']['nid'],
        ];

        $created_user_ID = DB::table('users')->insertGetId($user_table_array);

        $cdap_image_photo = $data_from_cdap['data']['photo'];

        if($cdap_image_photo !="")
        {
            $base64_str = substr($cdap_image_photo, strpos($cdap_image_photo, ',') + 1);
            $extension = explode('/', explode(';', $cdap_image_photo)[0])[1];
            $image_data = base64_decode($base64_str); // decode the image
           
            $imageName = 'CDAP_' . $data_from_cdap['data']['id'] .'.'. $extension;
            $upload_path = '/uploads/profile/';
            file_put_contents(public_path() . $upload_path . $imageName, $image_data);
            
            DB::table('users')
            ->where('id', $created_user_ID)
            ->update(['profile_pic' => $imageName]);
        }

        DB::table('users')
            ->where('id', $created_user_ID)
            ->update(['profile_pic' => $imageName]);

        $userdata = [
            'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C',
            'username' => 'CDAP_' . $data_from_cdap['data']['id'],
        ];
        return $userdata;
    }
    public static function create_cdap_user_organization_with_login($requestInfo,$data_from_cdap)
    {

        $mobile_int_2_str = (string)$data_from_cdap['data']['mobile'];
        if(strlen( $mobile_int_2_str) == 10)
        {

            $mobile_number_reshaped='0'.$mobile_int_2_str;
        }
        else
        {
            $mobile_number_reshaped= $mobile_int_2_str;
        }

        $gcc_citizens_array = [
            'citizen_name' => $data_from_cdap['data']['name'],
            'citizen_phone_no' => $mobile_number_reshaped,
            'citizen_NID' => $data_from_cdap['data']['nid'],
            'citizen_birth_reg_no' => $data_from_cdap['data']['brn'],
            'citizen_gender' => strtoupper($data_from_cdap['data']['gender']),
            'father' => $data_from_cdap['data']['father_name'],
            'mother' => $data_from_cdap['data']['mother_name'],
            'email' => $data_from_cdap['data']['email'], 
            'dob' => $data_from_cdap['data']['date_of_birth'],
            'present_address' =>$data_from_cdap['data']['pre_address'],
            'permanent_address' =>$data_from_cdap['data']['per_address'],
            'designation'=>$requestInfo->designation,
            'organization_employee_id'=>$requestInfo->organization_employee_id
        ];

        $nid_exits=DB::table('gcc_citizens')->where('citizen_NID',$data_from_cdap['data']['nid'])->first();
            
        
        if(!empty($nid_exits))
        {
            DB::table('gcc_citizens')->where('citizen_NID',$data_from_cdap['data']['nid'])->update($gcc_citizens_array);
            $created_citigen_ID=$nid_exits->id;
        }
        else
        {
            
            $created_citigen_ID = DB::table('gcc_citizens')->insertGetId($gcc_citizens_array);
            
        }


        date_default_timezone_set('Asia/Dhaka');

        $cdap_users_array = [
            'citizen_id' => $data_from_cdap['data']['id'],
            'mobile' => $mobile_number_reshaped,
            'email' => $data_from_cdap['data']['email'],
            'nid' => $data_from_cdap['data']['nid'],
            'name' => $data_from_cdap['data']['name'],
            'name_en' => $data_from_cdap['data']['name_en'],
            'mother_name' => $data_from_cdap['data']['mother_name'],
            'mother_name_en' => $data_from_cdap['data']['mother_name_en'],
            'father_name' => $data_from_cdap['data']['father_name'],
            'father_name_en' => $data_from_cdap['data']['father_name_en'],
            'present_address' =>$data_from_cdap['data']['pre_address'],
            'permanent_address' =>$data_from_cdap['data']['per_address'],
            'spouse_name' => $data_from_cdap['data']['spouse_name'],
            'spouse_name_en' => $data_from_cdap['data']['spouse_name_en'],
            'gender' => $data_from_cdap['data']['gender'],
            'nationality' => $data_from_cdap['data']['nationality'],
            'date_of_birth' => $data_from_cdap['data']['date_of_birth'],
            'occupation' => $data_from_cdap['data']['occupation'],
            'photo' => null,
            'email_verify' => $data_from_cdap['data']['email_verify'],
            'nid_verify' => $data_from_cdap['data']['nid_verify'],
            'brn' => $data_from_cdap['data']['brn'],
            'brn_verify' => $data_from_cdap['data']['brn_verify'],
            'passport' => $data_from_cdap['data']['passport'],
            'passport_verify' => $data_from_cdap['data']['passport_verify'],
            'tin' => $data_from_cdap['data']['tin'],
            'tin_verify' => $data_from_cdap['data']['tin_verify'],
            'bin' => $data_from_cdap['data']['bin'],
            'bin_verify' => $data_from_cdap['data']['bin_verify'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
        ];

        $created_cdap_user_ID = DB::table('cdap_users')->insertGetId($cdap_users_array);

        if($requestInfo->office_id =="OTHERS")
        {
              
           $office['office_name_bn']=$requestInfo->office_name_bn;
           $office['office_name_en']=$requestInfo->office_name_en;
           $office['division_id']=$requestInfo->division_id;
           $office['district_id']=$requestInfo->district_id;
           $office['upazila_id']=$requestInfo->upazila_id;
           $office['organization_type']=$requestInfo->organization_type;
           $office['organization_physical_address']=$requestInfo->organization_physical_address;
           $office['organization_routing_id']=$requestInfo->organization_id;
           $office['is_organization']=1;
           $office_id=DB::table('office')->insertGetId($office);
           $has_case_before=false;
        }
        else
        {
            $office_id=$requestInfo->office_id;
            $has_case_before=true;
            
        }

        $user_table_array = [
            'name' => $data_from_cdap['data']['name'],
            'username' => 'CDAP_' . $data_from_cdap['data']['id'],
            'cdap_user_id' => $created_cdap_user_ID,
            'is_cdap_user' => 1,
            'role_id' => 35,
            'mobile_no' => $mobile_number_reshaped,
            'email' => $data_from_cdap['data']['email'],
            'profile_image' => null,
            'password' => Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'),
            'citizen_id' => $created_citigen_ID,
            'citizen_nid' => $data_from_cdap['data']['nid'],
            'designation' => $requestInfo->designation,
            'office_id' =>$office_id,
            'organization_employee_id'=>$requestInfo->organization_employee_id,
        ];
        
        
        $created_user_ID = DB::table('users')->insertGetId($user_table_array);

        if($has_case_before)
        {
            OrganizationCaseMappingRepository::employeeOrgizationCaseMapping($office_id,$created_citigen_ID,$created_user_ID);
        }


        $cdap_image_photo = $data_from_cdap['data']['photo'];

        if($cdap_image_photo !="")
        {
            $base64_str = substr($cdap_image_photo, strpos($cdap_image_photo, ',') + 1);
            $extension = explode('/', explode(';', $cdap_image_photo)[0])[1];
            $image_data = base64_decode($base64_str); // decode the image
           
            $imageName = 'CDAP_' . $data_from_cdap['data']['id'] .'.'. $extension;
            $upload_path = '/uploads/profile/';
            file_put_contents(public_path() . $upload_path . $imageName, $image_data);
            
            DB::table('users')
            ->where('id', $created_user_ID)
            ->update(['profile_pic' => $imageName]);
        }

        DB::table('users')
            ->where('id', $created_user_ID)
            ->update(['profile_pic' => $imageName]);

        $userdata = [
            'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C',
            'username' => 'CDAP_' . $data_from_cdap['data']['id'],
        ];
        return $userdata;
    }
    public static function update_cdap_user_with_login($data_from_cdap)
    {
       
        $mobile_int_2_str = (string)$data_from_cdap['data']['mobile'];
        if(strlen( $mobile_int_2_str) == 10)
        {

            $mobile_number_reshaped='0'.$mobile_int_2_str;
        }
        else
        {
            $mobile_number_reshaped= $mobile_int_2_str;
        }


        $gcc_citizens_array = [
            'citizen_name' => $data_from_cdap['data']['name'],
            'citizen_phone_no' => $mobile_number_reshaped,
            'citizen_NID' => $data_from_cdap['data']['nid'],
            'citizen_birth_reg_no' => $data_from_cdap['data']['brn'],
            'citizen_gender' => strtoupper($data_from_cdap['data']['gender']),
            'father' => $data_from_cdap['data']['father_name'],
            'mother' => $data_from_cdap['data']['mother_name'],
            'email' => $data_from_cdap['data']['email'],
            'dob' => $data_from_cdap['data']['date_of_birth'],
            'present_address' =>$data_from_cdap['data']['pre_address'],
            'permanent_address' =>$data_from_cdap['data']['per_address'],
        ];
        DB::table('gcc_citizens')
            ->where('citizen_NID', '=', $data_from_cdap['data']['nid'])
            ->where('citizen_phone_no', '=', $mobile_number_reshaped)
            ->update($gcc_citizens_array);

        date_default_timezone_set('Asia/Dhaka');

        $cdap_users_array = [
            'citizen_id' => $data_from_cdap['data']['id'],
            'mobile' => $mobile_number_reshaped,
            'email' => $data_from_cdap['data']['email'],
            'nid' => $data_from_cdap['data']['nid'],
            'name' => $data_from_cdap['data']['name'],
            'name_en' => $data_from_cdap['data']['name_en'],
            'mother_name' => $data_from_cdap['data']['mother_name'],
            'mother_name_en' => $data_from_cdap['data']['mother_name_en'],
            'father_name' => $data_from_cdap['data']['father_name'],
            'father_name_en' => $data_from_cdap['data']['father_name_en'], 
            'present_address' =>$data_from_cdap['data']['pre_address'],
            'permanent_address' =>$data_from_cdap['data']['per_address'],
            'spouse_name' => $data_from_cdap['data']['spouse_name'],
            'spouse_name_en' => $data_from_cdap['data']['spouse_name_en'],
            'gender' => $data_from_cdap['data']['gender'],
            'nationality' => $data_from_cdap['data']['nationality'],
            'date_of_birth' => $data_from_cdap['data']['date_of_birth'],
            'occupation' => $data_from_cdap['data']['occupation'],
            'photo' => null,
            'email_verify' => $data_from_cdap['data']['email_verify'],
            'nid_verify' => $data_from_cdap['data']['nid_verify'],
            'brn' => $data_from_cdap['data']['brn'],
            'brn_verify' => $data_from_cdap['data']['brn_verify'],
            'passport' => $data_from_cdap['data']['passport'],
            'passport_verify' => $data_from_cdap['data']['passport_verify'],
            'tin' => $data_from_cdap['data']['tin'],
            'tin_verify' => $data_from_cdap['data']['tin_verify'],
            'bin' => $data_from_cdap['data']['bin'],
            'bin_verify' => $data_from_cdap['data']['bin_verify'],
            'created_at' => null,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

         DB::table('cdap_users')
            ->where('nid', '=', $data_from_cdap['data']['nid'])
            ->where('mobile', '=', $mobile_number_reshaped)
            ->update($cdap_users_array);

        $user_table_array = [
            'name' => $data_from_cdap['data']['name'],
            'username' => 'CDAP_' . $data_from_cdap['data']['id'],
            'is_cdap_user' => 1,
            'mobile_no' => $mobile_number_reshaped,
            'email' => $data_from_cdap['data']['email'],
            'profile_image' => null,
            'citizen_nid' => $data_from_cdap['data']['nid'],
            'password' => Hash::make('THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'),
        ];

        DB::table('users')
            ->where('mobile_no', '=', $mobile_number_reshaped)
            ->where('is_cdap_user', '=', 1)
            ->where('citizen_nid', '=', $data_from_cdap['data']['nid'])
            ->update($user_table_array);

        $exits_user = DB::table('users')
            ->where('mobile_no', '=', $mobile_number_reshaped)
            ->where('is_cdap_user', '=', 1)
            ->where('citizen_nid', '=', $data_from_cdap['data']['nid'])
            ->first();

        $created_user_ID = $exits_user->id;

        $cdap_image_photo = $data_from_cdap['data']['photo'];

        if($cdap_image_photo !="")
        {
            $base64_str = substr($cdap_image_photo, strpos($cdap_image_photo, ',') + 1);
            $extension = explode('/', explode(';', $cdap_image_photo)[0])[1];
            $image_data = base64_decode($base64_str); // decode the image
           
            $imageName = 'CDAP_' . $data_from_cdap['data']['id'] .'.'. $extension;
            $upload_path = '/uploads/profile/';
            file_put_contents(public_path() . $upload_path . $imageName, $image_data);
            
            DB::table('users')
            ->where('id', $created_user_ID)
            ->update(['profile_pic' => $imageName]);
        }
        
      

        $userdata = [
            'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C',
            'username' => 'CDAP_' . $data_from_cdap['data']['id'],
        ];

        return $userdata;
    }


}
