<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Provider\GenericProvider;

class OAuthController extends Controller
{
    private function getProvider(): GenericProvider
    {
        $service_structure = [
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
        return new GenericProvider([
            'clientId' => env('OAUTH_CLIENT_ID'),
            'clientSecret' => env('OAUTH_CLIENT_SECRET'),
            'redirectUri' => env('OAUTH_REDIRECT_URI'),
            'urlAuthorize' => env('OAUTH_URL_AUTHORIZE'),
            'urlAccessToken' => env('OAUTH_URL_ACCESS_TOKEN'),
            'urlResourceOwnerDetails' => env('OAUTH_URL_RESOURCE_OWNER_DETAILS'),
            'scopes' => base64_encode(json_encode($service_structure))
        ]);
    }

    public function redirectToProvider(): RedirectResponse
    {
        $provider = $this->getProvider();
        $authorizationUrl = $provider->getAuthorizationUrl();

        // Save state for CSRF protection
        Session::put('oauth2state', $provider->getState());

        return redirect($authorizationUrl);
    }

    public function handleCallback(Request $request): JsonResponse
    {
        $provider = $this->getProvider();

        // Validate state
        if (empty($request->state) || $request->state !== Session::get('oauth2state')) {
            Session::forget('oauth2state');
            abort(403, 'Invalid OAuth state');
        }

        // Get access token
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $request->code
        ]);

        // Get user details
        $user = $provider->getResourceOwner($token);

        return response()->json([
            'access_token' => $token->getToken(),
            'refresh_token' => $token->getRefreshToken(),
            'expires' => $token->getExpires(),
            'user' => $user->toArray()
        ]);
    }
}
