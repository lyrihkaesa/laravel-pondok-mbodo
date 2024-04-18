<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Str;
use App\Utilities\NikUtility;
use Creasi\Nusa\Models\District;
use Creasi\Nusa\Models\Regency;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => '628' . $this->faker->unique()->numberBetween(100000000, 999999999),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => str::random(10),
        ]);

        $studentRole = Role::where('name', 'Santri')->first();
        $user->assignRole($studentRole);


        $nik = $this->faker->nik();
        $parseNik = NikUtility::parseNIK($nik);
        $district = District::where('code', $parseNik->district)->first();

        // Lakukan pengecekan apakah $district ada dalam database
        if (!$district) {
            // Jika tidak ditemukan, buat NIK baru
            do {
                $nik = $this->faker->nik();
                $parseNik = NikUtility::parseNIK($nik);
                $district = District::where('code', $parseNik->district)->first();
            } while (!$district);
        }
        $parseNik = NikUtility::parseNIK($nik);
        $regency = Regency::where('code', $parseNik->regency)->first();

        $rtRwArray = ["001", "002", "003", "004", "005", "006", "007", "008", "009"];

        return [
            'name' => $user->name,
            'nik' => $nik,
            'nip' => '23' . $this->faker->unique()->numberBetween(10000000, 99999999),
            'nisn' => $this->faker->unique()->numberBetween(10000000, 9999999999),
            'gender' => $parseNik->gender,
            'birth_place' => $regency->name ?? 'Unknown',
            'birth_date' => $parseNik->birthDate,
            'province' => $parseNik->province,
            'regency' => $parseNik->regency,
            'district' => $parseNik->district,
            // 'village' => $this->faker->randomElement(\Creasi\Nusa\Models\Village::all()->pluck('name')->toArray()),
            'address' => $this->faker->address(),
            'rt' => $this->faker->randomElement($rtRwArray),
            'rw' => $this->faker->randomElement($rtRwArray),
            'postcode' => $this->faker->postcode(),
            'user_id' => $user->id,
            'status' => $this->faker->randomElement(['Mendaftar', 'Aktif', 'Lulus', 'Tidak Aktif']),
            'current_school' => $this->faker->randomElement(['PAUD/TK', 'MI', 'SMP', 'MA', 'Takhasus']),
            'category' => $this->faker->randomElement(['Santri Reguler', 'Santri Ndalem', 'Santri Berprestasi']),
        ];
    }
}
