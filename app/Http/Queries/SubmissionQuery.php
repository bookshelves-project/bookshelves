<?php

namespace App\Http\Queries;

use App\Exports\SubmissionExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\Filter\GlobalSearchFilter;
use App\Http\Resources\Admin\SubmisionResource;
use App\Models\Submission;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SubmissionQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option || null === $option->resource) {
            $option = new QueryOption(resource: SubmisionResource::class);
        }

        $this->option = $option;
        $option->with = [] === $option->with ? [] : $this->option->with;

        $this->query = QueryBuilder::for(Submission::class)
            ->defaultSort($this->option->defaultSort)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['name', 'email'])),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
            ])
            ->allowedSorts(['id', 'name', 'email', 'created_at', 'updated_at'])
            ->with($option->with)
        ;

        if ($this->option->withExport) {
            $this->export = new SubmissionExport($this->query);
        }
        $this->resource = 'submissions';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        return $this->getCollection();
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', $this->option->defaultSort),
            'filter' => request()->get('filter'),
            'submissions' => fn () => $this->collection(),
        ];
    }
}
