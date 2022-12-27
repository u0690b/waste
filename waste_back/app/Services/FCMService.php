<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FCMService
{
    public static function send(array $tokens, array $notification, array $data = [])
    {
        return Http::acceptJson()->withToken(config('fcm.token'))->post(
            'https://fcm.googleapis.com/fcm/send',
            [
                'registration_ids' => $tokens,
                // 'to' => $token,
                'notification' => $notification,
                'data' => $data
            ]
        );
    }
}
