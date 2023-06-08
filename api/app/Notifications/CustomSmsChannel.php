<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class CustomSmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toCustomSms($notifiable);

        $data = [
            'from' => $message->from,
            'to' => $notifiable->routeNotificationFor('custom_sms'),
            'text' => $message->content,
            'reference' => $message->reference,
        ];

        $ch = curl_init('https://messaging-service.co.tz/api/sms/v1/test/text/single');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic aW0yM246MjNuMjNu',
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        Log::info('SMS sent to '.$notifiable->routeNotificationFor('custom_sms').' with message: '.$message->content);
    }
}
