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
        ];

        $key = array_search($label, $navigationSort);

        return $key !== false ? $key : null;
    }
}
