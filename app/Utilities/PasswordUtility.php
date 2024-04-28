<?php

namespace App\Utilities;

class PasswordUtility
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Generate password berdasarkan tanggal lahir dan 4 angka nomor handphone terakhir
     */
    public static function generatePassword(string $name, string $phone, string $birthDate): string
    {
        return date('dmY', strtotime($birthDate)) . substr($phone, -4);
    }
}
