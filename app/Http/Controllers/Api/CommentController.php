<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\Book;
use App\Models\Commentable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Providers\ParserEngine\ParserTools;

/**
 * @hideFromAPIDocumentation
 */
class CommentController extends Controller
{
    public function index(string $model, string $slug)
    {
        $model_name = 'App\Models\\' . ucfirst($model);
        $entity = $model_name::whereSlug($slug)->first();
        $comments = $entity->comments;

        return CommentResource::collection($comments);
    }

    public function byUser(int $user)
    {
        $comments = Commentable::whereUserId($user)->with([
            'user',
            'commentable',
        ])->orderBy('created_at', 'DESC')->get();

        return CommentResource::collection($comments);
    }

    public function store(Request $request, string $model, string $slug)
    {
        $model_name = 'App\Models\\' . ucfirst($model);
        $entity = $model_name::whereSlug($slug)->first();
        $userId = Auth::id();
        $user = Auth::user();

        foreach ($entity->comments as $key => $value) {
            if ($value->user_id === $userId) {
                return response()->json(['error' => 'A comment exist, you can post only one comment here.'], 401);
            }
        }

        $comment_text = $request->text;
        $comment_text = ParserTools::cleanText($comment_text, 'markdown', 1800);
        $comment = Commentable::create([
            'text'   => $comment_text,
            'rating' => $request->rating,
        ]);
        $comment->user()->associate($user);
        $entity->comments()->save($comment);

        return response()->json([
            'Success'     => 'Commentable created',
            'Commentable' => $comment,
        ], 200);
    }

    public function edit(string $book)
    {
        $book = Book::whereSlug($book)->first();
        $userId = Auth::id();

        $comment = Commentable::whereBookId($book->id)->whereUserId($userId)->firstOrFail();
        if (null == $comment) {
            return response()->json(['error' => 'A comment exist'], 401);
        }

        return response()->json($comment);
    }

    public function update(Request $request, string $book)
    {
        $book = Book::whereSlug($book)->first();
        $userId = Auth::id();

        $comment = Commentable::whereBookId($book->id)->whereUserId($userId)->firstOrFail();
        if (null == $comment) {
            return response()->json(['error' => "Commentable don't exist"], 401);
        }
        $comment_text = $request->text;
        $comment_text = Str::markdown($comment_text);
        $comment->text = $comment_text;
        $comment->rating = $request->rating;
        $comment->save();

        return response()->json($comment);
    }

    public function destroy(int $id)
    {
        Commentable::destroy($id);

        return response()->json(['Success' => 'Commentable have been deleted'], 200);
    }
}
