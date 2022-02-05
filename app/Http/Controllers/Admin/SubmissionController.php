<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\SubmissionQuery;
use App\Http\Resources\Admin\SubmisionResource;
use App\Models\Submission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubmissionController extends Controller
{
    public function index()
    {
        return app(SubmissionQuery::class)->make()
            ->paginateOrExport(fn ($data) => Inertia::render('submissions/Index', $data))
        ;
    }

    public function show(Submission $submission)
    {
        return Inertia::render('submissions/Index', [
            'action' => 'show',
            'submission' => SubmisionResource::make($submission),
        ] + app(SubmissionQuery::class)->make()->get());
    }

    public function destroy(Submission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.submissions')->with('flash.success', __('Submission deleted.'));
    }

    public function bulkDestroy(Request $request)
    {
        $count = Submission::query()->findMany($request->input('ids'))
            ->each(fn (Submission $submission) => $submission->delete())
            ->count()
        ;

        return redirect()->route('admin.submissions')->with('flash.success', __(':count submissions deleted.', ['count' => $count]));
    }
}
