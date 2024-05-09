<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Utilities\NikUtility;
use Creasi\Nusa\Models\Regency;
use Creasi\Nusa\Models\District;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
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
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ]);

        $roles = Role::whereIn('name', ['guru', 'admin_keuangan', 'admin_tata_usaha'])->get()->random(2); // Pilih dua peran secara acak
        $rolePengurus = Role::where('name', 'pengurus')->first();

        $user->syncRoles($roles);
        $user->assignRole($rolePengurus);

        $user->wallets()->create([
            'id' => $user->phone,
            'name' => 'Dompet Utama',
            'balance' => 0,
        ]);

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
        $district = District::where('code', $parseNik->district)->first();

        $rtRwArray = ["001", "002", "003", "004", "005", "006", "007", "008", "009"];

        return [
            'user_id' => $user->id,
            'name' => $user->name,
            'nik' => $nik,
            'niy' => '23' . $this->faker->unique()->numberBetween(10000000, 99999999),
            'gender' => $parseNik->gender,
            'birth_place' => $regency->name ?? 'Unknown',
            'birth_date' => $parseNik->birthDate,
            'province' => $parseNik->province,
            'regency' => $parseNik->regency,
            'district' => $parseNik->district,
            'village' => $this->faker->randomElement($district->villages->pluck('code')->toArray()),
            'address' => $this->faker->address(),
            'rt' => $this->faker->randomElement($rtRwArray),
            'rw' => $this->faker->randomElement($rtRwArray),
            'postal_code' => $this->faker->postcode(),
            'start_employment_date' => now(),
            'salary' => $this->faker->numberBetween(300000, 1000000),
        ];
    }
}
