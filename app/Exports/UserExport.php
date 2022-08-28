<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;

class UserExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
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
        return collect(['name', 'email', 'is_blocked', 'role', 'created_at', 'updated_at'])
            ->map(
                fn ($field) => Lang::has("crud.users.attributes.{$field}")
                    ? __("crud.users.attributes.{$field}")
                    : __("admin.attributes.{$field}")
            )->toArray();
    }

    /**
     * @param User $row
     */
    public function map($row): array
    {
        return [
            $row->name,
            $row->email,
            $row->is_blocked,
            $row->role->value,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
