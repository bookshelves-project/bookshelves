<?php

namespace App\Http\Queries;

use App\Exports\SubmissionExport;
use App\Http\Resources\Admin\SubmisionResource;
use App\Models\Submission;
use App\Support\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SubmissionQuery extends BaseQuery
{
    public function make(): self
    {
        $this->query = QueryBuilder::for(Submission::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['name', 'email'])),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
            ])
            ->allowedSorts(['id', 'name', 'email', 'created_at', 'updated_at'])
        ;

        $this->export = new SubmissionExport($this->query);
        $this->resource = 'submissions';

        return $this;
    }

    public function collection(): AnonymousResourceCollection
    {
        return SubmisionResource::collection($this->paginate());
    }

    public function get(): array
    {
        return [
            'sort' => request()->get('sort', 'id'),
            'filter' => request()->get('filter'),
            'submissions' => fn () => $this->collection(),
        ];
    }
}
