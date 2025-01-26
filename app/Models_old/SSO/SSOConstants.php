<?php

namespace App\Models\SSO;

class SSOConstants
{
    const APP_ID = "T9OcHdOduiBblIulY4tkh1Io5TZ13FY2";
    const APP_NAME = "Certificate ecourt";
    const SHARED_SECRET = "MQtpe3YE5x0qm6sIkn9hoeWAWaKe8JaVZYSMQa5ChswbO0uLOxfsxYXzA6414H5xrmni2CPAakWcalTxcLOYpWBGa8ogo6jAX42gUo7xz52Fjxp1lXCpcZ64joDw8IiJAS9JbTaF6wnBfI8AdXqileC4CijnkPx4slpnfjknRIAXPml8gA5wD8j8Lei5n9tIQJlcezDgoY6J7ePSLXRWWqiUKi9ihEXjzUQifEYYA9JcFwJY5HsfaY4ISQ4Qbmph";
    const IDP_URL = "http://idp.doptor.gov.bd";
    const APP_NAME_QS = "appName";
    const APP_ID_QS = "appId";
    const APP_LOGIN_ENDPOINT ="applogin";
    const IA_LOGIN_ENDPOINT = "interapplogin";
	const AUTHORIZE_END_POINT = "authorize";
	const SLO_END_POINT = "ssologout";
    const TOKEN_EXP_DATE = "180000";
	// const REDIRECT_URI = "http://gcc.ecourt.gov.bd/applogin";
	// const LANDING_PAGE_URI = "http://gcc.ecourt.gov.bd/home";
	// const LOGIN_PAGE_URI = "http://gcc.ecourt.gov.bd/";


   const REDIRECT_URI = "http://localhost/minar/gcc_ecourt/public/applogin";
   const LANDING_PAGE_URI = "http://localhost/minar/gcc_ecourt/public/home";
   const LOGIN_PAGE_URI = "http://localhost/minar/gcc_ecourt/public/";

    const USERNAME = "username";
    const EMPLOYEE_RECORD_ID = "employee_record_id";
    const OFFICE_ID = "office_id";
    const DESIGNATION = "designation";
    const OFFICE_UNIT_ID = "office_unit_id";
    const INCHARGE_LABEL = "incharge_label";
    const OFFICE_UNIT_ORGANOGRAM_ID = "office_unit_organogram_id";
    const OFFICE_NAME_ENG = "office_name_eng";
    const OFFICE_NAME_BNG = "office_name_bng";
    const OFFICE_MINISTRY_ID = "office_ministry_id";
    const OFFICE_MINISTRY_NAME_ENG = "office_ministry_name_eng";
    const OFFICE_MINISTRY_NAME_BNG = "office_ministry_name_bng";
    const UNIT_NAME_ENG = "unit_name_eng";
    const UNIT_NAME_BNG = "unit_name_bng";
    const FROM_APP_NAME = "fromAppName";
    const FROM_APP_ID = "fromAppId";
    const TO_APP_NAME = "toAppName";
    const TO_APP_ID = "toAppId";
    const LANDING_PAGE_URL = "landingpageurl";
    const TOKEN_EXP_TIME_TEXT = "expirationTime";
}