<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserExitsCheckController extends Controller
{
    //
    public function index(Request $request)
    {
        $usernames=DB::table('users')->where('username','=',$request->username)->first();
        $email=DB::table('users')->where('email','=',$request->email)->first();

        if(!empty($usernames))
        {
            $is_username_found=1;

        }
        else
        {
            $is_username_found=0;
        }
        
        if(!empty($email))
        {
            $is_email_found=1;

        }
        else
        {
            $is_email_found=0;
        }


        return response()->json([
            'success'=>'success',
            'is_username_found'=>$is_username_found,
            'is_email_found'=>$is_email_found,
        ]);
    }   
    public function forget_password()   
    {
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status',1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status',1)->get();
        // return $data;
        
        $data['page_title'] = 'নাগরিক পাসওয়ার্ড রিসেট ফর্ম';

        return view('citizen.password_reset_form')->with($data);
    }

    public function user_check_forget_password(Request $request)
    {
        $request->validate([
            'nid_no' => 'required',
            'dob' => 'required',
            'mobile_number' => 'required',
          
            ],
            [
            'nid_no.required' => 'আপনার জাতীয় পরিচয় পত্র লিখুন',
            'dob.required' => 'আপনার জাতীয় পরিচয় এর জন্ম তারিখ লিখুন',
            'mobile_number.required'=>'মোবাইল নং লিখুন',
         
            ]);


        
        $nid_verified = DB::table('dummy_nids')->where('national_id', $request->nid_no)->where('dob','=',$request->dob)->first();

        if(!empty($nid_verified))
        {
            $user=DB::table('users')->where('citizen_nid','=',$request->nid_no)->where('mobile_no','=',$request->mobile_number)->first();
            if(!empty($user))
            {
                $otp = rand(1111,9999);

                $update_otp=DB::table('users')->where('id','=',$user->id)->update([
                    'otp'=>$otp,
                    'updated_at'=>date('Y-m-d H:i:s')
                ]);
                if($update_otp)
                {

                    $message = " সিস্টেমে পাসওয়ার্ড রিসেট সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ".$otp."\r\n"."ধন্যবাদ।";
                    $mobile = $user->mobile_no;
                    $this->send_sms($mobile, $message);
                    return redirect()->route('user.check.forget.password.mobile_check',['id'=>encrypt($user->id)])->with('success','আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন। ');
                }
            }
            else
            {
                return redirect()->back()->with('Errormessage','আপনার তথ্য পাওয়া যায়নি');
            }
        }
        else
            {
                return redirect()->back()->with('Errormessage','আপনার তথ্য পাওয়া যায়নি');
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

    public function mobile_check_reset_password($id)
    {
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status',1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status',1)->get();
        
        $user=User::where('id', decrypt($id))->first();
        //dd($user);
        $data['user_id']=decrypt($id);
        $data['updated_at_otp']=$user->updated_at;

        $data['page_title'] = 'নাগরিক মোবাইল নম্বর ভেরিফিকেশন ফর্ম';

        return view('citizen.mobile_check_reset_password')->with($data);
    }

    public function forget_password_otp_resend($id)
    {
      
        
        $otp = rand(1111,9999);
        
        $update_otp=DB::table('users')->where('id','=',decrypt($id))->update([
            'otp'=>$otp,
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        
        if($update_otp)
        {

            $user=User::where('id', decrypt($id))->first();

            $mobile = $user->mobile_no;            

            $message = " সিস্টেমে পাসওয়ার্ড রিসেট সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ".$otp."\r\n"."ধন্যবাদ।";

            $this->send_sms($mobile, $message);

            return redirect()->route('user.check.forget.password.mobile_check',['id'=>encrypt($user->id)])->with('success','আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন। ');
        }
    }

    public function mobile_verify(Request $request)
    {
        $otp = $request->otp_1.$request->otp_2.$request->otp_3.$request->otp_4; 
        // return $otp;
        $result = User::where('otp', $otp)->where('id',$request->user_id)->first();
         //return $result;
        if(empty($result)){
            return redirect()->back()->withErrors(['আপনার তথ্য পাওয়া যায়নি']);
        }else{
            $data['results'] = $result;
            if(Auth::loginUsingId($result->id)){
                return redirect('/my-profile/new/change-password/');
            }else{
                return redirect()->back()->withErrors(['আপনার তথ্য পাওয়া যায়নি']);
            }
        }
    }

}
