<?php

namespace App\Http\Controllers;

use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\DB;

class DummiDataController extends Controller
{
    public function dammi_case_no()
    {
        AppealRepository::generateCaseNo(5);

        //dd(DB::table('gcc_citizens')->where('id',4)->select('designation')->first()->designation);
        dd(DB::table('gcc_appeals')
                ->join('office', 'gcc_appeals.office_id', 'office.id')
                ->join('district', 'gcc_appeals.district_id', 'district.id')
                ->where('gcc_appeals.id', 10)->select('gcc_appeals.loan_amount_text', 'gcc_appeals.loan_amount', 'office.office_name_bn', 'office.organization_physical_address', 'district.district_name_bn')->first());
    }
    public function dummi_nid_create()
    {
        for ($i = 1; $i <= 50; $i++) {

            while (1) {
                $dammi_nid = rand(11111111111111111, 99999999999999999);

                $dummi_data = [
                    'name_bn' => 'মোস্তফা আতাউল ' . $i,
                    'name_en' => 'Mostafa Ataul ' . $i,
                    'gender' => 'MALE',
                    'dob' => '1993-10-30',
                    'father' => 'আবু মোস্তফা আতাউল ' . $i,
                    'mother' => 'উম্মে মোস্তফা আতাউল ' . $i,
                    'national_id' => $dammi_nid,
                    'permanent_address' => 'বিভাগ : চট্টগ্রাম,জেলা : চট্টগ্রাম,উপজেলা  : রাউজান,পোস্ট-অফিস : রাউজান,পোস্টালকোড : 4900,মৌজা : পাহাড়তলি,রোড : ২৯,বাসা: ৩৭৮,',
                    'present_address' => 'বিভাগ : চট্টগ্রাম,জেলা : চট্টগ্রাম,উপজেলা  : রাউজান,পোস্ট-অফিস : রাউজান,পোস্টালকোড : 4900,মৌজা : পাহাড়তলি,রোড : ২৯,বাসা: ৩৭৮,',
                    'created_at' => date('Y-m-d h:i:s', strtotime("now")),
                    'updated_at' => date('Y-m-d h:i:s', strtotime("now")),
                ];

                $inserted = DB::table('dummy_nids')->insert($dummi_data);

                if ($inserted) {
                    break;
                }

            }
        }

    }
    public function update_nid_phone()
    {
        DB::table('custom_tokens')
                    ->updateOrInsert(
                        ['token_name' => 'IDPAPIToken'],
                        ['token' => '1566']
                    );

       $phone_number=[
       '01684981149',
       '01974981149',
       '01741315099',
       '01683791964',
       '01748890748',
       '01551678133',
       '01937793487',
       '01790344242',
       '01824129706',
       '01751657555',
       '01799539064',
       ];

       for($i=1;$i<=1268;$i++)
       {
            DB::table('dummy_nids')->where('id',$i)->update(['mobile_no'=>$phone_number[array_rand($phone_number)]]);
       }
       //dd($phone_number[array_rand($phone_number)]);
    }
    public function update_citizen_email()
    {
        $email_array = ['touhidulislam256@gmail.com', null, 'touhidul.developer.2022@gmail.com', 'touhidul.encoderit@gmail.com', 'tutul5162@gmail.com'];

        $all_citizens = DB::table('gcc_citizens')->select('id')->get();
        foreach ($all_citizens as $all_citizens) {
            DB::table('gcc_citizens')->where('id', $all_citizens->id)->update([
                'email' => $email_array[rand(0, 4)],
            ]);
        }
    }
   
}
