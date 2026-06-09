<script setup>
import LandingLayout from "../layouts/LandingLayout.vue";
</script>

<template>
  <LandingLayout>
    <section class="py-20">
      <div class="container-shell">
        <div class="glass-card p-8 text-center">
          <p class="mb-2 text-sm font-semibold text-brand-plum">404</p>
          <h1 class="mb-3 text-3xl font-bold">Page not found</h1>
          <p class="mb-6 text-[#6f6176]">
            The page you are looking for does not exist or may have been moved.
          </p>
          <RouterLink to="/" class="btn-primary inline-block">Go back home</RouterLink>
        </div>
      </div>
    </section>
  </LandingLayout>
</template>
