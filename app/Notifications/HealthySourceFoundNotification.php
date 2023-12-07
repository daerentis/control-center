<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Spatie\BackupServer\Notifications\Notifiable;

class HealthySourceFoundNotification extends Notification
{
    use Queueable;

    public function send(Notifiable $notifiable, $notification)
    {
        Http::get('https://uptime.betterstack.com/api/v1/heartbeat/QasrLtF1XFJZBcFx6EzgJkL4');
    }
}
