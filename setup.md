# Laravel

```bash
composer create-project laravel/laravel example-app
```

## Dependencies

```bash
pnpm i
```

[https://github.com/kiwilan/steward-laravel](https://github.com/kiwilan/steward-laravel)

```bash
composer require kiwilan/steward-laravel
php artisan vendor:publish --tag="steward-config"
mkdir .vscode
cat > .vscode/settings.json << EOF
{
  "laravel-pint.configPath": "vendor/kiwilan/steward-laravel/pint.json"
}
EOF
```

[https://github.com/barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)

```bash
composer require --dev barryvdh/laravel-ide-helper
php artisan vendor:publish --provider="Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider" --tag=config
```

[laravel/telescope](https://laravel.com/docs/10.x/telescope)
[fruitcake/laravel-telescope-toolbar](https://github.com/fruitcake/laravel-telescope-toolbar)

```bash
composer require laravel/telescope
php artisan telescope:install
php artisan migrate
composer require fruitcake/laravel-telescope-toolbar --dev
```

[opcodesio/log-viewer](https://github.com/opcodesio/log-viewer)

```bash
composer require opcodesio/log-viewer
php artisan vendor:publish --tag="log-viewer-config"
```

[spatie/laravel-route-attributes](https://github.com/spatie/laravel-route-attributes)

```bash
composer require spatie/laravel-route-attributes
php artisan vendor:publish --provider="Spatie\RouteAttributes\RouteAttributesServiceProvider" --tag="config"
```

[spatie/laravel-ray](https://spatie.be/docs/ray)

```bash
composer require spatie/laravel-ray
```

[nunomaduro/larastan](https://github.com/nunomaduro/larastan)

```bash
composer require nunomaduro/larastan:^2.0 --dev
cat > phpstan.neon << EOF
includes:
  - ./vendor/nunomaduro/larastan/extension.neon

parameters:
  tmpDir: public/build/.phpstan

  paths:
    - app

  # The level 9 is the highest level
  level: 5

  checkMissingIterableValueType: false
EOF
```

## Scout

[laravel/scout](https://laravel.com/docs/10.x/scout)

```bash
composer require laravel/scout
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
composer require meilisearch/meilisearch-php http-interop/http-factory-guzzle
echo "SCOUT_DRIVER=collection # meilisearch/collection" >> .env
echo "MEILISEARCH_HOST=http://127.0.0.1:7700 # meilisearch/collection" >> .env
echo "MEILISEARCH_KEY= # meilisearch/collection" >> .env
```

## Livewire

[livewire/livewire](https://laravel-livewire.com/)

```bash
composer require livewire/livewire
php artisan livewire:publish --config
pnpm i
```

[laravel/jetstream](https://jetstream.laravel.com/3.x/introduction.html)

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire --dark
```

[artesaos/seotools](https://github.com/artesaos/seotools)

```bash
composer require artesaos/seotools
php artisan vendor:publish --provider="Artesaos\SEOTools\Providers\SEOToolsServiceProvider"
```

## Inertia

[inertiajs/inertia-laravel](https://inertiajs.com)
[laravel/jetstream](https://jetstream.laravel.com/3.x/introduction.html)

```bash
composer require laravel/jetstream
php artisan jetstream:install inertia --ssr --dark
pnpm i
```

[kiwilan/typescriptable-laravel](https://github.com/kiwilan/typescriptable-laravel)

```bash
composer require kiwilan/typescriptable-laravel
php artisan vendor:publish --tag="typescriptable-config"
pnpm add @kiwilan/typescriptable-laravel -D
```

## Filament

[filament/filament](https://filamentphp.com/)

```bash
composer require filament/filament:"^2.0"
php artisan vendor:publish --tag=filament-config
cat > database/seeders/EmptySeeder.php << EOF
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmptySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
EOF
php artisan db:seed --class=EmptySeeder
```

## Front

```bash
pnpm add -D tailwindcss @tailwindcss/forms @tailwindcss/typography @tailwindcss/aspect-ratio @tailwindcss/line-clamp postcss autoprefixer
npx tailwindcss init -p
pnpm add -D eslint typescript @antfu/eslint-config
cat > .eslintrc << EOF
{
    "extends": "@antfu",
    "rules": {
        "no-console": "warn"
    }
}
EOF
cat > .eslintignore << EOF
node_modules
public/build
public/dist
vendor
*.svg
*.html
EOF
echo "[*.{json,js,ts,vue,blade}]" >> .editorconfig
echo "indent_size = 2" >> .editorconfig
```

```bash
cat > tsconfig.json << EOF
{
    "compilerOptions": {
        "target": "esnext",
        "module": "esnext",
        "moduleResolution": "node",
        "strict": true,
        "jsx": "preserve",
        "sourceMap": true,
        "resolveJsonModule": true,
        "esModuleInterop": true,
        "skipLibCheck": true,
        "noImplicitAny": false,
        "lib": ["esnext", "dom"],
        "types": ["vite/client"],
        "typeRoots": ["./node_modules/@types", "resources/**/*.d.ts"],
        "paths": {
            "@/*": ["./resources/js/*"],
            "@": ["./resources/js"]
        }
    },
    "include": [
        "resources/**/*.ts",
        "resources/**/*.{js,jsx,ts,tsx,vue}",
        "components.d.ts",
        "auto-imports.d.ts"
    ]
}
EOF
```

-   replace `app.js` with `app.ts`
-   tasks
-   typescriptable
    -   "route" => "$route"
    -   page.props.auth.user => page.props.user

`package.json`

```json
{
    "scripts": {
        "lint": "eslint .",
        "lint:fix": "eslint . --fix"
    }
}
```

## After install

```bash
pnpm i
pnpm build
php artisan migrate:fresh --seed
./vendor/bin/pint --config vendor/kiwilan/steward-laravel/pint.json
php artisan ide-helper:generate
php artisan ide-helper:models --nowrite --reset
php artisan ide-helper:meta
php artisan ide-helper:eloquent
```

## Scripts

```json
{
    "scripts": {
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force",
            "@php artisan filament:upgrade",
            "@php artisan optimize:clear",
            "./vendor/bin/pint --config vendor/kiwilan/steward-laravel/pint.json",
            "@php artisan ide-helper:generate",
            "@php artisan ide-helper:models --nowrite --reset",
            "php artisan ide-helper:meta",
            "@php artisan ide-helper:eloquent"
        ],
        "helper": [
            "./vendor/bin/pint --config vendor/kiwilan/steward-laravel/pint.json",
            "@php artisan ide-helper:generate",
            "@php artisan ide-helper:models --nowrite --reset",
            "php artisan ide-helper:meta",
            "@php artisan ide-helper:eloquent"
        ],
        "format": [
            "./vendor/bin/pint --config vendor/kiwilan/steward-laravel/pint.json"
        ],
        "analyse": ["phpstan analyse --ansi --memory-limit=4G"],
        "insights": ["php artisan insights --ansi --no-interaction"],
        "serve": [
            "Composer\\Config::disableProcessTimeout",
            "php artisan serve"
        ],
        "test": ["@php artisan test"],
        "test:filter": ["@php artisan test --filter"],
        "test:watch": [
            "Composer\\Config::disableProcessTimeout",
            "phpunit-watcher watch"
        ],
        "test:filter:watch": [
            "Composer\\Config::disableProcessTimeout",
            "phpunit-watcher watch --filter"
        ],
        "queue:listen": [
            "Composer\\Config::disableProcessTimeout",
            "php artisan queue:listen --tries=3 --timeout=3600"
        ]
    }
}
```
