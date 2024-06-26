<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(AppointmentSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(DiagnosisSeeder::class);
    }
}
