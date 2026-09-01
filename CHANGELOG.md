# Changelog

All notable changes to `goldencreepertech/automobile` are documented here.
This project adheres to [Semantic Versioning](https://semver.org/).

## [Unreleased]

### Fixed
- `AutomobileSeeder` now disables foreign key checks while flushing its tables.
  MySQL refuses to `TRUNCATE` a table referenced by a foreign key even when the
  child table is empty, so seeding failed on MySQL with a 1701 error.

### Changed
- **`vehicles.fuel_type`, `body_type`, and `seating_capacity` are now real
  columns** instead of keys inside the `details` JSON blob (`fuel_type` and
  `body_type` are indexed). This models the `variant` → `vehicles` one-to-many
  properly: one trim can ship in several fuel / body / seating combinations.
  `vehicles.details` now only carries `manufacturing_origin`. The API request
  bodies, filters (`?fuel_type=`, `?body_type=`), `VehicleResource`, and OpenAPI
  annotations move the three fields up to the top level accordingly.
- `AutomobileSeeder` now carries a **fixed primary-key id on every catalog entry**
  (the array key at each level) and truncates its tables before seeding, so a
  flush + re-seed reproduces the exact same manufacturer / model / variant /
  vehicle / part ids and pivot rows. Vehicles take their variant's id. Give new
  entries the next unused id and append — never reuse, renumber, or reorder.

## [0.2.0] - 2026-08-31

### Removed
- **Static-token authentication.** The `auth.static` middleware,
  `config/static_token.php`, `AuthenticateWithStaticToken`, and the
  `automobile.auth.guard` option are gone. The bundled routes now run through
  `automobile.routes.middleware` (default `['api']`); the host application adds
  its own auth (`['api', 'auth:sanctum']`, a custom middleware, …).
- `laravel/sanctum` is no longer a runtime dependency (moved to `require-dev`
  for the demo app). Runtime require is just `laravel/framework` `^12.0`.

### Changed
- OpenAPI security scheme renamed `sanctum` → `bearerAuth` (generic HTTP bearer).

## [0.1.1] - 2026-08-31

First usable release. (`v0.1.0` was tagged with a `^11.0 || ^12.0` constraint that
Composer cannot resolve — every Laravel 11.x release carries unpatched advisories.)

### Added
- `AutomobileServiceProvider` — auto-discovered; loads the package migrations,
  registers the `auth.static` middleware alias, mounts the bundled REST API
  (guarded by `config('automobile.routes.enabled')`), merges + publishes config.
- `automobile:install` — publishes config, runs migrations, seeds the vehicle catalog.
- `automobile:seed` — re-seeds the catalog without migrating.
- `config/automobile.php` — route enable / prefix / middleware, plus
  `auth.guard` (`AUTOMOBILE_AUTH_GUARD`, default `sanctum`) for the `auth.static` fallback.
- `routes/automobile.php` — the five `apiResource` routes.

### Changed
- Converted the standalone Laravel app into an installable package
  (`type: library`, `Automobile\` → `src/`).
- Runtime dependencies trimmed to `laravel/framework` + `laravel/sanctum`.
  `darkaonline/l5-swagger`, `doctrine/annotations` and `laravel/tinker` moved to
  `require-dev`; `laravel/sail` dropped.
- Target Laravel 12 (`^12.0`). Laravel 11 is EOL and every 11.x release now carries
  unpatched security advisories, so Composer will not install it.
- Composer dist pruned to the package via `.gitattributes` `export-ignore`.

### Testing
- Isolated test suite with `orchestra/testbench` 10.
- GitHub Actions CI: PHPUnit on PHP 8.2 / 8.3 / 8.4 + Pint.

[Unreleased]: https://github.com/goldencreepertech/automobile/compare/v0.2.0...HEAD
[0.2.0]: https://github.com/goldencreepertech/automobile/compare/v0.1.1...v0.2.0
[0.1.1]: https://github.com/goldencreepertech/automobile/releases/tag/v0.1.1
