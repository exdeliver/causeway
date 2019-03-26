const mix = require('laravel-mix');
var SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');


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

mix.webpackConfig({
    plugins: [
    ]
}).js('js/app.js', 'compiled/js')
    .js('js/website.js', 'compiled/js')
    .js('js/datatables.min.js', 'compiled/js')
    .sass('sass/app.scss', 'compiled/css')
    .sass('sass/website.scss', 'compiled/css')
    .sass('sass/datatables.scss', 'compiled/css')
    .copyDirectory('fonts', 'compiled/fonts')
    .copyDirectory('images', 'compiled/images')
    .copyDirectory('image', 'compiled/image');