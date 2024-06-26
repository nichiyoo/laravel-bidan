<?php

namespace App\Exports;

use App\Models\Review;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReviewExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Review::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return Schema::getColumnListing('reviews');
    }
}
