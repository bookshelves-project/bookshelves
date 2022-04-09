<?php

namespace App\Http\Queries;

use App\Exports\UserExport;
use App\Http\Queries\Addon\QueryOption;
use App\Http\Queries\Filter\GlobalSearchFilter;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserQuery extends BaseQuery
{
    public function make(?QueryOption $option = null): self
    {
        if (! $option || null === $option->resource) {
            $option = new QueryOption(resource: UserResource::class);
        }

        $this->option = $option;
        $option->with = [] === $option->with ? [] : $this->option->with;

        $this->query = QueryBuilder::for(User::class)
            ->defaultSort($this->option->defaultSort)
            ->allowedFilters([
                AllowedFilter::custom('q', new GlobalSearchFilter(['name', 'email'])),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::exact('id'),
                AllowedFilter::exact('role'),
                AllowedFilter::exact('active'),
            ])
            ->allowedSorts(['id', 'name', 'last_login_at', 'created_at', 'updated_at'])
        ;

        if ($this->option->withExport) {
            $this->export = new UserExport($this->query);
        }
        $this->resource = 'users';

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
            'users' => fn () => $this->collection(),
        ];
    }
}
