<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Payment::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return Schema::getColumnListing('payments');
    }
}
