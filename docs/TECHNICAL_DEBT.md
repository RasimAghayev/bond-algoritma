# Technical Debt — bond-algoritma

- Resolved: duplicate `api/` skeleton removed.
- Resolved: commented-out code cleaned from controllers.
- Resolved: `APP_DEBUG=false` in `.env.example`.
- Open: near-duplicate CI workflows (`laravel.yml` ≡ `phpunit.yml`) — consolidate.
- Open: Docker Compose test/postgres vs `phpunit.xml` sqlite mismatch — align test environment.
