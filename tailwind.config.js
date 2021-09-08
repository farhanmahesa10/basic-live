module.exports = {
  purge: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
    fontFamily: {
      'nunito': ['nunito', 'sans-serif'],

    }
  },

  variants: {
    extend: {},
  },
  plugins: [],
}
