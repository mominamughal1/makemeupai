# Production Deployment (Vercel + Railway)

Hybrid setup: Vue SPA on **Vercel**, Laravel API on **Railway**, PostgreSQL on Railway.

## Architecture

| Service | Platform | URL |
|---------|----------|-----|
| Frontend | Vercel | https://makemeupai.vercel.app |
| Backend API | Railway | `https://<your-service>.up.railway.app` |
| Database | Railway PostgreSQL | via `DATABASE_URL` |

## 1. Railway (backend)

1. [railway.app](https://railway.app) → New Project → Deploy from GitHub → `mominamughal1/makemeupai`
2. Set **Root Directory** to `backend`
3. Add **PostgreSQL** plugin to the project
4. Set environment variables on the web service:

| Variable | Value |
|----------|-------|
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | `base64:...` (from `php artisan key:generate --show`) |
| `APP_URL` | `https://<railway-api-host>` |
| `FRONTEND_URL` | `https://makemeupai.vercel.app` |
| `DB_CONNECTION` | `pgsql` |
| `SESSION_DRIVER` | `database` |
| `SESSION_SECURE_COOKIE` | `true` |
| `SESSION_SAME_SITE` | `none` |
| `SESSION_DOMAIN` | *(leave empty)* |
| `SANCTUM_STATEFUL_DOMAINS` | `makemeupai.vercel.app` |
| `FILESYSTEM_DISK` | `public` |

Railway injects `DATABASE_URL` automatically; Laravel reads it via `DB_URL` fallback in `config/database.php`.

5. Optional: attach a **Volume** mounted at `/app/storage/app/public` for persistent selfie/wardrobe uploads
6. Generate public domain in Railway → Settings → Networking
7. One-time seed (Railway shell): `php artisan db:seed --force`
8. Verify: `curl https://<api-host>/up` and `curl https://<api-host>/api/beauticians`

## 2. Vercel (frontend)

1. [vercel.com](https://vercel.com) → Import `mominamughal1/makemeupai`
2. **Root Directory:** repository root (default)
3. Framework: Vite (uses [`vercel.json`](../vercel.json))
4. Environment variables (Production):

| Variable | Value |
|----------|-------|
| `VITE_API_URL` | `https://<railway-api-host>` |
| `VITE_SITE_URL` | `https://makemeupai.vercel.app` |

5. Deploy. Changing `VITE_*` requires a redeploy.

## 3. Wire both services

1. Set Railway `FRONTEND_URL` and `SANCTUM_STATEFUL_DOMAINS` to your final Vercel URL
2. Set Vercel `VITE_API_URL` to your final Railway URL
3. Redeploy both

## 4. Production QA

Use [TESTING_CHECKLIST.md](../TESTING_CHECKLIST.md) against live URLs. Watch for:

| Symptom | Fix |
|---------|-----|
| CORS error | `FRONTEND_URL` mismatch on Railway |
| 419 CSRF | Add Vercel domain to `SANCTUM_STATEFUL_DOMAINS` |
| Auth cookie lost | `SESSION_SAME_SITE=none` + `SESSION_SECURE_COOKIE=true` |
| Upload 404 | `storage:link` + Railway volume on `storage/app/public` |
| API calls localhost | Rebuild Vercel with correct `VITE_API_URL` |

## Custom domains

Point `makemeupai.com` to Vercel and `api.makemeupai.com` to Railway, then update all env vars above.
