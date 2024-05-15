<?php

namespace App\Utilities;

class FilamentUtility
{
    public function __construct()
    {
        //
    }

    public static function getNavigationSort(string $label): ?int
    {
        $navigationSort = [
            -99 => __('Profile'),
            -98 => __('Profile Student'),
            -97 => __('Profile Employee'),
            -89 => __('Student'),
            -88 => __('Employee'),
            -87 => __('Guardian'),
        ];

        $key = array_search($label, $navigationSort);

        return $key !== false ? $key : null;
    }
}
