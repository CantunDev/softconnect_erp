<?php
namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function getCurrentDate()
    {
        return Carbon::now();
    }

    public static function getStartOfMonth()
    {
        return Carbon::now()->startOfMonth()->format('d-m-y');
    }

    public static function getEndOfMonth()
    {
        return Carbon::now()->endOfMonth()->format('d-m-y');
    }

    public static function getCurrentMonthName()
    {
        return Carbon::now()->translatedFormat('F');
    }

    public static function getDaysInMonth()
    {
        return Carbon::now()->daysInMonth;
    }

    public static function getCurrentDay()
    {
        return Carbon::now()->day;
    }

    public static function getCurrentMonth()
    {
        return Carbon::now()->month;
    }

    public static function getCurrentYear()
    {
        return Carbon::now()->year;
    }

    public static function getDaysPassed()
    {
        return Carbon::now()->day - 1;
    }

    public static function getMonthProgress()
    {
        $daysPassed = self::getDaysPassed();
        $daysInMonth = self::getDaysInMonth();
        return round(($daysPassed / $daysInMonth) * 100, 2);
    }
    
    public static function getMonthsOfYear()
    {
        $months = [];
        for ($month = 1; $month <= 12; $month++) {
            $months[$month] = Carbon::create()->month($month)->translatedFormat('F');
        }
        return $months;
    }
}
