<script setup>
import { useAuthNavigation } from "../composables/useAuthNavigation";
import { authStore } from "../stores/auth";

defineProps({
  features: {
    type: Array,
    required: true,
  },
  showIntro: {
    type: Boolean,
    default: true,
  },
});

const { goTo, goToProtected } = useAuthNavigation();

function handleFeatureClick(feature) {
  if (feature.requiresAuth && !authStore.isLoggedIn) {
    goToProtected(feature.route);
    return;
  }
  goTo(feature.route);
}
</script>

<template>
  <section id="features" class="py-14">
    <div class="container-shell">
      <h2 :class="['text-3xl font-semibold', showIntro ? 'mb-3' : 'mb-6']">
        Everything You Need for a Complete Look
      </h2>
      <p v-if="showIntro" class="mb-6 max-w-2xl text-[#6f6176]">
        From your digital wardrobe to beautician booking — explore AI-inspired tools built for
        everyday styling and special occasions in Pakistan.
      </p>
      <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        <article
          v-for="feature in features"
          :key="feature.title"
          class="glass-card cursor-pointer p-4 transition-shadow hover:ring-2 hover:ring-[#f0dce8]"
          role="button"
          tabindex="0"
          @click="handleFeatureClick(feature)"
          @keydown.enter="handleFeatureClick(feature)"
        >
          <h3 class="font-semibold">{{ feature.title }}</h3>
          <p class="mt-1 text-sm text-[#6f6176]">{{ feature.description }}</p>
          <p class="mt-3 text-xs font-semibold text-brand-plum">Explore →</p>
        </article>
      </div>
    </div>
  </section>
</template>
