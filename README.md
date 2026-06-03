# MakemeupAI

**Style Smarter. Glow Better.** — A full-stack platform for digital wardrobe management, AI-inspired outfit and beauty guidance, face-based look suggestions, and beautician booking in Pakistan.

**Repository:** [github.com/Huzaifa690-arch/makemeupai](https://github.com/Huzaifa690-arch/makemeupai)

---

## Overview

MakemeupAI helps users plan a complete look in one place: upload clothing, get occasion-based outfit recommendations with weather context, analyze a selfie for personalized makeup and hairstyle ideas, and book verified beauticians by city, skill badge, and rating.

The project is a **monorepo**:

| Part | Stack | Default URL |
|------|--------|-------------|
| Frontend | Vue 3, Vite, Vue Router, Tailwind CSS | http://localhost:5173 |
| Backend | Laravel 11, Sanctum (SPA cookies), SQLite/MySQL | http://localhost:8000 |

---

## Features

### Public marketing site

- Landing page with hero CTAs, feature cards, how-it-works guide, live beautician teasers (API), wardrobe preview, and pricing
- Dedicated pages: Features, How It Works (FAQ), Beauticians directory, Pricing
- SEO: per-route meta tags, Open Graph, canonical URLs, `robots.txt`, `sitemap.xml`

### Authenticated app

| Module | Description |
|--------|-------------|
| **Dashboard** | Wardrobe snapshot, outfit shortcuts, upcoming bookings, Face Insights entry |
| **Digital wardrobe** | Upload items by category with images; filter and manage inventory |
| **Outfit recommendations** | Up to 3 combinations from your wardrobe by occasion + local weather |
| **Face insights** | Upload selfie (stored on profile); heuristic style traits; makeup, hair, and mehndi suggestions |
| **Beauticians** | Browse, filter, book sessions; skill badges and ratings |
| **Bookings** | View and cancel upcoming appointments |

---

## Tech stack

**Frontend:** Vue 3 (Composition API), Vite 5, Vue Router 4, Tailwind CSS 3, Axios (credentials + CSRF for Sanctum)

**Backend:** Laravel 11, Laravel Sanctum, SQLite (default) or MySQL, PHPUnit feature tests

**Auth:** Cookie-based SPA authentication (`/sanctum/csrf-cookie` + session)

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
- **PHP** 8.2+ and **Composer** 2.x
- **Git**

**Windows note:** If `php` is not recognized, PHP may be installed via Scoop. Use the full path or add shims to PATH:

```powershell
$env:Path = "C:\Users\huzai\scoop\shims;" + $env:Path
php -v
```

---

## Quick start

### 1. Clone and install

```powershell
git clone https://github.com/Huzaifa690-arch/makemeupai.git
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

---

## Security and secrets

Never commit:

- `.env.local` (frontend)
- `backend/.env` (APP_KEY, database, etc.)

Both are listed in `.gitignore`. Use `.env.example` files as templates.

---

## Deployment notes

1. Set `VITE_API_URL` and `VITE_SITE_URL` to production URLs and rebuild the frontend.
2. Update `public/sitemap.xml` and `public/robots.txt` sitemap URL if needed.
3. Run `php artisan migrate --force`, `php artisan storage:link`, and configure a real database for production.
4. Serve the Vue `dist/` folder and proxy API requests to Laravel, or deploy separately with CORS/Sanctum domains configured.

---

## Status

Production-ready MVP: marketing site, auth, wardrobe, outfit recommendations, face insights (heuristic analysis), beautician directory, and booking flows with automated API smoke tests.

Future enhancements: real computer-vision face APIs, premium billing, and deeper outfit + face trait integration.

---

## License

This project is provided as an academic / portfolio codebase unless a separate license is added by the maintainer.

---

## Contact

**Email:** hello@makemeupai.com  
**Maintainer:** [Huzaifa690-arch](https://github.com/Huzaifa690-arch)
