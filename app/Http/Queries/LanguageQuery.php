<?php

namespace App\Http\Queries;

use App\Exports\LanguageExport;
use App\Http\Resources\Admin\LanguageResource;
use App\Models\Language;
use App\Support\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class LanguageQuery extends BaseQuery
{
    public function make(): self
    {
        $this->query = QueryBuilder::for(Language::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['name',  'slug'])),
                AllowedFilter::partial('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('slug'),
            ])
            ->allowedSorts(['id', 'name', 'slug', 'created_at', 'updated_at'])
            ->withCount('books', 'series')
            ->orderByDesc('slug')
        ;

        $this->export = new LanguageExport($this->query);
        $this->resource = 'languages';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        return LanguageResource::collection($this->paginate());
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', 'slug'),
            'filter' => request()->get('filter'),
            'languages' => fn () => $this->collection(),
        ];
    }
}
