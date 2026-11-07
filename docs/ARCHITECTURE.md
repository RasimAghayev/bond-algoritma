# Architecture — bond-algoritma

Laravel 9 monolith (PHP ^8.0). Single deployable exposing REST API for Bonds and PurchaseOrders.

## Layers
- HTTP: routes/api.php → App\Http\Controllers\API\{Bond,PurchaseOrder}Controller
- Domain: App\Models\{Bond,PurchaseOrder}
- Resources: App\Http\Resources\{Bond,PurchaseOrder}Resource
- Persistence: Eloquent + DB (mysql/sqlite)

## Known issues
- pi/ subfolder is a near-duplicate Laravel skeleton (dead weight, Phase 7).
- Commented-out code in controllers (enums, json responses).
- APP_DEBUG=true in .env.example.
- No vendor installed; composer.lock present.

## Applied principles
- KISS/YAGNI: keep single monolith; no extraction yet.
