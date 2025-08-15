<?php

namespace App\Services;

use App\Models\Customer;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;
use Storage;

class DanProvider extends AbstractProvider
{
    protected $scopes = [
        [
            'services' => [
                "WS100101_getCitizenIDCardInfo",
            ],
            'wsdl' => "https://xyp.gov.mn/citizen-1.3.0/ws?WSDL",                    // wsdl зам
            // Оролтын параметргүй дуудагддаг сервис
        ],
        // [
        //     'services' => [
        //         "WS100101_getCitizenIDCardInfo",                                         // сервис код
        //     ],
        //     'wsdl' => "https://xyp.gov.mn/property-1.3.0/ws?WSDL",                   // wsdl зам
        //     // 'params' => [                                                             // Оролтын параметртэй дуудагддаг сервис бол
        //     //     "WS100101_getCitizenIDCardInfo" => [                                       // сервис ко[]
        //     //         'propertyNumber' => 'value',                                      // Оролтын параметрууд
        //     //     ],
        //     // ]
        // ]
    ];
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(config('OAUTH_URL_AUTHORIZE', 'https://sso.gov.mn/oauth2/authorize'), $state);
    }
    protected function formatScopes(array $scopes, $scopeSeparator)
    {
        return base64_encode(json_encode($scopes));
    }
    protected function getTokenUrl()
    {
        return config('OAUTH_URL_ACCESS_TOKEN', 'https://sso.gov.mn/oauth2/token');
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(config('OAUTH_URL_RESOURCE_OWNER_DETAILS', "https://sso.gov.mn/oauth2/api/v1/service"), [
            'headers' => ['Authorization' => 'Bearer ' . $token],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function mapUserToObject(array $user)
    {
        $ss = $user[1]['services']['WS100101_getCitizenIDCardInfo']['response'];


        return (new User())->setRaw($ss)->map([
            'regnum' => $ss['regnum'],
            'firstname' => $ss['firstname'],
            'gender' => $ss['gender'],
            'image' => $ss['image'],
            'lastname' => $ss['lastname'],
            'nationality' => $ss['nationality'],
            'passportAddress' => $ss['passportAddress'],
            'passportExpireDate' => $ss['passportExpireDate'],
            'passportIssueDate' => $ss['passportIssueDate'],

            'soumDistrictCode' => $ss['soumDistrictCode'],
            'soumDistrictName' => $ss['soumDistrictName'],
            'surname' => $ss['surname'],
        ]);

    }
}

