<?php

namespace App\Console\Commands;

use App\Enums\PostStatusEnum;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled posts according to publish dates';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $posts = Post::query()
            ->scheduled()
            ->where('published_at', '<', Carbon::now())
            ->each(function (Post $post) {
                $post->update(['status' => PostStatusEnum::published()]);
            })
        ;

        return 0;
    }
}
