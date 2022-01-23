<?php

namespace App\Http\Controllers\Features\Documentation;

use App\Http\Controllers\Controller;
use App\Services\FileService;
use App\Services\MarkdownService;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * @hideFromAPIDocumentation
 */
class DocumentationController extends Controller
{
    public function page(Request $request)
    {
        if (! $request->page) {
            return redirect(route('features.documentation.page', ['page' => 'home']));
        }
        $page = $request->page ?? 'home';
        $path = "documentation/{$page}.md";

        $slug = str_contains($page, '_') ? explode('_', $page) : $page;
        $slug = is_array($slug) ? end($slug) : $slug;
        SEOTools::setTitle(__("documentation.{$slug}"));

        return self::getContent($path, $page);
    }

    public static function getContent(string $path, string $page)
    {
        $path = str_contains($page, '_') ? str_replace('_', '/', $path) : $path;
        $service = MarkdownService::generate($path);
        $content = $service->convertToHtml();
        $date = $service->date;

        $documents = self::getDocuments('features/content/documentation');
        $links = FileService::arrayToObject($documents);

        return view('features::pages.documentation.page', compact('date', 'content', 'links', 'page'));
    }

    private static function getDocuments(string $path): array
    {
        $documents = File::allFiles(resource_path($path));
        $links = [];
        foreach ($documents as $document) {
            $slug = str_replace('.md', '', $document->getBasename());
            $category = ! empty($document->getRelativePath()) ? $document->getRelativePath() : '';
            array_push($links, [
                'slug' => $slug,
                'file' => $document->getBasename(),
                'category' => $category,
                'route' => 'features.documentation.page',
                'parameters' => [
                    'page' => $category ? $category.'_'.$slug : $slug,
                ],
                'external' => false,
            ]);
        }
        $links = self::groupBy('category', $links);

        return array_reverse($links, true);
    }

    private static function groupBy(string $key, array $data): array
    {
        $result = [];
        foreach ($data as $value) {
            if (array_key_exists($key, $value)) {
                $result[$value[$key]][] = $value;
            } else {
                $result[''][] = $value;
            }
        }

        return $result;
    }
}
