<?php

namespace App\Providers\EpubParser\Entities;

use App\Models\Tag;
use Illuminate\Support\Str;

class SubjectsParser
{
    public function __construct(
        public ?array $subjects = [],
    ) {}

    /**
     * Generate Tags from $tags
     * 
     * @param array|bool $tags 
     * @return SubjectsParser 
     */
    public static function run(array|bool $subjects): SubjectsParser
    {
        $tags_entities = [];
        if (is_array($subjects)) {
            foreach ($subjects as $key => $tag) {
                $tag_entity = null;
                $tag_name = $tag;
                $tag_slug = Str::slug($tag_name, '-');
                $tagIfExist = Tag::whereSlug($tag_slug)->first();
                if (!$tagIfExist) {
                    $tag = Tag::firstOrCreate([
                        'name' => $tag_name,
                        'slug' => $tag_slug
                    ]);
                    $tag_entity = $tag;
                } else {
                    $tag_entity = $tagIfExist;
                }
                array_push($tags_entities, $tag_entity);
            }
        }
        return new SubjectsParser(subjects: $tags_entities);
    }
}
