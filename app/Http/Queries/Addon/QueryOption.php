<?php

namespace App\Http\Queries\Addon;

class QueryOption
{
    public string $sortDirection = '';
    public string $defaultSort = '';

    public function __construct(
        public int $perPage = 15,
        public bool $withExport = true,
        public string $orderBy = 'id',
        public bool $sortAsc = false,
        public ?string $resource = '',
    ) {
    }

    public static function create(
        int $perPage = 15,
        bool $withExport = true,
        string $orderBy = 'id',
        bool $sortAsc = false,
        string $resource = null
    ): QueryOption {
        $query = new QueryOption(
            $perPage,
            $withExport,
            $orderBy,
            $sortAsc,
            $resource
        );
        $query->sortDirection = $query->sortAsc ? '' : '-';
        $query->defaultSort = "{$query->sortDirection}{$query->orderBy}";

        return $query;
    }
}
