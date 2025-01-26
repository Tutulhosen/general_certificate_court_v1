<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\News;
use App\Models\User;
use App\Models\Office;
use App\Models\DummyNid;
use App\Rules\IsEnglish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\OrganizationCaseMappingRepository;

class OrganizationRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }
    public function nid_check()
    {
        //
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        // return $data;

        $data['page_title'] = 'প্রাতিষ্ঠানিক এনআইডি যাচাইকরণ ফর্ম';

        return view('organization.nid_check')->with($data);
    }

    public function nid_verify(Request $request)
    {
        $request->validate([
            
            'nid_no' => 'required|unique:users,citizen_nid',
            ],
            [
            'nid_no.unique' => 'আপনার জাতীয় পরিচয় পত্র দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
            ]);
            
        $dob = date('Y-m-d', strtotime($request->dob));
        $result = DummyNid::where('national_id', $request->nid_no)
            ->where('dob', $dob)
            ->first();
        if (empty($result)) {
            return redirect()
                ->back()
                ->withErrors(['আপনার তথ্য পাওয়া যায়নি'])->withInput();
        } else {
            $data['results'] = $result;
            $data['page_title'] = 'প্রাতিষ্ঠানিক এনআইডি যাচাইকরণ ফর্ম';
            session(['nidData' => $result]);

            return redirect('/organizationRegister');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(!isset(Session::get('nidData')->national_id))
        {
            return redirect('/');
        }
    //     $data['offices'] = DB::table('office')
    //         ->where('office.is_gcc', 1)
    //         ->where('office.is_organization', 1)
    //         ->get();
    //    $citigen_organization_stuff_already=null;
    //    $already_office=null;
       
    //    $citigen_organization_stuff_already=DB::table('gcc_citizens')
    //                       ->join('gcc_appeal_citizens','gcc_citizens.id','=','gcc_appeal_citizens.citizen_id')
    //                       ->join('gcc_appeals','gcc_appeal_citizens.appeal_id','=','gcc_appeals.id')   
    //                       ->where('gcc_appeal_citizens.citizen_type_id',1)
    //                       ->where('gcc_citizens.citizen_NID',Session::get('nidData')->national_id)
    //                       ->whereNotNull('gcc_citizens.designation')
    //                       ->whereNotNull('gcc_citizens.organization')
    //                       ->whereNotNull('gcc_citizens.present_address')
    //                       ->whereNotNull('gcc_citizens.organization_id')
    //                       ->whereNotNull('gcc_citizens.email') 
    //                       ->whereNotNull('gcc_citizens.citizen_phone_no')
    //                        ->select('gcc_appeals.created_by','gcc_citizens.designation','gcc_citizens.organization','gcc_citizens.present_address','gcc_citizens.organization_id','gcc_citizens.email','gcc_citizens.citizen_phone_no')
    //                       ->first();
                          
    //    if(!empty($citigen_organization_stuff_already)){
    //     $already_office=DB::table('users')
    //                     ->join('office','users.office_id','=','office.id')
    //                     ->where('users.id',$citigen_organization_stuff_already->created_by)
    //                     ->first();
    //    }   


       //$data['citigen_organization_stuff_already']=$citigen_organization_stuff_already;
        //$data['already_office']=$already_office;

        $SesionData = Session::get('nidData');

        $data['results'] = $SesionData;

        $data['page_title'] = 'প্রতিষ্ঠান নিবন্ধন ফরম';

        $data['division']=DB::table('division')->get();

        return view('organization.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $request->validate(
            [
                'name' => 'required',
                'citizen_nid' => 'required|unique:users,citizen_nid',
                'email' => 'email | required | unique:users,email',
                'mobile_no' => 'required|size:11|regex:/(01)[0-9]{9}/',
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'organization_id' => ['required',new IsEnglish()],
                'confirm_password' => 'min:6',
                'office_id'=>'required',
                'division_id'=>'required',
                'district_id'=>'required',
                'upazila_id'=>'required',
                'organization_type'=>'required',
                'office_name_bn'=>'required',
                'office_name_en'=>['required',new IsEnglish()],
                'organization_physical_address'=>'required',
                'organization_employee_id'=>'required',
                'designation'=>'required'
            ],
            [    
                'division_id.required'=>'বিভাগ নির্বাচন করুন',
                'district_id.required'=>'জেলা নির্বাচন করুন',
                'upazila_id.required'=>'উপজেলা নির্বাচন করুন',
                'organization_type.required'=>'প্রতিষ্ঠানের ধরন নির্বাচন করুন',
                'office_name_bn.required'=>'প্রতিষ্ঠানের নাম বাংলাতে দিন',
                'office_name_en.required'=>'প্রতিষ্ঠানের নাম ইংরেজিতে দিন',
                'organization_physical_address.required'=>'প্রতিষ্ঠানের ঠিকানা দিন',
                'office_id.required'=>'অফিস নির্বাচন করুন',
                'name.required' => 'পুরো নাম লিখুন',
                'citizen_nid.unique' => 'আপনার জাতীয় পরিচয় পত্র দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
                'email.unique' => 'আপনার ইমেইল  দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
                'email.required' => 'আপনার ইমেইল লিখুন',
                'mobile_no.required' => 'মোবাইল নং দিতে হবে',
                'organization_id.required'=>'রাউটিং নং দিতে হবে',
                'password.required_with' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'confirm_password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন, ৬ সংখ্যার বেশি হতে হবে',
                'password.same'=>'উভয় ক্ষেত্রে একই পাসওয়ার্ড লিখুন',
                'organization_employee_id.required'=>'প্রতিনিধির EmployeeID দিতে হবে',
                'designation.required'=>'পদবী দিতে হবে'
            ],
        );
         
        //dd('dsd');

        $FourDigitRandomNumber = rand(1111, 9999);

        $data = [
            'citizen_name' => $request->name,
            'citizen_phone_no' => $request->mobile_no,
            'citizen_NID' => $request->citizen_nid,
            'citizen_gender' => $request->citizen_gender,
            'present_address' => $request->presentAddress,
            'permanent_address' => $request->permanentAddress,
            'dob' => $request->dob,
            'email' => $request->email,
            'father' =>$request->father,
            'mother' =>$request->mother,
            'designation'=>$request->designation,
            'organization_employee_id'=>$request->organization_employee_id
        ];

        $nid_exits=DB::table('gcc_citizens')->where('citizen_NID',$request->citizen_nid)->first();
              
        if(!empty($nid_exits))
        {
            DB::table('gcc_citizens')->where('citizen_NID',$request->citizen_nid)->update($data);
            $ID=$nid_exits->id;
        }
            else
        {

            $ID = DB::table('gcc_citizens')->insertGetId($data);
        }
        if($request->office_id =="OTHERS")
        {
              
           $office['office_name_bn']=$request->office_name_bn;
           $office['office_name_en']=$request->office_name_en;
           $office['division_id']=$request->division_id;
           $office['district_id']=$request->district_id;
           $office['upazila_id']=$request->upazila_id;
           $office['organization_type']=$request->organization_type;
           $office['organization_physical_address']=$request->organization_physical_address;
           $office['organization_routing_id']=$request->organization_id;
           $office['is_organization']=1;
           $office_id=DB::table('office')->insertGetId($office);
           $has_case_before=false;
        }
        else
        {
            $office_id=$request->office_id;
            $has_case_before=true;
            
        }
       // dd($office->ID); 
       if($request->password == "google_sso_login_password_14789_gcc_ourt")
       {
           $password='m#P52s@ap$V';
       }else
       {
              $password=$request->password;
       }
        $result = DB::table('users')->insertGetId([
            'citizen_id'=>$ID,
            'name' => $request->name,
            'username' => $request->name,
            'citizen_nid'=>$request->citizen_nid,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'designation' => $request->designation,
            'role_id' => 35,
            'otp' => $FourDigitRandomNumber,
            'office_id' =>$office_id,
            'organization_id' => $request->organization_id,
            'password' => Hash::make($password),
            'organization_employee_id'=>$request->organization_employee_id,
            'updated_at'=>date('Y-m-d H:i:s')
            
        ]);

        if($has_case_before)
        {
            OrganizationCaseMappingRepository::employeeOrgizationCaseMapping($office_id,$ID,$result);
        }

        if ($result) {
            $message = ' সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $FourDigitRandomNumber . "\r\n" . 'ধন্যবাদ।';
            $mobile = $request->mobile_no;
            $this->send_sms($mobile, $message);
            return redirect()->route('organization.mobile_check',['user_id'=>encrypt($result)])->with('success','আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন। ');
        }


    }
    public function mobile_check($user_id)
    {
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status',1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status',1)->get();
        // return $data;
        
        $data['page_title'] = 'প্রাতিষ্ঠানিক প্রতিনিধি মোবাইল নম্বর ভেরিফিকেশন ফর্ম';
        $data['user_id'] = decrypt($user_id);
        $user=User::where('id', decrypt($user_id))->first();
        $data['updated_at_otp']=$user->updated_at;
        $data['mobile']=$user->mobile_no;

        return view('organization.mobile_check')->with($data);
    }
    

    public function mobile_verify(Request $request)
    {
        $otp = $request->otp_1.$request->otp_2.$request->otp_3.$request->otp_4; 
        // return $otp;
        $result = User::where('otp', $otp)->where('id',$request->user_id)->first();
        // return $result;
        if(empty($result)){
            return redirect()->back()->withErrors(['আপনার তথ্য পাওয়া যায়নি']);
        }else{
            $data['results'] = $result;
            if(Auth::loginUsingId($result->id)){
                return redirect('/dashboard');
            }else{
                return redirect()->back()->withErrors(['আপনার তথ্য পাওয়া যায়নি']);
            }
        }
    }
   
    public function send_sms($mobile, $message)
    {
        // print_r($mobile.' , '.$message);exit('zuel');
                Http::post('http://bulkmsg.teletalk.com.bd/api/sendSMS', [
                
                    'auth'=>array(
                        "username" => 'ecourt',
                        "password" => 'A2ist2#0166',
                        "acode" => 1005370
                    ),
                    "smsInfo"=>array(
                        'message' => $message,
                        'is_unicode' => 1,
                        'masking' => 8801552146224,
                        'msisdn' =>array(
                            '0'=>$mobile
                        )
                    )
                
            ]);
    }
    
    public function organization_registration_otp_resend($user_id)
    {
        $otp = rand(1111,9999);
         
        $update_otp=DB::table('users')->where('id','=',decrypt($user_id))->update([
            'otp'=>$otp,
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        
        if($update_otp)
        {

            $user=User::where('id', decrypt($user_id))->first();

            $mobile = $user->mobile_no;            
           

            $message = " সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ".$otp."\r\n"."ধন্যবাদ।";

            $this->send_sms($mobile, $message);

            return redirect()->route('organization.mobile_check',['user_id'=>encrypt($user->id)])->with('success','আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন। ');
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
