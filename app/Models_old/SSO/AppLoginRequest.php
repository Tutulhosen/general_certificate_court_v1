<?php

namespace App\Models\SSO;

class AppLoginRequest
{
	private $ssoValues;
	private $cryptoUtil;
	private $nonce;
	private $landingPageUrl;

	function __construct(){
		$this->ssoValues = new SSOValues();
		$this->cryptoUtil = new CryptoUtil();
		$this->landingPageUrl = "";
	}
	
	public function getReqNonce(){
		return $this->nonce;
	}
	
	public function setLandingPageUrl($landingPageUrl){
		$this->landingPageUrl = $landingPageUrl;
	}

    public function buildRequest(){ 
    	$requestUrl = $this->ssoValues->getIdpUrl() . "/" . $this->ssoValues->getAuthorizeEndPoint() . "?"; // $this->ssoValues->getAppNameQS() . "=" . $this->ssoValues->getAppName();
		$this->nonce = $this->cryptoUtil->getToken(10);

		if(!$this->landingPageUrl){
			$this->landingPageUrl = $this->ssoValues->getLandingPageUrl();
		}

		$data = array(
			'response_type' => 'id_token',
			'response_mode' => 'form_post',
			'client_id' => $this->ssoValues->getAppId(),
			'scope' => 'openid',
			'redirect_uri' => $this->ssoValues->getRedirectUrl(),
			'landing_page_uri' => $this->landingPageUrl,
			'state' => $this->cryptoUtil->getToken(10),
			'nonce' => $this->nonce
		);
    	return $requestUrl . http_build_query($data);
    }
}