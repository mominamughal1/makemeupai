<script setup>
import FeaturesSection from "../components/FeaturesSection.vue";
import PageIntro from "../components/PageIntro.vue";
import LandingLayout from "../layouts/LandingLayout.vue";
import { pageIntros } from "../data/siteSeo";
import { featureCards } from "../data/homeData";
</script>

<template>
  <LandingLayout>
    <PageIntro
      :title="pageIntros.features.title"
      :subtitle="pageIntros.features.subtitle"
      :description="pageIntros.features.description"
    />
    <FeaturesSection :features="featureCards" :show-intro="false" />
  </LandingLayout>
</template>
