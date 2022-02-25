<?php

namespace App\Http\Queries;

use App\Models\Language;
use App\Exports\LanguageExport;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Resources\Admin\LanguageResource;
use App\Http\Queries\Filter\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LanguageQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption(resource: LanguageResource::class);
        }

        $this->option = $option;
        $option->with = [] === $option->with ? [] : $this->option->with;
        $option->orderBy = 'slug';
        $option->defaultSort = '-slug';
        $option->sortAsc = true;

        $this->query = QueryBuilder::for(Language::class)
            ->defaultSort($this->option->defaultSort)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['name',  'slug'])),
                AllowedFilter::partial('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('slug'),
            ])
            ->allowedSorts(['id', 'name', 'slug', 'created_at', 'updated_at'])
            ->with($option->with)
            ->withCount('books', 'series')
        ;

        if ($this->option->withExport) {
            $this->export = new LanguageExport($this->query);
        }
        $this->resource = 'languages';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        /** @var JsonResource $resource */
        $resource = $this->option->resource;

        return $resource::collection($this->paginate());
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', $this->option->defaultSort),
            'filter' => request()->get('filter'),
            'languages' => fn () => $this->collection(),
        ];
    }
}
