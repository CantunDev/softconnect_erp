<?php
namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function getCurrentDate()
    {
        return Carbon::now()->toDateString();
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

    public static function getDaysOfCurrentMonth()
    {
        $days = [];
        $currentMonth = self::getCurrentMonth();
        $currentYear = self::getCurrentYear();
        $daysInMonth = self::getDaysInMonth();
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($currentYear, $currentMonth, $day);
            $days[$day] = [
                // 'day_number' => $date->translatedFormat('j'), // Formato: día sin ceros iniciales
                'day' => $day,
                'day_name' => $date->translatedFormat('l'),
                'short_name' => $date->translatedFormat('D ').' '. $date->format('Y-m-d'),     // Día abreviado (ej: "Lun")
                'short_day' => $date->translatedFormat('D'),     // Día abreviado (ej: "Lun")
                'full_date' => $date->format('Y-m-d'),          // Fecha completa (ej: "2023-11-05")
                'formatted_date' => $date->translatedFormat('j F Y'), // Ej: "5 noviembre 2023"
                'is_weekend' => $date->isWeekend(),             // Booleano si es fin de semana
                'is_today' => $date->isToday()                  // Booleano si es hoy
            ];
        }
        
        return $days;
    }

       public static function capitalizeName($name)
    {
        if (empty($name)) {
            return '';
        }
        $name = trim($name);
        $name = mb_strtolower($name, 'UTF-8');
        // Capitalizar la primera letra de cada palabra
        $name = mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
        return $name;
    }

    public static function translateType($type)
{
    $translations = [
        'fixed' => 'Fijo',
        'temporal' => 'Temporal',
        'part-time' => 'Tiempo Parcial',
        'contractor' => 'Contratista',
        'internship' => 'Practicante',
        'freelance' => 'Freelance'
    ];
    
    return $translations[$type] ?? ucfirst($type);
}
}