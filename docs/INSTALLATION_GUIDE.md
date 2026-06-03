# MakemeupAI Installation Guide (Monorepo)

Install the **Vue frontend** and **Laravel API** on another device.

## 1) Prerequisites

Install these tools on the target device:

- Git (latest)
- Node.js LTS (recommended: Node 20 LTS, minimum: Node 18+)
- npm (comes with Node.js)
- **PHP 8.2+** and **Composer 2.x** (for `backend/`)
- SQLite extension enabled (or MySQL if you change `DB_CONNECTION`)

Verify installation:

```bash
node -v
npm -v
git --version
```

## 2) Get the Project

Use one method:

### Option A: Clone from Git repository (recommended)

```bash
git clone <your-repo-url> makemeupai-frontend
cd makemeupai-frontend
```

### Option B: Copy project folder manually

- Copy/transfer the full project folder to new device
- Open terminal in project root

Ensure `package.json` exists in the root folder.

## 3) Install Dependencies

Run in project root:

```bash
npm install
```

This creates:

- `node_modules/`
- `package-lock.json` (if not already included)

## 4) Run Development Server

```bash
npm run dev
```

Open URL shown in terminal (usually):

- `http://localhost:5173`

If default port is busy:

```bash
npm run dev -- --host 127.0.0.1 --port 5174
```

Then open:

- `http://localhost:5174`

## 5) Build for Production

```bash
npm run build
```

Build output is generated in:

- `dist/`

Preview production build locally:

```bash
npm run preview
```

## 6) Troubleshooting

### A) Error: `vite is not recognized`

Cause: dependencies are not installed.

Fix:

```bash
npm install
npm run dev
```

### B) Browser error: `ERR_CONNECTION_REFUSED`

Cause: dev server is not running or crashed.

Fix:

1. Keep terminal open and run `npm run dev`
2. Wait for Vite local URL message
3. Open that exact URL in browser

### C) Port already in use

Use another port:

```bash
npm run dev -- --port 5174
```

### D) Dependency install issues (clean reinstall)

On Linux/macOS:

```bash
rm -rf node_modules package-lock.json
npm install
npm run dev
```

On Windows PowerShell:

```powershell
rmdir /s /q node_modules
del package-lock.json
npm install
npm run dev
```

### E) Node version problems

If install/build fails due to version mismatch:

- Install Node 20 LTS
- Restart terminal
- Run `npm install` again

## 7) Project NPM Scripts

- `npm run dev` -> start development server
- `npm run build` -> generate production build
- `npm run preview` -> preview production build

## 8) Backend setup (Laravel API)

From project root:

```bash
cd backend
composer install
```

Windows:

```powershell
copy .env.example .env
php artisan key:generate
New-Item -ItemType File -Path database\database.sqlite -Force
php artisan migrate
php artisan serve
```

API runs at `http://localhost:8000`.

Required `.env` values for Vue SPA auth:

```env
APP_URL=http://localhost:8000
SESSION_DOMAIN=localhost
SESSION_DRIVER=cookie
SANCTUM_STATEFUL_DOMAINS=localhost:5173
```

Verify CSRF route:

```bash
curl -i http://localhost:8000/sanctum/csrf-cookie
```

Full API notes: [backend/README.md](../backend/README.md)

## 9) Run both servers (development)

Terminal 1 (frontend):

```bash
npm run dev
```

Terminal 2 (backend):

```bash
cd backend
php artisan serve
```

Use **`localhost`** (not `127.0.0.1`) in the browser for cookie-based Sanctum auth.

## 10) Share/Transfer Checklist

### Include when sharing:

- `src/`, `backend/` (without `vendor/`), `docs/`
- `index.html`, `package.json`, `package-lock.json`
- `vite.config.js`, `tailwind.config.js`, `postcss.config.js`
- `backend/composer.json`, `backend/.env.example`

### Exclude when sharing:

- `node_modules/`, `backend/vendor/`, `backend/.env`
- `backend/database/*.sqlite` (optional; recreate on new device)

---

If needed, convert this file to PDF/DOCX for formal submission.
