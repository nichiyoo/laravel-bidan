<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('role', 'patient')->get()->each(function ($user) {
            $user->patient()->create([
                'nik' => fake()->nik(),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'birth_date' => fake()->dateTimeThisDecade(),
                'birth_place' => fake()->city(),
                'gender' => fake()->randomElement(['male', 'female']),
            ]);
        });
    }
}
