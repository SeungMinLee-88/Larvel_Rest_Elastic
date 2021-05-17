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

let mix = require('laravel-mix');
mix.sass('resources/sass/app.scss', 'public/css/all.css');

mix.styles([
    'public/css/all.css',
    'node_modules/dropzone/dist/dropzone.css',
    'node_modules/bootstrap/dist/css/bootstrap.css',
], 'public/css/app.css');

mix.js([
    'resources/js/app.js',
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
    'node_modules/dropzone/dist/dropzone.js',

], 'public/js/app.js')

mix.version('public/css/app.css', 'public/js/app.js');
mix.copy("node_modules/font-awesome/fonts/**/*", "public/build/fonts");
