# Automobile

An installable **Laravel package** that ships a ready-made vehicle database — manufacturers,
models, variants, vehicles, and parts — with real seed data and an optional REST API
(optional Swagger/OpenAPI docs).

- **Composer name:** `goldencreepertech/automobile`
- **PHP namespace:** `Automobile\`
- **Requires:** PHP `^8.2`, `laravel/framework` `^12.0` — nothing else
- **License:** MIT

> The bundled routes ship with **no authentication** — the host application adds its own.
> See [Configuration](#configuration).

> Swagger doc generation is optional: `composer require --dev darkaonline/l5-swagger` in the
> consuming app to enable `php artisan l5-swagger:generate`. The controllers' OpenAPI
> annotations are inert docblocks when it isn't installed.

This repository is *also* a runnable demo Laravel app (`app/`, `bootstrap/`, `public/`,
`routes/api.php`) that consumes the package through its own service provider — exactly as a
real consuming application would.

---

## Installation

### From Packagist (once published)

```bash
composer require goldencreepertech/automobile
php artisan automobile:install
```

### From GitHub (until it lands on Packagist)

Add the repository to the consuming app's `composer.json`, then require it:

```jsonc
"repositories": [
    { "type": "vcs", "url": "https://github.com/goldencreepertech/automobile" }
]
```

```bash
composer require goldencreepertech/automobile:dev-main
php artisan automobile:install
```

### What `automobile:install` does

1. Publishes the package config (`config/automobile.php`)
2. Runs `php artisan migrate`
3. Seeds the bundled manufacturer / model / variant / vehicle / part catalog

| Flag | Effect |
| --- | --- |
| `--no-seed` | Install the schema only. Run `php artisan automobile:seed` later to populate. |
| `--force` | Overwrite config files that were already published. |

Re-seed at any time without re-migrating:

```bash
php artisan automobile:seed
```

---

## What you get

| Piece | Detail |
| --- | --- |
| Models | `Automobile\Models\{Manufacturer, VehicleModel, Variant, Vehicle, Part}` |
| Migrations | Auto-loaded from the package via `loadMigrationsFrom()` — no publish step needed |
| Seeder | `Automobile\Database\Seeders\AutomobileSeeder` — real catalog for vehicles sold in India (≈2026), plus a spare-parts catalog |
| REST API | `apiResource` routes for all five models, behind a config flag; **no auth of its own** — add yours to `automobile.routes.middleware` |
| Docs | OpenAPI annotations on the controllers + `Automobile\Swagger\SwaggerDefinitions` — rendered by `darkaonline/l5-swagger` when the consuming app adds it (dev) |

### Data model

```
Manufacturer 1──∞ VehicleModel 1──∞ Variant 1──∞ Vehicle ∞──∞ Part
```

| Table | Columns |
| --- | --- |
| `manufacturers` | `id`, `name` (unique), timestamps |
| `models` | `id`, `manufacturer_id`, `name`, timestamps — unique on `(manufacturer_id, name)` |
| `variants` | `id`, `model_id`, `name`, timestamps — unique on `(model_id, name)` |
| `vehicles` | `id`, `variant_id`, `launch_date` (nullable), `discontinue_date` (nullable), `details` (json), timestamps |
| `parts` | `id`, `name`, `part_number` (nullable), `category` (nullable), `details` (json), timestamps |
| `part_vehicle` | `vehicle_id`, `part_id` — unique on `(vehicle_id, part_id)` |

`vehicles.details` holds `manufacturing_origin`, `fuel_type`, `body_type`, `seating_capacity`.
`parts.details` holds `manufacturer`, `compatibility`.

> The `VehicleModel` model maps to the `models` table (`protected $table = 'models'`) to
> avoid clashing with the word "Model".

---

## REST API

Enabled by default. Every route is registered under
`config('automobile.routes.prefix')` (default `api/v1`) with the
`config('automobile.routes.middleware')` stack (default `['api']` — add your auth guard).

| Method | URI | Action | Notes |
| --- | --- | --- | --- |
| `GET` | `/manufacturers` | list | `?name=` partial filter (not paginated) |
| `POST` | `/manufacturers` | create | `{ "name": "..." }` |
| `GET` | `/manufacturers/{id}` | show | eager-loads `models` |
| `PUT/PATCH` | `/manufacturers/{id}` | update | |
| `DELETE` | `/manufacturers/{id}` | delete | `204` |
| `GET` | `/models` | list | `?manufacturer_id=` `?name=` · paginated (15) |
| `POST` | `/models` | create | `{ "manufacturer_id", "name" }` |
| `GET/PUT/PATCH/DELETE` | `/models/{id}` | show / update / delete | |
| `GET` | `/variants` | list | `?model_id=` `?name=` · paginated (15) |
| `POST` | `/variants` | create | `{ "model_id", "name" }` |
| `GET/PUT/PATCH/DELETE` | `/variants/{id}` | show / update / delete | |
| `GET` | `/vehicles` | list | `?variant_id=` `?fuel_type=` `?body_type=` `?manufacturing_origin=` `?launch_date_from=` `?launch_date_to=` · paginated (15) |
| `POST` | `/vehicles` | create | `{ "variant_id", "launch_date?", "discontinue_date?", "details?": {...}, "parts?": [ids] }` |
| `GET/PUT/PATCH/DELETE` | `/vehicles/{id}` | show / update / delete | `show` eager-loads `variant.model.manufacturer` + `parts` |
| `GET` | `/parts` | list | `?name=` `?category=` `?part_number=` · paginated (15) |
| `POST` | `/parts` | create | `{ "name", "part_number?", "category?", "details?": {...}, "vehicles?": [ids] }` |
| `GET/PUT/PATCH/DELETE` | `/parts/{id}` | show / update / delete | |

### Example

```bash
curl -H "Accept: application/json" \
     "https://your-app.test/api/v1/vehicles?fuel_type=Electric&body_type=SUV"
```

```jsonc
{
  "data": [
    {
      "id": 42,
      "variant_id": 118,
      "launch_date": "2022-10-11",
      "discontinue_date": null,
      "details": {
        "manufacturing_origin": "China",
        "fuel_type": "Electric",
        "body_type": "SUV",
        "seating_capacity": 5
      }
    }
  ],
  "links": { "first": "...", "last": "...", "prev": null, "next": "..." },
  "meta": { "current_page": 1, "per_page": 15, "total": 30 }
}
```

---

## Configuration

`config/automobile.php` (publish tag `automobile-config`):

```php
'routes' => [
    'enabled'    => (bool) env('AUTOMOBILE_ROUTES_ENABLED', true),
    'prefix'     => env('AUTOMOBILE_ROUTES_PREFIX', 'api/v1'),
    'middleware' => ['api'],
],
```

Set `AUTOMOBILE_ROUTES_ENABLED=false` to keep only the models / migrations / seeder and
expose the data through your own controllers.

### Authentication

The package ships none. The bundled routes run through whatever you put in
`automobile.routes.middleware` — publish the config and add your guard:

```php
'middleware' => ['api', 'auth:sanctum'],   // or 'auth', a custom middleware, ...
```

Leave it as `['api']` and the endpoints are public.

### Publishable tags

| Tag | Publishes |
| --- | --- |
| `automobile-config` | `config/automobile.php` |
| `automobile-migrations` | The domain migration files — only if you want to customize the schema *and* stop the package auto-loading its migrations |

---

## Running the demo app locally

```bash
composer install
cp .env.example .env        # already present; adjust DB credentials
php artisan key:generate
php artisan migrate --seed
php artisan l5-swagger:generate   # regenerate storage/api-docs from annotations
php artisan serve
```

Swagger UI is then at `/api/documentation`. Set `L5_SWAGGER_CONST_HOST` in `.env` to the
public base URL used in the generated spec's `@OA\Server`.

The demo defines its own API — including Sanctum-based `login` / `register` / `user` /
`logout` and `auth:sanctum`-guarded resource routes — in `routes/api.php`, so it sets
`AUTOMOBILE_ROUTES_ENABLED=false` to avoid duplicate resource routes. The Laravel/Sanctum
core tables (`users`, `cache`, `jobs`, `personal_access_tokens`) live in
`database/migrations/host/` and are loaded only by the demo's `AppServiceProvider`, never by
the package.

---

## Testing

The package is tested in isolation with [Testbench](https://github.com/orchestral/testbench)
(no host app needed):

```bash
composer install
vendor/bin/phpunit
vendor/bin/pint --test   # code style
```

CI (`.github/workflows/ci.yml`) runs the suite on PHP 8.2 / 8.3 / 8.4.

---

## Package layout

```
src/
  AutomobileServiceProvider.php      # migrations, routes, publishing, commands
  Console/Commands/                  # automobile:install, automobile:seed
  Models/                            # Manufacturer, VehicleModel, Variant, Vehicle, Part
  Http/Controllers/                  # apiResource controllers (OpenAPI-annotated)
  Http/Resources/                    # API Resources for response shaping
  Swagger/SwaggerDefinitions.php     # @OA\Info / @OA\Server / @OA\SecurityScheme
  Database/Seeders/AutomobileSeeder.php
config/                    automobile.php  (+ demo app config)
routes/automobile.php      bundled REST API routes (loaded by the service provider)
database/migrations/       domain tables (shipped by the package)
database/migrations/host/  Laravel/Sanctum core tables (demo app only)
```

---

## Roadmap

- [x] Package skeleton — `type: library`, `Automobile\` → `src/`, domain code moved out of `app/`
- [x] `AutomobileServiceProvider` — migrations, config-guarded routes, config merge + publish
- [x] Auto-discovery via `composer.json` `extra.laravel.providers`
- [x] One-command install — `automobile:install` (+ `automobile:seed`)
- [x] Runtime dep is just `laravel/framework` `^12.0` — no bundled auth (host brings its own)
- [x] Isolated package tests with `orchestra/testbench` + GitHub Actions CI
- [x] Verified `automobile:install` end-to-end in a clean Testbench app
- [ ] Submit to [Packagist](https://packagist.org/) as `goldencreepertech/automobile` + auto-update hook

---

## After a code change

Run this locally before committing. All commands are from the repo root.

```bash
# 1. Dependencies (only if composer.json changed)
composer update --no-interaction        # otherwise: composer install

# 2. Auto-fix code style, then verify
vendor/bin/pint
vendor/bin/pint --test

# 3. Test suite (Testbench — no host app needed)
vendor/bin/phpunit

# 4. Manifest + advisories
composer validate
composer audit

# 5. If you touched controllers / @OA annotations, regenerate the demo spec
php artisan l5-swagger:generate

# 6. Optional: exercise the package as a real consumer (fresh skeleton app)
DB_CONNECTION=sqlite DB_DATABASE=":memory:" vendor/bin/testbench automobile:install
#   ^ this writes vendor/orchestra/testbench-core/laravel/{.env,config/automobile.php}.
#     Delete them afterwards or `vendor/bin/phpunit` may 404 on the bundled routes:
rm -f vendor/orchestra/testbench-core/laravel/.env \
      vendor/orchestra/testbench-core/laravel/config/automobile.php
```

Then commit and push:

```bash
git add -A
git commit -m "Describe the change"
git push origin main
```

### Cutting a release

```bash
# 1. Move the "Unreleased" notes in CHANGELOG.md under a new "## [X.Y.Z] - YYYY-MM-DD"
#    heading and update the link refs at the bottom, then commit it.
git add CHANGELOG.md && git commit -m "Changelog: X.Y.Z"

# 2. Tag and push (annotated tag)
git tag -a vX.Y.Z -m "vX.Y.Z — one-line summary"
git push origin main
git push origin vX.Y.Z
```

Versioning (pre-1.0): bump **patch** for fixes, **minor** for features or any
breaking change. Packagist publishes the new tag automatically once the
[Packagist GitHub App](https://github.com/apps/packagist) is installed on the repo.
