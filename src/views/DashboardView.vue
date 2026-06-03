<script setup>
import { computed, onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import DashboardLayout from "../layouts/DashboardLayout.vue";
import { getMyBookings } from "../services/bookings";
import { getItems } from "../services/wardrobe";
import { authStore } from "../stores/auth";

const router = useRouter();

const loading = ref(true);
const wardrobeItems = ref([]);
const bookings = ref([]);

const greeting = computed(() => {
  const hour = new Date().getHours();
  if (hour < 12) return "Good morning";
  if (hour < 17) return "Good afternoon";
  return "Good evening";
});

const todayDate = computed(() =>
  new Date().toLocaleDateString(undefined, {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  })
);

const categoryBreakdown = computed(() => {
  const counts = {};
  for (const item of wardrobeItems.value) {
    counts[item.category] = (counts[item.category] || 0) + 1;
  }
  return Object.entries(counts)
    .map(([category, count]) => `${category.charAt(0).toUpperCase() + category.slice(1)}: ${count}`)
    .join(", ");
});

const upcomingBookings = computed(() => {
  const today = new Date().toISOString().split("T")[0];

  return bookings.value
    .filter(
      (booking) =>
        ["pending", "confirmed"].includes(booking.status) && booking.booking_date >= today
    )
    .sort((a, b) => {
      const dateCompare = a.booking_date.localeCompare(b.booking_date);
      if (dateCompare !== 0) return dateCompare;
      return a.booking_time.localeCompare(b.booking_time);
    })
    .slice(0, 2);
});

function statusClass(status) {
  const classes = {
    pending: "bg-amber-100 text-amber-800",
    confirmed: "bg-green-100 text-green-800",
    cancelled: "bg-gray-100 text-gray-600",
  };
  return classes[status] || classes.pending;
}

function goToRecommendations(occasion) {
  router.push({ path: "/recommendations", query: { occasion } });
}

onMounted(async () => {
  try {
    const [items, userBookings] = await Promise.all([getItems(), getMyBookings()]);
    wardrobeItems.value = items;
    bookings.value = userBookings;
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <DashboardLayout>
    <div v-if="loading" class="flex justify-center py-20">
      <div class="h-10 w-10 animate-spin rounded-full border-4 border-[#f0dce8] border-t-brand-rose"></div>
    </div>

    <div v-else class="space-y-6">
      <section>
        <h1 class="text-2xl font-bold text-brand-plum">
          {{ greeting }}, {{ authStore.user?.name }} 👋
        </h1>
        <p class="mt-1 text-sm text-[#6f6176]">{{ todayDate }}</p>
      </section>

      <section class="glass-card p-5">
        <h2 class="text-lg font-semibold text-brand-plum">Wardrobe Snapshot</h2>
        <p class="mt-2 text-sm text-[#6f6176]">
          <span class="font-medium text-[#1f1124]">{{ wardrobeItems.length }} items</span>
          <span v-if="categoryBreakdown"> — {{ categoryBreakdown }}</span>
        </p>
        <RouterLink to="/wardrobe" class="mt-4 inline-block text-sm font-semibold text-brand-plum hover:underline">
          Go to Wardrobe →
        </RouterLink>
      </section>

      <section class="glass-card p-5">
        <h2 class="text-lg font-semibold text-brand-plum">Outfit Suggestions</h2>
        <p class="mt-2 text-sm text-[#6f6176]">Ready to plan your look?</p>
        <div class="mt-4 flex flex-wrap gap-2">
          <button type="button" class="btn-ghost text-sm" @click="goToRecommendations('casual')">
            Casual
          </button>
          <button type="button" class="btn-ghost text-sm" @click="goToRecommendations('work')">
            Work
          </button>
          <button type="button" class="btn-ghost text-sm" @click="goToRecommendations('formal')">
            Formal
          </button>
        </div>
      </section>

      <section class="glass-card p-5">
        <h2 class="text-lg font-semibold text-brand-plum">Upcoming Bookings</h2>

        <div v-if="upcomingBookings.length === 0" class="mt-3">
          <p class="text-sm text-[#6f6176]">No bookings yet</p>
          <RouterLink
            to="/beauticians"
            class="mt-2 inline-block text-sm font-semibold text-brand-plum hover:underline"
          >
            Browse Beauticians →
          </RouterLink>
        </div>

        <ul v-else class="mt-4 space-y-3">
          <li
            v-for="booking in upcomingBookings"
            :key="booking.id"
            class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-[#f0dce8] bg-white/60 px-4 py-3"
          >
            <div>
              <p class="font-medium text-[#1f1124]">{{ booking.beautician.name }}</p>
              <p class="text-sm text-[#6f6176]">
                {{ booking.booking_date }} at {{ booking.booking_time }}
              </p>
            </div>
            <span
              class="rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize"
              :class="statusClass(booking.status)"
            >
              {{ booking.status }}
            </span>
          </li>
        </ul>
      </section>
    </div>
  </DashboardLayout>
</template>
