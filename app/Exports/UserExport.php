<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        return User::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'id',
            'name',
            'email',
            'role',
            'remember_token',
            'created_at',
            'updated_at'
        ];
    }
}
