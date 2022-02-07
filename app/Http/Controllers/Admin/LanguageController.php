<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\LanguageQuery;
use App\Http\Resources\Admin\LanguageResource;
use App\Models\Language;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('languages')]
class LanguageController extends Controller
{
    #[Get('/', name: 'languages')]
    public function index()
    {
        return app(LanguageQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('languages/Index', $data))
        ;
    }

    #[Get('create', name: 'languages.create')]
    public function create()
    {
        return Inertia::render('languages/Create');
    }

    #[Get('{language}/edit', name: 'languages.edit')]
    public function edit(Language $language)
    {
        return Inertia::render('languages/Edit', [
            'language' => LanguageResource::make($language), // $stubConcat->load('relation')
        ]);
    }

    #[Delete('{language}', name: 'languages.destroy')]
    public function destroy(Language $language)
    {
        $language->delete();

        return redirect()->route('admin.languages')->with('flash.success', __('Language deleted.'));
    }

    #[Delete('/', name: 'languages.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = Language::query()->findMany($request->input('ids'))
            ->each(fn (Language $language) => $language->delete())
            ->count()
        ;

        return redirect()->route('admin.languages')->with('flash.success', __(':count languages deleted.', ['count' => $count]));
    }

    #[Get('/fetch', name: 'languages.fetch')]
    public function fetch(Request $request)
    {
        return LanguageResource::collection(
            Language::query()
                ->where('name', 'like', "%{$request->input('filter.q')}%")
                ->withCount('books')->get()
        );
    }
}
