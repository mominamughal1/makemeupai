# MakemeupAI Frontend Architecture

## 1. Purpose

This document explains the current frontend architecture for MakemeupAI and how it is designed to scale from a demo UI into a production-ready platform.

## 2. Architecture Goals

- Keep UI modular and reusable
- Separate content/data from presentation
- Enable easy route-level expansion
- Support future API integration without major rewrites
- Maintain clean, readable code for team collaboration

## 3. High-Level Structure

```text
App (src/App.vue)
└── Router View
    ├── HomeView
    ├── FeaturesView
    ├── HowItWorksView
    ├── BeauticiansView
    ├── WardrobeView
    ├── PricingView
    └── NotFoundView

Each view uses:
LandingLayout
├── AppHeader
├── [Page Sections]
└── AppFooter
```

## 4. Routing Layer

Routing is managed in `src/router/index.js` using Vue Router.

### Routes

- `/` -> `HomeView`
- `/features` -> `FeaturesView`
- `/how-it-works` -> `HowItWorksView`
- `/beauticians` -> `BeauticiansView`
- `/wardrobe` -> `WardrobeView`
- `/pricing` -> `PricingView`
- `/:pathMatch(.*)*` -> `NotFoundView` (fallback 404)

### Route Metadata

Each route contains `meta.title`, and a global `afterEach` hook updates `document.title`:

- Example: `Features | MakemeupAI`

## 5. Layout System

### `LandingLayout.vue`

Shared layout wrapper for public pages:

- Header (navigation)
- Main content slot
- Footer

This avoids repeating shell markup in every view and keeps route components small.

## 6. Component Layer

Section-level components are located in `src/components`.

### Current Components

- `AppHeader.vue`
- `HeroSection.vue`
- `FeaturesSection.vue`
- `HowItWorksSection.vue`
- `BeauticiansSection.vue`
- `WardrobeSection.vue`
- `PricingSection.vue`
- `AppFooter.vue`

### Component Design Pattern

- Stateless where possible
- Props-based inputs for reusable content
- Minimal local state (mobile menu in header)
- Tailwind utility classes + shared component classes

## 7. Data Layer (Current)

### `src/data/homeData.js`

Currently stores demo/static data:

- `navLinks`
- `featureCards`
- `steps`
- `beauticians`
- `pricingPlans`

This makes UI text/content easy to modify without touching component logic.

## 8. Styling Layer

### `src/assets/main.css`

- Tailwind base/components/utilities imports
- App-wide base styles (font, background)
- Shared custom classes:
  - `.container-shell`
  - `.glass-card`
  - `.btn-primary`
  - `.btn-secondary`
  - `.btn-ghost`

This ensures consistent visual identity across all pages.

## 9. Configuration Layer

- `vite.config.js` -> Vue plugin + build/dev config
- `tailwind.config.js` -> content paths + custom brand colors
- `postcss.config.js` -> Tailwind + Autoprefixer
- `package.json` -> scripts and dependencies

## 10. Scalability Plan

### Near-Term

- Add dedicated pages: Sign In, Sign Up, Build Your Look, Booking
- Add form validation and state management patterns
- Add API service modules (`src/services/*`)

### Mid-Term

- Add auth guards in router
- Integrate backend endpoints for user and booking flows
- Replace mock data with live API responses

### Future

- Add AI inference integration points
- Add AR try-on flow/pages
- Add role-based dashboard (User/Beautician/Admin)

## 11. Suggested Future Directory Growth

```text
src/
  components/
  layouts/
  views/
  router/
  data/
  services/        # API clients
  composables/     # reusable Vue logic
  stores/          # optional Pinia stores
  utils/           # helpers/constants
  assets/
```

## 12. Current Limitations

- No backend integration yet
- No authentication workflow yet
- No real booking state or persistence
- No AI/AR implementation yet
- No automated tests yet

These are planned and the current architecture is prepared to support them incrementally.
