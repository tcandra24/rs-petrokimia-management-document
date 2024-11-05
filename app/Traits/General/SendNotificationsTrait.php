<?php

namespace App\Traits\General;

use Illuminate\Mail\Mailables\Attachment;

// Mail
use App\Jobs\SendMailJob;

// Notification
use App\Notifications\GeneralNotification;

trait SendNotificationsTrait
{
    public function sendEmail($dataEmail, $mailClass)
    {
        $mailTemplate = new $mailClass($dataEmail['content']);

        $data = [
            'email' => $dataEmail['detail']['email'],
            'name' => $dataEmail['detail']['name'],
            'cc' => $dataEmail['detail']['cc'],
            'template' => $mailTemplate
        ];

        dispatch(new SendMailJob($data));
    }

    public function sendNotification($user, $data)
    {
        $user->notify(new GeneralNotification($data['type'], $data['title'], $data['message'], $data['link'], $data['icon']));
    }
}
