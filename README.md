# Secretlab versioned key-value API

Laravel 13 using PHP 8.4 and MySQL 8.4 in Docker.

## Local development

Requirements: Docker Engine and Docker Compose.

```sh
cp .env.example .env # Only on a fresh checkout; keep an existing .env.
docker compose build
docker compose run --rm --no-deps app composer install
docker compose run --rm --no-deps app php artisan key:generate
docker compose up -d
docker compose exec app php artisan migrate
```

```sh
docker compose exec app php artisan test
```
