<?php

namespace App\Models\SSO;

use Firebase\JWT\JWT;

class InterAppLoginRequest
{
    private $ssoValues;
    private $ssoToken;

    function __construct(){
        $this->ssoValues = new SSOValues();
        $this->ssoToken = new SSOToken();
    }

    public function getIALoginReqInfoAjax($username,$toAppName,$landingPageUrl){

        $response = array(
                "success" => 1,
                "action"  => $this->getPostEndPoint(),
                "appName" => $this->ssoValues->getAppName(),
                "token"   => $this->getToken($username,$toAppName,$landingPageUrl)
            );
        return json_encode($response);
    }

    public function getPostEndPoint(){
        return $this->ssoValues->getIdpUrl() . "/" . $this->ssoValues->getIALoginEndPoint();
    }

    public function getToken($username,$toAppName,$landingPageUrl){      
        $key = $this->ssoValues->getSharedSecret();

        $token = array(
                SSOConstants::USERNAME => $username,
                SSOConstants::FROM_APP_NAME => $this->ssoValues->getAppName(),
                SSOConstants::TO_APP_NAME => $toAppName,
                SSOConstants::LANDING_PAGE_URL => $landingPageUrl,
                SSOConstants::TOKEN_EXP_TIME_TEXT => $this->ssoToken->getExpiryTime()
            );

        $jwt = JWT::encode($token, $key, 'HS256');

        return $jwt;
    }    
}