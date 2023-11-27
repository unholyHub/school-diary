<?php

namespace App\Helpers;

use DateTime;
use DateTimeZone;

class DateTimeHelper
{
    private static $SQL_FORMAT = 'Y-m-d H:i';

    private static $ISO_FORMAT = 'Y-m-d\TH:i';

    public static function getTimeSQL()
    {
        return DateTimeHelper::getCurrentTimeInSofiaTimeZone(DateTimeHelper::$SQL_FORMAT);
    }

    public static function getTimeISO()
    {
        return DateTimeHelper::getCurrentTimeInSofiaTimeZone(DateTimeHelper::$ISO_FORMAT);
    }

    public static function convertTimeFormat($timeString)
    {
        $time = DateTime::createFromFormat('H:i:s', $timeString);
        return $time ? $time->format('H:i') : null;
    }

    private static function getCurrentTimeInSofiaTimeZone($format)
    {
        $sofiaTimeZone = new DateTimeZone('Europe/Sofia');
        $currentTime = new DateTime('now', $sofiaTimeZone);
        $currentTimeFormatted = $currentTime->format($format);
        return $currentTimeFormatted;
    }
}
