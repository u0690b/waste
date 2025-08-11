<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\WebPushConfig;
use Exception;
use Illuminate\Support\Facades\Log;

class FirebaseMessagingService
{
    protected $messaging;
    public function __construct()
    {
        // Define the path to your service account file
        // It's better to use a configuration variable here
        $serviceAccountPath = storage_path('app/firebase_credentials.json');

        if (!file_exists($serviceAccountPath)) {
            // Handle the error - the credentials file is missing!
            // In a real app, you'd log this or throw a more specific exception
            throw new Exception("Firebase service account file not found at: " . $serviceAccountPath);
        }

        // Initialize Firebase Admin SDK
        // You could potentially do this initialization once in a service provider
        // and inject the $messaging instance into this class's constructor.
        $factory = (new Factory)
            ->withServiceAccount($serviceAccountPath);

        $firebase = $factory->createMessaging();
        $this->messaging = $firebase;
    }
    public static function send(array $tokens, array $notification, array $data = [])
    {
        return Http::acceptJson()->withToken(config('fcm.token'))->post(
            'https://fcm.googleapis.com/v1/projects/waste-project-49d6d/messages:send',
            [
                'registration_ids' => $tokens,
                // 'to' => $token,
                'notification' => $notification,
                'data' => $data
            ]
        );
    }
    /**
     * Sends a push notification to a specific device token.
     *
     * @param string $deviceToken The FCM registration token of the target device.
     * @param string $title The title of the notification.
     * @param string $body The body text of the notification.
     * @param array $data Optional: Custom data payload (key-value pairs).
     * @return array|null The result of the send operation, or null on error.
     */
    public function sendNotificationToDevice(string $deviceToken, string $title, string $body, array $data = []): ?array
    {
        // Create a basic notification payload
        $notification = Notification::create($title, $body);
        $config = WebPushConfig::fromArray([
            'fcm_options' => [
                'link' => 'https://waste.mecc.gov.mn/mobile',
            ],
        ]);
        // Build the message targeting the specific device token
        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification)
             //->withWebPushConfig($config)
            ->withData($data); // Add any custom data

        try {
            // Send the message
            $sendReport = $this->messaging->send($message);

            // You can inspect the $sendReport for details about the outcome
            // For single messages, it's usually a simple success/failure.
            // For multiple messages, it gives detailed results for each.
            // For this example, we'll just return a success indicator.
            return ['success' => true, 'messageId' => $sendReport];
        } catch (Exception $e) {
            // Handle exceptions (e.g., invalid token, network issues)
            // In a real app, you'd log the error:
            Log::error('FCM Send Error', ['error' => $e->getMessage(), 'token' => $deviceToken]);
            echo "Error sending FCM message: " . $e->getMessage(); // For demonstration

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Sends a push notification to a topic.
     *
     * @param string $topic The topic name (e.g., 'weather_alerts').
     * @param string $title The title of the notification.
     * @param string $body The body text of the notification.
     * @param array $data Optional: Custom data payload (key-value pairs).
     * @return array|null The result of the send operation, or null on error.
     */
    public function sendNotificationToTopic(string $topic, string $title, string $body, array $data = []): ?array
    {
        // Create a basic notification payload
        $notification = Notification::create($title, $body);
        $config = WebPushConfig::fromArray([
            'fcm_options' => [
                'link' => 'https://waste.mecc.gov.mn/mobile',
            ],
        ]);
        // Build the message targeting the topic
        $message = CloudMessage::withTarget('topic', $topic)
            ->withNotification($notification)
            ->withWebPushConfig($config)
            ->withData($data); // Add any custom data

        try {
            // Send the message
            $sendReport = $this->messaging->send($message);

            // Similar to sending to a token, inspect $sendReport for results.
            return ['success' => true, 'messageId' => $sendReport];
        } catch (Exception $e) {
            // Handle exceptions
             Log::error('FCM Topic Send Error', ['error' => $e->getMessage(), 'topic' => $topic]);
            echo "Error sending FCM message to topic: " . $e->getMessage(); // For demonstration

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // You could add methods for sending to multiple tokens, conditions, etc.

}
