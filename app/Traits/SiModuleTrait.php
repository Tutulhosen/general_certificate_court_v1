<?php
// TokenVerificationTrait.php

namespace App\Traits;

trait SiModuleTrait
{

    protected $idpData = [
        'idp_email' => '',
        'idp_password' => '',
        'idp_api_key' => '',
        'idp_url' => ''
    ];

    public function configureSiModule()
    {
        if (app()->environment(['production'])) {
            $this->idpData = [
                'idp_email' => "agricultureuser@gmail.com",
                'idp_password' => "123456789",
                'idp_api_key' => "qwertyudfcvgbhn",
                'idp_url' => "https://agrisiapi.ubid.gov.bd"
            ];
        }

        if (app()->environment(['local', 'staging'])) {
            $this->idpData = [
                'idp_email' => "agriculturesiapi@gmail.com",
                'idp_password' => "123456789",
                'idp_api_key' => "qwertyudfcvgbhn",
                'idp_url' => "http://127.0.0.1:7870/"
            ];
        }
    }


    protected function getSiModule()
    {
        $this->configureSiModule();

        return $this->idpData;
    }
}
