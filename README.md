# MakemeupAI

**Style Smarter. Glow Better.** — A full-stack platform for digital wardrobe management, AI-inspired outfit and beauty guidance, face-based look suggestions, and beautician booking in Pakistan.

**Repository:** [github.com/mominamughal1/makemeupai](https://github.com/mominamughal1/makemeupai)  
**Live demo (frontend):** [makemeupai.vercel.app](https://makemeupai.vercel.app)  
**Forked from:** [Huzaifa690-arch/makemeupai](https://github.com/Huzaifa690-arch/makemeupai)

---

## Overview

MakemeupAI helps users plan a complete look in one place: upload clothing, get occasion-based outfit recommendations with weather context, analyze a selfie for personalized makeup and hairstyle ideas, and book verified beauticians by city, skill badge, and rating.

The project is a **monorepo**:

| Part | Stack | Default URL |
|------|--------|-------------|
| Frontend | Vue 3, Vite, Vue Router, Tailwind CSS | http://localhost:5173 |
| Backend | Laravel 11, Sanctum (SPA cookies), SQLite/MySQL | http://localhost:8000 |

---

## Current working features

All flows below are implemented and covered by automated API smoke tests (`php artisan test` — 29 tests).

### Public marketing site

- Landing page with hero CTAs, feature cards, how-it-works guide, live beautician teasers (API), wardrobe preview, and pricing
- Dedicated pages: Features, How It Works (FAQ), Beauticians directory, Pricing
- SEO: per-route meta tags, Open Graph, canonical URLs, `robots.txt`, `sitemap.xml`

### Authentication (sign up / sign in)

- **Sign up** at `/signup` — name, email, password (min 8 chars), confirm password, city
- Cookie-based Sanctum SPA auth: CSRF cookie → register → auto-login → redirect to dashboard
- Client-side validation for password length and match; server-side Laravel validation with field errors
- Logged-in users are redirected away from `/signup` and `/signin` to `/dashboard`
- **Sign in** at `/signin`; session restored on reload via `GET /api/auth/me`

### Authenticated app

| Module | Description | Status |
|--------|-------------|--------|
| **Dashboard** | Wardrobe snapshot, outfit shortcuts, upcoming bookings, Face Insights entry | Working |
| **Digital wardrobe** | Upload items by category with images; filter and manage inventory | Working |
| **Outfit recommendations** | Up to 3 combinations from your wardrobe by occasion + local weather | Working |
| **Face insights** | Upload selfie → heuristic trait analysis → makeup, hair, and mehndi suggestions | Working |
| **Beauticians** | Browse, filter by city, book sessions; skill badges and ratings | Working |
| **Bookings** | View and cancel upcoming appointments | Working |

### Face insights flow (selfie → recommendations)

1. Go to **Face Insights** (`/face-insights`) after signing in.
2. **Upload selfie** — image is stored on your profile; traits are analyzed server-side.
3. View **style traits**: face shape, skin tone, hair length (heuristic MVP — deterministic from image hash, not a live CV API).
4. Choose **event** (wedding, party, casual, work, formal) and **mood** (elegant, natural, bold, soft).
5. **Generate look recommendations** — personalized makeup, hairstyle, and mehndi suggestions.
6. Optional: jump to **outfit recommendations** from your wardrobe for the same occasion.

> **Note:** Face analysis uses a heuristic engine for the MVP (same image always yields the same traits). Production can swap in a real computer-vision API without changing the UI flow.

---

## Tech stack

**Frontend:** Vue 3 (Composition API), Vite 5, Vue Router 4, Tailwind CSS 3, Axios (credentials + CSRF for Sanctum)

**Backend:** Laravel 11, Laravel Sanctum, SQLite (default) or MySQL, PHPUnit feature tests

**Auth:** Cookie-based SPA authentication (`/sanctum/csrf-cookie` + session). Use **`localhost`** (not `127.0.0.1`) so session cookies work locally.

---

## Project structure

```text
makemeupai/
├── src/                    # Vue application
│   ├── components/         # UI sections (Hero, Features, BookingModal, …)
│   ├── views/              # Route pages (Home, Wardrobe, FaceInsights, …)
│   ├── services/           # API clients (api, wardrobe, beauticians, ai, …)
│   ├── composables/        # useAuthNavigation, usePageSeo, useToast
│   └── data/               # Marketing copy & SEO config
├── backend/                # Laravel API
│   ├── app/Http/Controllers/Api/
│   ├── app/Services/       # Recommendations, weather, face analysis, …
│   ├── routes/api.php
│   └── tests/Feature/      # API smoke tests (29 tests)
├── docs/                   # Architecture, API contracts, installation
├── public/                 # favicon, robots.txt, sitemap.xml
└── README.md
```

---

## Prerequisites

- **Node.js** 18+ (20 LTS recommended) and npm
- **PHP** 8.4+ and **Composer** 2.x (required by current `composer.lock`)
- **Git**

**Windows note:** If `php` is not recognized after install, refresh PATH or use the full path to `php.exe`. Enable extensions in `php.ini`: `openssl`, `pdo_sqlite`, `sqlite3`, `mbstring`, `fileinfo`, `curl`, `zip`.

---

## Quick start

### 1. Clone and install

```powershell
git clone https://github.com/mominamughal1/makemeupai.git
cd makemeupai
npm install
copy .env.example .env.local
```

### 2. Frontend

```powershell
npm run dev
```

Open **http://localhost:5173**

`.env.local`:

```env
VITE_API_URL=http://localhost:8000
VITE_SITE_URL=http://localhost:5173
```

### 3. Backend

```powershell
cd backend
composer install
copy .env.example .env
php artisan key:generate
```

**SQLite (default):**

```powershell
New-Item -ItemType File -Path database\database.sqlite -Force
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve --port=8000
```

Or run `.\setup.ps1` then `php artisan serve`.

API base: **http://localhost:8000**

Ensure `backend/.env` includes:

- `SESSION_DOMAIN=localhost`
- `SANCTUM_STATEFUL_DOMAINS=localhost:5173`
- `FILESYSTEM_DISK=public`

---

## Main API endpoints

| Method | Endpoint | Auth |
|--------|----------|------|
| POST | `/api/auth/register` | No |
| POST | `/api/auth/login` | No |
| GET | `/api/auth/me` | Yes |
| GET/POST/DELETE | `/api/wardrobe` | Yes |
| GET | `/api/recommendations?occasion=` | Yes |
| POST | `/api/ai/face-analysis` | Yes (multipart image) |
| POST | `/api/ai/look-recommendations` | Yes |
| GET | `/api/ai/face-profile` | Yes |
| GET | `/api/beauticians` | No |
| POST | `/api/bookings` | Yes |

Full contracts: [docs/API_CONTRACTS.md](docs/API_CONTRACTS.md)

---

## Testing

**Backend (from `backend/`):**

```powershell
php artisan test
```

Key test groups: auth (register/login), wardrobe, outfit recommendations, face analysis + look recommendations, beauticians, bookings.

**Frontend build:**

```powershell
npm run build
```

**Manual QA:** [TESTING_CHECKLIST.md](TESTING_CHECKLIST.md)

---

## Documentation

| Document | Purpose |
|----------|---------|
| [docs/MakemeupAI-Project-Documentation.md](docs/MakemeupAI-Project-Documentation.md) | Full project documentation (Markdown) |
| [docs/MakemeupAI-Project-Documentation.docx](docs/MakemeupAI-Project-Documentation.docx) | Same content for reports/submission (Word) |
| [docs/INSTALLATION_GUIDE.md](docs/INSTALLATION_GUIDE.md) | Detailed install on a new machine |
| [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md) | Frontend architecture |
| [docs/API_CONTRACTS.md](docs/API_CONTRACTS.md) | REST API reference |
| [docs/CHANGELOG.md](docs/CHANGELOG.md) | Version history |
| [backend/README.md](backend/README.md) | API-specific backend notes |
| [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md) | Vercel + Railway production deployment |

---

## Security and secrets

Never commit:

- `.env.local` (frontend)
- `backend/.env` (APP_KEY, database, etc.)

Both are listed in `.gitignore`. Use `.env.example` files as templates.

---

## Deployment notes

**Full guide:** [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md)

### Production (Vercel + Railway)

| Service | Platform | Env highlights |
|---------|----------|----------------|
| Frontend | Vercel | `VITE_API_URL`, `VITE_SITE_URL` |
| Backend | Railway (`backend/` root) | `APP_URL`, `FRONTEND_URL`, `SANCTUM_STATEFUL_DOMAINS`, `SESSION_SAME_SITE=none` |
| Database | Railway PostgreSQL | `DB_CONNECTION=pgsql`, `DATABASE_URL` auto-injected |

1. Deploy backend on Railway first; note the public API URL.
2. Deploy frontend on Vercel with `VITE_API_URL` pointing to Railway.
3. Set Railway `FRONTEND_URL` to your Vercel URL; redeploy both if URLs change.
4. Attach a Railway volume at `storage/app/public` for uploaded images (selfies, wardrobe).
5. Run `php artisan db:seed --force` once on Railway for beautician demo data.

Config files added: [`vercel.json`](vercel.json), [`backend/railway.toml`](backend/railway.toml), [`backend/Procfile`](backend/Procfile).

---

## Status

Production-ready MVP: marketing site, auth (sign up/sign in), wardrobe, outfit recommendations, face insights (heuristic analysis + look output), beautician directory, and booking flows with automated API smoke tests.

Future enhancements: real computer-vision face APIs, premium billing, and deeper outfit + face trait integration.

---

## License

This project is provided as an academic / portfolio codebase unless a separate license is added by the maintainer.

---

## Contact

**Email:** hello@makemeupai.com  
**Maintainer:** [mominamughal1](https://github.com/mominamughal1)
