/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./inc/**/*.php",
    "./template-parts/**/*.php",
    "./assets/js/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        brand: "#cc4345",
        secondary: "rgb(148, 163, 184)",
      },
      fontFamily: {
        sans: ["Arad", "ui-sans-serif", "system-ui", "sans-serif"],
      },
    },
  },
  plugins: [],
  darkMode: 'class',
}
