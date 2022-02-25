<?php

use App\Models\User;
use function Pest\Laravel\post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can drop files from wysiwyg', function () {
    Storage::fake('files');
    $this->actingAs(User::factory()->superAdmin()->create());
    $file = UploadedFile::fake()->image('photo.jpg');

    $response = post('/admin/upload', [
        'file' => $file,
    ]);

    $response->assertJson([
        'location' => "/storage/upload/{$file->hashName()}",
    ]);

    Storage::disk('files')->assertExists("upload/{$file->hashName()}");
});

test('admin cannot drop empty files from wysiwyg', function () {
    $this->actingAs(User::factory()->superAdmin()->create());

    $response = post('/admin/upload');

    $response->assertStatus(400);
});
