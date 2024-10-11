<?php

declare(strict_types=1);

namespace App\Services\Notification\Mail;

use App\Services\Notification\NotificationInterface;

class Mail implements NotificationInterface
{
    public function send(string $recipient, string $subject, string $content): void
    {
        //mail is sent here
    }
}
