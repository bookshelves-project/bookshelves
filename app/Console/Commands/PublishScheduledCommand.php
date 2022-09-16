<?php

namespace App\Console\Commands;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Kiwilan\Steward\Enums\PublishStatusEnum;
use Schema;

class PublishScheduledCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish models that are scheduled to be published';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->alert($this->signature);
        $this->warn($this->description);
        $this->newLine();

        $models = [
            Post::class,
        ];

        foreach ($models as $model) {
            $instance = new $model();
            $date_column = Schema::hasColumn($instance->getTable(), 'published_at') ? 'published_at' : 'created_at';

            $models_udpated = $model::query()
                ->where('status', '=', PublishStatusEnum::scheduled)
                ->where($date_column, '<', Carbon::now())
                ->get()
            ;

            $models_udpated->each(function ($model_updated) {
                $model_updated->update(['status' => PublishStatusEnum::published]);
            });

            $this->info("Publish {$models_udpated->count()} {$model}");
        }

        return 0;
    }
}
