<?php

declare(strict_types=1);

namespace App\Services\Notification;

enum NotificationType
{
    case MAIL;
    //here can be added e.g. sms
}
