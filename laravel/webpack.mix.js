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

var coreui_vendor = './vendor/coreui/coreui';
var node_modules = './node_modules';
mix.copyDirectory(coreui_vendor + '/dist', './public/coreui/src')
    .copyDirectory(node_modules + '/popper.js', './public/popper.js')
    .copyDirectory(node_modules + '/bootstrap', './public/bootstrap')
    .copyDirectory(node_modules + '/jquery', './public/jquery');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
