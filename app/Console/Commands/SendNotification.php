<?php

namespace App\Console\Commands;

use App\Mail\AppointmentNotification;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to send appoinment notification to user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $appointment = Appointment::first();
        Mail::to($appointment->patient->user->email)->send(new AppointmentNotification($appointment));

        Appointment::with('notification', 'patient.user')
            ->where('status', 'confirmed')
            ->chunk(50, function ($appointments) {
                foreach ($appointments as $appointment) {
                    $notification = $appointment->notification;
                    $patient = $appointment->patient;
                    $user = $patient->user;

                    switch ($notification->frequency) {
                        case 'every hour':
                            $this->sendNotification($user, $appointment);
                            break;

                        case 'every 6 hours':
                            if (Carbon::now()->hour % 6 == 0) $this->sendNotification($user, $appointment);
                            break;

                        case 'every 12 hours':
                            if (Carbon::now()->hour % 12 == 0) $this->sendNotification($user, $appointment);
                            break;
                    }

                    if (Carbon::now()->hour != 6) continue;

                    switch ($notification->frequency) {
                        case 'every day':
                            $this->sendNotification($user, $appointment);
                            break;

                        case 'every 2 days':
                            if (Carbon::now()->day % 2 == 0) $this->sendNotification($user, $appointment);
                            break;

                        case 'every week':
                            if (Carbon::now()->dayOfWeek == Carbon::MONDAY) $this->sendNotification($user, $appointment);
                            break;
                    }
                }
            });
    }

    /**
     * Function to send notification to user
     *
     * @param $user
     * @param $appointment
     */
    private function sendNotification($user, $appointment)
    {
        Mail::to($user->email)->send(new AppointmentNotification($appointment));
    }
}
