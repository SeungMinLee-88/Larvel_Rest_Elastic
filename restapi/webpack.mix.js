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

/*mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');*/
/*var mix = require('laravel-mix');*/
let mix = require('laravel-mix');
mix.sass('resources/sass/app.scss', 'public/css/all.css');
/*mix.css('resources/assets/vendor/earthsong.css', 'css');
mix.styles('node_modules/dropzone/dist/dropzone.css', 'public/css/app.css');*/

mix.styles([
    'public/css/all.css',
    'node_modules/dropzone/dist/dropzone.css',
    'node_modules/bootstrap/dist/css/bootstrap.css',
    /*    'resources/assets/vendor/earthsong.css',*/
], 'public/css/app.css');

mix.js([
    'resources/js/app.js',
    'node_modules/jquery/dist/jquery.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
    /*    'node_modules/select2/dist/js/select2.js',*/
    'node_modules/dropzone/dist/dropzone.js',

], 'public/js/app.js')

/*mix.js('resources/js/app.js', 'public/js/app.js');
mix.js('node_modules/jquery/dist/jquery.js', 'public/js/app.js');
mix.js('node_modules/bootstrap-sass/assets/javascripts/bootstrap.js', 'public/js/app.js');
mix.js('node_modules/dropzone/dist/dropzone.js', 'public/js/app.js');
mix.js('node_modules/bootstrap/dist/js/bootstrap.js', 'public/js');
mix.js('resources/assets/vendor/fastclick/lib/fastclick.js', 'public/js');
mix.js('resources/assets/vendor/tabby/jquery.textarea.js', 'public/js');
mix.js('resources/assets/vendor/autosize/dist/autosize.js', 'public/js');
mix.js('resources/assets/vendor/highlightjs/highlight.pack.js', 'public/js');

mix.js('resources/assets/vendor/marked/lib/marked.js', 'public/js/app.js');*/



mix.version('public/css/app.css', 'public/js/app.js');
mix.copy("node_modules/font-awesome/fonts/**/*", "public/build/fonts");
