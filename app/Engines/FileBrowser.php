<?php

namespace App\Engines;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class FileBrowser
{
    /**
     * @param  string[]  $files
     * @param  string|string[]|null  $jsonKey
     */
    protected function __construct(
        protected string $pathToScan,
        protected string $jsonPath,
        protected int|false $limit = false,
        protected bool $pathExists = false,

        protected array $files = [],
        protected int $total = 0,
        protected array $skipExtensions = [],

        protected string $engine = 'native',
        protected array $arguments = [],
        protected string|array|null $jsonKey = null,
        protected ?string $commandOutput = null,
        protected bool $commandSuccess = false,

        protected float $timeElapsed = 0,
        protected ?string $error = null,
    ) {
    }

    /**
     * Make a new instance of the class.
     *
     * @param  string  $pathToScan  The path to scan.
     * @param  string  $jsonPath  The path to save the json file.
     */
    public static function make(string $pathToScan, string $jsonPath): self
    {
        $self = new self($pathToScan, $jsonPath);
        $self->pathExists = file_exists($pathToScan);

        if (! $self->pathExists) {
            return $self;
        }

        $jsonDir = dirname($jsonPath);
        if (! file_exists($jsonPath) && ! is_dir($jsonDir)) {
            mkdir($jsonDir, recursive: true);
        }

        return $self;
    }

    public function limit(int|false $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function skipExtensions(array $skipExtensions): self
    {
        $this->skipExtensions = $skipExtensions;

        return $this;
    }

    /**
     * Set the engine to use.
     *
     * @param  string  $cmd  The command to use.
     * @param  string[]  $arguments  The arguments to pass to the command.
     * @param  string|string[]|null  $jsonKey  The key to get from the json output.
     */
    public function engine(string $cmd, array $arguments, string|array|null $jsonKey): self
    {
        $this->engine = $cmd;
        $this->arguments = $arguments;

        if ($jsonKey) {
            $this->jsonKey = $jsonKey;
        }

        return $this;
    }

    public function run(): self
    {
        $startTime = microtime(true);

        if ($this->engine === 'native') {
            $files = [];
            $this->files = $this->native($this->pathToScan, $files);
        } else {
            $this->command($this->engine, $this->arguments);

            if ($this->commandSuccess) {
                $contents = json_decode(file_get_contents($this->jsonPath), true);

                if ($this->jsonKey) {
                    if (is_array($this->jsonKey)) {
                        foreach ($this->jsonKey as $key) {
                            $contents = $contents[$key];
                        }
                    } else {
                        $contents = $contents[$this->jsonKey];
                    }

                    if (! $contents) {
                        $contents = [];
                    }

                    $this->files = $contents;
                }
            } else {
                $files = [];
                $this->files = $this->native($this->pathToScan, $files);
            }
        }

        $this->total = count($this->files);

        $this->limiting();
        $this->cleaning();

        $this->total = count($this->files);
        $this->saveJson($this->files);

        $endTime = microtime(true);

        $this->timeElapsed = $endTime - $startTime;
        $this->timeElapsed = floatval(number_format($this->timeElapsed, 2, '.', ''));

        return $this;
    }

    public function isExists(): bool
    {
        return $this->pathExists;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getTimeElapsed(): float
    {
        return $this->timeElapsed;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * Parse files with glob.
     */
    private function native(string $path, array &$results = []): array
    {
        $files = glob($path.'/*');
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->native($file, $results);
            } else {
                $results[] = $file;
            }
        }

        return $results;
    }

    /**
     * Parse files with glob.
     */
    private function command(string $cmd, array $arguments): self
    {
        if (! $this->commandExists($cmd)) {
            $this->error = "FileBrowser: command `{$cmd}` not found";

            return $this;
        }

        $process = new Process([$cmd, ...$arguments]);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->commandOutput = $process->getOutput();
        $this->commandSuccess = true;

        return $this;
    }

    private function commandExists(string $cmd): bool
    {
        $return = shell_exec(sprintf('which %s', escapeshellarg($cmd)));

        return ! empty($return);
    }

    private function limiting(): void
    {
        if ($this->limit && $this->total > $this->limit) {
            $this->files = array_slice($this->files, 0, $this->limit);
            $this->total = count($this->files);
        }
    }

    /**
     * Clean files list.
     */
    private function cleaning(): void
    {
        $files = $this->files;

        $files = array_map(function (string $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            if (str_starts_with($filename, '.')) {
                return;
            }

            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($extension, $this->skipExtensions)) {
                return;
            }

            if (empty($filename)) {
                return;
            }

            return $file;

        }, $files);

        $files = array_filter($files);
        $files = array_values($files);
        sort($files);

        $this->files = $files;
    }

    /**
     * Save files as JSON.
     *
     * @param  string[]  $files
     */
    private function saveJson(array $files): void
    {
        if (file_exists($this->jsonPath)) {
            unlink($this->jsonPath);
        }

        if (! is_dir(dirname($this->jsonPath))) {
            mkdir(dirname($this->jsonPath), recursive: true);
        }

        $contents = json_encode($files, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->jsonPath, $contents);
    }
}
