<?php

namespace App\Console\Commands;

use App\Models\Tag;
use App\Models\TagExtend;
use DB;
use Illuminate\Console\Command;

class TagCleanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tag:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean taggables pivot table.';

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

        $taggables = DB::table('taggables')->get();
        foreach ($taggables as $row) {
            $model = $row->taggable_type::find($row->taggable_id);
            if (null === $model) {
                DB::table('taggables')->where('id', $row->id)->delete();
                $this->warn("Deleted taggable entry: {$row->taggable_type} #{$row->taggable_id}");
            }

            $tag = TagExtend::find($row->tag_id);
            if (null === $tag) {
                DB::table('taggables')->where('id', $row->id)->delete();
                $this->warn("Deleted taggable entry: Tag #{$row->id}");
            }
        }

        return 0;
    }
}
