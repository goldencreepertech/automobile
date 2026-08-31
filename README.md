# Automobile

An installable **Laravel package** that ships a ready-made vehicle database — manufacturers, models, variants, vehicles, and parts — with real seed data and an optional REST API (static-token auth + Swagger/OpenAPI docs).

- **Composer name:** `goldencreepertech/automobile`
- **PHP namespace:** `Automobile\`
- **Requires:** PHP `^8.2`, Laravel `^11.0`

This repository is *also* a runnable demo Laravel app (`app/`, `bootstrap/`, `public/`, `routes/api.php`) that consumes the package through its own service provider — exactly as a real consuming application would.

## Installation (in a Laravel app)

```bash
composer require goldencreepertech/automobile
php artisan automobile:install
```

`automobile:install` publishes the package config, runs the migrations, and seeds the bundled vehicle catalog. Flags:

- `--no-seed` — install schema only; run `php artisan automobile:seed` later to populate.
- `--force` — overwrite already-published config files.

Re-seed at any time without re-migrating:

```bash
php artisan automobile:seed
```

## What you get

| Piece | Detail |
| --- | --- |
| Models | `Automobile\Models\{Manufacturer, VehicleModel, Variant, Vehicle, Part}` (`Manufacturer` → `VehicleModel` → `Variant` → `Vehicle`, plus `Part` ⇄ `Vehicle` many-to-many) |
| Migrations | Auto-loaded from the package via `loadMigrationsFrom()` — no publish step needed |
| Seeder | `Automobile\Database\Seeders\AutomobileSeeder` — real manufacturer/model/variant catalog for vehicles sold in India, plus a spare-parts catalog |
| REST API | `apiResource` routes for all five models, mounted at `config('automobile.routes.prefix')` (default `api/v1`) |
| Auth | `auth.static` middleware (`Automobile\Http\Middleware\AuthenticateWithStaticToken`) — bearer token compared against `STATIC_TOKEN`, falling back to Sanctum |
| Docs | `darkaonline/l5-swagger` annotations on the controllers + `Automobile\Swagger\SwaggerDefinitions` |

## Configuration

`config/automobile.php` (publish tag `automobile-config`):

```php
'routes' => [
    'enabled'    => env('AUTOMOBILE_ROUTES_ENABLED', true),
    'prefix'     => env('AUTOMOBILE_ROUTES_PREFIX', 'api/v1'),
    'middleware' => ['api', 'auth.static'],
],
```

Static-token auth (`config/static_token.php`):

```dotenv
IS_STATIC_TOKEN=true
STATIC_TOKEN=your-secret-token
```

Set `AUTOMOBILE_ROUTES_ENABLED=false` to keep only the models/migrations/seeder and expose the data through your own controllers.

### Publishable tags

| Tag | Publishes |
| --- | --- |
| `automobile-config` | `config/automobile.php`, `config/static_token.php` |
| `automobile-migrations` | The domain migration files — only needed if you want to customize the schema *and* stop the package auto-loading its migrations |

## Running the demo app locally

```bash
composer install
cp .env.example .env        # already present; adjust DB credentials
php artisan key:generate
php artisan migrate --seed
php artisan l5-swagger:generate
php artisan serve
```

The demo defines its own API (including `login` / `register` / `logout`) in `routes/api.php`, so it sets `AUTOMOBILE_ROUTES_ENABLED=false` to avoid duplicate resource routes. The Laravel/Sanctum core tables (`users`, `cache`, `jobs`, `personal_access_tokens`) live in `database/migrations/host/` and are loaded only by the demo's `AppServiceProvider`, never by the package.

## Package layout

```
src/
  AutomobileServiceProvider.php      # migrations, middleware alias, routes, publishing, commands
  Console/Commands/                  # automobile:install, automobile:seed
  Models/                            # Manufacturer, VehicleModel, Variant, Vehicle, Part
  Http/Controllers/                  # apiResource controllers (OpenAPI-annotated)
  Http/Resources/                    # API Resources for response shaping
  Http/Middleware/                   # AuthenticateWithStaticToken
  Swagger/SwaggerDefinitions.php     # @OA\OpenApi root
  Database/Seeders/AutomobileSeeder.php
config/            automobile.php, static_token.php  (+ demo app config)
database/migrations/       domain tables (shipped by the package)
database/migrations/host/  Laravel/Sanctum core tables (demo app only)
routes/automobile.php      bundled REST API routes
```

## Roadmap

- [x] Package skeleton — `type: library`, `Automobile\` → `src/`, domain code moved out of `app/`
- [x] `AutomobileServiceProvider` — migrations, routes (config-guarded), middleware alias, config merge + publish
- [x] Auto-discovery via `composer.json` `extra.laravel.providers`
- [x] One-command install — `automobile:install` (+ `automobile:seed`)
- [ ] Isolated package tests with `orchestra/testbench`
- [ ] Tag `v0.1.0` and submit to [Packagist](https://packagist.org/) as `goldencreepertech/automobile`
