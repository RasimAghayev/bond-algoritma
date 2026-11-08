# INSTALL — bond-algoritma

English setup instructions. A short Azerbaijani summary follows.

## Requirements

- PHP 8.5+ and Composer (local)
- Docker and Docker Compose (containerized)

## Local installation

```bash
# 1. Clone the repository
git clone https://github.com/RasimAghayev/bond-algoritma.git
cd bond-algoritma

# 2. Install PHP dependencies
composer install

# 3. Prepare the environment
cp .env.example .env
php artisan key:generate --ansi

# 4. Run migrations and seeders
php artisan migrate --seed

# 5. Serve the application
php artisan serve
```

The API is available at `http://127.0.0.1:8000/api`.

## Docker installation

```bash
# Start app (port 20100) and postgres (port 20101)
docker compose up -d

# Run the test suite
docker compose run --rm test
```

## Azerbaijani summary

Qeydiyyat və qurulum: depoyu klonlayın, `composer install` çalışdırın, `.env.example`-i `.env` olaraq kopyalayın, `php artisan key:generate` və `php artisan migrate --seed` çalışdırın, sonra `php artisan serve` ilə serveri başlatın. Docker ilə isə `docker compose up -d` və testlər üçün `docker compose run --rm test`.
