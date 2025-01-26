<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
// use Validator;
use Illuminate\Support\Facades\Validator;
//use App\Http\Resources\CaseRegister as CaseResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rules\MatchOldPassword; 
use App\Models\CaseRegister;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ProfileController extends BaseController
{

    public function details($id)
    {
        $data  = DB::table('users')
                ->join('role', 'users.role_id', '=', 'role.id')
                ->join('office', 'users.office_id', '=', 'office.id')
                ->leftJoin('district', 'office.district_id', '=', 'district.id')
                ->leftJoin('upazila', 'office.upazila_id', '=', 'upazila.id')
                ->select('users.id','users.name','users.email','users.mobile_no','users.profile_pic','users.signature', 'role.role_name', 'office.office_name_bn',
                    'district.district_name_bn', 'upazila.upazila_name_bn')
                ->where('users.id',$id)
                ->get()->first();
        // dd($data);

        return $this->sendResponse($data, 'User Details.');
    }

    public function test()
    {
        // Counter
        $data['total_case'] = DB::table('case_register')->count();
        // dd($data);
        // echo 'Hellollll'; exit;
        return $this->sendResponse($data, 'test successfully.');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = CaseRegister::all();

        return $this->sendResponse(CaseResource::collection($items), 'Case retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
            ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $case = CaseRegister::create($input);

        return $this->sendResponse(new CaseResource($case), 'Case created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $case = CaseRegister::find($id);

        if (is_null($case)) {
            return $this->sendError('Case not found.');
        }

        return $this->sendResponse(new CaseResource($case), 'Case retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CaseRegister $case)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
            ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $case->name = $input['name'];
        $case->detail = $input['detail'];
        $case->save();

        return $this->sendResponse(new CaseResource($case), 'Case updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CaseRegister $case)
    {
        $case->delete();

        return $this->sendResponse([], 'Case deleted successfully.');
    }

    public function update_password(Request $request)
    {
        $userid = Auth::guard('api')->user()->id;
        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'new_password' => ['required','min:6'],
            'new_confirm_password' => ['same:new_password'],
            ]);
        if ($validator->fails()) {
            $arr = $this->sendError($validator->errors()->first() , ['error'=>$validator->errors()->first()]);
        } else {
            try {
                if ((Hash::check(request('current_password'), Auth::user()->password)) == false) {
                    $arr = $this->sendError('Check your old password.' , ['error'=> 'Your old password not match.']);
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    $arr = $this->sendError('Make sure your current password does not match your new password.' , ['error'=> 'Please enter a new password which is not similar then current password.']);
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($request->new_password)]);
                    return $this->sendResponse(null, 'Password updated successfully.');
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = $this->sendError($msg , ['error'=> $msg]);
            }
        }
        return $arr;
    }
    public function profile_picture(Request $request)
    {
        $user_id = Auth::user()->id;
        if($image_64 = $request->image){
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',')+1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = $user_id . '_' . time() . '_' . Str::random(5) . '.'.$extension;
            // Storage::disk('public/uploads/profile')->put($imageName, base64_decode($image));
            file_put_contents('uploads/profile/' . $imageName, base64_decode($image));

            $user = User::findOrFail($user_id);
            $user->profile_pic = $imageName;
            if($user->save()){
                return $this->sendResponse(null, 'Profile Picture updated successfully.');
            } else{
                return $this->sendError('Something went wrong' , ['error'=> 'Something went wrong.']);
            }
        }
        return $this->sendError('Image Null' , ['error'=> 'Please select the images.']);
    }

}
