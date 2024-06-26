<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientExport implements FromArray, WithHeadings
{
    protected $patients;

    public function __construct()
    {
        $this->patients = Patient::with('user', 'appointments')
            ->withCount([
                'appointments as total',
                'appointments as cancelled' => function ($query) {
                    return $query->where('status', 'cancelled');
                },
            ])
            ->get();
    }

    /**
     * array of data to export
     * 
     * @return array
     */
    public function array(): array
    {
        return $this->patients->map(function (Patient $patient) {
            return [
                $patient->id,
                $patient->user->name,
                $patient->nik,
                $patient->phone,
                $patient->address,
                $patient->birth_date,
                $patient->birth_place,
                $patient->gender,
                $patient->total,
                $patient->cancelled,
                $patient->total == 0 ? 0 : 100 - ($patient->cancelled / $patient->total) * 100,
                $patient->created_at,
                $patient->updated_at,
            ];
        })->toArray();
    }

    /**
     * Column titles
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'no',
            'name',
            'nik',
            'phone',
            'address',
            'birth_date',
            'birth_place',
            'gender',
            'total_appointments',
            'cancelled_appointments',
            'obediance_percentage',
            'created_at',
            'updated_at',
        ];
    }
}
