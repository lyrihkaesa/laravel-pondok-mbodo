<?php

namespace App\Utilities;

class NikUtility
{
    public function __construct()
    {
        //
    }

    public static $arrayStringProvince = [
        '11',
        '12',
        '13',
        '14',
        '15',
        '16',
        '17',
        '18',
        '19',
        '21',
        '31',
        '32',
        '33',
        '34',
        '35',
        '36',
        '51',
        '52',
        '53',
        '61',
        '62',
        '63',
        '64',
        '65',
        '71',
        '72',
        '73',
        '74',
        '75',
        '76',
        '81',
        '82',
        '91',
        '92',
        '93',
        '94',
        '95'
    ];

    public static $provinces = [
        11 => "Aceh",
        12 => "Sumatera Utara",
        13 => "Sumatera Barat",
        14 => "Riau",
        15 => "Jambi",
        16 => "Sumatera Selatan",
        17 => "Bengkulu",
        18 => "Lampung",
        19 => "Kepulauan Bangka Belitung",
        21 => "Kepulauan Riau",
        31 => "Dki Jakarta",
        32 => "Jawa Barat",
        33 => "Jawa Tengah",
        34 => "Daerah Istimewa Yogyakarta",
        35 => "Jawa Timur",
        36 => "Banten",
        51 => "Bali",
        52 => "Nusa Tenggara Barat",
        53 => "Nusa Tenggara Timur",
        61 => "Kalimantan Barat",
        62 => "Kalimantan Tengah",
        63 => "Kalimantan Selatan",
        64 => "Kalimantan Timur",
        65 => "Kalimantan Utara",
        71 => "Sulawesi Utara",
        72 => "Sulawesi Tengah",
        73 => "Sulawesi Selatan",
        74 => "Sulawesi Tenggara",
        75 => "Gorontalo",
        76 => "Sulawesi Barat",
        81 => "Maluku",
        82 => "Maluku Utara",
        91 => "Papua",
        92 => "Papua Barat",
        93 => "Papua Selatan",
        94 => "Papua Tengah",
        95 => "Papua Pegunungan",
    ];

    public static function parseNIK($nik, $femaleLabel = 'Perempuan', $maleLabel = 'Laki-Laki', $birthYearThreshold = 50)
    {
        // Memisahkan bagian NIK
        $province = substr($nik, 0, 2);
        $regency = substr($nik, 0, 4);
        $district = substr($nik, 0, 6);
        $birthDateDay = substr($nik, 6, 2);
        $birthDateMonth = substr($nik, 8, 2);
        $birthDateYear = substr($nik, 10, 2);


        // Menentukan jenis kelamin berdasarkan (hari lahir > 40) perempuan
        $gender = ($birthDateDay > 40) ? $femaleLabel : $maleLabel;

        // Jika (hari lahir > 40) harus di kurangi dulu dengan 40 baru hari sesuai dari range 1 - 31 sesuai bulan
        $birthDateDay = ($birthDateDay > 40) ? $birthDateDay - 40 : $birthDateDay;
        $birthDateDay = str_pad($birthDateDay, 2, '0', STR_PAD_LEFT);


        // Menentukan prefix/awalan tahun lahir berdasarkan threshold 50
        // Misal 88 menjadi 1988
        // Misal 33 menjadi 2033
        $intBirthDateYear = (int)$birthDateYear;
        $prefixDateYear = ($intBirthDateYear > $birthYearThreshold) ? "19" : "20";

        // Menggabungkan bagian-bagian NIK menjadi format tanggal lahir yang valid (yyyy-mm-dd)
        // Misal: 1988-09-09
        $birthDate = $prefixDateYear . $birthDateYear . '-' . $birthDateMonth . '-' . $birthDateDay;

        $result = new \stdClass();
        $result->province = $province;
        $result->regency = $regency;
        $result->district = $district;
        $result->birthDate = $birthDate;
        $result->gender = $gender;

        return $result;
    }
}
