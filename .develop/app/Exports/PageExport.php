<?php

namespace App\Exports;

use App\Models\Page;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;

class PageExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
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
        return collect(['title', 'created_at', 'updated_at'])
            ->map(
                fn ($field) => Lang::has("crud.pages.attributes.{$field}")
                    ? __("crud.pages.attributes.{$field}")
                    : __("admin.attributes.{$field}")
            )->toArray();
    }

    /**
     * @param  Page  $row
     */
    public function map($row): array
    {
        return [
            $row->title,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
