# Changelog

All notable changes to `goldencreepertech/automobile` are documented here.
This project adheres to [Semantic Versioning](https://semver.org/).

## [Unreleased]

## [0.1.0] - 2026-08-31

First release.

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
- Support Laravel 11 **and** 12 (`^11.0 || ^12.0`).
- Composer dist pruned to the package via `.gitattributes` `export-ignore`.

### Testing
- Isolated test suite with `orchestra/testbench` (Laravel 11 + 12).
- GitHub Actions CI: PHPUnit matrix (PHP 8.2/8.3 × Laravel 11/12) + Pint.

[Unreleased]: https://github.com/goldencreepertech/automobile/compare/v0.1.0...HEAD
[0.1.0]: https://github.com/goldencreepertech/automobile/releases/tag/v0.1.0
