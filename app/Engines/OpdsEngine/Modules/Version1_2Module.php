<?php

namespace App\Engines\OpdsEngine\Modules;

use App\Engines\OpdsEngine;
use App\Engines\OpdsEngine\XmlResponse;
use App\Engines\SearchEngine;
use App\Enums\EntityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Route;

class Version1_2Module
{
    public OpdsEngine $engine;

    public static function create(OpdsEngine $engine): Version1_2Module
    {
        $opds = new Version1_2Module();
        $opds->engine = $engine;

        return $opds;
    }

    public function template(EntityEnum $entity, Collection|Model $data, ?string $title = null)
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

    public function xml(string $template)
    {
        return response($template)->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }

    public function index()
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

    public function search()
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

    public function entities(EntityEnum $entity, Collection|Model $collection)
    {
        $template = $this->template($entity, $collection);

        return $this->xml($template);
    }
}
