<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diagnosis>
 */
class DiagnosisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $appointment = Appointment::all()
            ->where('status', 'finished')
            ->random();

        return [
            'detail' => fake()->paragraphs(2, true),
            'appointment_id' => $appointment->id,
        ];
    }
}
