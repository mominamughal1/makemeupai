<script setup>
import { useAuthNavigation } from "../composables/useAuthNavigation";
import {
  howItWorksCompactIntro,
  howItWorksCta,
  howItWorksFaq,
  howItWorksGettingStarted,
} from "../data/howItWorksContent";

defineProps({
  steps: {
    type: Array,
    required: true,
  },
  variant: {
    type: String,
    default: "compact",
    validator: (v) => ["compact", "full"].includes(v),
  },
});

const { goTo } = useAuthNavigation();

function stepKey(step, index) {
  return step.title || step.summary || index;
}
</script>

<template>
  <section id="how" class="border-y border-[#f0dce8] bg-white/60 py-14">
    <div class="container-shell">
      <h2 class="mb-3 text-3xl font-semibold">Create Your Look in 4 Simple Steps</h2>
      <p class="mb-6 max-w-2xl text-[#6f6176]">{{ howItWorksCompactIntro }}</p>

      <div
        v-if="variant === 'compact'"
        class="grid gap-4 md:grid-cols-2 lg:grid-cols-4"
      >
        <article
          v-for="(step, index) in steps"
          :key="stepKey(step, index)"
          class="glass-card p-4"
        >
          <div
            class="mb-3 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#ffe1f2] font-semibold text-brand-plum"
          >
            {{ index + 1 }}
          </div>
          <h3 class="mb-1 font-semibold text-[#1f1124]">{{ step.title }}</h3>
          <p class="text-sm text-[#6f6176]">{{ step.summary }}</p>
        </article>
      </div>

      <div v-else class="max-w-3xl space-y-6">
        <article
          v-for="(step, index) in steps"
          :key="stepKey(step, index)"
          class="glass-card flex gap-4 p-5"
        >
          <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#ffe1f2] font-semibold text-brand-plum"
          >
            {{ index + 1 }}
          </div>
          <div>
            <h3 class="text-lg font-semibold text-[#1f1124]">{{ step.title }}</h3>
            <p class="mt-2 text-sm leading-relaxed text-[#6f6176]">{{ step.detail }}</p>
            <p v-if="step.tip" class="mt-3 text-xs text-brand-plum">
              <span class="font-semibold">Tip:</span> {{ step.tip }}
            </p>
          </div>
        </article>
      </div>

      <p v-if="variant === 'compact'" class="mt-6 text-center">
        <RouterLink
          to="/how-it-works"
          class="text-sm font-semibold text-brand-plum hover:underline"
        >
          See full guide →
        </RouterLink>
      </p>

      <template v-if="variant === 'full'">
        <div class="mt-12 glass-card p-5">
          <h2 class="text-xl font-semibold text-brand-plum">What you need to get started</h2>
          <ul class="mt-4 list-inside list-disc space-y-2 text-sm text-[#6f6176]">
            <li v-for="item in howItWorksGettingStarted" :key="item">{{ item }}</li>
          </ul>
        </div>

        <div class="mt-10">
          <h2 class="mb-4 text-2xl font-semibold text-brand-plum">Common questions</h2>
          <div class="space-y-3">
            <details
              v-for="item in howItWorksFaq"
              :key="item.question"
              class="glass-card group p-4"
            >
              <summary class="cursor-pointer font-semibold text-[#1f1124] list-none [&::-webkit-details-marker]:hidden">
                <h3 class="inline text-base font-semibold">{{ item.question }}</h3>
              </summary>
              <p class="mt-3 text-sm leading-relaxed text-[#6f6176]">{{ item.answer }}</p>
            </details>
          </div>
        </div>

        <div class="mt-12 text-center">
          <p class="mb-4 text-[#6f6176]">{{ howItWorksCta.line }}</p>
          <div class="flex flex-wrap justify-center gap-3">
            <button type="button" class="btn-primary" @click="goTo(howItWorksCta.primaryRoute)">
              {{ howItWorksCta.primaryLabel }}
            </button>
            <button type="button" class="btn-ghost" @click="goTo(howItWorksCta.secondaryRoute)">
              {{ howItWorksCta.secondaryLabel }}
            </button>
          </div>
        </div>
      </template>

      <div v-if="variant === 'compact'" class="mt-8 text-center">
        <button type="button" class="btn-primary" @click="goTo('/signup')">Get Started</button>
      </div>
    </div>
  </section>
</template>
