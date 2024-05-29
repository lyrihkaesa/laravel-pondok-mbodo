<?php

use App\Models\User;
use Livewire\Livewire;
use App\Models\Package;
use App\Models\Product;
use App\Models\Student;
use App\Models\Category;
use Database\Seeders\UserSeeder;
use Database\Seeders\PackageSeeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use App\Livewire\Ppdb\Registration;

beforeEach(function () {
    // Bersihkan data dalam database sebelum setiap pengujian
    Student::truncate();
});

it('renders successfully', function () {
    Livewire::test(Registration::class)
        ->assertStatus(200);
});

it('renders the student registration form', function () {
    Livewire::test(Registration::class)
        ->assertSee(__('Personal Identity'))
        ->assertSee(__('Address Information'))
        ->assertSee(__('Academic Information'))
        ->assertSee(__('Contact and Security Information'))
        ->assertSee(__('Parent Information'))
        ->assertSee(__('Terms and Conditions'))
        ->assertSee(__('Other'));
});

function getValidFormData()
{
    return [
        "name" => "Muhammad Faisal",
        "nik" => "3315040909090001",
        "gender" => "Laki-Laki",
        "birth_place" => "Kab. Grobogan",
        "birth_date" => "2009-09-09",
        "province" => "33",
        "regency" => "3315",
        "district" => "331504",
        "village" => "3315042013",
        "address" => "Dusun Sendang Sari",
        "rt" => "005",
        "rw" => "007",
        "postal_code" => 58171,
        "nisn" => "1234567890",
        "kip" => "1234567890",
        "current_name_school" => "SD Negeri 2 Danyang",
        "category" => "Santri Reguler",
        "current_school" => "SMP",
        "phone" => "6281231231231",
        "email" => "email@gmail.com",
        "family_card_number" => "3315040909090002",
        "father_name" => "Marmin Suparjo",
        "father_nik" => "3315040909090003",
        "father_job" => "Petani",
        "father_phone" => "6281231231231",
        "father_address" => "Alamat Ayah",
        "mother_name" => "Alis Susanti",
        "mother_nik" => "3315040909090004",
        "mother_job" => "Ibu Rumah Tangga",
        "mother_phone" => "6281231231231",
        "mother_address" => "Alamat Ibu",
        "guardians" => [
            0 => [
                "name" => "Bangek Sadam Husain",
                "relationship" => "Saudara Laki-Laki",
                "nik" => "3315040909090005",
                "job" => "Mahasiswa",
                "phone" => "6281231231231",
                "address" => "Alamat Kakak Laki-Laki",
            ],
        ],
        "term_01" => true,
        "term_03" => true,
        "term_04" => true,
        "term_05" => true,
        "term_06" => true,
        "term_07" => true,
    ];
}

it('submits the form with valid data student', function ($item) {
    $data = getValidFormData();

    $data['gender'] = $item['gender'];
    $data['category'] = $item['category'];
    $data['current_school'] = $item['current_school'];

    // Mengisi formulir dengan data yang valid
    Livewire::test(Registration::class)
        ->set('data', $data)
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertSeeText(__('Student Register Success'))
        ->assertSet('data.term_01', $data['term_01'])
        ->assertSet('isSuccessful', true); // Pastikan variabel isSuccessful diatur ke true

    $student = Student::where('nik', $data['nik'])->first();
    expect($student)->not->toBeNull();

    expect($student->guardians)->toHaveCount(3);

    $packageModel = Package::with('products')->whereHas('categories', function ($query) use ($data) {
        $query->whereIn('name', ['Biaya Pendaftaran', $data["gender"], $data["category"], $data["current_school"]]);
    }, '=', 4)->first();

    expect($packageModel)->not()->toBeNull();
    expect($packageModel->name)->toBe($item['package']);
    expect($student->products)->toHaveCount($packageModel->products->count());
})->with([
    'Pendaftaran PAUD/TK Putra Reguler' => collect(['gender' => 'Laki-Laki', 'category' => 'Santri Reguler', 'current_school' => 'PAUD/TK', 'package' => 'Pendaftaran PAUD/TK Putra Reguler']),
    'Pendaftaran PAUD/TK Putri Reguler' => collect(['gender' => 'Perempuan', 'category' => 'Santri Reguler', 'current_school' => 'PAUD/TK', 'package' => 'Pendaftaran PAUD/TK Putri Reguler']),
    'Pendaftaran MI Putra Reguler' => collect(['gender' => 'Laki-Laki', 'category' => 'Santri Reguler', 'current_school' => 'MI', 'package' => 'Pendaftaran MI Putra Reguler']),
    'Pendaftaran MI Putri Reguler' => collect(['gender' => 'Perempuan', 'category' => 'Santri Reguler', 'current_school' => 'MI', 'package' => 'Pendaftaran MI Putri Reguler']),
    'Pendaftaran SMP Putra Reguler' => collect(['gender' => 'Laki-Laki', 'category' => 'Santri Reguler', 'current_school' => 'SMP', 'package' => 'Pendaftaran SMP Reguler']),
    'Pendaftaran SMP Putri Reguler' => collect(['gender' => 'Perempuan', 'category' => 'Santri Reguler', 'current_school' => 'SMP', 'package' => 'Pendaftaran SMP Reguler']),
    'Pendaftaran MA Putra Reguler' => collect(['gender' => 'Laki-Laki', 'category' => 'Santri Reguler', 'current_school' => 'MA', 'package' => 'Pendaftaran MA Reguler']),
    'Pendaftaran MA Putri Reguler' => collect(['gender' => 'Perempuan', 'category' => 'Santri Reguler', 'current_school' => 'MA', 'package' => 'Pendaftaran MA Reguler']),

    'Pendaftaran SMP Putra Berprestasi' => collect(['gender' => 'Laki-Laki', 'category' => 'Santri Berprestasi', 'current_school' => 'SMP', 'package' => 'Pendaftaran SMP Berprestasi']),
    'Pendaftaran SMP Putri Berprestasi' => collect(['gender' => 'Perempuan', 'category' => 'Santri Berprestasi', 'current_school' => 'SMP', 'package' => 'Pendaftaran SMP Berprestasi']),
    'Pendaftaran MA Putra Berprestasi' => collect(['gender' => 'Laki-Laki', 'category' => 'Santri Berprestasi', 'current_school' => 'MA', 'package' => 'Pendaftaran MA Berprestasi']),
    'Pendaftaran MA Putri Berprestasi' => collect(['gender' => 'Perempuan', 'category' => 'Santri Berprestasi', 'current_school' => 'MA', 'package' => 'Pendaftaran MA Berprestasi']),
]);

it('submits the form with valid data student whithout guardians', function () {
    $data = getValidFormData();

    $data["guardians"] = [];

    // Mengisi formulir dengan data yang valid
    Livewire::test(Registration::class)
        ->set('data', $data)
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertSeeText(__('Student Register Success'))
        ->assertSet('isSuccessful', true); // Pastikan variabel isSuccessful diatur ke true
});

it('submits the form with invalid data', function () {
    $data = getValidFormData();

    // Mengisi formulir dengan data yang valid
    Livewire::test(Registration::class)
        ->set('data', $data)
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertSeeText(__('Student Register Success'))
        ->assertSet('isSuccessful', true);

    Livewire::test(Registration::class)
        ->set('data', $data)
        ->call('create')
        ->assertHasErrors(['data.nik', 'data.nisn', 'data.kip', 'data.phone', 'data.email'])
        ->assertSeeText(__('Student Register Failed'))
        ->assertSet('isSuccessful', false);
});
