import { createRouter, createWebHistory } from "vue-router";
import BeauticiansView from "../views/BeauticiansView.vue";
import BookingsView from "../views/BookingsView.vue";
import DashboardView from "../views/DashboardView.vue";
import FeaturesView from "../views/FeaturesView.vue";
import HomeView from "../views/HomeView.vue";
import HowItWorksView from "../views/HowItWorksView.vue";
import NotFoundView from "../views/NotFoundView.vue";
import PricingView from "../views/PricingView.vue";
import RecommendationsView from "../views/RecommendationsView.vue";
import SignInView from "../views/SignInView.vue";
import SignUpView from "../views/SignUpView.vue";
import WardrobeView from "../views/WardrobeView.vue";
import { applyPageSeo } from "../composables/usePageSeo";
import { authStore } from "../stores/auth";

const routes = [
  { path: "/", name: "home", component: HomeView, meta: { title: "Home" } },
  { path: "/features", name: "features", component: FeaturesView, meta: { title: "Features" } },
  {
    path: "/how-it-works",
    name: "how-it-works",
    component: HowItWorksView,
    meta: { title: "How It Works" },
  },
  {
    path: "/beauticians",
    name: "beauticians",
    component: BeauticiansView,
    meta: { title: "Beauticians" },
  },
  { path: "/wardrobe", name: "wardrobe", component: WardrobeView, meta: { title: "My Wardrobe", requiresAuth: true, layout: "dashboard" } },
  { path: "/pricing", name: "pricing", component: PricingView, meta: { title: "Pricing" } },
  { path: "/signin", name: "signin", component: SignInView, meta: { title: "Sign In" } },
  { path: "/signup", name: "signup", component: SignUpView, meta: { title: "Sign Up" } },
  {
    path: "/dashboard",
    name: "dashboard",
    component: DashboardView,
    meta: { title: "Dashboard", requiresAuth: true, layout: "dashboard" },
  },
  {
    path: "/recommendations",
    name: "recommendations",
    component: RecommendationsView,
    meta: { title: "Outfit Recommendations", requiresAuth: true, layout: "dashboard" },
  },
  {
    path: "/bookings",
    name: "bookings",
    component: BookingsView,
    meta: { title: "My Bookings", requiresAuth: true, layout: "dashboard" },
  },
  { path: "/:pathMatch(.*)*", name: "not-found", component: NotFoundView, meta: { title: "Not Found" } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 };
  },
});

const sessionReady = authStore.fetchUser();

router.beforeEach(async (to) => {
  await sessionReady;

  if (to.meta.requiresAuth && !authStore.isLoggedIn) {
    return { path: "/signin" };
  }
});

router.afterEach((to) => {
  applyPageSeo(to);
});

export default router;
