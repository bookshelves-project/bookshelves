<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\Book;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;
use App\Providers\EpubParser\EpubParserTools;

class CommentController extends Controller
{
    public function index(string $book)
    {
        $comments = Comment::whereHas('books', function ($query) use ($book) {
            return $query->where('slug', '=', $book);
        })->get();

        return CommentCollection::collection($comments);
    }

    public function byUser(int $user)
    {
        $comments = Comment::whereUserId($user)->get();

        return CommentResource::collection($comments);
    }

    public function store(Request $request, string $book)
    {
        $book = Book::whereSlug($book)->first();
        $user = Auth::user();

        foreach ($book->comments as $key => $value) {
            if ($value->user_id === $user->id) {
                return response()->json(['error' => 'A comment exist'], 401);
            }
        }

        $comment_text = $request->text;
        $comment_text = EpubParserTools::cleanText($comment_text, 'markdown', 1800);
        $comment = Comment::create([
            'text'    => $comment_text,
            'rating'  => $request->rating,
        ]);
        $comment->books()->save($book);
        $comment->user()->associate($user);
        $comment->save();

        return response()->json([
            'Success' => 'Comment created',
            'Comment' => $comment,
        ], 200);
    }

    public function edit(string $book)
    {
        $book = Book::whereSlug($book)->first();
        $user = Auth::user();

        $comment = Comment::whereBookId($book->id)->whereUserId($user->id)->firstOrFail();
        if (null === $comment) {
            return response()->json(['error' => 'A comment exist'], 401);
        }

        return response()->json($comment);
    }

    public function update(Request $request, string $book)
    {
        $book = Book::whereSlug($book)->first();
        $user = Auth::user();

        $comment = Comment::whereBookId($book->id)->whereUserId($user->id)->firstOrFail();
        if (null === $comment) {
            return response()->json(['error' => "Comment don't exist"], 401);
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
        Comment::destroy($id);

        return response()->json(['Success' => 'Comment have been deleted'], 200);
    }
}
