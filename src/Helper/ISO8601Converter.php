<?php

declare(strict_types=1);

namespace App\Helper;

use DateTimeImmutable;

final class ISO8601Converter
{
    public static function convertISOToDateTime(string $dateString): DateTimeImmutable|false
    {
        return DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', $dateString);
    }

    public static function convertDateTimeToISO(DateTimeImmutable $dateTime): string
    {
        return $dateTime->format('Y-m-d\TH:i:s.u\Z');
    }

}
