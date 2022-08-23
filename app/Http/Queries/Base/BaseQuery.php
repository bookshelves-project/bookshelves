<?php

namespace App\Http\Queries\Base;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use ReflectionClass;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseQuery
{
    public QueryOption $option;

    protected Builder|QueryBuilder $query;

    protected $export;

    protected string $resource;

    protected int $size = 15;

    public static function setup(
        string $instance,
        ?string $defaultResource,
        ?QueryOption $defaultOption,
        array $defaultWith = [],
    ): BaseQuery|false {
        $class = new ReflectionClass($instance);
        $short_name = $class->getShortName();
        $model_name = str_replace('query', '', $short_name);

        $query_class = 'App\Http\Queries\\'.ucfirst($model_name).'Query';
        if (! class_exists($query_class)) {
            return false;
        }

        /** @var BaseQuery $query */
        $query = new $query_class();

        if (null === $defaultOption) {
            $defaultOption = new QueryOption();
        }

        $query->option = $defaultOption;
        if (! $query->option->resource) {
            $query->option->resource = $defaultResource;
        }
        $query->option->with = $defaultWith;

        $export_class = 'App\Exports\\'.ucfirst($model_name).'Export';
        if ($defaultOption->exportable && class_exists($export_class)) {
            $query->export = new $export_class($query->query);
        }
        if (! $query->option->resourceName) {
            $slug = preg_split('/(?=[A-Z])/', $model_name);
            $slug = implode('-', $slug);
            $query->option->resourceName = Str::plural(Str::slug($slug));
        }
        $query->resource = $query->option->resourceName;

        return $query;
    }

    // public static function setup(?QueryOption $baseOption = null, ?string $defaultResource, array $with = [], ?string $export = null): QueryOption
    // {

    //     if ($option->exportable && $export) {
    //         $q->export = new $export($q->query);
    //     }
    //     $q->resource = 'armies';

    //     return $baseOption;
    // }

    public function paginate(): LengthAwarePaginator
    {
        return $this->query->paginate(min(100, request()->get('size', $this->option->size ?? $this->size)));
    }

    abstract public function collection(): AnonymousResourceCollection;

    abstract public function get(): array;

    public function paginateOrExport(?Closure $response = null)
    {
        if (! $response || request()->wantsJson()) {
            return $this->collection();
        }

        if (request()->get('export')) {
            $fileName = Str::slug(trans_choice("crud.{$this->resource}.name", 10));
            $date = date('Ymd-His');

            return Excel::download($this->export, "export-{$fileName}-{$date}.xlsx");
        }

        return $response($this->get());
    }

    public function getCollection()
    {
        /** @var JsonResource $resource */
        $resource = $this->option->resource;
        $response = $this->option->full ? $this->query->get() : $this->paginate();

        return $resource::collection($response);
    }
}
