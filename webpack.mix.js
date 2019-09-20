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
//    .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/controller/testcases/index.js', 'public/js/controller/testcases/index.js');
mix.js('resources/js/controller/projects/index.js', 'public/js/controller/projects/index.js');
mix.js('resources/js/controller/projects/create.js', 'public/js/controller/projects/create.js');
mix.js('resources/js/controller/sheets/create.js', 'public/js/controller/sheets/create.js');
