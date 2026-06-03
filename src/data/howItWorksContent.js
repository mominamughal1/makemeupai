export const howItWorksSteps = [
  {
    title: "Create your account",
    summary: "Sign up free and set your style preferences in minutes.",
    detail:
      "Register with your email to unlock your MakemeupAI dashboard. Add basic preferences so recommendations and beautician matches align with how you like to dress and glam up.",
    tip: "Use a photo-friendly email — you will use this account across wardrobe, recommendations, and bookings.",
  },
  {
    title: "Build your digital wardrobe",
    summary: "Upload tops, bottoms, shoes, and more by category.",
    detail:
      "Photograph or upload clothing items and tag them by category. Your wardrobe powers smarter outfit combinations and helps the app suggest looks you can actually wear from what you own.",
    tip: "Add at least five items across different categories for noticeably better outfit suggestions.",
  },
  {
    title: "Get outfit recommendations",
    summary: "Pick an occasion and receive looks tailored to you.",
    detail:
      "Choose casual, formal, or other occasions to generate outfit ideas from your wardrobe. Suggestions factor in weather context where available so you can plan with comfort and style in mind.",
    tip: "Try both casual and formal occasions to compare how MakemeupAI mixes your pieces differently.",
  },
  {
    title: "Book a verified beautician",
    summary: "Filter by city, skill badge, and rating — then confirm your slot.",
    detail:
      "Browse beauticians on the directory page, review specializations and hourly rates, and book a session when you are signed in. Skill badges help you pick the right level for everyday glam or bridal work.",
    tip: "Book early for weddings and events — popular slots in major cities fill quickly.",
  },
];

export const howItWorksCompactIntro =
  "MakemeupAI connects your wardrobe, AI-inspired outfit ideas, and beautician booking in one flow. Here is the quick overview — or read the full guide for FAQs and tips.";

export const howItWorksGettingStarted = [
  "A free MakemeupAI account (email signup)",
  "Optional wardrobe photos — clear, well-lit images work best",
  "Your city when browsing beauticians for local matches",
];

export const howItWorksFaq = [
  {
    question: "Is MakemeupAI free to use?",
    answer:
      "Yes. You can create an account, manage your wardrobe, get outfit recommendations, and browse beauticians on the free plan. Premium adds advanced features as they become available.",
  },
  {
    question: "Do I need a full wardrobe before getting recommendations?",
    answer:
      "No, but more items improve suggestions. Start with a few favorites per category and add over time — the app works better as your digital closet grows.",
  },
  {
    question: "How do beautician skill badges work?",
    answer:
      "Beauticians display beginner, intermediate, or expert badges so you can match skill level to your event — from everyday makeup to bridal and mehndi sessions.",
  },
  {
    question: "Can I book a beautician without signing in?",
    answer:
      "Browsing is open to everyone. Booking requires a signed-in account so we can confirm your session and show it on your dashboard.",
  },
  {
    question: "Is my wardrobe data private?",
    answer:
      "Your wardrobe and bookings are tied to your account and accessed only when you are signed in. We do not publish your uploads on public marketing pages.",
  },
  {
    question: "When will Premium features launch?",
    answer:
      "Premium is planned for advanced styling tools and perks. Free features remain fully usable today — we will announce Premium details on the dashboard when ready.",
  },
];

export const howItWorksCta = {
  line: "Ready to build your complete look with confidence?",
  primaryLabel: "Get Started",
  primaryRoute: "/signup",
  secondaryLabel: "Explore Features",
  secondaryRoute: "/features",
};

/** @deprecated Use howItWorksSteps — summaries only for legacy imports */
export const steps = howItWorksSteps.map((s) => s.summary);
