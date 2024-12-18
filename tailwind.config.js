/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./vendor/tales-from-a-dev/flowbite-bundle/templates/**/*.html.twig",
    "./vendor/quill/dist/*.css"
  ],

  theme: {
    extend: {},
  },
  plugins: [require("flowbite/plugin")],
};
