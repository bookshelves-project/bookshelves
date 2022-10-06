<?php

namespace App\Exports;

use App\Models\Post;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\QueryBuilder;

class PostExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
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
        return collect([
            'title',
            'category',
            'status',
            'summary',
            'is_pinned',
            'published_at',
            'created_at',
            'updated_at',
        ])->toArray();
    }

    /**
     * @param Post $row
     */
    public function map($row): array
    {
        return [
            $row->title,
            $row->category?->name,
            $row->status->value, // @phpstan-ignore-line
            $row->summary,
            $row->is_pinned ? 'true' : 'false',
            $row->published_at,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
