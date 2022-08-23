<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Review\ReviewResource;
use App\Models\Book;
use App\Models\Review;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @group User: Review
 */
class ReviewController extends ApiController
{
    /**
     * GET Reviews for entity.
     */
    public function index(string $model, string $slug)
    {
        $model_name = ucfirst($model);
        $model_name = "App\\Models\\{$model_name}";
        $entity = $model_name::whereSlug($slug)->first();
        $reviews = $entity->reviews;

        return ReviewResource::collection($reviews);
    }

    /**
     * GET Reviews by user.
     *
     * @authenticated
     */
    public function user(int $user)
    {
        $reviews = Review::whereUserId($user)->orderBy('created_at', 'DESC')->get();

        return ReviewResource::collection($reviews);
    }

    /**
     * POST Store new review.
     *
     * @authenticated
     */
    public function store(Request $request, string $model, string $slug)
    {
        $model_name = 'App\Models\\'.ucfirst($model);
        $entity = $model_name::whereSlug($slug)->first();
        $userId = Auth::id();
        $user = Auth::user();

        foreach ($entity->reviews as $key => $value) {
            if ($value->user_id === $userId) {
                return response()->json(['error' => 'A review exist, you can post only one review here.'], 401);
            }
        }

        $review_text = $request->text;
        $review = Review::create([
            'text' => $review_text,
            'rating' => $request->rating,
        ]);
        $review->user()->associate($user);
        $entity->reviews()->save($review);

        return response()->json([
            'Success' => 'Review created',
            'Review' => $review,
        ], 200);
    }

    /**
     * POST Edit review.
     *
     * @authenticated
     */
    public function edit(string $book)
    {
        $book = Book::whereSlug($book)->first();
        $userId = Auth::id();

        $review = Review::whereBookId($book->id)->whereUserId($userId)->firstOrFail();
        if (null == $review) {
            return response()->json(['error' => 'A review exist'], 401);
        }

        return response()->json($review);
    }

    /**
     * POST Update review.
     *
     * @authenticated
     */
    public function update(Request $request, string $book)
    {
        $book = Book::whereSlug($book)->first();
        $userId = Auth::id();

        $review = Review::whereBookId($book->id)->whereUserId($userId)->firstOrFail();
        if (null == $review) {
            return response()->json(['error' => "Review don't exist"], 401);
        }
        $review_text = $request->text;
        $review_text = Str::markdown($review_text);
        $review->text = $review_text;
        $review->rating = $request->rating;
        $review->save();

        return response()->json($review);
    }

    /**
     * POST Destroy review.
     *
     * @authenticated
     */
    public function destroy(int $id)
    {
        Review::destroy($id);

        return response()->json(['Success' => 'Review have been deleted'], 200);
    }
}
