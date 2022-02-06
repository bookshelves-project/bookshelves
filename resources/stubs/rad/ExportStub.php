<?php

namespace App\Exports;

use App\Models\Stub;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;

class StubExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
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
        return collect(['stubAttr', 'created_at', 'updated_at'])
            ->map(
                fn ($field) => Lang::has("crud.stubs.attributes.{$field}")
                    ? __("crud.stubs.attributes.{$field}")
                    : __("admin.attributes.{$field}")
            )->toArray();
    }

    /**
     * @param Stub $row
     */
    public function map($row): array
    {
        return [
            $row->stubAttr,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
