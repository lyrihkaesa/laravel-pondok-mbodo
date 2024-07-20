<?php

use Laravel\Dusk\Browser;

test('Registration Success', function () {
    $this->browse(function (Browser $browser) {
        $browser
            ->visit('/ppdb/formulir')
            ->type('#data\.name', 'Muhammad Ibnu')
            ->type('#data\.nik', '3315040909090021')
            ->click('@autoInputFormNik')
            ->waitForText('Apakah anda yakin ingin auto input data "Jenis Kelamin, Tempat dan Tanggal Lahir, Provinsi, Kabupaten/Kota, Kecamatan" dari NIK?', 10)
            ->press('Ya, input semuanya.')
            ->waitForText('Toroh', 10)
            ->type('#data\.address', 'Dusun Sendangsari')
            ->click('#data\.informasi-alamat > div > div > div > div:nth-child(4) > div > div > div.grid.gap-y-2 > div > div > div > div') // Klik untuk membuka dropdown
            ->pause(5000)
            ->click('#choices--datavillage-item-choice-2')
            ->type('#data\.rt', '005')
            ->type('#data\.rw', '007')
            ->press('Auto Generate Kode Pos')
            ->pause(5000)
            ->type('#data\.nisn', '111222333444')
            ->type('#data\.kip', '111222333444')
            ->type('#data\.current_name_school', 'SMP Negeri 1 Purwodadi')
            ->scrollIntoView('#data\.informasi-akademik > div > div > div > div:nth-child(4)')
            ->click('#data\.informasi-akademik > div > div > div > div:nth-child(4) > div > div > div.grid.gap-y-2 > div > div:nth-child(4) > label > span')
            ->type('#data\.phone', '6281234567890')
            ->type('#data\.email', 'ibnu@gmail.com')
            ->type('#data\.family_card_number', '3315040909090022')
            ->type('#data\.father_name', 'Marmin Suparjo')
            ->type('#data\.father_nik', '3315040909090023')
            ->type('#data\.father_job', 'Petani')
            ->type('#data\.father_phone', '6281234567890')
            ->type('#data\.father_address', 'Dusun Sendangsari RT005 RW007')
            ->type('#data\.mother_name', 'Dewi Wulandari')
            ->type('#data\.mother_nik', '3315040909090024')
            ->type('#data\.mother_job', 'Ibu Rumah Tangga')
            ->type('#data\.mother_phone', '6281234567890')
            ->type('#data\.mother_address', 'Dusun Sendangsari RT005 RW007')
            ->scrollIntoView('#data\.pernyataan-persetujuan')
            ->check('#data\.term_01')
            // ->check('#data\.term_02')
            ->check('#data\.term_03')
            ->check('#data\.term_04')
            ->check('#data\.term_05')
            ->check('#data\.term_06')
            ->check('#data\.term_07')
            ->scrollIntoView('#section-submit')
            ->pause(5000)
            ->click('#section-submit > div > div > button')
            ->waitForText('Pendaftaran Berhasil', 10)
            ->assertSee('Pendaftaran Berhasil');
    });
});
