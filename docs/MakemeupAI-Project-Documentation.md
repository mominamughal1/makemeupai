# MakemeupAI — Project Documentation

**Version:** 0.5.0  
**Date:** June 2026  
**Repository:** https://github.com/Huzaifa690-arch/makemeupai

---

## 1. Executive Summary

MakemeupAI is a hybrid beauty and styling platform that combines:

- A **digital wardrobe** for clothing inventory and outfit planning
- **Occasion-based outfit recommendations** using wardrobe items and weather data
- **Face insights** for makeup, hairstyle, and mehndi suggestions (MVP heuristic analysis)
- **Beautician discovery and booking** with skill badges and ratings

The solution is implemented as a **Vue 3 single-page application** talking to a **Laravel 11 REST API** with Laravel Sanctum cookie authentication suitable for local development and deployment to standard PHP hosting plus static frontend hosting.

**Tagline:** Style Smarter. Glow Better.

---

## 2. Problem Statement

Users often struggle to coordinate outfits, makeup, hairstyles, and professional beauty services for daily wear and special events. Existing tools tend to focus on either wardrobe catalogs or appointment booking, not an integrated journey from personal inventory to complete look planning and beautician booking.

MakemeupAI addresses this by providing one cohesive experience from wardrobe upload through recommendations, beauty look suggestions, and verified beautician booking.

---

## 3. Solution Overview

### 3.1 User journeys

1. **Guest** — Browse marketing pages, features, how-it-works, beautician directory (read-only), and pricing; sign up or sign in.
2. **Registered user** — Manage wardrobe, generate outfit ideas, upload a selfie for face insights, book beauticians, and track bookings on the dashboard.

### 3.2 Core modules

| Module | User value |
|--------|------------|
| Marketing & SEO | Professional landing experience with searchable metadata |
| Authentication | Secure email/password accounts (Sanctum SPA) |
| Wardrobe | Photo-backed clothing catalog by category |
| Recommendations | Weather-aware outfit combinations (up to 3) |
| Face insights | Trait summary + event/mood-based beauty suggestions |
| Beauticians | City/specialization filters, hourly rates, booking modal |
| Bookings | Pending/confirmed/cancelled lifecycle |

---

## 4. System Architecture

### 4.1 High-level diagram

```text
[Browser Vue SPA :5173]
        |
        | HTTPS + cookies (axios withCredentials)
        v
[Laravel API :8000]
        |
        +-- SQLite / MySQL (users, wardrobe, beauticians, bookings)
        +-- Public disk storage (wardrobe images, selfies)
        +-- External weather API (with fallback)
```

### 4.2 Frontend architecture

- **Router-driven views** with `LandingLayout` (public) and `DashboardLayout` (authenticated)
- **Centralized copy** in `src/data/` (homeData, siteSeo, howItWorksContent)
- **Service layer** per domain (`wardrobe.js`, `beauticians.js`, `ai.js`, etc.)
- **Composables** for navigation, SEO head tags, and toasts
- **No global Pinia store** beyond reactive `authStore` for session user

### 4.3 Backend architecture

- REST JSON API under `/api/*`
- Controllers delegate to **service classes** (RecommendationService, FaceAnalysisService, LookRecommendationService, WeatherService)
- **JsonResource** transformers for consistent API shapes
- **Feature tests** (ApiSmokeTest) for regression coverage

---

## 5. Technology Stack

| Layer | Technologies |
|-------|----------------|
| Frontend | Vue 3, Vite, Vue Router, Tailwind CSS, Axios |
| Backend | Laravel 11, Sanctum, Eloquent ORM |
| Database | SQLite (dev), MySQL-compatible migrations |
| Testing | PHPUnit 11, 29 API smoke tests |
| Auth | Session + CSRF for SPA origin localhost:5173 |

---

## 6. Database Entities

- **users** — name, email, password, gender, city, profile_photo, face_traits (JSON)
- **clothing_items** — user_id, name, category, colors, season, occasion, image_path
- **beauticians** — name, bio, city, specializations, hourly_rate, skill_badge, ratings
- **bookings** — user_id, beautician_id, service_type, date/time, status, price

---

## 7. API Summary

Authentication: `POST /api/auth/register`, `POST /api/auth/login`, `GET /api/auth/me`, `POST /api/auth/logout`

Wardrobe: `GET/POST /api/wardrobe`, `DELETE /api/wardrobe/{id}`

Recommendations: `GET /api/recommendations?occasion=casual|work|formal|party`

AI / Face: `POST /api/ai/face-analysis` (multipart), `POST /api/ai/look-recommendations`, `GET /api/ai/face-profile`

Beauticians: `GET /api/beauticians`, `GET /api/beauticians/{id}`

Bookings: `POST/GET /api/bookings`, `PATCH /api/bookings/{id}/cancel`

Detailed request/response schemas: see `docs/API_CONTRACTS.md` in the repository.

---

## 8. Face Insights (MVP)

Face analysis v1 uses **deterministic heuristics** (hash of image + user id) to assign:

- Face shape: oval, round, heart, square
- Skin tone: warm/cool variants
- Hair length: short, medium, long

Look recommendations map traits plus **event type** (wedding, party, casual, work, formal) and **style mood** (elegant, natural, bold, soft) to curated suggestion lists for makeup, hairstyle, and mehndi.

Selfies are stored on the user profile (`profile_photo`) for repeat visits. This design allows swapping in Azure Face, AWS Rekognition, or a custom model later without changing the API response contract.

---

## 9. Security Considerations

- Passwords hashed with Laravel defaults
- API routes protected with `auth:sanctum` where required
- CORS and Sanctum stateful domains restricted to configured frontend origin
- `.env` files excluded from version control
- Booking and wardrobe mutations enforce ownership (403 for wrong user)
- Private app routes use `noindex` robots meta

---

## 10. Installation Summary

1. Clone repository from GitHub.
2. `npm install` at root; copy `.env.example` to `.env.local`.
3. In `backend/`: `composer install`, copy `.env.example` to `.env`, `php artisan key:generate`, create SQLite file, `php artisan migrate`, `php artisan db:seed`, `php artisan storage:link`.
4. Run `npm run dev` and `php artisan serve`.
5. Open http://localhost:5173 and register a test account.

Windows users without `php` on PATH may use Scoop: `C:\Users\huzai\scoop\shims\php.exe`.

Full steps: `docs/INSTALLATION_GUIDE.md`.

---

## 11. Testing

- Automated: `php artisan test` from `backend/` (29 tests)
- Build verification: `npm run build`
- Manual: `TESTING_CHECKLIST.md` (auth, wardrobe, recommendations, face insights, beauticians, bookings)

---

## 12. Project Status and Roadmap

**Completed (MVP):**

- Full marketing site with working CTAs and API-backed beautician teasers
- Auth, wardrobe CRUD, outfit recommendations, bookings
- Face insights upload and look recommendations
- SEO metadata and documentation

**Future:**

- Real face detection / ML pipeline
- Premium subscription implementation
- Production deployment (Vercel/Netlify + managed PHP or container)
- GDPR data export and selfie deletion endpoint

---

## 13. References

- GitHub: https://github.com/Huzaifa690-arch/makemeupai
- Contact: hello@makemeupai.com

---

*End of document*
