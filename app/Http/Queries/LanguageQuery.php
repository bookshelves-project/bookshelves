<?php

namespace App\Http\Queries;

use App\Exports\LanguageExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Resources\Admin\LanguageResource;
use App\Models\Language;
use App\Support\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class LanguageQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption();
            $option->resource = LanguageResource::class;
            $option->orderBy = 'slug';
            $option->sortAsc = true;
            $option->with = [];
        }

        $this->option = $option;

        $this->query = QueryBuilder::for(Language::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['name',  'slug'])),
                AllowedFilter::partial('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('slug'),
            ])
            ->allowedSorts(['id', 'name', 'slug', 'created_at', 'updated_at'])
            ->with($option->with)
            ->withCount('books', 'series')
            ->orderByDesc($this->option->orderBy)
        ;

        $this->export = new LanguageExport($this->query);
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
