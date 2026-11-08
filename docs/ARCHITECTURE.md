# Architecture — bond-algoritma

Laravel 13 (PHP ^8.5) modular monolith exposing a REST API for Bonds and PurchaseOrders. Single deployable with a rich domain layer for bond pricing and a thinner PurchaseOrder domain.

## Layers

### HTTP

- `routes/api.php` — resource routes plus custom bond/order endpoints.
- `App\Http\Controllers\API\{BondController,PurchaseOrderController}` — thin controllers using constructor dependency injection (`BondPricingService` injected into `BondController`).
- `App\Http\Resources\{Bond,PurchaseOrder}Resource` — JSON resource transformation.

### Domain (modules under `App\Modules\`)

- `Bond`:
  - `Entities\BondTerms` — domain terms built from a Bond model (`fromBond`).
  - `Services\BondPricingService` — payout-date and order-payout calculation.
  - `ValueObjects\{DateRange,Money}` — immutable value objects.
  - `Http\Requests\{BondStoreRequest,BondUpdateRequest}` — form-request validation.
- `PurchaseOrder`:
  - `Http\Requests\{PurchaseOrderStoreRequest,PurchaseOrderUpdateRequest}` — form-request validation.

### Persistence

- `App\Models\{Bond,PurchaseOrder,User}` — Eloquent models.
- `database/migrations` — `bonds`, `purchase_orders` (FK `bond_id` → `bonds.id`, cascade delete).

## Data flow

### Bond payout dates (`GET /api/bonds/{id}/payouts`)

1. Controller fetches the `Bond`.
2. `BondPricingService::calculatePayoutDates($bond)` builds `BondTerms::fromBond($bond)`.
3. `BondTerms` constructs a `DateRange` (emisia_date → turnover_date) and a `Money` value object from `nominal_price`.
4. Based on `period_for_calculating_interest` (360/364 → day, 365 → month), dates are stepped and weekend dates shift to the next Monday.

### Purchase order creation (`POST /api/bonds/{id}/order`)

1. `PurchaseOrderController::store` validates the payload (`PurchaseOrderStoreRequest`).
2. Loads the `Bond`, checks `order_date` is not before `emisia_date` and not after `turnover_date` (422 with Azerbaijani messages).
3. Creates the `PurchaseOrder` linked to the bond.

### Order payouts (`GET /api/bond/order/{id}`)

1. Loads the `PurchaseOrder` and its `Bond`.
2. `BondPricingService::calculateOrderPayouts` computes accumulated interest per payout date using nominal price, coupon interest, frequency, and day counts.

## Module boundary rules

- `Bond` owns pricing domain logic (Entities, Services, ValueObjects); `PurchaseOrder` only carries validation requests and delegates pricing to `Bond\Services\BondPricingService`.
- `PurchaseOrderController` depends on `App\Models\Bond` (read-only relationship) but does not import Bond domain services.
- Controllers never instantiate domain objects directly except via factory methods (`BondTerms::fromBond`).

## Applied principles

- SOLID: DIP — controllers receive `BondPricingService` via constructor DI.
- KISS/YAGNI: single monolith; no module extraction yet.
- Modular monolith: domain code grouped under `App\Modules\*`, persisted via Eloquent.

## Known issues (documented, not fixed in this phase)

- `.github/workflows/laravel.yml` and `.github/workflows/phpunit.yml` are near-duplicates (both run Pest on PHP 8.5).
- Docker Compose `test` service overrides `DB_CONNECTION=pgsql` + `postgres` host, while `phpunit.xml` uses SQLite (`:memory:`); `BondApiE2E` is the Pest E2E suite executed by `vendor/bin/pest` in the Docker `test` target.
