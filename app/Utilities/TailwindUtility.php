<?php

namespace App\Utilities;

class TailwindUtility
{
    public function __construct()
    {
        //
    }

    public static function getBackgroundClass(int $iteration): string
    {
        if ($iteration % 3 === 0) {
            return ' bg-gray-300 dark:bg-gray-900 ';
        } elseif ($iteration % 2 === 0) {
            return ' bg-gray-200 dark:bg-gray-800 ';
        } else {
            return ' bg-gray-100 dark:bg-gray-700 ';
        }
    }
}
