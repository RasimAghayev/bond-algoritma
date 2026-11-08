# Contributing — bond-algoritma

## Report a bug

Open an issue describing the expected vs. actual behavior, steps to reproduce, and the environment (PHP version, local or Docker).

## Request a feature

Open an issue with the use case and why it belongs in this project. Discuss before opening a pull request.

## Pull request workflow

1. Create a branch named `phase-<n>/<topic>` (for example `phase-15/docs-api`).
2. Make your change. Keep commits scoped to a single concern.
3. Commit with conventional commits (e.g. `docs: ...`, `feat: ...`, `fix: ...`).
4. Rebase onto `main` before merging (rebase-merge; avoid merge commits).
5. Delete the feature branch after it is merged.

## Coding standards

- Static analysis: PHPStan, Psalm, Rector (covered by `.github/workflows/{phpstan,psalm,rector}.yml`).
- Format PHP to PSR-12 before pushing.
- Keep controllers thin; business logic lives in `App\Modules\*` services and value objects.
- Do not commit commented-out code or dead weight.

## Testing

- Run the suite locally: `vendor/bin/pest` (primary runner, per Dockerfile/CI). PHPUnit config exists at `phpunit.xml` (`tests/Feature`, `tests/Unit`).
- Docker-first: `docker compose run --rm test` runs `vendor/bin/pest` against the `test` service.
- CI runs on push/pull_request to `main` (PHP 8.5) via `.github/workflows/laravel.yml` and `.github/workflows/phpunit.yml`.

## Commit authorship

No AI attribution in commits (CLAUDE.md rule 12). Do not add `Co-Authored-By` or `Claude-Session` trailers.
