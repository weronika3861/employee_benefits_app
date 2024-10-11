<?php

declare(strict_types=1);

namespace App\Services\Notification;

interface NotificationInterface
{
    public function send(string $recipient, string $subject, string $content): void;
}
