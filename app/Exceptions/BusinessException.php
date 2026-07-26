<?php

namespace App\Exceptions;

use Exception;

class BusinessException extends Exception
{
    public function __construct(
        string $messageKey,
        public int $status = 422
    ) {
        // اینجا جادو اتفاق می‌افتد: قبل از پاس دادن به کلاس والد، ترجمه می‌کنیم
        $translatedMessage = __($messageKey);

        parent::__construct($translatedMessage);
    }
}
