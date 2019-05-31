<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stelin\OVOID;

class OVOController extends Controller
{
    public function login($nohp){
        $ovoid = new OVOID();
        // dd($ovoid->login2FA($nohp)->getRefId());    

        $refid = "8d528fa3dabd45b0b0e166a258b3f49a";
        $otp = 2085;
        // echo $ovoid->login2FAVerify($refid, $otp, $nohp)->getUpdateAccessToken();

        $updateAccessToken = "b5a3205f1d5347ef84e6cbccda361b48";
        echo $ovoid->loginSecurityCode(351713, $updateAccessToken)->getAuthorizationToken();

        
    }
    
    public function balance() {
        $loginSecurityCode = "eyJhbGciOiJSUzI1NiJ9.eyJleHBpcnlJbk1pbGxpU2Vjb25kcyI6NjA0ODAwMDAwLCJjcmVhdGVUaW1lIjoxNTU4OTk2MjgzNjA3LCJzZWNyZXQiOiJzS1lIak9ldlcvNnEvdE1Dam5hQ3NGdmh1aGdaRnlsMEl1cUxqWm5DTEE5QThqSFlyRU1pQ05iM3N1TTV6Y3NONkRxWHdhSStTcWtVbG1PWFl1RVVqQ09JNE4xTkRrdUZJSXkzM056VkdEUi93Y3BzZTNiUGdwbjRIVjl0M3dqLzlJdnNvUlRCTGI1eU5kOFFaVkZSWlVJaWlTaDhQenpHa3FQRW5adU5sNkYwUUdYYjdUSHpidHhQbStxK0lZaVpoYzJ0RExidDV1VGZsZzFNaUNlTEdZTW12ZE9tQzF6OEc5U3RTMzdMdm1TL25TVmRSbjdJQTNGcEQzT1RpQjJTWmdzTXdaVlUwTzNPbHNEU2NZMmt3dW0xNmZ4TC9VckV6Z0hZSHBNbnJjeG1ZTi9NSUF0Q2ZsTHJxOHhES2ovL0J5QXZXL2lGUXVWYjl5U2tIcG1uQWgrcnU1U3MwMGxtd1UyVjdpR2tQMDA9In0.OougdJTewGqueTm7mJJRflG7EFmWNm1qXTWVftoYlEraM9cl-QyzvAW2A0hV_0JNOcbTK-Oouak0gTMEyUY7nc7gv_IywI-2pBXIY334sO80EEbcKMARwbzyV8y4hGdgjXoohDEZYQqJWg_oEiVr0Bj7VyYOVQJTqf0LhE0_uebua1x3XZmYNtxwY_1U_j80J2XfA4UXXhZdlqwDdKblH6qfqL3Jwxa1Prga3AfzHfBCOzg36yiuR3jWIoYNDw7GYDHbXQQpZyycJy-DbHVf8-6wlk5k9QDUpdw1xnZoHCpaj4ojwNTTYy5JvHvaX1OVfnBW48FKSO-vvDw7zfn6gQ";
        $ovoid = new OVOID($loginSecurityCode);
        dd($ovoid->balanceModel());
    }
}
