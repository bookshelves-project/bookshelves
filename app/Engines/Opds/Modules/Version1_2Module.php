<?php

namespace App\Engines\Opds\Modules;

use App\Engines\Opds\Modules\Interface\Module;
use App\Engines\Opds\Modules\Interface\ModuleInterface;
use App\Engines\Opds\XmlResponse;
use App\Engines\OpdsEngine;
use App\Engines\SearchEngine;
use App\Enums\EntityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Route;

class Version1_2Module extends Module implements ModuleInterface
{
    public static function create(OpdsEngine $opds): ModuleInterface
    {
        return new Version1_2Module($opds);
    }

    public function template(EntityEnum $entity, Collection|Model $data, ?string $title = null): string
    {
        $parameters = [...Route::getCurrentRoute()->parameters, ...$this->opds->request->all()];
        $current_route = route(Route::currentRouteName(), $parameters);
        $service = new XmlResponse(
            version: $this->opds->version,
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
        foreach ($this->opds->feed as $key => $value) {
            $model_name = 'App\Models\\'.ucfirst($value->model);
            $value->cover_thumbnail = config('app.url')."/vendor/vendor/images/opds/{$value->key}.png";
            $value->route = route($value->route, ['version' => $this->opds->version]);
            $value->content = $model_name::count().' '.$value->content;
        }
        $template = $this->template(EntityEnum::feed, collect($this->opds->feed));

        return $this->xml($template);
    }

    public function search(): Response
    {
        $query = $this->opds->request->q;

        if ($query) {
            $search = SearchEngine::create(q: $query, relevant: false, opds: true, types: ['books']);
            $template = $this->template(EntityEnum::book, $search->results_opds, "Results for {$query}");
        } else {
            $template = XmlResponse::search($this->opds->version);
        }

        return $this->xml($template);
    }

    public function entities(EntityEnum $entity, Collection|Model $collection, ?string $title = null): Response
    {
        $template = $this->template($entity, $collection, $title);

        return $this->xml($template);
    }
}
