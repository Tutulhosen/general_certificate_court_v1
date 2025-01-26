<?php
/**
 * Created by PhpStorm.
 * User: pranab
 * Date: 11/16/17
 * Time: 12:51 PM
 */

namespace App\Services;

use http\Env\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AppPermissionService
{
    public static function checkPermission($username,$permissionCode)
    {

        $users = DB::table('user_roles')
            ->join('role_permissions', 'user_roles.role_code', '=', 'role_permissions.role_code')
            ->join('user_applications', 'user_roles.username', '=', 'user_applications.username')
            ->select('role_permissions.*', 'user_applications.application_code', 'user_roles.role_code')
            ->where('user_roles.username', $username)
            ->get();
        foreach ($users as $user){
            if($user->permission_code == $permissionCode){
                return true;
            }
        }
        // TODO: Access session variable, check conditions and return true/false
    }
    public static function checkPermissionWithLevel($usersPermissions,$permissionCode)
    {
        foreach ($usersPermissions as $role){
            if($role->permission_code == $permissionCode){
                return true;
            }
        }
        // TODO: Access session variable, check conditions and return true/false
    }
    public static function CheckDatabaseName($districtId)
    {
        $dbName = DB::table('app_configs')
            ->select('app_configs.db_name')
            ->where('app_configs.district_code', $districtId)
            ->where('app_configs.app_code', 'ecourt_certificate')
            ->first();
        return $dbName;
        // TODO: Access session variable, check conditions and return true/false
    }
    public static function getDatabaseNames()
    {
        $dbName = DB::table('app_configs')
            ->select('app_configs.db_name')
            ->where('app_configs.app_code', 'ecourt_certificate')
            ->get();
        return $dbName;
        // TODO: Access session variable, check conditions and return true/false
    }
}