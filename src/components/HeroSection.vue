<script setup>
import { useAuthNavigation } from "../composables/useAuthNavigation";
import { authStore } from "../stores/auth";

const { goTo, goToProtected, scrollToSection } = useAuthNavigation();

function buildYourLook() {
  if (authStore.isLoggedIn) {
    goTo({ path: "/recommendations", query: { occasion: "casual" } });
  } else {
    goTo("/signup");
  }
}

function generateCompleteLook() {
  if (authStore.isLoggedIn) {
    goTo({ path: "/recommendations", query: { occasion: "formal" } });
  } else {
    goTo("/signup");
  }
}
</script>

<template>
  <section id="home" class="py-16">
    <div class="container-shell grid items-center gap-8 md:grid-cols-[1.2fr_0.8fr]">
      <div>
        <p
          class="mb-3 inline-block rounded-full border border-[#ffd1ea] bg-[#ffe8f5] px-3 py-1 text-xs text-brand-plum"
        >
          AI-Inspired Style Companion
        </p>
        <h1 class="mb-4 text-4xl font-bold md:text-6xl">Style Smarter. Glow Better.</h1>
        <p class="text-[#6f6176]">
          Plan outfits from your digital wardrobe, explore AI-inspired beauty and styling ideas,
          and book verified beauticians across Pakistan — all in one polished platform built for
          your complete look.
        </p>
        <div class="mt-5 flex flex-wrap gap-3">
          <button type="button" class="btn-primary" @click="buildYourLook">Build Your Look</button>
          <button type="button" class="btn-ghost" @click="scrollToSection('features')">
            Explore Demo
          </button>
        </div>
      </div>
      <div class="glass-card p-5">
        <h3 class="mb-2 text-lg font-semibold">Your Look Snapshot</h3>
        <p class="text-[#6f6176]">Event: Wedding / Bridal</p>
        <p class="text-[#6f6176]">Mood: Elegant Soft Glam</p>
        <p class="text-[#6f6176]">Hair: Textured Low Bun</p>
        <p class="mb-4 text-[#6f6176]">Mehndi: Minimal Arabic</p>
        <button type="button" class="btn-secondary" @click="generateCompleteLook">
          Generate My Complete Look
        </button>
      </div>
    </div>
  </section>
</template>
