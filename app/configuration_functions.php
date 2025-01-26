<?php

if (!function_exists('mobile_first_registration')) {
    function mobile_first_registration()
    {
        return true;
    }
}

if (!function_exists('citizen_auth_menu')) {
    function citizen_auth_menu()
    {
        if (!mobile_first_registration()) {

            return true;
        } elseif (mobile_first_registration() && globalUserInfo()->is_verified_account == 1 && in_array(globalUserInfo()->role_id, [35, 36])) {
            return true;
        } elseif (mobile_first_registration() && globalUserInfo()->is_verified_account == 0 && !in_array(globalUserInfo()->role_id, [35, 36])) {
            return true;
        } elseif (mobile_first_registration() && globalUserInfo()->is_verified_account == 0 && globalUserInfo()->is_cdap_user == 1 && in_array(globalUserInfo()->role_id, [35, 36])) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('pull_from_api_not_local_dummi')) {
    function pull_from_api_not_local_dummi()
    {
        return true;
    }
}
