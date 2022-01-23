<?php

use App\Enums\RoleEnum;
use App\Exports\UserExport;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Inertia\Testing\Assert;
use Maatwebsite\Excel\Facades\Excel;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->superAdmin()->create());
    User::addGlobalScope('admin', fn (Builder $builder) => $builder->where('role', '!=', RoleEnum::super_admin()));
});

test('admin can list users', function () {
    User::factory()->create([
        'name' => 'The first user name',
        'email' => 'The first email user',
    ]);
    User::factory(29)->create();

    $response = get('/admin/users');

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('users/Index')
            ->where('action', 'list')
            ->where('users.data.0.name', 'The first user name')
            ->where('users.data.0.email', 'The first email user')
            ->where('users.meta.total', 30)
    );
});

test('admin can sort users', function (string $sort, $expected) {
    User::factory()->createMany(
        collect(range(1, 9))->map(fn ($i) => [
            'name' => "user {$i}",
            'email' => "user-{$i}@example.com",
        ])->toArray()
    );

    $response = get("/admin/users?sort={$sort}");

    $attribute = Str::of($sort)->trim('-');

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('users/Index')
            ->where('action', 'list')
            ->where("users.data.0.{$attribute}", $expected)
            ->where('users.meta.total', 9)
            ->where('sort', $sort)
    );
})->with([
    ['name', 'user 1'],
    ['-name', 'user 9'],
]);

test('admin can filter users', function (array $filter, int $total) {
    User::factory()->createMany(
        collect(range(1, 9))->map(fn ($i) => [
            'name' => "user {$i}",
            'email' => "user-{$i}@example.com",
            'role' => RoleEnum::user(),
        ])->toArray()
    );

    $query = filterAsQuery($filter);
    $response = get("/admin/users?{$query}");

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('users/Index')
            ->where('action', 'list')
            ->where('users.meta.total', $total)
            ->where('filter', $filter)
    );
})->with([
    [['q' => 'user'], 9],
    [['q' => 'user 9'], 1],
    [['name' => 'user 9'], 1],
    [['email' => 'user'], 9],
    [['email' => 'user-5'], 1],
    [['name' => 'user 1', 'email' => 'user-1'], 1],
    [['name' => 'user 1', 'email' => 'user-2'], 0],
    [['active' => '1'], 9],
    [['active' => '0'], 0],
    [['role' => 'user'], 9],
    [['role' => 'admin'], 0],
]);

test('admin can export users', function () {
    Excel::fake();
    User::factory(9)->create();

    get('/admin/users?export=1');

    Excel::matchByRegex();
    Excel::assertDownloaded('/export-.*\\.xlsx/', function (UserExport $export) {
        return 9 === $export->query()->count() && $export->headings() && $export->map($export->query()->first());
    });
});

test('admin can render user create page', function () {
    $response = get('/admin/users/create');

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('users/Index')
            ->where('action', 'create')
    );
});

test('admin can render user show page', function () {
    /** @var User */
    $user = User::factory()->create();

    $response = get("/admin/users/{$user->id}");

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('users/Index')
            ->where('action', 'show')
            ->where('user.id', $user->id)
            ->where('user.name', $user->name)
            ->where('user.email', $user->email)
    );
});

test('admin can render user edit page', function () {
    /** @var User */
    $user = User::factory()->create();

    $response = get("/admin/users/{$user->id}/edit");

    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('users/Index')
            ->where('action', 'edit')
            ->where('user.id', $user->id)
            ->where('user.name', $user->name)
            ->where('user.email', $user->email)
    );
});

test('admin can store user', function () {
    $response = post('/admin/users', [
        'name' => 'example',
        'email' => 'user@example.com',
        'password' => 'password',
        'active' => true,
        'role' => RoleEnum::user(),
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionDoesntHaveErrors()
        ->assertRedirect('/admin/users')
    ;

    assertDatabaseHas('users', [
        'name' => 'example',
        'email' => 'user@example.com',
        'active' => true,
        'role' => RoleEnum::user(),
    ]);
});

test('admin cannot store user with invalid data', function () {
    $response = post('/admin/users', [
        'email' => 'user@example.com',
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['name'])
    ;
});

test('admin can update user', function () {
    $user = User::factory()->create();

    $response = put("/admin/users/{$user->id}", [
        'name' => 'example',
        'email' => 'user@example.com',
        'password' => 'password',
        'active' => true,
        'role' => RoleEnum::user(),
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionDoesntHaveErrors()
        ->assertRedirect('/admin/users')
    ;

    assertDatabaseHas('users', [
        'name' => 'example',
        'email' => 'user@example.com',
        'active' => true,
        'role' => RoleEnum::user(),
    ]);
});

test('admin cannot update user with invalid data', function () {
    $user = User::factory()->create();

    $response = put("/admin/users/{$user->id}", [
        'email' => 'user@example.com',
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['name'])
    ;
});

test('admin can toggle non active user to active', function () {
    $user = User::factory()->create([
        'active' => false,
    ]);

    $response = patch("/admin/users/{$user->id}/toggle", [
        'active' => true,
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionDoesntHaveErrors()
        ->assertRedirect('/admin/users')
    ;

    assertDatabaseHas('users', [
        'active' => true,
    ]);
});

test('admin can delete user', function () {
    $user = User::factory()->create([
        'email' => 'user@example.com',
    ]);

    $response = delete("/admin/users/{$user->id}");

    $response
        ->assertStatus(302)
        ->assertSessionDoesntHaveErrors()
        ->assertRedirect('/admin/users')
    ;

    assertDatabaseMissing('users', [
        'email' => 'user@example.com',
    ]);
});

test('admin can delete multiple users', function () {
    $users = User::factory(5)->create();

    $response = delete('/admin/users', [
        'ids' => $users->map(fn (User $user) => $user->id),
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionDoesntHaveErrors()
        ->assertRedirect('/admin/users')
    ;

    assertDatabaseCount('users', 1);
});
