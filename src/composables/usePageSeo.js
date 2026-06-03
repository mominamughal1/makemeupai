import { routeSeo, siteName, defaultDescription, defaultKeywords, tagline } from "../data/siteSeo";

const SITE_URL = (import.meta.env.VITE_SITE_URL || "http://localhost:5173").replace(/\/$/, "");

function upsertMeta(attr, key, content) {
  if (!content) return;
  let el = document.head.querySelector(`meta[${attr}="${key}"][data-seo]`);
  if (!el) {
    el = document.createElement("meta");
    el.setAttribute(attr, key);
    el.setAttribute("data-seo", "true");
    document.head.appendChild(el);
  }
  el.setAttribute("content", content);
}

function upsertLink(rel, href) {
  if (!href) return;
  let el = document.head.querySelector(`link[rel="${rel}"][data-seo]`);
  if (!el) {
    el = document.createElement("link");
    el.setAttribute("rel", rel);
    el.setAttribute("data-seo", "true");
    document.head.appendChild(el);
  }
  el.setAttribute("href", href);
}

function removeManagedJsonLd() {
  document.head.querySelectorAll('script[type="application/ld+json"][data-seo]').forEach((el) => el.remove());
}

function injectJsonLd(routeName) {
  removeManagedJsonLd();
  const config = routeSeo[routeName];
  if (!config?.jsonLd) return;

  const script = document.createElement("script");
  script.type = "application/ld+json";
  script.setAttribute("data-seo", "true");
  script.textContent = JSON.stringify({
    "@context": "https://schema.org",
    "@type": "WebApplication",
    name: siteName,
    description: defaultDescription,
    url: SITE_URL,
    applicationCategory: "LifestyleApplication",
    operatingSystem: "Web",
    offers: {
      "@type": "Offer",
      price: "0",
      priceCurrency: "PKR",
    },
  });
  document.head.appendChild(script);
}

function canonicalPath(fullPath) {
  if (!fullPath || fullPath === "/") return "/";
  return fullPath.split("?")[0].split("#")[0];
}

export function applyPageSeo(route) {
  const routeName = route.name || "home";
  const config = routeSeo[routeName] || {};
  const title = config.title || "Page";
  const description = config.description || defaultDescription;
  const ogTitle = config.ogTitle || `${title} – ${siteName}`;
  const ogDescription = config.ogDescription || description;
  const robots = config.robots || "index,follow";
  const path = canonicalPath(route.fullPath);
  const canonicalUrl = `${SITE_URL}${path === "/" ? "" : path}`;

  document.title = `${title} – ${siteName}`;

  upsertMeta("name", "description", description);
  upsertMeta("name", "keywords", defaultKeywords);
  upsertMeta("name", "robots", robots);

  upsertMeta("property", "og:title", ogTitle);
  upsertMeta("property", "og:description", ogDescription);
  upsertMeta("property", "og:url", canonicalUrl);
  upsertMeta("property", "og:type", "website");
  upsertMeta("property", "og:site_name", siteName);

  upsertMeta("name", "twitter:card", "summary");
  upsertMeta("name", "twitter:title", ogTitle);
  upsertMeta("name", "twitter:description", ogDescription);

  upsertLink("canonical", canonicalUrl);

  injectJsonLd(routeName);
}

export function getSiteUrl() {
  return SITE_URL;
}

export { tagline, siteName, defaultDescription };
