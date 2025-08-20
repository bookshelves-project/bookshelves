<?php

namespace App\Jobs\Author;

use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class AuthorsDispatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public bool $fresh = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $authors = $this->getAuthors($this->fresh);
        if ($authors->isEmpty()) {
            return;
        }

        foreach ($authors as $author) {
            AuthorJob::dispatch($author, $this->fresh);
        }
    }

    /**
     * @return Collection<int, Author>
     */
    private function getAuthors(bool $fresh): Collection
    {
        if ($fresh) {
            return Author::all();
        }

        return Author::query()
            ->where('api_parsed_at', null)
            ->get();
    }
}
