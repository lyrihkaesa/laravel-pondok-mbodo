<?php

namespace App\Utilities;

class FinancialUtility
{
    public function __construct()
    {
        //
    }

    public static function getProductNameWithDate(string $productName, string|null $billDateTime): ?string
    {
        $billDateTimeCarbon = $billDateTime === null ? now() : \Illuminate\Support\Carbon::parse($billDateTime);
        return $productName . ' ' . $billDateTimeCarbon->translatedFormat('M Y');
    }
}
