<script setup>
import { navLinks } from "../data/homeData";
import { tagline } from "../data/siteSeo";

const year = new Date().getFullYear();
const footerLinks = navLinks.filter((link) => link.to !== "/wardrobe");
</script>

<template>
  <footer class="border-t border-[#f0dce8] bg-white py-8">
    <div class="container-shell grid gap-8 md:grid-cols-[1.2fr_1fr_1fr]">
      <div>
        <h3 class="font-semibold text-brand-plum">MakemeupAI</h3>
        <p class="mt-1 text-sm text-[#6f6176]">{{ tagline }}</p>
        <p class="mt-3 text-sm text-[#6f6176]">
          Digital wardrobe, outfit recommendations, and beautician booking for confident styling
          every day and every event.
        </p>
      </div>
      <div>
        <h4 class="text-sm font-semibold text-[#1f1124]">Explore</h4>
        <nav class="mt-3 flex flex-col gap-2" aria-label="Footer navigation">
          <RouterLink
            v-for="link in footerLinks"
            :key="link.to"
            :to="link.to"
            class="text-sm text-[#6f6176] hover:text-brand-plum"
          >
            {{ link.label }}
          </RouterLink>
        </nav>
      </div>
      <div>
        <h4 class="text-sm font-semibold text-[#1f1124]">Contact</h4>
        <a
          href="mailto:hello@makemeupai.com"
          class="mt-3 inline-block text-sm text-[#6f6176] hover:text-brand-plum"
        >
          hello@makemeupai.com
        </a>
        <p class="mt-6 text-xs text-[#6f6176]">© {{ year }} MakemeupAI. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>
