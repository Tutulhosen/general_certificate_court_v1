<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\DummyNid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function redirectFromGoogleSSO()
    {
        $google_user=Socialite::driver('google')->stateless()->user();
        //dd($google_user);
        $exits_user_with_gmail=DB::table('users')->where('email','=',$google_user->email)->first();
        if(!empty($exits_user_with_gmail))
        {
            if(Auth::loginUsingId($exits_user_with_gmail->id)){
                return redirect('/dashboard');
            }
        }
        else
        {
            return Redirect()->route('after.google.get.email.nid.profile.create')->withCookie(cookie('Gmail_info', $google_user->email, 60));
        }
        

    }
    
    public function nid_verification_profile_create(Request $request)
    {
        $cookieData = $request->cookie('Gmail_info');
        $data['results'] = $cookieData;
        $data['page_title'] = 'রেজিস্ট্রার ফরম';
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status',1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status',1)->get();
        // return $data;
        if(mobile_first_registration())
        {
            return view('mobile_first_registration._after_google_sso_registration')->with($data);
        }else
        {
            return view('registration.after_google_sso_registration')->with($data);
        }
        


    }
    public function nid_check_citizen_google_sso(Request $request)
    {
        //
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status',1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status',1)->get();
        $cookieData = $request->cookie('Gmail_info');
        $data['results'] = $cookieData;
        
        $data['page_title'] = 'নাগরিক এনআইডি যাচাইকরণ ফর্ম';

        return view('googleSSOcitizen.nid_check_citizen')->with($data);
    }
    
    public function nid_verify_citizen_google_sso(Request $request)
    {
        $request->validate([
            
            'nid_no' => 'required|unique:users,citizen_nid',
            ],
            [
            'nid_no.unique' => 'আপনার জাতীয় পরিচয় পত্র দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
            ]);

        $dob = date('Y-m-d',strtotime($request->dob));
        $result = DummyNid::where('national_id', $request->nid_no)->where('dob',$dob)->first();
        if(empty($result)){
            return redirect()->back()->withErrors(['আপনার তথ্য পাওয়া যায়নি'])->withInput();
        }else{
            $cookieData = $request->cookie('Gmail_info');
            $data['gmail_info'] = $cookieData;

            $data['results'] = $result;
            $data['page_title'] = 'নাগরিক এনআইডি যাচাইকরণ ফর্ম';
            session(['nidData' => $result]);
            
            return redirect('/citizenRegister/google/sso');
        }
    }
    public function create_citizen_google_sso(Request $request)
    {
        $SesionData = Session::get('nidData');
        $data['results'] = $SesionData;
        $cookieData = $request->cookie('Gmail_info');
        $data['gmail_info'] = $cookieData;
        $data['page_title'] = 'রেজিস্ট্রার ফরম';
        // return $data;
        return view('googleSSOcitizen.citizen_add')->with($data);
    }
     
    public function nid_check_organization_google_sso(Request $request)
    {
        //
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status',1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status',1)->get();
        $cookieData = $request->cookie('Gmail_info');
        $data['results'] = $cookieData;
        
        $data['page_title'] = 'প্রাতিষ্ঠানিক এনআইডি যাচাইকরণ ফর্ম';

        return view('googleSSOcitizen.nid_check_organization')->with($data);
    }
    
    public function nid_verify_organization_google_sso(Request $request)
    {
        $request->validate([
            
            'nid_no' => 'required|unique:users,citizen_nid',
            ],
            [
            'nid_no.unique' => 'আপনার জাতীয় পরিচয় পত্র দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
            ]);
            
        $dob = date('Y-m-d',strtotime($request->dob));
        $result = DummyNid::where('national_id', $request->nid_no)->where('dob',$dob)->first();
        if(empty($result)){
            return redirect()->back()->withErrors(['আপনার তথ্য পাওয়া যায়নি'])->withInput();
        }else{
            $cookieData = $request->cookie('Gmail_info');
            $data['gmail_info'] = $cookieData;

            $data['results'] = $result;
            $data['page_title'] = 'প্রাতিষ্ঠানিক এনআইডি যাচাইকরণ ফর্ম';
            session(['nidData' => $result]);
            
            return redirect('/organizationRegister/google/sso');
        }
    }
    public function create_organization_google_sso(Request $request)
    {


        $SesionData = Session::get('nidData');
        $data['results'] = $SesionData;
        $cookieData = $request->cookie('Gmail_info');
        $data['gmail_info'] = $cookieData;
        $data['page_title'] = 'প্রতিষ্ঠান নিবন্ধন ফরম';
        $data['division']=DB::table('division')->get();
        // return $data;
        return view('googleSSOcitizen.organization_add')->with($data);
    }





}
