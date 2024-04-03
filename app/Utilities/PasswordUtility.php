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
     * Generate password berdasarkan nama, 4 angka nomor handphone terakhir, dan tanggal lahir format: 'dmY', contoh: 09092002
     */
    public static function generatePassword(string $name, string $phone, string $birthDate): string
    {
        // Generate password berdasarkan nama, 4 angka nomor handphone terakhir, dan tanggal lahir
        $name_parts = explode(" ", $name ?? 'Unnamed'); // Pisahkan string berdasarkan spasi
        $firstName = $name_parts[0]; // Ambil bagian pertama
        $firstName = strtolower($firstName); // Ubah ke huruf kecil jika diperlukan
        return $firstName . substr($phone, -4) . date('dmY', strtotime($birthDate));
    }
}
