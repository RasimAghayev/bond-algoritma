# Changelog — bond-algoritma

All notable changes to this project are documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to Semantic Versioning.

## [Unreleased]

### Added

- Documentation overhaul: `README.md`, `INSTALL.md`, `CONTRIBUTING.md`, `CHANGELOG.md`, `docs/API.md`.
- Expanded `docs/ARCHITECTURE.md` (layers, data flow, module boundaries, principles, known issues).
- Updated `docs/REPOSITORY_AUDIT.md`, `docs/TECHNICAL_DEBT.md`, `docs/IMPROVEMENT_ROADMAP.md`.

### Changed

- Stack upgraded to Laravel 13 / PHP ^8.5 (composer.json, composer.lock).
- Modular domain layer introduced under `App\Modules\Bond` (Entities, Services, ValueObjects, Http\Requests) and `App\Modules\PurchaseOrder\Http\Requests`.

### Removed

- Duplicate `.idea` directory (already ignored by `.gitignore`).

### Fixed

- `.env.example` already uses `APP_DEBUG=false`.

## [1.0.0] — Initial tracked release

- Laravel API with Bonds and PurchaseOrders resources.
- Bond interest/payout calculation (`BondPricingService`, `BondTerms`, `DateRange`, `Money`).
- PHPUnit + Pest test suite; GitHub Actions CI; Docker Compose (app + postgres + test).

[1.0.0]: https://github.com/RasimAghayev/bond-algoritma/releases/tag/v1.0.0
