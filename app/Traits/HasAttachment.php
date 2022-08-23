<?php

namespace App\Traits;

use App\Enums\MediaTypeEnum;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Str;

trait HasAttachment
{
    /**
     * Save attachment.
     *
     * @param string[] $fields
     */
    public function saveAttachments(array $fields, Model $model, Request $request, string $field_name = null, MediaTypeEnum $type = MediaTypeEnum::media)
    {
        $filesystem_disk = public_path('storage/'.$type->name);
        $directory_path = '/'.$type->name.'/';

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);

                $ext = $file->getClientOriginalExtension();
                $file_name = Str::slug($field_name).'-'.uniqid().'.'.$ext;
                $file_path = "{$filesystem_disk}/{$file_name}";

                File::put($file_path, $file->getContent());

                $model->{$field} = "{$directory_path}{$file_name}";
            }
        }

        return $model;
    }
}
