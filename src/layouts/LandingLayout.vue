<script setup>
import AppFooter from "../components/AppFooter.vue";
import AppHeader from "../components/AppHeader.vue";
import { navLinks } from "../data/homeData";
</script>

<template>
  <AppHeader :links="navLinks" />
  <main>
    <slot />
  </main>
  <AppFooter />
</template>
