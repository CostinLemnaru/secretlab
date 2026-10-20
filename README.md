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

## Tests

```sh
docker compose exec app php artisan test
docker compose exec app php artisan test --coverage
```

## API

Live URL: https://secretlab-production.up.railway.app

Local URL: `http://localhost:8000`. Use `Content-Type: application/json` and `Accept: application/json`.

| Method | Path | Description |
| --- | --- | --- |
| POST | `/object` | Save a value, e.g. `{"mykey":"value1"}`. |
| GET | `/object/mykey` | Get the latest value. |
| GET | `/object/mykey?timestamp=1440568980` | Get the value at or before a UNIX timestamp (UTC). |
| GET | `/object/get_all_records` | Get all saved versions. |

## AI usage

AI was used to help write the code and tests.
