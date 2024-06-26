<?php

namespace App\Exports;

use App\Models\Article;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArticleExport  implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Article::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return Schema::getColumnListing('articles');
    }
}
