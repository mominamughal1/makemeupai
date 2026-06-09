<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { useAuthNavigation } from "../composables/useAuthNavigation";
import { getItems } from "../services/wardrobe";
import { authStore } from "../stores/auth";

const { goTo, goToProtected } = useAuthNavigation();

const loading = ref(false);
const fetchError = ref("");
const wardrobeItems = ref([]);

const categoryBreakdown = computed(() => {
  const counts = {};
  for (const item of wardrobeItems.value) {
    counts[item.category] = (counts[item.category] || 0) + 1;
  }
  return Object.entries(counts)
    .map(([category, count]) => `${category.charAt(0).toUpperCase() + category.slice(1)}: ${count}`)
    .join(", ");
});

const isEmpty = computed(() => wardrobeItems.value.length === 0);

async function fetchWardrobe() {
  if (!authStore.isLoggedIn) {
    wardrobeItems.value = [];
    fetchError.value = "";
    return;
  }

  loading.value = true;
  fetchError.value = "";
  try {
    wardrobeItems.value = await getItems();
  } catch {
    wardrobeItems.value = [];
    fetchError.value = "Could not load your wardrobe. Please try again.";
  } finally {
    loading.value = false;
  }
}

watch(
  () => authStore.isLoggedIn,
  () => {
    fetchWardrobe();
  }
);

onMounted(() => {
  fetchWardrobe();
});
</script>

<template>
  <section id="wardrobe" class="border-y border-[#f0dce8] bg-white/60 py-14">
    <div class="container-shell">
      <h2 class="mb-6 text-3xl font-semibold">Your Smart Digital Wardrobe</h2>

      <div v-if="!authStore.isLoggedIn" class="glass-card p-5">
        <p class="font-semibold">Your wardrobe is empty</p>
        <p class="mt-1 text-sm text-[#6f6176]">
          Create an account to upload clothes and get personalized outfit suggestions.
        </p>
        <div class="mt-4 flex flex-wrap gap-2">
          <button type="button" class="btn-primary" @click="goTo('/signup')">Get Started</button>
          <button type="button" class="btn-ghost" @click="goTo('/signin')">Sign In</button>
        </div>
      </div>

      <div v-else-if="loading" class="flex justify-center py-12">
        <div
          class="h-10 w-10 animate-spin rounded-full border-4 border-[#f0dce8] border-t-brand-rose"
        ></div>
      </div>

      <div v-else-if="fetchError" class="glass-card px-6 py-8 text-center">
        <p class="font-semibold text-brand-plum">{{ fetchError }}</p>
        <button type="button" class="btn-primary mt-4" @click="fetchWardrobe">Try Again</button>
      </div>

      <div v-else class="glass-card p-5">
        <template v-if="isEmpty">
          <p class="font-semibold">Your wardrobe is empty</p>
          <p class="mt-1 text-sm text-[#6f6176]">
            Add your first item to start getting outfit suggestions.
          </p>
        </template>
        <template v-else>
          <p class="font-semibold">Wardrobe snapshot</p>
          <p class="mt-2 text-sm text-[#6f6176]">
            <span class="font-medium text-[#1f1124]">{{ wardrobeItems.length }} items</span>
            <span v-if="categoryBreakdown"> — {{ categoryBreakdown }}</span>
          </p>
        </template>
        <div class="mt-4 flex flex-wrap gap-2">
          <button type="button" class="btn-primary" @click="goToProtected('/wardrobe')">
            Manage Wardrobe
          </button>
          <button
            type="button"
            class="btn-ghost"
            @click="goToProtected('/recommendations?occasion=casual')"
          >
            Get Outfit Ideas
          </button>
        </div>
      </div>
    </div>
  </section>
</template>
