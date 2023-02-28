/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    // Entra a todas las carpetas y a todos los archivos con la extension marcada le agrega estilos
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
