<?php

namespace App\Http\Queries\Addon;

class QueryOption
{
    public string $sortDirection = '';
    public string $defaultSort = '-id';

    public function __construct(
        public ?string $resource,
        public array $with = [],
        public bool $withExport = true,
        public string $orderBy = 'id',
        public bool $sortAsc = false,
        public bool $withPagination = true,
        public int $perPage = 32,
    ) {
    }

    public static function create(
        string $resource,
        string $orderBy = 'id',
        array $with = [],
        bool $withExport = true,
        bool $sortAsc = false,
        bool $withPagination = true,
        int $perPage = 32,
    ): QueryOption {
        $query = new QueryOption(
            resource: $resource,
            perPage: $perPage,
            withExport: $withExport,
            withPagination: $withPagination,
            orderBy: $orderBy,
            sortAsc: $sortAsc,
            with: $with
        );
        $query->sortDirection = $query->sortAsc ? '' : '-';
        $query->defaultSort = "{$query->sortDirection}{$query->orderBy}";

        return $query;
    }
}
