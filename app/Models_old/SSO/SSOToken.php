<?php

namespace App\Models\SSO;

class SSOToken {
    private $ssoValues;

    function __construct(){
        $this->ssoValues = new SSOValues();
    }

    public function getExpiryTime(){
        $t = round(microtime(true)*1000) + $this->ssoValues->getTokenExpInterval() + 0;
        return $t;
    }
}