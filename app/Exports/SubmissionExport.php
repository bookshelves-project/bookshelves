<?php

namespace App\Exports;

use App\Models\Submission;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;

class SubmissionExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
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
        return collect(['name', 'email', 'reason', 'message', 'created_at', 'updated_at'])
            ->map(
                fn ($field) => Lang::has("crud.users.attributes.{$field}")
                    ? __("crud.users.attributes.{$field}")
                    : __("admin.attributes.{$field}")
            )->toArray();
    }

    /**
     * @param Submission $row
     */
    public function map($row): array
    {
        return [
            $row->name,
            $row->email,
            $row->reason->value,
            $row->message,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
