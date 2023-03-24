<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\SubmissionStoreRequest;
use App\Models\Submission;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

/**
 * @group Creations
 *
 * APIs for Creations.
 */
#[Prefix('submissions')]
class SubmissionController extends Controller
{
    // /**
    //  * GET Service.
    //  */
    // #[Post('/create', name: 'api.submissions.create')]
    // public function create(SubmissionStoreRequest $request)
    // {
    //     $success = false;
    //     $submission = null;

    //     if (! $request->boolean('honeypot')) {
    //         $success = true;

    //         $submission = new Submission();
    //         $submission->fill($request->validated());
    //         $submission->save();
    //     }

    //     return response()->json([
    //         'success' => $success,
    //         'message' => $success ? 'Votre message a été envoyé' : "Votre message n'a pas pu être envoyé",
    //         'submission' => $submission,
    //     ], $success ? 200 : 422);
    // }
}
