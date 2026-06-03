<script setup>
import { useRouter } from "vue-router";
import { authStore } from "../stores/auth";

const router = useRouter();

const navLinks = [
  { label: "Dashboard", to: "/dashboard" },
  { label: "Wardrobe", to: "/wardrobe" },
  { label: "Recommendations", to: "/recommendations" },
  { label: "Bookings", to: "/bookings" },
];

function initials(name) {
  if (!name) return "?";
  return name
    .split(" ")
    .map((part) => part[0])
    .join("")
    .slice(0, 2)
    .toUpperCase();
}

async function handleSignOut() {
  await authStore.logout();
  router.push("/");
}
</script>

<template>
  <div class="min-h-screen bg-brand-blush">
    <div class="flex min-h-screen flex-col md:flex-row">
      <aside class="hidden w-60 shrink-0 border-r border-[#f0dce8] bg-white/80 p-6 md:block">
        <RouterLink class="mb-8 block font-extrabold tracking-wide text-brand-plum" to="/dashboard">
          MakemeupAI
        </RouterLink>

        <div class="mb-8 flex items-center gap-3">
          <img
            v-if="authStore.user?.profile_photo"
            :src="authStore.user.profile_photo"
            :alt="authStore.user.name"
            class="h-10 w-10 rounded-full object-cover ring-2 ring-[#f0dce8]"
          />
          <div
            v-else
            class="flex h-10 w-10 items-center justify-center rounded-full bg-[#fff0f5] text-sm font-bold text-brand-plum ring-2 ring-[#f0dce8]"
          >
            {{ initials(authStore.user?.name) }}
          </div>
          <div>
            <p class="text-sm font-semibold text-[#1f1124]">{{ authStore.user?.name }}</p>
            <p class="text-xs text-[#6f6176]">{{ authStore.user?.city }}</p>
          </div>
        </div>

        <nav class="space-y-1">
          <RouterLink
            v-for="link in navLinks"
            :key="link.to"
            :to="link.to"
            class="block rounded-xl px-3 py-2 text-sm text-[#6f6176] hover:bg-[#fff0f5] hover:text-brand-plum"
            active-class="!bg-[#fff0f5] !font-semibold !text-brand-plum"
          >
            {{ link.label }}
          </RouterLink>
          <button
            type="button"
            class="block w-full rounded-xl px-3 py-2 text-left text-sm text-[#6f6176] hover:bg-[#fff0f5] hover:text-brand-plum"
            @click="handleSignOut"
          >
            Sign Out
          </button>
        </nav>
      </aside>

      <div class="flex flex-1 flex-col">
        <header class="border-b border-[#f0dce8] bg-white/80 p-4 md:hidden">
          <RouterLink class="mb-3 block font-extrabold tracking-wide text-brand-plum" to="/dashboard">
            MakemeupAI
          </RouterLink>
          <nav class="flex gap-2 overflow-x-auto pb-1">
            <RouterLink
              v-for="link in navLinks"
              :key="`mobile-${link.to}`"
              :to="link.to"
              class="whitespace-nowrap rounded-full px-3 py-1.5 text-xs text-[#6f6176] ring-1 ring-[#f0dce8]"
              active-class="!bg-[#fff0f5] !font-semibold !text-brand-plum !ring-brand-rose"
            >
              {{ link.label }}
            </RouterLink>
            <button
              type="button"
              class="whitespace-nowrap rounded-full px-3 py-1.5 text-xs text-[#6f6176] ring-1 ring-[#f0dce8]"
              @click="handleSignOut"
            >
              Sign Out
            </button>
          </nav>
        </header>

        <main class="flex-1 p-4 md:p-6">
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>
