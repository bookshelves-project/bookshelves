<?php

namespace App\Exports;

use App\Models\WikipediaItem;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;

class WikipediaItemExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
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
        return collect(['search_query', 'created_at', 'updated_at'])
            ->map(
                fn ($field) => Lang::has("crud.wikipedia-items.attributes.{$field}")
                    ? __("crud.wikipedia-items.attributes.{$field}")
                    : __("admin.attributes.{$field}")
            )->toArray();
    }

    /**
     * @param WikipediaItem $row
     */
    public function map($row): array
    {
        return [
            $row->search_query,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
