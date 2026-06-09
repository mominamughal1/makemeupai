/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        brand: {
          rose: "#ca4d91",
          plum: "#9b2b6c",
          lilac: "#7f56d9",
          blush: "#fff7fb",
        },
      },
    },
  },
  plugins: [],
};
