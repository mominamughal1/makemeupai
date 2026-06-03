import { useRouter } from "vue-router";
import { authStore } from "../stores/auth";

export function useAuthNavigation() {
  const router = useRouter();

  function goTo(path) {
    return router.push(path);
  }

  function redirectTarget(path) {
    if (typeof path === "string") return path;
    return router.resolve(path).fullPath;
  }

  function goToProtected(path, redirectPath = null) {
    if (authStore.isLoggedIn) {
      return router.push(path);
    }

    const target = redirectTarget(redirectPath ?? path);
    return router.push({ path: "/signin", query: { redirect: target } });
  }

  function scrollToSection(id) {
    const el = document.getElementById(id);
    if (el) {
      el.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  }

  return { goTo, goToProtected, scrollToSection };
}
