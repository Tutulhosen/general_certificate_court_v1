@php
use Illuminate\Support\Facades\DB;
global $menu;
$menu = [1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 29, 40, 101,42,114,43,110,44];
//114 is news settings

if (globalUserInfo()->role_id == 8) {

    $assigned_permission = DB::table('role_permission')
        ->where('role_id',8)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
} elseif (globalUserInfo()->role_id == 2) {
    $menu = [1, 4, 6, 7, 8, 9, 10, 11, 13,26, 27, 28, 40, 99,101,42,114,12,41,110,45,46];
} elseif (globalUserInfo()->role_id == 6) {
    $assigned_permission = DB::table('role_permission')
        ->where('role_id', 6)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
} elseif (globalUserInfo()->role_id == 7) {
    $assigned_permission = DB::table('role_permission')
        ->where('role_id', 7)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
} elseif (globalUserInfo()->role_id == 24) {
    $assigned_permission = DB::table('role_permission')
        ->where('role_id', 24)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
} elseif (globalUserInfo()->role_id == 25) {
    $assigned_permission = DB::table('role_permission')
        ->where('role_id', 25)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
} elseif (globalUserInfo()->role_id == 27) {
    $assigned_permission = DB::table('role_permission')
        ->where('role_id', 27)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
} elseif (globalUserInfo()->role_id == 28) {
    $assigned_permission = DB::table('role_permission')
        ->where('role_id', 28)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
} elseif (globalUserInfo()->role_id == 32) {
    $assigned_permission = DB::table('role_permission')
        ->where('role_id', 32)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
} elseif (globalUserInfo()->role_id == 33) {
    $assigned_permission = DB::table('role_permission')
        ->where('role_id', 33)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
} elseif (globalUserInfo()->role_id == 34) {
    $assigned_permission = DB::table('role_permission')
        ->where('role_id', 34)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
} elseif (globalUserInfo()->role_id == 35) {
    $assigned_permission = DB::table('role_permission')
        ->where('role_id', 35)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
} elseif (globalUserInfo()->role_id == 36) {
    $assigned_permission = DB::table('role_permission')
        ->where('role_id', 36)
        ->where('status', 1)
        ->select('permission_id')
        ->get();

    $assigned_permissions = [];
    foreach ($assigned_permission as $assigned_permission) {
        array_push($assigned_permissions, $assigned_permission->permission_id);
    }
    $menu = $assigned_permissions;
}

@endphp
