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

let productionSourceMaps = true;
mix.styles([
    'public/front/css/bootstrap.min.css',
    'public/front/css/colorized.css',
    'public/front/css/animate.css',
    'public/front/css/font-awesome.min.css',
    'public/front/style.css'
],'public/front/css/app.css').sourceMaps(productionSourceMaps, 'source-map');

mix.scripts([
    'public/front/js/jquery-2.2.4.min.js',
    'public/front/js/bootstrapValidator.min.js',
    'public/front/js/css_browser_selector.js',
    'public/front/js/bootstrap.min.js',
    'public/front/js/viewportchecker.js',
    'public/front/js/kodeized.js',
    'public/front/js/main.js',
], 'public/front/js/app.js').sourceMaps(productionSourceMaps, 'source-map');
