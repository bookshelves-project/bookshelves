<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:rad
                            {model : The name of the model}
                            {--f|force : overwrite existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     */
    public function __construct(
        public ?string $model = null,
        public ?string $model_lower = null,
        public ?bool $force = false,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = $this->argument('model');
        $model = ucfirst($model);
        $force = $this->option('force') ?? false;
        $this->force = $force;

        $this->alert("RAD Stack: Generate {$model} CRUD");

        try {
            $class_name = 'App\Models\\'.$model;
            $class = new $class_name();
        } catch (\Throwable $th) {
            $this->error("{$model} not found in path {$class_name}");

            exit;
        }
        $this->model = $model;
        $this->model_lower = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $model));

        $this->generateFromStub("{$this->model}Controller", app_path('Http/Controllers/Admin'), 'php');
        $this->generateFromStub("{$this->model}Query", app_path('Http/Queries'), 'php');
        $this->generateFromStub("{$this->model}Export", app_path('Exports'), 'php');
        $this->generateFromStub("{$this->model}Resource", app_path('Http/Resources/Admin'), 'php');

        $crud_path = resource_path('admin/pages')."/{$this->model_lower}s";

        $this->generateFromStub('Index', $crud_path, 'vue', 'crud/', true);
        $this->generateFromStub('Create', $crud_path, 'vue', 'crud/', true);
        $this->generateFromStub('Edit', $crud_path, 'vue', 'crud/', true);
        $this->generateFromStub("{$this->model}Form", resource_path('admin/components/forms'), 'vue', 'crud/');
        $this->generateTypeFromStub();
        $this->generateAttributes();
        $this->generateAttributes('fr');
        $this->addToNavigation();
    }

    /**
     * Generate new file from `stubs` for new model.
     */
    protected function generateFromStub(string $name, string $destination_path, string $extension, ?string $stub_path = null, ?bool $createDir = false): bool
    {
        $destination = "{$destination_path}/{$name}.{$extension}";
        $type = str_replace($this->model, '', $name);
        if (! File::exists($destination) || $this->force) {
            if ($createDir) {
                try {
                    File::makeDirectory($destination_path);
                } catch (\Throwable $th) {
                }
            }
            $stub_path = resource_path("stubs/rad/{$stub_path}{$type}Stub.{$extension}");
            $stub = File::get($stub_path);

            $stub = $this->replaceAll($stub);

            File::put($destination, $stub);

            $this->info("{$type} generated.");

            return true;
        }

        $this->error("{$type} exist!");

        return false;
    }

    /**
     * Add type in `types` for new model.
     */
    protected function generateTypeFromStub(): bool
    {
        $success = false;

        /**
         * Create new type file.
         */
        $destination_path = resource_path("admin/types/{$this->model_lower}.ts");

        if (! File::exists($destination_path) || $this->force) {
            $stub_path = resource_path('stubs/rad/crud/type-stub.ts');
            $stub = File::get($stub_path);

            $stub = $this->replaceAll($stub);

            File::put($destination_path, $stub);

            $success = true;
        }

        /**
         * Add new type to `index.ts`.
         */
        $new_import = "import { {$this->model} } from './{$this->model_lower}'\n";
        $types_path = resource_path('admin/types/index.ts');

        if (! $this->find($types_path, $new_import) || $this->force) {
            $file_part = $this->find($types_path, 'export');
            $file_part['begin'] = array_merge([$new_import], $file_part['begin']); // add import at the top of file
            $last = array_pop($file_part['end']); // remove `}` to add export
            array_push($file_part['end'], "  {$this->model},\n"); // add export
            array_push($file_part['end'], $last); // add `}` at the end of export

            $file_content = $this->mergeFind($file_part);

            $this->rewriteFile($types_path, $file_content);

            $success = true;
        }

        if ($success) {
            $this->info('Type generated.');
        } else {
            $this->error('Type exist!');
        }

        return $success;
    }

    /**
     * Add attributes to `resources/lang/{$lang}/crud.php` if not exist.
     */
    protected function generateAttributes(string $lang = 'en'): bool
    {
        $path = resource_path("lang/{$lang}/crud.php");

        $entry = "'{$this->model_lower}s' => [";
        $is_exist = $this->find($path, $entry);
        if (! $is_exist || $this->force) {
            $stubs = [
                "    {$entry}\n",
                "        'name' => '{$this->model}|{$this->model}s',\n",
                "        'attributes' => [\n",
                "        ],\n",
                "    ],\n",
            ];
            $file_content = $this->getFileContent($path);
            $last = array_pop($file_content); // remove `];` at the end
            array_push($file_content, ...$stubs); // insert new entity
            array_push($file_content, $last); // add `];` at the end
            $this->rewriteFile($path, $file_content);

            $this->info('Attributes generated.');

            return true;
        }

        $this->error('Attributes exist!');

        return false;
    }

    /**
     * Add new model to navigation `_nav.ts`.
     */
    protected function addToNavigation(): bool
    {
        $path = resource_path('admin/_nav.ts');
        $file_part = $this->find($path, 'mainNav');

        if ($file_part) {
            $is_exist = $this->find($path, "route('admin.{$this->model_lower}s')");
            if (! $is_exist || $this->force) {
                $name = ucfirst($this->model);
                $nav = [
                    "  {\n",
                    "    href: route('admin.{$this->model_lower}s'),\n",
                    "    active: () =>\n",
                    "      route().current('admin.{$this->model_lower}s') || route().current('admin.{$this->model_lower}s.*'),\n",
                    "    icon: HomeIcon,\n",
                    "    text: __('{$name}'),\n",
                    "  },\n",
                ];
                $end = array_shift($file_part['end']);
                $file_part['end'] = array_merge($nav, $file_part['end']);
                $file_part['end'] = array_merge([$end], $file_part['end']);

                $file_content = $this->mergeFind($file_part);
                $this->rewriteFile($path, $file_content);

                $this->info('Added to navigation');

                return true;
            }
        }

        $this->error('Nav exists!');

        return false;
    }

    /**
     * Replace `stub` with Model name into `$stub`.
     */
    protected function replaceAll(string $stub): string
    {
        $stub = $this->replace('/Stub/', $this->model, $stub);
        $stub = $this->replace('/stubVar/', lcfirst($this->model), $stub);
        $stub = $this->replace('/stubsVar/', lcfirst($this->model), $stub);

        return $this->replace('/stub/', $this->model_lower, $stub);
    }

    protected function replace(string $pattern, string $replace, string $file): string
    {
        return preg_replace($pattern, $replace, $file);
    }

    /**
     * Split file content into an `array`.
     */
    protected function getFileContent(string $path): array
    {
        $lines = file($path);
        $file_content = [];
        foreach ($lines as $number => $line) {
            array_push($file_content, $line);
        }

        return $file_content;
    }

    /**
     * Rewrite file at `path` with `file_content`.
     */
    protected function rewriteFile(string $path, array $file_content): void
    {
        // clear file
        file_put_contents($path, '');
        // rewrite file
        foreach ($file_content as $key => $value) {
            file_put_contents($path, $value, FILE_APPEND | LOCK_EX);
        }
    }

    /**
     * Merge array from of `find()`.
     */
    protected function mergeFind(array $file_part): array
    {
        $file_content = [];
        array_push($file_content, ...$file_part['begin']);
        array_push($file_content, ...$file_part['end']);

        return $file_content;
    }

    /**
     * Try to find an expression `$search` in file in `$path`.
     *
     * If not exist, return `false`, otherwise return an `array` with `begin[]` and `end[]`.
     *
     * ```
     * ['begin' => [], 'end' => []]
     * ```
     */
    protected function find(string $path, string $search): array|bool
    {
        $lines = file($path);
        $begin = [];
        $end = [];
        $found = false;
        foreach ($lines as $number => $line) {
            if (! $found) {
                array_push($begin, $line);
            }
            if (false !== strpos($line, $search)) {
                $found = true;
            }
            if ($found) {
                array_push($end, $line);
            }
        }
        array_pop($begin);

        if (! $found) {
            return false;
        }

        return [
            'begin' => $begin,
            'end' => $end,
        ];
    }
}
