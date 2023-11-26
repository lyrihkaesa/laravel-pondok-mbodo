<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

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
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $roles = Role::whereIn('name', ['Guru', 'Admin Keuangan', 'Admin TAta Usaha'])->get()->random(1); // Pilih dua peran secara acak

        $user->syncRoles($roles);

        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'gender' => $this->faker->randomElement(['Laki-Laki', 'Perempuan']),
            'birth_date' => $this->faker->date,
            'address' => $this->faker->address,
            'user_id' => $user->id,
        ];
    }
}
