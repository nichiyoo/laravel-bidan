<?php

namespace App\Exports;

use App\Models\Service;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiceExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Service::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return Schema::getColumnListing('services');
    }
}
