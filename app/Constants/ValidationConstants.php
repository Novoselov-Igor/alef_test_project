<?php

declare(strict_types=1);

namespace App\Constants;

class ValidationConstants
{
    // Студенты
    public const MAX_NAME_LENGTH = 255;
    public const MAX_EMAIL_LENGTH = 255;

    // Классы
    public const MAX_CLASS_NAME_LENGTH = 100;

    // Лекции
    public const MAX_TOPIC_LENGTH = 200;
    public const MAX_DESCRIPTION_LENGTH = 1000;
}
