<script setup>
defineProps({
  title: {
    type: String,
    required: true,
  },
  subtitle: {
    type: String,
    default: "",
  },
  description: {
    type: String,
    default: "",
  },
});
</script>

<template>
  <section class="border-b border-[#f0dce8] bg-white/40 py-12">
    <div class="container-shell max-w-3xl">
      <h1 class="text-3xl font-bold text-brand-plum md:text-4xl">{{ title }}</h1>
      <p v-if="subtitle" class="mt-2 text-lg font-medium text-[#1f1124]">{{ subtitle }}</p>
      <p v-if="description" class="mt-4 text-[#6f6176] leading-relaxed">{{ description }}</p>
    </div>
  </section>
</template>
