<?php

namespace App\Models\SSO;

class AppLogoutRequest
{
	private $ssoValues;
	private $cryptoUtil;
	private $nonce;

	function __construct(){
		$this->ssoValues = new SSOValues();
		$this->cryptoUtil = new CryptoUtil();
	}
	
	public function getReqNonce(){
		return $this->nonce;
	}

    public function buildRequest(){ 
    	$requestUrl = $this->ssoValues->getIdpUrl() . "/" . $this->ssoValues->getSLOEndPoint() . "?"; // $this->ssoValues->getAppNameQS() . "=" . $this->ssoValues->getAppName();
				
		$data = array(
			'login_url' => $this->ssoValues->getLoginPageUrl()			
		);
    	return $requestUrl . http_build_query($data);
    }
}