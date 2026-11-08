# Improvement Roadmap — bond-algoritma

## Completed

1. Documentation overhaul (Phase 15): `README.md`, `INSTALL.md`, `CONTRIBUTING.md`, `CHANGELOG.md`, `docs/API.md`; expanded `docs/ARCHITECTURE.md`; updated `docs/REPOSITORY_AUDIT.md`, `docs/TECHNICAL_DEBT.md`.
2. Remove duplicate `api/` skeleton.
3. Clean commented code from controllers.
4. Set `APP_DEBUG=false` in `.env.example`.
5. Add real tests (Feature + Unit + Pest E2E).

## Backlog

6. Verify Docker build/test when daemon available.
7. Consolidate near-duplicate CI workflows (`laravel.yml`, `phpunit.yml`).
8. Align Docker Compose test environment (`pgsql`/postgres) with `phpunit.xml` (sqlite) or `.env.ci`.
