<?php

namespace App\Exports;

use App\Models\Post;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Lang;
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
        return collect(['title', 'category', 'status', 'summary', 'pin', 'promote', 'published_at', 'created_at', 'updated_at'])
            ->map(
                fn ($field) => Lang::has("crud.posts.attributes.{$field}")
                    ? __("crud.posts.attributes.{$field}")
                    : __("admin.attributes.{$field}")
            )->toArray();
    }

    /**
     * @param Post $row
     */
    public function map($row): array
    {
        return [
            $row->title,
            $row->category?->name,
            $row->status->label,
            $row->summary,
            $row->pin,
            $row->promote,
            $row->published_at,
            $row->created_at,
            $row->updated_at,
        ];
    }
}
