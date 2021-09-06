<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Spatie\Tags\Tag;
use App\Models\Serie;
use App\Models\Author;
use App\Models\Language;
use App\Models\Publisher;
use App\Providers\CommonMarkProvider;

/**
 * @hideFromAPIDocumentation
 */
class NavigationController extends Controller
{
    public function welcome()
    {
        $markdown = CommonMarkProvider::generate('welcome/content/index.md');
        $content = $markdown->content;
        $date = $markdown->date;
        
        $table = [
            [
                'entity' => 'Books',
                'count'  => Book::count()
            ],
            [
                'entity' => 'Series',
                'count'  => Serie::count()
            ],
            [
                'entity' => 'Authors',
                'count'  => Author::count()
            ],
            [
                'entity' => 'Languages',
                'count'  => Language::count()
            ],
            [
                'entity' => 'Publishers',
                'count'  => Publisher::count()
            ],
            [
                'entity' => 'Tags',
                'count'  => Tag::count()
            ],
            [
                'entity' => 'Users',
                'count'  => User::count()
            ]
        ];
        $table = json_decode(json_encode($table));
        
        return view('pages.welcome.index', compact('table', 'content'));
    }

    public function fallback()
    {
        return response()->json([
            'failed' => 'Route not found'
        ], 404);
    }
    
    public function admin()
    {
        return view('pages.admin');
    }
}
