<?php

namespace App\Http\Queries;

use App\Exports\UserExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use App\Support\GlobalSearchFilter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option) {
            $option = new QueryOption();
            $option->resource = UserResource::class;
            $option->with = [];
        }

        $this->option = $option;

        $this->query = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['name', 'email'])),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::exact('id'),
                AllowedFilter::exact('role'),
                AllowedFilter::exact('active'),
            ])
            ->allowedSorts(['id', 'name', 'last_login_at', 'created_at', 'updated_at'])
            ->orderByDesc($this->option->orderBy)
        ;

        $this->export = new UserExport($this->query);
        $this->resource = 'users';

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
            'users' => fn () => $this->collection(),
        ];
    }
}
