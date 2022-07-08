<?php

namespace App\Http\Queries\Addon;

use Illuminate\Http\Request;

class QueryOption
{
    public string $sortDirection = '';

    public string $defaultSort = '-id';

    public function __construct(
        public ?string $resource,
        public array $with = [],
        public array $withCount = [],
        public bool $withExport = true,
        public string $orderBy = 'id',
        public bool $sortAsc = false,
        public bool $full = false,
        public int $size = 32,
        public mixed $request = null,
    ) {
    }

    public static function create(
        ?Request $request = null,
        ?string $resource = null,
        string $orderBy = 'id',
        array $with = [],
        array $withCount = [],
        bool $withExport = true,
        bool $sortAsc = false,
        bool $full = false,
    ): QueryOption {
        $query = new QueryOption(
            resource: $resource,
            withExport: $withExport,
            full: $full,
            orderBy: $orderBy,
            sortAsc: $sortAsc,
            with: $with,
            withCount: $withCount
        );
        $query->sortDirection = $query->sortAsc ? '' : '-';
        $query->defaultSort = "{$query->sortDirection}{$query->orderBy}";
        $query->size = $request?->size ? $request->size : 32;

        return $query;
    }
}
