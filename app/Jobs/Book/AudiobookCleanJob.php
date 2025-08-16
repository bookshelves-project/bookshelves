<?php

namespace App\Jobs\Book;

use App\Models\AudiobookTrack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Kiwilan\LaravelNotifier\Facades\Journal;

class AudiobookCleanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $library,
        protected bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // parse AudiobookTrack to get all tracks with same `slug` and group them
        $groups = AudiobookTrack::select('slug', DB::raw('COUNT(*) as track_count'))
            ->groupBy('slug')
            ->having('track_count', '>', 1)
            ->get();

        foreach ($groups as $group) {
            $tracks = AudiobookTrack::where('slug', $group->slug)->get();
            Journal::debug('tracks of '.$group->slug, [
                'id' => $tracks->pluck('id')->toArray(),
                'slug' => $tracks->pluck('slug')->toArray(),
            ]);
        }
    }
}
