<?php

class DaysOfWeek
{
    const MONDAY = 1;

    const TUESDAY = 2;

    const WEDNESDAY = 3;

    const THURSDAY = 4;

    const FRIDAY = 5;

    public static function getDayTextBulgarian($day)
    {
        switch ($day) {
            case self::MONDAY:
                return 'Понеделник';
            case self::TUESDAY:
                return 'Вторник';
            case self::WEDNESDAY:
                return 'Сряда';
            case self::THURSDAY:
                return 'Четвъртък';
            case self::FRIDAY:
                return 'Петък';
            default:
                return 'Invalid day';
        }
    }

    public static function getDayTextEnglish($day)
    {
        switch ($day) {
            case self::MONDAY:
                return 'Monday';
            case self::TUESDAY:
                return 'Tuesday';
            case self::WEDNESDAY:
                return 'Wednesday';
            case self::THURSDAY:
                return 'Thursday';
            case self::FRIDAY:
                return 'Friday';
            default:
                return 'Invalid day';
        }
    }
}
