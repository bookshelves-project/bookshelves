<?php

namespace App\Jobs;

use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessSyncBooks implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $timeout = 86400;
    public $failOnTimeout = true;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public bool $fresh = false,
        public ?Authenticatable $recipient = null,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('ProcessSyncBooks: start');

        if ($this->fresh) {
            File::deleteDirectory(public_path('storage/covers'));
            File::deleteDirectory(public_path('storage/formats'));
        }

        Log::debug('ProcessSyncBooks: make');
        Artisan::call('bookshelves:make', [
            '--fresh' => $this->fresh,
            '--force' => true,
        ]);

        Log::debug('ProcessSyncBooks: api');
        Artisan::call('bookshelves:api', [
            '--books' => true,
            '--authors' => true,
            '--series' => true,
            '--fresh' => $this->fresh,
            '--force' => true,
        ]);

        Log::info('ProcessSyncBooks: success');

        if ($this->recipient) {
            Notification::make()
                ->title('Sync is finished')
                ->icon('heroicon-o-refresh')
                ->iconColor('success')
                ->body($this->fresh ? 'All books are deleted and re-created.' : 'All books are sync with assets and relations.')
                ->sendToDatabase($this->recipient)
            ;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception)
    {
        Log::error('ProcessSyncBooks: failed', [
            'exception' => $exception,
        ]);

        Notification::make()
            ->title('Sync error')
            ->icon('heroicon-o-refresh')
            ->iconColor('danger')
            ->body("Sync process failed with error: {$exception->getMessage()}")
            ->sendToDatabase($this->recipient)
        ;
    }
}
