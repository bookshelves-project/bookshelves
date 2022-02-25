<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Queries\SubmissionQuery;
use App\Http\Resources\Admin\SubmisionResource;
use App\Models\Submission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('submissions')]
class SubmissionController extends Controller
{
    #[Get('/', name: 'submissions')]
    public function index()
    {
        return app(SubmissionQuery::class)->make(null)
            ->paginateOrExport(fn ($data) => Inertia::render('submissions/Index', $data))
        ;
    }

    #[Get('submissions', name: 'submissions.create')]
    public function show(Submission $submission)
    {
        return Inertia::render('submissions/Index', [
            'action' => 'show',
            'submission' => SubmisionResource::make($submission),
        ] + app(SubmissionQuery::class)->make(null)->get());
    }

    #[Delete('{submission}', name: 'submissions.destroy')]
    public function destroy(Submission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.submissions')->with('flash.success', __('Submission deleted.'));
    }

    #[Delete('/', name: 'submissions.bulk.destroy')]
    public function bulkDestroy(Request $request)
    {
        $count = Submission::query()->findMany($request->input('ids'))
            ->each(fn (Submission $submission) => $submission->delete())
            ->count()
        ;

        return redirect()->route('admin.submissions')->with('flash.success', __(':count submissions deleted.', ['count' => $count]));
    }
}
