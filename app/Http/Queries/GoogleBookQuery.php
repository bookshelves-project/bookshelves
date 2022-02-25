<?php

namespace App\Http\Queries;

use App\Models\GoogleBook;
use App\Exports\GoogleBookExport;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\Filter\GlobalSearchFilter;
use App\Http\Resources\Admin\GoogleBookResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GoogleBookQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption(resource: GoogleBookResource::class);
        }

        $this->option = $option;
        $option->with = [] === $option->with ? ['book'] : $this->option->with;

        $this->query = QueryBuilder::for(GoogleBook::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['original_isbn'])),
                AllowedFilter::exact('id'),
                AllowedFilter::partial('original_isbn'),
            ])
            ->allowedSorts(['id', 'original_isbn', 'created_at', 'updated_at'])
            ->with($option->with)
            ->orderByDesc($this->option->orderBy)
        ;

        if ($this->option->withExport) {
            $this->export = new GoogleBookExport($this->query);
        }
        $this->resource = 'google-books';

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
            'google-books' => fn () => $this->collection(),
        ];
    }
}
