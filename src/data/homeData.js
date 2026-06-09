export const navLinks = [
  { label: "Home", to: "/" },
  { label: "Features", to: "/features" },
  { label: "How It Works", to: "/how-it-works" },
  { label: "Beauticians", to: "/beauticians" },
  { label: "Wardrobe", to: "/wardrobe" },
  { label: "Pricing", to: "/pricing" },
];

export const featureCards = [
  {
    title: "AI Face Insights",
    description: "Personalized style hints based on your features and preferences.",
    route: "/face-insights",
    requiresAuth: true,
  },
  {
    title: "Virtual Try-On Experience",
    description: "Preview outfit combinations before you step out.",
    route: "/recommendations",
    requiresAuth: true,
  },
  {
    title: "Smart Beautician Matching",
    description: "Find pros in your city by skill, rating, and specialty.",
    route: "/beauticians",
    requiresAuth: false,
  },
  {
    title: "Skill Badge System",
    description: "See beginner, intermediate, and expert badges at a glance.",
    route: "/beauticians",
    requiresAuth: false,
  },
  {
    title: "Digital Wardrobe Manager",
    description: "Upload and organize clothes for smarter outfit picks.",
    route: "/wardrobe",
    requiresAuth: true,
  },
  {
    title: "Build Your Look Journey",
    description: "From wardrobe to recommendations to booking in one flow.",
    route: "/dashboard",
    requiresAuth: true,
  },
];

export { howItWorksSteps as steps, howItWorksSteps } from "./howItWorksContent";

export const pricingPlans = [
  { name: "Free", price: "Rs 0 / month", cta: "Start Free", featured: false },
  { name: "Premium", price: "Rs 1,499 / month", cta: "Go Premium", featured: true },
];
