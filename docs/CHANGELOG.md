# Changelog

All notable frontend changes for MakemeupAI are documented here.

## [0.4.0] - 2026-04-27

### Added

- Laravel 11 API in `backend/` with Sanctum SPA auth
- Auth endpoints: register, login, logout, me
- Users table fields: gender, city (default Lahore), profile_photo
- CORS + session config for Vue on port 5173
- `backend/README.md`, `backend/setup.ps1`

## [0.3.0] - 2026-04-27

### Added

- Shared layout system with `LandingLayout.vue`
- Dedicated route views:
  - Home
  - Features
  - How It Works
  - Beauticians
  - Wardrobe
  - Pricing
- `NotFoundView.vue` for unmatched routes
- Route metadata titles + automatic document title updates
- Active route highlighting in navigation
- Progress documentation:
  - `docs/PROGRESS.md`
  - `docs/ARCHITECTURE.md`
  - `docs/CHANGELOG.md`

### Changed

- Refactored navigation links from anchor hashes to router paths
- Updated router configuration to map each route to its own view

## [0.2.0] - 2026-04-27

### Added

- Componentized section architecture:
  - `AppHeader.vue`
  - `HeroSection.vue`
  - `FeaturesSection.vue`
  - `HowItWorksSection.vue`
  - `BeauticiansSection.vue`
  - `WardrobeSection.vue`
  - `PricingSection.vue`
  - `AppFooter.vue`
- Centralized frontend content in `src/data/homeData.js`

### Changed

- Simplified `HomeView.vue` to use reusable section components

## [0.1.0] - 2026-04-27

### Added

- Initial Vue 3 + Vite + Tailwind frontend setup
- Core project files:
  - `package.json`
  - `vite.config.js`
  - `tailwind.config.js`
  - `postcss.config.js`
- Base app files:
  - `src/main.js`
  - `src/App.vue`
  - `src/router/index.js`
  - `src/assets/main.css`
- Initial marketing/product sections and responsive UI foundation

---

## Versioning Notes

- `0.1.x`: initial foundation
- `0.2.x`: internal refactor and modularity
- `0.3.x`: routing maturity + documentation + UX polish
