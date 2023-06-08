<?php

namespace App\Notifications;

use App\Notifications\Messages\CustomSmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SendOTP extends Notification implements ShouldQueue
{
    use Queueable;

    public $phone;
    public $code;

    public function __construct($phone, $code)
    {
        $this->phone = $phone;
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['messaging-service'];
    }
    
    public function toCustomSms($notifiable)
    {
        return (new CustomSmsMessage)
            ->from('N-SMS')
            ->content("Your OTP is {$this->code}")
            ->reference('aswqetgcv');
    }

    public function toArray($notifiable)
    {
        return [
            'phone' => $this->phone,
            'code' => $this->code,
        ];
    }
}
