<script setup>
import HowItWorksSection from "../components/HowItWorksSection.vue";
import PageIntro from "../components/PageIntro.vue";
import LandingLayout from "../layouts/LandingLayout.vue";
import { pageIntros } from "../data/siteSeo";
import { howItWorksSteps } from "../data/howItWorksContent";
</script>

<template>
  <LandingLayout>
    <PageIntro
      :title="pageIntros['how-it-works'].title"
      :subtitle="pageIntros['how-it-works'].subtitle"
      :description="pageIntros['how-it-works'].description"
    />
    <HowItWorksSection variant="full" :steps="howItWorksSteps" />
  </LandingLayout>
</template>
