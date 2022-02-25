<?php

namespace App\Exports;

use App\Models\Book;
use Illuminate\Support\Facades\Lang;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LanguageExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
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
        return collect(['title', 'category', 'status', 'summary', 'pin', 'promote', 'published_at', 'created_at', 'updated_at'])
            ->map(
                fn ($field) => Lang::has("crud.books.attributes.{$field}")
                    ? __("crud.books.attributes.{$field}")
                    : __("admin.attributes.{$field}")
            )->toArray();
    }

    /**
     * @param Book $row
     */
    public function map($row): array
    {
        return [
            $row->title,
            $row->volume,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
