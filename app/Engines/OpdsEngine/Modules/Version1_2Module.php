<?php

namespace App\Engines\OpdsEngine\Modules;

use App\Engines\OpdsEngine;
use App\Engines\OpdsEngine\Modules\Interface\Module;
use App\Engines\OpdsEngine\Modules\Interface\ModuleInterface;
use App\Engines\OpdsEngine\XmlResponse;
use App\Engines\SearchEngine;
use App\Enums\EntityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Route;

class Version1_2Module extends Module implements ModuleInterface
{
    public static function create(OpdsEngine $engine): ModuleInterface
    {
        return new Version1_2Module($engine);
    }

    public function template(EntityEnum $entity, Collection|Model $data, ?string $title = null): string
    {
        $parameters = [...Route::getCurrentRoute()->parameters, ...$this->engine->request->all()];
        $current_route = route(Route::currentRouteName(), $parameters);
        $service = new XmlResponse(
            version: $this->engine->version,
            entity: $entity,
            route: $current_route,
            data: $data,
        );
        return $service->template($title);
    }

    public function xml(string $template): Response
    {
        return response($template)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }

    public function index(): Response
    {
        foreach ($this->engine->feed as $key => $value) {
            $model_name = 'App\Models\\'.ucfirst($value->model);
            $value->cover_thumbnail = config('app.url')."/assets/images/opds/{$value->key}.png";
            $value->route = route($value->route, ['version' => $this->engine->version]);
            $value->content = $model_name::count().' '.$value->content;
        }
        $template = $this->template(EntityEnum::feed, collect($this->engine->feed));

        return $this->xml($template);
    }

    public function search(): Response
    {
        $query = $this->engine->request->q;

        if ($query) {
            $search = SearchEngine::create($query, false, ['books']);
            $template = $this->template(EntityEnum::book, $search->list, "Results for {$query}");
        } else {
            $template = XmlResponse::search($this->engine->version);
        }

        return $this->xml($template);
    }

    public function entities(EntityEnum $entity, Collection|Model $collection, ?string $title = null): Response
    {
        $template = $this->template($entity, $collection, $title);

        return $this->xml($template);
    }
}
