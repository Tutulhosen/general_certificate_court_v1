<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    public function index()
    {
        $data['role'] = DB::table('role')->where('is_gcc', 1)->where('in_action', 1)->get();
        $data['permission'] = DB::table('permission')->where('status', 1)->get();

        $data['page_title'] = 'রোল পারমিশন ফর্ম';
        return view('role_permission.index')->with($data);
    }
    public function show_permission(Request $request)
    {

        $assigned_permission = DB::table('role_permission')->where('role_id', $request->id)->where('status', 1)->select('permission_id')->get();

        $assigned_permissions = [];
        foreach ($assigned_permission as $assigned_permission) {
            array_push($assigned_permissions, $assigned_permission->permission_id);
        }
        $permission = DB::table('permission')->where('status', 1)->get();

        $html = ' ';
        $html .= '<table class="table table-hover mb-6 font-size-h6">
        <thead class="thead-light">
            <tr>
                <!-- <th scope="col" width="30">#</th> -->
                <th scope="col">
                    সিলেক্ট করুণ
                </th>
                <th scope="col">নাম</th>

            </tr>
        </thead>
        <tbody>';

        foreach ($permission as $permissions) {

            $checked = in_array($permissions->id, $assigned_permissions) ? 'checked' : '';
            $html .= '<tr>';
            $html .= '<td>';
            $html .= '<div class="checkbox-inline">';
            $html .= '<label class="checkbox">';
            $html .= '<label class="checkbox">';
            $html .= '<input type="checkbox" name="role_permisson[]"
                                value="' . $permissions->id . '" class="role_permission_check" ' . $checked . '/><span></span>';
            $html .= '</div>
                </td>
                <td>' . $permissions->name . '</td>';
            $html .= '<tr>';
        }
        $html .= '</tbody>
                </table>';
        return response()->json([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function store(Request $request)
    {
        //$upzilla_case_mapping = $request->upzilla_case_mapping;
        //$court_id = $request->court_id;


        $assigned_permission = DB::table('role_permission')->where('role_id', $request->role_id)->where('status', 1)->select('permission_id')->get();

        $assigned_permissions = [];
        foreach ($assigned_permission as $assigned_permission) {
            array_push($assigned_permissions, $assigned_permission->permission_id);
        }



        $request_permission = array();
        if (!empty($request->role_permisson)) {

            foreach ($request->role_permisson as $role_permisson) {
                array_push($request_permission, $role_permisson);

                if (!in_array($role_permisson, $assigned_permissions)) {


                    DB::table('role_permission')->insert([
                        'role_id' => $request->role_id,
                        'permission_id' => $role_permisson,
                        'status' => 1,
                    ]);

                }

            }
        }


        foreach ($assigned_permissions as $role_permisson) {

            if (!in_array($role_permisson, $request_permission)) {

                DB::table('role_permission')->where('permission_id', $role_permisson)
                    ->where('role_id', $request->role_id)
                    ->update(array('status' => 0));

                //echo $up_id;

            }

        }

        return response()->json([
            'status' => 'success',

        ]);
    }
}
