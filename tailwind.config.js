/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  safelist: ['bg-primary'],
  theme: {
    extend: {
      colors: {
        'primary': '#2E5CB8'
      },
      scale: ['group-hover'],
      translate: ['group-hover'],
    },
  },
  plugins: [
    require('@tailwindcss/aspect-ratio'),

  ],
}

