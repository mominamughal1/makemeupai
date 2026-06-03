<script setup>
import { ref } from "vue";
import { authStore } from "../stores/auth";

defineProps({
  links: {
    type: Array,
    required: true,
  },
});

const isMobileMenuOpen = ref(false);
</script>

<template>
  <header class="sticky top-0 z-10 border-b border-[#f0dce8] bg-[#fff7fb]/90 backdrop-blur">
    <nav class="container-shell flex min-h-[72px] items-center justify-between gap-4">
      <RouterLink class="font-extrabold tracking-wide text-brand-plum" to="/">MakemeupAI</RouterLink>
      <button
        class="rounded-lg border border-[#edd9e5] bg-white px-3 py-2 text-brand-plum md:hidden"
        @click="isMobileMenuOpen = !isMobileMenuOpen"
      >
        Menu
      </button>
      <ul class="hidden items-center gap-4 text-sm text-[#6f6176] md:flex">
        <li v-for="link in links" :key="link.to">
          <RouterLink
            :to="link.to"
            class="hover:text-brand-plum"
            active-class="text-brand-plum font-semibold"
          >
            {{ link.label }}
          </RouterLink>
        </li>
      </ul>
      <div class="hidden items-center gap-2 md:flex">
        <RouterLink v-if="authStore.isLoggedIn" class="btn-primary" to="/dashboard">
          Dashboard →
        </RouterLink>
        <template v-else>
          <RouterLink class="btn-ghost" to="/signin">Sign In</RouterLink>
          <RouterLink class="btn-primary" to="/signup">Get Started</RouterLink>
        </template>
      </div>
    </nav>
    <div
      v-if="isMobileMenuOpen"
      class="container-shell mb-3 flex flex-col gap-2 rounded-xl border border-[#f0dce8] bg-white p-3 md:hidden"
    >
      <RouterLink
        v-for="link in links"
        :key="`mobile-${link.to}`"
        :to="link.to"
        class="hover:text-brand-plum"
        active-class="text-brand-plum font-semibold"
        @click="isMobileMenuOpen = false"
      >
        {{ link.label }}
      </RouterLink>
      <RouterLink
        v-if="authStore.isLoggedIn"
        class="btn-primary text-center"
        to="/dashboard"
        @click="isMobileMenuOpen = false"
      >
        Dashboard →
      </RouterLink>
      <template v-else>
        <RouterLink class="btn-ghost text-center" to="/signin" @click="isMobileMenuOpen = false">
          Sign In
        </RouterLink>
        <RouterLink class="btn-primary text-center" to="/signup" @click="isMobileMenuOpen = false">
          Get Started
        </RouterLink>
      </template>
    </div>
  </header>
</template>
