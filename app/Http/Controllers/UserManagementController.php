<?php

namespace App\Http\Controllers;

use \Auth;
use App\Models\UserManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator,Redirect,Response;



class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();
        // All user list
        // $users = UserManagement::latest()->paginate(10);
        if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4 ){
            $users= DB::table('users')
                            ->orderBy('id','DESC')
                            ->join('role', 'users.role_id', '=', 'role.id')
                            ->join('office', 'users.office_id', '=', 'office.id')
                            ->leftJoin('district', 'office.district_id', '=', 'district.id')
                            ->leftJoin('court', 'users.court_id', '=', 'court.id')
                            ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                            ->select('users.*', 'role.role_name', 'office.office_name_bn', 'district.district_name_bn', 'court.court_name', 'upazila.upazila_name_bn')
                            ->paginate(10);
        }elseif($roleID == 6){                    
            $users= DB::table('users')
                            ->orderBy('id','DESC')
                            ->join('role', 'users.role_id', '=', 'role.id')
                            ->leftjoin('court', 'users.court_id', '=', 'court.id')
                            ->join('office', 'users.office_id', '=', 'office.id')
                            ->leftJoin('district', 'office.district_id', '=', 'district.id')
                            ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                            ->select('users.*', 'role.role_name', 'office.office_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'court.court_name')
                            ->where('office.district_id', $officeInfo->district_id)
                            ->whereIn('users.role_id', array(27,28))
                            ->paginate(10);
        }
        $page_title = 'ইউজার ম্যানেজমেন্ট তালিকা';

        return view('user_manage.index', compact('page_title','users'))
        ->with('i', (request()->input('page',1) - 1) * 10); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $roleID = Auth::user()->role_id;
        $officeInfo = user_office_info();

        $data['roles'] = DB::table('role')
        ->where('is_gcc', 1)
        ->select('id', 'role_name')
        ->get(); 
        if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4 ){
            $data['offices'] = DB::table('office')
                ->leftJoin('district', 'office.district_id', '=', 'district.id')
                ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                ->select('office.id', 'office.office_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn')
                ->where('office.is_gcc', 1)
                ->get();
            $data['courts'] = DB::table('court')
                ->leftJoin('district', 'court.district_id', '=', 'district.id')
                ->select('court.id', 'court.court_name_bn', 'district.district_name_bn')
                ->get();
            $data['roles'] = DB::table('role')
                ->where('is_gcc', 1)
                ->select('id', 'role_name')
                ->get();                                 
        }elseif($roleID == 6){
            $data['offices'] = DB::table('office')
                ->leftJoin('district', 'office.district_id', '=', 'district.id')
                ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                ->select('office.id', 'office.office_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn')
                ->where('office.district_id', $officeInfo->district_id)
                ->get(); 
            $data['courts'] = DB::table('court')
                ->leftJoin('district', 'court.district_id', '=', 'district.id')
                ->select('court.id', 'court.court_name', 'district.district_name_bn')
                ->where('court.district_id', $officeInfo->district_id)
                ->get(); 
            $data['roles'] = DB::table('role')
                ->where('is_gcc', 1)
                ->whereIn('id', array(27,28))
                ->select('id', 'role_name')
                ->get();   
        }

        // return $data['offices'];
        // $data['subcategories'] = DB::table("mouja")->where("upazila_id",38)->pluck("mouja_name_bn","id");

        $data['page_title'] = 'নতুন ইউজার এন্ট্রি ফরম';

        return view('user_manage.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
       $request->validate([
            'name' => 'required',
            'username' => 'required', 'unique:users', 'max:100',
            'role_id' => 'required',
            'office_id' => 'required',            
            'court_id' => 'required',            
            /*'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',            
            'mobile_no' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users', */           
            'password' => 'required',            
            ],
            [
            'name.required' => 'পুরো নাম লিখুন',
            'username.required' => 'ইউজার নাম লিখুন',
            'role_id.required' => 'ভূমিকা নির্বাচন করুন',
            'office_id.required' => 'অফিস নির্বাচন করুন',
            'court_id.required' => 'আদালত নির্বাচন করুন',
            'password.required' => 'পাসওয়ার্ড লিখুন',
            ]);

        DB::table('users')->insert([
            'name'=>$request->name,
            'username' =>$request->username,
            'mobile_no' =>$request->mobile_no,
            'email' =>$request->email,
            'role_id' =>$request->role_id,
            'office_id' =>$request->office_id,
            'court_id' =>$request->court_id,
            'password' =>Hash::make($request->password)
            
       ]);

         return redirect()->route('user-management.index')->with('success','সাফল্যের সাথে সংযুক্তি সম্পন্ন হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    // public function show(UserManagement $userManagement)
    public function show($id = '')
    {        
        $userManagement = DB::table('users')
                        ->join('role', 'users.role_id', '=', 'role.id')
                        ->join('office', 'users.office_id', '=', 'office.id')
                        ->leftJoin('district', 'office.district_id', '=', 'district.id')
                        ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                        ->select('users.*', 'role.role_name', 'office.office_name_bn', 
                            'district.district_name_bn', 'upazila.upazila_name_bn')
                        ->where('users.id',$id)
                        ->get()->first();
                  // dd($userManagement);     

        return view('user_manage.show', compact('userManagement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $data['userManagement'] = DB::table('users')
                        ->join('role', 'users.role_id', '=', 'role.id')
                        ->join('office', 'users.office_id', '=', 'office.id')
                        ->leftJoin('district', 'office.district_id', '=', 'district.id')
                        ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                        ->select('users.*', 'role.role_name', 'office.office_name_bn', 
                            'district.district_name_bn', 'upazila.upazila_name_bn')
                        ->where('users.id',$id)
                        ->get()->first();
                  // dd($userManagement);     
        $data['roles'] = DB::table('role')
        ->select('id', 'role_name')
        ->get(); 

        $data['offices'] = DB::table('office')
        ->leftJoin('district', 'office.district_id', '=', 'district.id')
        ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
        ->select('office.id', 'office.office_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn')/*
        ->where('office.district_id', 38)*/
        ->get();
        $data['page_title'] = 'ইউজার ইনফর্মেশন সংশোধন ফরম';
        return view('user_manage.edit')->with($data);
        // return view('user_manage.edit', compact('userManagement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id='')
    {
         $request->validate([
            'name' => 'required',
            'username' => 'required', 'unique:users', 'max:100',
            'role_id' => 'required',
            'office_id' => 'required',            
            // 'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users',            
            // 'mobile_no' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users',            
            'signature' => 'max:10240',             
            ],
            [
            'name.required' => 'পুরো নাম লিখুন',
            'username.required' => 'ইউজার নাম লিখুন',
            'role_id.required' => 'ভূমিকা নির্বাচন করুন',
            'office_id.required' => 'অফিস নির্বাচন করুন',
            
            ]);

        // File upload
        if($file = $request->file('signature')){
            $fileName = $id.'_'.time().'.'.$request->signature->extension();
            $request->signature->move(public_path('/uploads/signature'), $fileName);
            $fileName = '/uploads/signature/'.$fileName;
        }else{
            $fileName = NULL;
        }
        if($file = $request->file('pro_pic')){
            $profilePic = $id.'_'.time().'.'.$request->pro_pic->extension();
            $request->pro_pic->move(public_path('/uploads/profile'), $profilePic);
            $profilePic = '/uploads/profile/'.$profilePic;
        }else{
            $profilePic = NULL;
        }

         DB::table('users')
            ->where('id', $id)
            ->update(['name'=>$request->name,
            'username' =>$request->username,
            'mobile_no' =>$request->mobile_no,
            'signature' =>$fileName,
            'profile_pic' =>$profilePic,
            'email' =>$request->email,
            'role_id' =>$request->role_id,
            'office_id' =>$request->office_id,
            ]);
        return redirect()->route('user-management.index')
            ->with('success', 'ইউজার ডাটা সফলভাবে আপডেট হয়েছে');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserManagement  $userManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserManagement $userManagement)
    {
        //
    }
}
