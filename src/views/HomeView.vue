<script setup>
import BeauticiansSection from "../components/BeauticiansSection.vue";
import FeaturesSection from "../components/FeaturesSection.vue";
import HeroSection from "../components/HeroSection.vue";
import HowItWorksSection from "../components/HowItWorksSection.vue";
import LandingLayout from "../layouts/LandingLayout.vue";
import PricingSection from "../components/PricingSection.vue";
import WardrobeSection from "../components/WardrobeSection.vue";
import { howItWorksSteps } from "../data/howItWorksContent";
import { featureCards, pricingPlans } from "../data/homeData";
</script>

<template>
  <LandingLayout>
    <HeroSection />
    <FeaturesSection :features="featureCards" />
    <HowItWorksSection variant="compact" :steps="howItWorksSteps" />
    <BeauticiansSection />
    <WardrobeSection />
    <PricingSection :plans="pricingPlans" />
  </LandingLayout>
</template>
