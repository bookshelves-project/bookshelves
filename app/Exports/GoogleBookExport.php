<?php

namespace App\Exports;

use App\Models\GoogleBook;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;

class GoogleBookExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    private Builder|QueryBuilder $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return collect(['original_isbn', 'created_at', 'updated_at'])
            ->map(
                fn ($field) => Lang::has("crud.google-books.attributes.{$field}")
                    ? __("crud.google-books.attributes.{$field}")
                    : __("admin.attributes.{$field}")
            )->toArray();
    }

    /**
     * @param GoogleBook $row
     */
    public function map($row): array
    {
        return [
            $row->original_isbn,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
