# Automobile

An installable **Laravel package** that ships a ready-made vehicle database — manufacturers,
models, variants, vehicles, and parts — with real seed data and an optional REST API
(static-token auth + optional Swagger/OpenAPI docs).

- **Composer name:** `goldencreepertech/automobile`
- **PHP namespace:** `Automobile\`
- **Requires:** PHP `^8.2`, `laravel/framework` `^11.0 || ^12.0`, `laravel/sanctum` `^4.0` — nothing else
- **License:** MIT

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

1. Publishes the package config (`config/automobile.php`, `config/static_token.php`)
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
| REST API | `apiResource` routes for all five models, behind a config flag |
| Auth | `auth.static` middleware — bearer token compared against `STATIC_TOKEN`, falling back to Sanctum |
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
`config('automobile.routes.middleware')` stack (default `['api', 'auth.static']`).

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
curl -H "Authorization: Bearer $STATIC_TOKEN" \
     -H "Accept: application/json" \
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
    'middleware' => ['api', 'auth.static'],
],
```

Set `AUTOMOBILE_ROUTES_ENABLED=false` to keep only the models / migrations / seeder and
expose the data through your own controllers.

Static-token auth (`config/static_token.php`):

```dotenv
IS_STATIC_TOKEN=true
STATIC_TOKEN=your-secret-token
```

When `IS_STATIC_TOKEN=false` the `auth.static` middleware falls straight through to Sanctum,
so you can bring your own auth by leaving it off and swapping the middleware entry.

### Publishable tags

| Tag | Publishes |
| --- | --- |
| `automobile-config` | `config/automobile.php`, `config/static_token.php` |
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

The demo defines its own API — including `login` / `register` / `user` / `logout` — in
`routes/api.php`, so it sets `AUTOMOBILE_ROUTES_ENABLED=false` to avoid duplicate resource
routes. The Laravel/Sanctum core tables (`users`, `cache`, `jobs`,
`personal_access_tokens`) live in `database/migrations/host/` and are loaded only by the
demo's `AppServiceProvider`, never by the package.

---

## Testing

The package is tested in isolation with [Testbench](https://github.com/orchestral/testbench)
(no host app needed) against Laravel 11 and 12:

```bash
composer install
vendor/bin/phpunit
vendor/bin/pint --test   # code style
```

CI (`.github/workflows/ci.yml`) runs the suite on PHP 8.2 / 8.3 × Laravel 11 / 12.

---

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
config/                    automobile.php, static_token.php  (+ demo app config)
routes/automobile.php      bundled REST API routes (loaded by the service provider)
database/migrations/       domain tables (shipped by the package)
database/migrations/host/  Laravel/Sanctum core tables (demo app only)
```

---

## Roadmap

- [x] Package skeleton — `type: library`, `Automobile\` → `src/`, domain code moved out of `app/`
- [x] `AutomobileServiceProvider` — migrations, routes (config-guarded), middleware alias, config merge + publish
- [x] Auto-discovery via `composer.json` `extra.laravel.providers`
- [x] One-command install — `automobile:install` (+ `automobile:seed`)
- [x] Trim runtime deps to `laravel/framework` + `laravel/sanctum` (l5-swagger, tinker → dev; sail dropped)
- [x] Support Laravel 11 **and** 12
- [x] Isolated package tests with `orchestra/testbench` + GitHub Actions CI
- [ ] Verify `composer require` + `automobile:install` end-to-end in a clean host app
- [ ] Tag `v0.1.0` and submit to [Packagist](https://packagist.org/) as `goldencreepertech/automobile`
