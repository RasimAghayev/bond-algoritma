# bond-algoritma

[![Views](https://hits.sh/github.com/RasimAghayev/bond-algoritma.svg?label=views&color=0e75b6)](https://github.com/RasimAghayev/bond-algoritma)

[![Actions Status](https://github.com/RasimAghayev/bond-algoritma/actions/workflows/laravel.yml/badge.svg)](https://github.com/RasimAghayev/bond-algoritma/actions)

[![Run in Postman](https://run.pstmn.io/button.svg)](https://documenter.getpostman.com/view/1965733/Uz5NiDCK)

[![SonarCloud](https://sonarcloud.io/images/project_badges/sonarcloud-orange.svg)](https://sonarcloud.io/summary/new_code?id=RasimAghayev_bond-algoritma)

Laravel 13 (PHP ^8.5) modular monolith REST API for bonds and purchase orders, with bond interest/payout calculation.

## Stack

- Laravel Framework ^13.0, PHP ^8.5
- Laravel Sanctum, Guzzle, Tinker
- Pest (tests/Pest.php, tests/E2E) with PHPUnit (phpunit.xml, tests/Feature, tests/Unit)
- PHPStan, Psalm, Rector static analysis (GitHub Actions)
- Docker (multi-stage), PostgreSQL in Docker Compose

## Requirements

- PHP 8.5+ and Composer (local setup)
- Docker + Docker Compose (Docker setup)

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate --ansi
php artisan migrate --seed
php artisan serve
```

The app serves on `http://127.0.0.1:8000` by default. API base path: `/api`.

## Docker setup

```bash
docker compose up -d            # app on port 20100, postgres on 20101
docker compose run --rm test    # run the test suite
```

- `app` service: `http://localhost:20100`
- `postgres` service: `localhost:20101` (user/password/db: `postgres`/`postgres`/`bond`)
- `test` service: builds the `test` target and runs `vendor/bin/pest`

## API reference

Base path: `/api` (example: `https://bond-algoritma.herokuapp.com/api/`).

| Method | Path | Description | Body / Query |
|--------|------|-------------|--------------|
| GET | `/api/bonds` | List bonds | — |
| POST | `/api/bonds` | Create a bond | Bond payload (see validation) |
| GET | `/api/bonds/{id}` | Get a bond | — |
| PUT/PATCH | `/api/bonds/{id}` | Update a bond | Bond payload |
| DELETE | `/api/bonds/{id}` | Delete a bond | — |
| GET | `/api/bonds/{id}/payouts` | Bond payout dates | `?arr=1` returns raw array |
| GET | `/api/purchase_orders` | List purchase orders | — |
| POST | `/api/purchase_orders` | Create a purchase order | Order payload |
| GET | `/api/purchase_orders/{id}` | Get a purchase order | — |
| PUT/PATCH | `/api/purchase_orders/{id}` | Update a purchase order | Order payload |
| DELETE | `/api/purchase_orders/{id}` | Delete a purchase order | — |
| POST | `/api/bonds/{id}/order` | Create an order for a bond | `order_date`, `number_bonds_received` |
| GET | `/api/bond/order/{id}` | Order payouts / interest payments | — |

Routes are not protected by authentication middleware (Sanctum is installed but the user endpoint is commented out). See `docs/API.md` for request/response examples and validation rules.

## Links

- Postman collection: https://documenter.getpostman.com/view/1965733/Uz5NiDCK
- Heroku: https://bond-algoritma.herokuapp.com/api/

## Özet (Azerbaijani)

Bond-algoritma — bu Laravel 13 API-də obligasiyalar və 사ifə (purchase order) əməliyyatları,idarə olunur. PHP 8.5 tələb olunur. Yerli qurulum: `composer install`, `.env.example`-dən `.env` yaradılması, `php artisan key:generate`, `php artisan migrate --seed`, `php artisan serve`. Docker ilə: `docker compose up -d` və `docker compose run --rm test`. API nëticələri JSON ötürür və 422 xətaları Azərbaycan dilində qaytarılır.
