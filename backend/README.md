# MakemeupAI API (Laravel 11)

REST API with Laravel Sanctum SPA cookie authentication for the Vue 3 frontend at `http://localhost:5173`.

## Prerequisites

- PHP 8.2+
- Composer 2.x
- SQLite (enabled) or MySQL

## First-time setup

```bash
cd backend
composer install
copy .env.example .env
php artisan key:generate
```

Create SQLite database file:

```bash
# Windows PowerShell
New-Item -ItemType File -Path database\database.sqlite -Force
```

Run migrations:

```bash
php artisan migrate
```

Start API server:

```bash
php artisan serve
```

API base URL: `http://localhost:8000`

## Environment (SPA auth)

Required `.env` values:

```env
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:5173
SESSION_DOMAIN=localhost
SESSION_DRIVER=database
SESSION_SAME_SITE=lax
SANCTUM_STATEFUL_DOMAINS=localhost:5173
FILESYSTEM_DISK=public
OPENWEATHER_KEY=
```

## Auth endpoints

| Method | URL | Auth |
|--------|-----|------|
| POST | `/api/auth/register` | No |
| POST | `/api/auth/login` | No |
| POST | `/api/auth/logout` | Yes (`auth:sanctum`) |
| GET | `/api/auth/me` | Yes (`auth:sanctum`) |

CSRF (Sanctum): `GET /sanctum/csrf-cookie`

## Response format

```json
{
  "success": true,
  "message": "Login successful.",
  "data": { "user": { ... } }
}
```

Errors (validation):

```json
{
  "success": false,
  "message": "Invalid credentials.",
  "data": {},
  "errors": { "email": ["..."] }
}
```

## Verify CSRF route

```bash
curl -i http://localhost:8000/sanctum/csrf-cookie
```

Expect HTTP 204/200 with `Set-Cookie` headers.

## Smoke test (register + me)

```bash
curl -c cookies.txt -b cookies.txt http://localhost:8000/sanctum/csrf-cookie
curl -c cookies.txt -b cookies.txt -X POST http://localhost:8000/api/auth/register ^
  -H "Content-Type: application/json" ^
  -H "Accept: application/json" ^
  -d "{\"name\":\"Test User\",\"email\":\"test@example.com\",\"password\":\"password123\",\"password_confirmation\":\"password123\"}"
curl -c cookies.txt -b cookies.txt http://localhost:8000/api/auth/me -H "Accept: application/json"
```

Use `localhost` (not `127.0.0.1`) for both frontend and API when testing cookies.
