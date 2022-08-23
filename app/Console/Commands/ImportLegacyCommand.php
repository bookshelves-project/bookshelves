<?php

namespace App\Console\Commands;

use App\Enums\ColorEnum;
use App\Enums\MediaTypeEnum;
use App\Enums\PostTypeEnum;
use App\Enums\PublishStatusEnum;
use App\Models\Content;
use App\Models\Page;
use App\Models\Post;
use App\Models\Reference;
use App\Models\Service;
use App\Models\TeamMember;
use App\Services\HttpService\ApiLegacyResponse;
use Artisan;
use Database\Seeders\DatabaseSeeder;
use FilamentCurator\Models\Media;
use File;
use Http;
use Illuminate\Console\Command;
use Spatie\Image\Image;
use Str;

class ImportLegacyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:legacy
                            {--f|fresh : Delete all database entries before import}
                            {--F|force : Skip confirm in production when fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import old database to convert all entities to new database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $option_fresh = $this->option('fresh') ? $this->option('fresh') : false;
        $option_force = $this->option('force') ? $this->option('force') : false;
        $refresh = false;

        $this->alert('import:legacy');
        $this->warn($this->description);
        $this->newLine();

        if (! $option_force && $option_fresh && 'local' !== config('app.env')) {
            if ($this->confirm('Do you wish to continue?')) {
                $refresh = true;
            } else {
                $this->error('Aborted.');
                return 1;
            }
        }
        if ($option_fresh && 'local' === config('app.env')) {
            $refresh = true;
        }

        if ($refresh) {
            $this->warn('Database will be deleted before import.');
            DatabaseSeeder::clearMedia();
            Artisan::call('migrate:fresh');
        }
        $this->info('Importing old database...');

        $endpoints = [
            '/raw/team-members' => TeamMember::class,
            '/raw/uploads' => Media::class,
            '/raw/blocks' => Content::class,
            '/raw/posts' => Post::class,
            '/raw/pages' => Page::class,
            '/raw/references' => Reference::class,
            '/raw/services' => Service::class,
        ];
        $api_url = config('app.legacy_api_url').'/api';

        $bar = $this->output->createProgressBar(count($endpoints));

        $this->newLine();
        $bar->start();
        foreach ($endpoints as $endpoint => $model) {
            $response = Http::get("{$api_url}{$endpoint}");
            $body = json_decode($response->body(), true);
            if (array_key_exists('data', $body)) {
                $body = $body['data'];
            }
            $this->setDataToModel($model, $body);
            $bar->advance();
        }
        $bar->finish();

        $this->newLine(2);
        $this->info('Create admin...');
        Artisan::call('db:seed', [
            '--class' => 'EmptySeeder',
            '--force' => true,
        ], $this->getOutput());
        $this->info('Create legacy users...');
        Artisan::call('db:seed', [
            '--class' => 'ApiLegacySeeder',
            '--force' => true,
        ], $this->getOutput());

        return 0;
    }

    public function setDataToModel(string $model, mixed $body)
    {
        if ($body) {
            foreach ($body as $item) {
                $http = ApiLegacyResponse::create($item);

                $message = match ($model) {
                    Content::class => $this->content($http),
                    Media::class => $this->media($http),
                    Post::class => $this->post($http),
                    Page::class => $this->page($http),
                    Reference::class => $this->reference($http),
                    Service::class => $this->service($http),
                    TeamMember::class => $this->teamMember($http),
                    default => 'unknown api endpoint',
                };
            }
        }
    }

    public function content(ApiLegacyResponse $http)
    {
        Content::create([
            'key' => $http->key('slug'),
            'title' => $http->key('title'),
            'description' => $http->key('description'),
            'image' => $http->setMedia($http->key('image'), MediaTypeEnum::contents),
            'created_at' => $http->key('created_at'),
            'updated_at' => $http->key('updated_at'),
        ]);
    }

    public function media(ApiLegacyResponse $http)
    {
        $response = Http::get($http->response);
        $content = $response->body();

        $pathinfo = pathinfo($http->response);
        $filename = Str::slug($pathinfo['filename']);
        $ext = $pathinfo['extension'];
        $media_path = public_path("storage/media/{$filename}");

        File::put("{$media_path}.{$ext}", $content);
        if ('webp' !== $ext) {
            Image::load("{$media_path}.{$ext}")->save("{$media_path}.webp");
            File::delete("{$media_path}.{$ext}");
            $ext = 'webp';
        }

        $image = Image::load("{$media_path}.{$ext}");
        $size = filesize("{$media_path}.{$ext}");

        Media::create([
            'public_id' => "media/{$filename}",
            'filename' => "media/{$filename}.{$ext}",
            'ext' => $ext,
            'type' => "image/{$ext}",
            'width' => $image->getWidth(),
            'height' => $image->getHeight(),
            'disk' => 'public',
            'directory' => 'media',
            'size' => $size,
        ]);
    }

    public function page(ApiLegacyResponse $http)
    {
        Page::create([
            'title' => $http->key('title'),
            'slug' => $http->key('slug'),
            'summary' => $http->key('summary'),
            'body' => $http->setBody($http->key('body')),
            'image' => $http->setMedia($http->key('image'), MediaTypeEnum::pages),
            'meta_title' => $http->key('meta_title'),
            'meta_description' => $http->key('meta_description'),
            'created_at' => $http->key('created_at'),
            'updated_at' => $http->key('updated_at'),
        ]);
    }

    public function post(ApiLegacyResponse $http)
    {
        $post = Post::create([
            'title' => $http->key('title'),
            'subtitle' => $http->key('subtitle'),
            'slug' => $http->key('slug'),
            'summary' => $http->key('summary'),
            'body' => $http->setBody($http->key('body')),
            'image' => $http->setMedia($http->key('image'), MediaTypeEnum::posts),
            'image_extra' => $http->setMedia($http->key('image_extra'), MediaTypeEnum::posts),
            'youtube_id' => $http->key('youtube_link'),
            'is_pinned' => $http->key('is_pinned'),
            'status' => $http->key('status') ? PublishStatusEnum::tryFromCase($http->key('status')) : PublishStatusEnum::published,
            'type' => PostTypeEnum::seo->value,
            'meta_title' => $http->key('meta_title'),
            'meta_description' => $http->key('meta_description'),
            'cta' => $http->key('cta'),
            'published_at' => $http->key('publication_date') ? date($http->key('publication_date')) : null,
            'created_at' => $http->key('created_at'),
            'updated_at' => $http->key('updated_at'),
        ]);

        $author_raw = $http->key('author') ? $http->key('author')['firstname'] : null;
        $author_2_raw = $http->key('author_2') ? $http->key('author_2')['firstname'] : null;

        $authors = [];
        $authors[] = TeamMember::whereFirstname($author_raw)->first();
        $authors[] = TeamMember::whereFirstname($author_2_raw)->first();
        $authors = array_filter($authors);

        $post->authors()->saveMany($authors);
        $post->save();
    }

    public function reference(ApiLegacyResponse $http)
    {
        Reference::create([
            'title' => $http->key('title'),
            'slug' => $http->key('slug'),
            'summary' => $http->key('summary'),
            'site_url' => $http->key('site_url'),
            'image' => $http->setMedia($http->key('logo'), MediaTypeEnum::references),
            'alternate_blocks' => $http->setBlocks($http->key('text_blocks'), MediaTypeEnum::references),
            'meta_title' => $http->key('meta_title'),
            'meta_description' => $http->key('meta_description'),
            'presentation_title' => $http->key('presentation_title'),
            'presentation_text' => $http->key('presentation_text'),
            'presentation_year' => $http->key('presentation_year'),
            'testimony_title' => $http->key('testimony_title'),
            'testimony_text' => $http->key('testimony_text'),
            'testimony_image' => $http->setMedia($http->key('testimony_image'), MediaTypeEnum::references),
            'cta' => $http->key('cta'),
            'published_at' => date('Y-m-d'),
            'status' => PublishStatusEnum::published->value,
            'created_at' => $http->key('created_at'),
            'updated_at' => $http->key('updated_at'),
        ]);
    }

    public function service(ApiLegacyResponse $http)
    {
        Service::create([
            'title' => $http->key('title'),
            'subtitle' => $http->key('subtitle'),
            'slug' => $http->key('slug'),
            'color' => ColorEnum::tryFromCase($http->key('color')),
            'introduction' => $http->key('introduction'),
            'hang' => $http->key('hang'),
            'body' => $http->setBody($http->key('body')),
            'image' => $http->setMedia($http->key('image'), MediaTypeEnum::services),
            'image_extra' => $http->setMedia($http->key('image_extra'), MediaTypeEnum::services),
            'meta_title' => $http->key('meta_title'),
            'meta_description' => $http->key('meta_description'),
            'alternate_blocks' => $http->setBlocks($http->key('text_blocks'), MediaTypeEnum::services),
            'title_after_purple_block' => $http->key('secondTitle'),
            'cta_purple_block' => $http->key('ctaTitle'),
            'accordion_title' => $http->key('accordeonTitle'),
            'accordion_blocks' => $http->setBlocks($http->key('accordeon'), MediaTypeEnum::services),
            'accordion_image' => $http->setMedia($http->key('imgAccordeon'), MediaTypeEnum::services),
            'testimonies_blocks' => $http->setBlocks($http->key('temoignages'), MediaTypeEnum::services),
            'cta' => $http->key('cta'),
            'sort' => $http->key('lft'),
            'created_at' => $http->key('created_at'),
            'updated_at' => $http->key('updated_at'),
        ]);
    }

    public function teamMember(ApiLegacyResponse $http)
    {
        TeamMember::create([
            'firstname' => $http->key('firstname'),
            'lastname' => $http->key('lastname'),
            'function' => $http->key('function'),
            'image' => $http->setMedia($http->key('image'), MediaTypeEnum::team_members),
            'description' => $http->key('description'),
            'is_active' => $http->key('state'),
            'sort' => $http->key('lft'),
            'created_at' => $http->key('created_at'),
            'updated_at' => $http->key('updated_at'),
        ]);
    }
}
