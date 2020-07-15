const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/chat.js', 'public/js');
mix.js('resources/js/comment.js', 'public/js');
   //.sass('resources/sass/app.scss', 'public/css');

mix.combine(
      [
          "resources/gull/assets/js/vendor/jquery-3.3.1.min.js",
          "resources/gull/assets/js/vendor/bootstrap.bundle.min.js",
          "resources/gull/assets/js/vendor/perfect-scrollbar.min.js"
      ],
      "public/assets/js/common-bundle-script.js"
  );

  mix.js(["resources/gull/assets/js/script.js"], "public/assets/js/script.js");
