<?php

namespace App\Http\Controllers;

use App\Rules\IsEnglish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\OrganizationCaseMappingRepository;

class OrganizationManagementController extends Controller
{

    public function get_organization_details($id)
    {
        $data['organization'] = DB::table('office')->where('id', decrypt($id))->first();
        $data['users'] = DB::table('users')->where('office_id',  $data['organization']->id)->get();
        $data['division'] = DB::table('division')->where('id', $data['organization']->division_id)->first();
        $data['district'] = DB::table('district')->where('id', $data['organization']->district_id)->first();
        $data['upazila'] = DB::table('upazila')->where('id', $data['organization']->upazila_id)->first();
        // dd($data);
        $data['page_title'] = 'প্রতিষ্ঠানের বিস্তারিত';
        return  view('organization.organization_details')->with($data);
    }
    public function get_organization_list()
    {
        $user_office_info = user_office_info();
        if ($user_office_info->level == 4) {

            $list_of_org = DB::table('office')->where('is_organization', 1)->where('district_id', user_office_info()->district_id)->where('upazila_id', user_office_info()->upazila_id)->paginate(30);
        } elseif ($user_office_info->level == 3) {
            $list_of_org = DB::table('office')->where('is_organization', 1)->where('district_id', user_office_info()->district_id)->paginate(30);
        }
        //dd($list_of_org);
        $data['list_of_org'] = $list_of_org;
        $data['page_title'] = 'প্রতিষ্ঠানের তালিকা';
        return view('organization.organization_list')->with($data);
    }
    public function get_organization_edit($id)
    {
        //dd(decrypt($id));

        $data['organization'] = DB::table('office')->where('id', decrypt($id))->first();

        $data['page_title'] = 'প্রতিষ্ঠানের তথ্য সংশোধন';
        // return $data;
        // dd($data);
        return view('organization.organization_edit')->with($data);
    }
    public function post_organization_update(Request $request)
    {


        $request->validate(
            [

                'organization_routing_id' => ['required', new IsEnglish()],
                'organization_type' => 'required',
                'office_name_bn' => 'required',
                'office_name_en' => ['required', new IsEnglish()],
                'organization_physical_address' => 'required',
            ],
            [
                'organization_routing_id.required' => 'রাউটিং নং দিতে হবে',
                'organization_type.required' => 'প্রতিষ্ঠানের ধরন নির্বাচন করুন',
                'office_name_bn.required' => 'প্রতিষ্ঠানের নাম বাংলাতে দিন',
                'office_name_en.required' => 'প্রতিষ্ঠানের নাম ইংরেজিতে দিন',
                'organization_physical_address.required' => 'প্রতিষ্ঠানের ঠিকানা দিন',
            ],
        );

        $office['office_name_bn'] = $request->office_name_bn;
        $office['office_name_en'] = $request->office_name_en;
        $office['organization_type'] = $request->organization_type;
        $office['organization_physical_address'] = $request->organization_physical_address;
        $office['organization_routing_id'] = $request->organization_routing_id;
        $office['is_organization'] = 1;
        $office['is_varified_org'] = $request->active_status;

        $office_id = DB::table('office')->where([
            'id' => $request->office_id
        ])->update($office);


        return redirect()->back()->with('success', 'প্রতিষ্ঠান সঠিকভাবে আপডেট হয়েছে');
    }
    public function get_organization_add()
    {
        $user_office_info = user_office_info();

        if ($user_office_info->level == 4) {

            $data['division_id'] = $user_office_info->division_id;
            $data['div_name_bn'] = $user_office_info->div_name_bn;
            $data['district_id'] = $user_office_info->district_id;
            $data['dis_name_bn'] = $user_office_info->dis_name_bn;
            $data['upazila_list'] = DB::table('upazila')->where('division_id', $user_office_info->division_id)
                ->where('district_id', $user_office_info->district_id)->where('id', $user_office_info->upazila_id)->get();
        } elseif ($user_office_info->level == 3) {
            $data['division_id'] = $user_office_info->division_id;
            $data['div_name_bn'] = $user_office_info->div_name_bn;
            $data['district_id'] = $user_office_info->district_id;
            $data['dis_name_bn'] = $user_office_info->dis_name_bn;
            $data['upazila_list'] = DB::table('upazila')->where('division_id', $user_office_info->division_id)
                ->where('district_id', $user_office_info->district_id)->get();
        }

        $data['page_title'] = 'প্রতিষ্ঠানের তথ্য এন্ট্রি';
        return view('organization._certificate_asst_add_organization')->with($data);
    }
    public function post_organization_add(Request $request)
    {
        //dd($request);

        $request->validate(
            [

                'organization_routing_id' => ['required', 'unique:office,organization_routing_id', new IsEnglish()],
                'division_id' => 'required',
                'district_id' => 'required',
                'upazila_id' => 'required',
                'organization_type' => 'required',
                'office_name_bn' => 'required',
                'office_name_en' => ['required', new IsEnglish()],
                'organization_physical_address' => 'required',
            ],
            [
                'organization_routing_id.required' => 'রাউটিং নং দিতে হবে',
                'organization_routing_id.unique' => 'এই রাউটিং নং ইতিমধ্যেই ব্যবহৃত হয়েছে',
                'division_id.required' => 'বিভাগ নির্বাচন করুন',
                'district_id.required' => 'জেলা নির্বাচন করুন',
                'upazila_id.required' => 'উপজেলা নির্বাচন করুন',
                'organization_type.required' => 'প্রতিষ্ঠানের ধরন নির্বাচন করুন',
                'office_name_bn.required' => 'প্রতিষ্ঠানের নাম বাংলাতে দিন',
                'office_name_en.required' => 'প্রতিষ্ঠানের নাম ইংরেজিতে দিন',
                'organization_physical_address.required' => 'প্রতিষ্ঠানের ঠিকানা দিন',
            ],
        );



        $office['office_name_bn'] = $request->office_name_bn;
        $office['office_name_en'] = $request->office_name_en;
        $office['division_id'] = $request->division_id;
        $office['district_id'] = $request->district_id;
        $office['upazila_id'] = $request->upazila_id;
        $office['organization_type'] = $request->organization_type;
        $office['organization_physical_address'] = $request->organization_physical_address;
        $office['organization_routing_id'] = $request->organization_routing_id;
        $office['is_organization'] = 1;
        $office['is_varified_org'] = 1;
        $office_id = DB::table('office')->insertGetId($office);

        if ($office_id) {
            return redirect()->route('get.organization.list')->with('success', 'প্রতিষ্ঠান সঠিকভাবে যুক্ত হয়েছে');
        }
    }

    public function get_organization_change_by_applicant()
    {
        $data['page_title'] = 'প্রাতিষ্ঠানিক প্রতিনিধির প্রতিষ্ঠান পরিবর্তন ফরম';

        $data['division'] = DB::table('division')->get();
        $data['division'] = DB::table('division')->get();
        $data['division'] = DB::table('division')->get();
        return view('organization._change_office_applicant')->with($data);
    }
    public function post_organization_change_by_applicant(Request $request)
    {
        $case_cout = OrganizationCaseMappingRepository::employeeOrgizationCaseMappingOnTrasferValidation();

        //dd($case_cout);

        if ($case_cout == 0 || $case_cout > 1) {
            $trasfer_flag = true;
        } else {
            $trasfer_flag = false;
        }
        if (!$trasfer_flag) {
            return redirect()->back()->with('organization_case_error', 'আপনি আপনার বর্তমান প্রতিষ্ঠানে চলমান মামলা গুলোর জন্য প্রতিনিধি যোগ করলে , আপনি আপনার নতুন প্রতিষ্ঠানে পরিবর্তন করতে পারবেন');
        }

        $request->validate(
            [

                'organization_id' => ['required', new IsEnglish()],
                'division_id' => 'required',
                'district_id' => 'required',
                'upazila_id' => 'required',
                'organization_type' => 'required',
                'office_name_bn' => 'required',
                'office_name_en' => ['required', new IsEnglish()],
                'organization_physical_address' => 'required',
                'designation' => 'required',
                'organization_employee_id' => 'required'
            ],
            [
                'organization_id.required' => 'রাউটিং নং দিতে হবে',
                'division_id.required' => 'বিভাগ নির্বাচন করুন',
                'district_id.required' => 'জেলা নির্বাচন করুন',
                'upazila_id.required' => 'উপজেলা নির্বাচন করুন',
                'organization_type.required' => 'প্রতিষ্ঠানের ধরন নির্বাচন করুন',
                'office_name_bn.required' => 'প্রতিষ্ঠানের নাম বাংলাতে দিন',
                'office_name_en.required' => 'প্রতিষ্ঠানের নাম ইংরেজিতে দিন',
                'organization_physical_address.required' => 'প্রতিষ্ঠানের ঠিকানা দিন',
                'designation.required' => 'পদবী দিতে হবে',
                'organization_employee_id.required' => 'প্রতিনিধির EmployeeID দিতে হবে'
            ],
        );
        if ($request->office_id == "OTHERS") {

            $office['office_name_bn'] = $request->office_name_bn;
            $office['office_name_en'] = $request->office_name_en;
            $office['division_id'] = $request->division_id;
            $office['district_id'] = $request->district_id;
            $office['upazila_id'] = $request->upazila_id;
            $office['organization_type'] = $request->organization_type;
            $office['organization_physical_address'] = $request->organization_physical_address;
            $office['organization_routing_id'] = $request->organization_id;
            $office['is_organization'] = 1;

            $office_id = DB::table('office')->insertGetId($office);
        } else {
            $office_id = $request->office_id;
        }
        DB::table('users')->where('id', globalUserInfo()->id)->update([
            'designation' => $request->designation,
            'office_id' => $office_id
        ]);
        OrganizationCaseMappingRepository::employeeOrgizationCaseMappingOnTrasfer($office_id);

        return redirect()->route('dashboard')->with('success', 'আপনার প্রোফাইলে প্রতিষ্ঠান সঠিকভাবে আপডেট হয়েছে');
    }
}