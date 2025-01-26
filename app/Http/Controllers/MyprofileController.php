<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class MyprofileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        $userManagement = DB::table('users')
                        ->join('role', 'users.role_id', '=', 'role.id')
                        ->leftjoin('office', 'users.office_id', '=', 'office.id')
                        ->leftJoin('district', 'office.district_id', '=', 'district.id')
                        ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                        ->select('users.*', 'role.role_name', 'office.office_name_bn', 
                            'district.district_name_bn', 'upazila.upazila_name_bn')
                        ->where('users.id',$user_id)
                        ->first();
        

        $page_title = "মাই প্রোফাইল";
                  // dd($userManagement);  

        if(globalUserInfo()->is_cdap_user  == 1 )
        {
            $userManagement = DB::table('cdap_users')
            ->where('id',globalUserInfo()->cdap_user_id)
            ->first();
             
            $profile_pic=globalUserInfo()->profile_pic;
            return view('myprofile.cdap_user', compact('userManagement','profile_pic','page_title'));
        }
        elseif(globalUserInfo()->role_id  == 35 || globalUserInfo()->role_id  == 36 )
        {
            return view('myprofile.show', compact('userManagement','page_title'));
        }
        
        else
        {
            

            return view('myprofile.doptor_user', compact('userManagement','page_title'));
        }

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function basic_edit()
    {   
        $user_id = Auth::user()->id;
  
        $data['userManagement'] = DB::table('users')
                        ->join('role', 'users.role_id', '=', 'role.id')
                        ->leftjoin('office', 'users.office_id', '=', 'office.id')
                        ->leftJoin('district', 'office.district_id', '=', 'district.id')
                        ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                        ->select('users.*', 'role.role_name', 'office.office_name_bn', 
                            'district.district_name_bn', 'upazila.upazila_name_bn')
                        ->where('users.id',$user_id)
                        ->get()->first();
        $data['roles'] = DB::table('role')
        ->select('id', 'role_name')
        ->get(); 

        $data['offices'] = DB::table('office')
        ->leftJoin('district', 'office.district_id', '=', 'district.id')
        ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
        ->select('office.id', 'office.office_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn')
        ->get();
        $data['page_title'] = 'প্রোফাইল তথ্য  সংশোধন ফরম';

        if(globalUserInfo()->is_cdap_user  == 1 )
        {
            $userManagement = DB::table('cdap_users')
            ->where('id',globalUserInfo()->cdap_user_id)
            ->first();
             
            $profile_pic=globalUserInfo()->profile_pic;
            return view('myprofile.edit_cdap_user')->with($data);
        }
        elseif(globalUserInfo()->role_id  == 35 || globalUserInfo()->role_id  == 36 )
        {
            return view('myprofile.edit')->with($data);
        }
        elseif(globalUserInfo()->role_id  == 28 && globalUserInfo()->doptor_user_flag == 0 )
        {
            return view('myprofile.edit_certificte_assitent')->with($data);
        }
        elseif(globalUserInfo()->role_id  == 1 || globalUserInfo()->role_id  == 2 || globalUserInfo()->role_id  == 8  || globalUserInfo()->role_id  == 25 )
        {
            return view('myprofile.edit_admin_a2i')->with($data);
        }
        else
        {
        

            return view('myprofile.edit_doptor_user')->with($data);
        }

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function basic_update(Request $request)
    {
        $user_id = Auth::user()->id;

        $email_already=DB::table('users')->where('email',$request->email)->where('id','!=',$user_id)->first();
      
        
        if(!empty($email_already))
        {
            return Redirect::back()->with('withError',''.$request->email.' দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে ! ');
        }
        
        $request->validate([
            'name' => 'required',                      
            'mobile_no' => 'required|size:11|regex:/(01)[0-9]{9}/',                       
            ],
            [
            'name.required' => 'পুরো নাম লিখুন',
            'mobile_no.required' =>'মোবাইল নং দিতে হবে',
            'mobile_no.size' =>'মোবাইল নং ১১ digit হতে হবে',
            'mobile_no.regex' =>'ইংরেজিতে সঠিক মোবাইল নং প্রদান করুন'
            ]);

         DB::table('users')
            ->where('id', $user_id)
            ->update(['name'=>$request->name,
            'mobile_no' =>$request->mobile_no,
            'email' =>$request->email,
            ]);
        return redirect()->route('my-profile.index')
            ->with('success', 'প্রোফাইলের বেসিক ইনফরমেশন সফলভাবে আপডেট হয়েছে');
    }



    public function imageUpload()
    {
        $user_id = Auth::user()->id;

        $data['userManagement'] = DB::table('users')
                                ->select('users.*')
                                ->where('users.id',$user_id)
                                ->get()->first();
        $data['page_title']='Profile Image Update';                        

         if(globalUserInfo()->is_cdap_user  == 1 )
            {
                  $userManagement = DB::table('cdap_users')
                                    ->where('id',globalUserInfo()->cdap_user_id)
                                    ->first();
                                     
                                    $profile_pic=globalUserInfo()->profile_pic;
                                    return view('myprofile.edit_cdap_user')->with($data);
            }
            elseif(globalUserInfo()->role_id  == 35 || globalUserInfo()->role_id  == 36)
            {
                return view('myprofile.imageUpload')->with($data);
            }
            elseif(globalUserInfo()->role_id  == 28 && globalUserInfo()->doptor_user_flag == 0 )
            {
                return view('myprofile.edit_profile_image_certificate_assitent')->with($data);
            }
            elseif(globalUserInfo()->role_id  == 25 || globalUserInfo()->role_id  == 8 || globalUserInfo()->role_id  == 2 || globalUserInfo()->role_id == 1 )
            {
                return view('myprofile.edit_profile_image_certificate_assitent')->with($data);
            }
            else
            {
                                
                       
                 return view('myprofile.edit_doptor_user')->with($data);
            }                        
        
    }

     public function image_update(Request $request)
    {  
        $user_id = Auth::user()->id;
        $request->validate([
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if($file = $request->file('image')){
            $profilePic = $user_id.'_'.time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/profile'), $profilePic);
        }else{
            $profilePic = NULL;
        }

        DB::table('users')
            ->where('id', $user_id)
            ->update(['profile_pic' =>$profilePic,]);
        return redirect()->route('my-profile.index')
            ->with('success', 'ইউজার ডাটা সফলভাবে আপডেট হয়েছে');
    }




    public function change_password()
    {


        if(globalUserInfo()->is_cdap_user  == 1 )
        {
            $data['page_title']='পাসওয়ার্ড পরিবর্তন';
             
            return view('myprofile.edit_cdap_user')->with($data);
        }
        elseif(globalUserInfo()->role_id  == 35 || globalUserInfo()->role_id  == 36 )
        {
            $data['page_title']='পাসওয়ার্ড পরিবর্তন';
            return view('myprofile.changePassword')->with($data);
        }
        elseif(globalUserInfo()->role_id  == 28 && globalUserInfo()->doptor_user_flag == 0 )
        {
            $data['page_title']='পাসওয়ার্ড পরিবর্তন';
            return view('myprofile.edit_certificte_assitent')->with($data);
        }
        elseif(globalUserInfo()->role_id  == 1 || globalUserInfo()->role_id  == 2  )
        {
            $data['page_title']='পাসওয়ার্ড পরিবর্তন';
            return view('myprofile.changePassword_admin_a2i')->with($data);
        }
        else
        {
        
            $data['page_title']='পাসওয়ার্ড পরিবর্তন';
            return view('myprofile.edit_doptor_user')->with($data);
        }

        
    }


     public function update_password(Request $request)
    {
        if(!Hash::check($request->current_password, globalUserInfo()->password))
       {
           return redirect()->back()->with('errorMSG','আপনার বর্তমান পাসওয়ার্ড সঠিক নয়')->with('error','পাসওয়ার্ড হালনাগাদ করা নাই');
       }
       elseif($request->new_password != $request->new_confirm_password)
       {
        return redirect()->back()->with('errorMSG','আপনার নতুন পাসওয়ার্ড, নতুন কনফার্ম পাসওয়ার্ড একই নয়')->with('error','পাসওয়ার্ড হালনাগাদ করা নাই');
       }
       elseif(strlen($request->new_password) < 8 || strlen($request->new_confirm_password) < 8)
       {
        return redirect()->back()->with('errorMSG','আপনার নতুন পাসওয়ার্ড অথবা নতুন কনফার্ম পাসওয়ার্ড ৮ সংখ্যার কম')->with('error','পাসওয়ার্ড হালনাগাদ করা নাই');
       }
       
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

         return redirect()->route('my-profile.index')
            ->with('success', 'পাসওয়ার্ড সফলভাবে হালনাগাদ করা হয়েছে');
   
        // dd('Password change successfully.');
    }
    
    public function new_change_password()
    {
        
         

        return view('myprofile.new_changePassword');

    } 
    public function new_update_password(Request $request)
    {
        if($request->new_password != $request->new_confirm_password)
        {
         return redirect()->back()->with('errorMSG','আপনার নতুন পাসওয়ার্ড, নতুন কনফার্ম পাসওয়ার্ড একই নয়')->with('error','পাসওয়ার্ড হালনাগাদ করা নাই');
        }
        elseif(strlen($request->new_password) < 8 || strlen($request->new_confirm_password) < 8)
        {
         return redirect()->back()->with('errorMSG','আপনার নতুন পাসওয়ার্ড অথবা নতুন কনফার্ম পাসওয়ার্ড ৮ সংখ্যার কম')->with('error','পাসওয়ার্ড হালনাগাদ করা নাই');
        }
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

         return redirect()->route('my-profile.index')
            ->with('success', 'পাসওয়ার্ড সফলভাবে হালনাগাদ করা হয়েছে');
   
        // dd('Password change successfully.');
    }
    public function store(Request $request)
    {
        //
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
