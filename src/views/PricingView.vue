<script setup>
import PageIntro from "../components/PageIntro.vue";
import LandingLayout from "../layouts/LandingLayout.vue";
import PricingSection from "../components/PricingSection.vue";
import { pageIntros } from "../data/siteSeo";
import { pricingPlans } from "../data/homeData";
</script>

<template>
  <LandingLayout>
    <PageIntro
      :title="pageIntros.pricing.title"
      :subtitle="pageIntros.pricing.subtitle"
      :description="pageIntros.pricing.description"
    />
    <PricingSection :plans="pricingPlans" />
  </LandingLayout>
</template>
