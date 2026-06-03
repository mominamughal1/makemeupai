<script setup>
import { showToast } from "../composables/useToast";
import { useAuthNavigation } from "../composables/useAuthNavigation";
import { authStore } from "../stores/auth";

defineProps({
  plans: {
    type: Array,
    required: true,
  },
});

const { goTo } = useAuthNavigation();

function handleStartFree() {
  goTo("/signup");
}

function handleGoPremium() {
  if (authStore.isLoggedIn) {
    showToast("Premium plans are coming soon. Enjoy all free features for now!", "success");
    goTo("/dashboard");
  } else {
    goTo("/signup");
  }
}
</script>

<template>
  <section id="pricing" class="py-14">
    <div class="container-shell">
      <h2 class="mb-6 text-3xl font-semibold">Choose Your Styling Plan</h2>
      <div class="grid gap-4 md:grid-cols-2">
        <article
          v-for="plan in plans"
          :key="plan.name"
          class="glass-card p-5"
          :class="{ 'border-[#e7bad6]': plan.featured }"
        >
          <h3 class="text-xl font-semibold">{{ plan.name }}</h3>
          <p class="mb-3 text-brand-plum">{{ plan.price }}</p>
          <button
            v-if="plan.featured"
            type="button"
            class="btn-primary"
            @click="handleGoPremium"
          >
            {{ plan.cta }}
          </button>
          <button v-else type="button" class="btn-ghost" @click="handleStartFree">
            {{ plan.cta }}
          </button>
        </article>
      </div>
    </div>
  </section>
</template>
