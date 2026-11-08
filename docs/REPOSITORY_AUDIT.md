# Repository Audit — bond-algoritma

## Stack

Laravel 13, PHP ^8.5, Sanctum, Guzzle, Tinker. Pest + PHPUnit tests; PHPStan, Psalm, Rector static analysis. Docker Compose (app + postgres + test).

## Findings (P0-P3)

- P2: Duplicate `api/` directory — resolved (removed; no `api/` directory remains).
- P2: Commented-out code blocks in controllers — resolved (controllers are clean).
- P2: `.env.example` had `APP_DEBUG=true` — resolved (`APP_DEBUG=false`).
- P3: No tests beyond scaffolding — resolved (Feature, Unit, and Pest E2E tests exist; see `tests/`).
- P3: Docker build unverified (no daemon) — open (no local Docker tooling; verify in CI).
- Open: `.github/workflows/laravel.yml` and `.github/workflows/phpunit.yml` are near-duplicates (both run Pest on PHP 8.5). Consolidate into one workflow.
- Open: Docker Compose `test` service sets `DB_CONNECTION=pgsql` + `postgres` host, while `phpunit.xml` uses SQLite (`:memory:`). Align test env with `phpunit.xml`/`.env.ci`.
