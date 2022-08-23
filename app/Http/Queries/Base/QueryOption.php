<?php

namespace App\Http\Queries\Base;

use Illuminate\Http\Request;

class QueryOption
{
    public string $sortDirection = '';

    public string $defaultSort = '-id';

    public function __construct(
        public ?string $resource = null,
        public ?string $resourceName = null,
        public array $with = [],
        public array $withCount = [],
        public bool $exportable = false,
        public string $orderBy = 'id',
        public bool $sortAsc = true,
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
        bool $exportable = false,
        bool $sortAsc = true,
        bool $full = false,
    ): QueryOption {
        $query = new QueryOption(
            resource: $resource,
            exportable: $exportable,
            full: $full,
            orderBy: $orderBy,
            sortAsc: $sortAsc,
            with: $with,
            withCount: $withCount,
        );
        $query->sortDirection = $query->sortAsc ? '' : '-';
        $query->defaultSort = "{$query->sortDirection}{$query->orderBy}";
        $query->size = $request?->size ? $request->size : 32;

        return $query;
    }
}
