<?php

namespace App\Models\SSO;

class SSOValues
{
	public function getAppId(){
		return SSOConstants::APP_ID;
	}

	public function getAppName(){
		return SSOConstants::APP_NAME;
	}

	public function getSharedSecret(){
		return SSOConstants::SHARED_SECRET;
	}

	public function getIdpUrl(){
		return SSOConstants::IDP_URL;
	}

	public function getAppNameQS(){
		return SSOConstants::APP_NAME_QS;
	}

	public function getAppIdQS(){
		return SSOConstants::APP_ID_QS;
	}

	public function getAppLoginEndPoint(){
		return SSOConstants::APP_LOGIN_ENDPOINT;
	}

	public function getIALoginEndPoint(){
		return SSOConstants::IA_LOGIN_ENDPOINT;
	}

	public function getTokenExpInterval(){
		return SSOConstants::TOKEN_EXP_DATE;
	}
	
	public function getAuthorizeEndPoint(){
		return SSOConstants::AUTHORIZE_END_POINT;
	}
	
	public function getSLOEndPoint(){
		return SSOConstants::SLO_END_POINT;
	}

	public function getLandingPageUrl(){
		return SSOConstants::LANDING_PAGE_URI;
	}
	
	public function getRedirectUrl(){
		return SSOConstants::REDIRECT_URI;
	}
	
	public function getLoginPageUrl(){
		return SSOConstants::LOGIN_PAGE_URI;
	}
}