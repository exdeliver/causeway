const mix = require('laravel-mix');
var SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');
let tailwindcss = require('tailwindcss');
const PurgecssPlugin = require('purgecss-webpack-plugin');

// Custom PurgeCSS extractor for Tailwind that allows special characters in
// class names.
//
// https://github.com/FullHuman/purgecss#extractor
class TailwindExtractor {
    static extract(content) {
        return content.match(/[A-Za-z0-9-_:\/]+/g) || [];
    }
}
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
var siteName = 'deraad';
var userName = 'jasonhoendervanger';
mix.browserSync({
    files: [
        '../src/Views/**/*.blade.php',
        '../assets/sass/**/*',
        '../assets/js/*',
        '../assets/images/**/*',
        '../assets/image/**/*',
        '../assets/fonts/**/*',
    ],
    proxy: 'https://' + siteName + '.test',
    host: siteName + '.test',
    // Uncomment the lines below if working with SSL
    https: {
        key:
            '/Users/' +
            userName +
            '/.config/valet/Certificates/' +
            siteName +
            '.test.key',
        cert:
            '/Users/' +
            userName +
            '/.config/valet/Certificates/' +
            siteName +
            '.test.crt'
    },
    open: 'external',
    port: 8000,
}).webpackConfig({
    plugins: []
}).js('js/app.js', 'compiled/js')
    .js('js/website.js', 'compiled/js')
    .js('js/datatables.min.js', 'compiled/js')
    .sass('sass/app.scss', 'compiled/css')
    .options({
        processCssUrls: false,
        postCss:[tailwindcss('./tailwind.config.js')],
    })
    .sass('sass/website.scss', 'compiled/css')
    .sass('sass/datatables.scss', 'compiled/css')
    .copyDirectory('fonts', 'compiled/fonts')
    .copyDirectory('images', 'compiled/images')
    .copyDirectory('image', 'compiled/image');