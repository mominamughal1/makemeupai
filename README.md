# MakemeupAI (Monorepo)

Hybrid styling and beautician booking platform — Vue 3 SPA + Laravel 11 REST API.

## Project structure

```text
./                 Vue 3 frontend (port 5173)
backend/           Laravel 11 API (port 8000)
docs/              Project documentation
```

## Stack

| Layer | Technologies |
|-------|----------------|
| Frontend | Vue 3, Vite, Vue Router, Tailwind CSS |
| Backend | Laravel 11, Sanctum (SPA cookie auth), SQLite/MySQL |

## Clone and environment setup

After cloning [github.com/Huzaifa690-arch/makemeupai](https://github.com/Huzaifa690-arch/makemeupai):

```bash
npm install
copy .env.example .env.local
cd backend
composer install
copy .env.example .env
php artisan key:generate
```

Do not commit `.env.local` or `backend/.env` — they are gitignored and hold local secrets and API keys.

## Quick start (both apps)

### Frontend

```bash
npm install
npm run dev
```

Open: `http://localhost:5173`

### Backend

Requires **PHP 8.2+** and **Composer** on your machine.

```bash
cd backend
composer install
copy .env.example .env
php artisan key:generate
```

Create SQLite DB and migrate:

```powershell
# Windows
New-Item -ItemType File -Path database\database.sqlite -Force
php artisan migrate
php artisan serve
```

Or run automated setup:

```powershell
cd backend
.\setup.ps1
php artisan serve
```

API: `http://localhost:8000`

## Backend auth API

| Method | Endpoint |
|--------|----------|
| GET | `/sanctum/csrf-cookie` |
| POST | `/api/auth/register` |
| POST | `/api/auth/login` |
| POST | `/api/auth/logout` (auth required) |
| GET | `/api/auth/me` (auth required) |

SPA env (see `backend/.env.example`):

- `SESSION_DOMAIN=localhost`
- `SANCTUM_STATEFUL_DOMAINS=localhost:5173`
- CORS allows `http://localhost:5173` with credentials

Details: [backend/README.md](backend/README.md)

## Documentation

- [docs/INSTALLATION_GUIDE.md](docs/INSTALLATION_GUIDE.md)
- [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md)
- [docs/API_CONTRACTS.md](docs/API_CONTRACTS.md)
- [docs/PROGRESS.md](docs/PROGRESS.md)
- [docs/CHANGELOG.md](docs/CHANGELOG.md)

## Status

- Frontend: componentized marketing/app shell with routed pages
- Backend: Sanctum SPA auth API scaffolded (run `composer install` locally to activate)
