let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

const root_dir = './';
const assets_dir = root_dir + '/assets';
const dist_dir = root_dir + '/dist';

mix.js(assets_dir + '/javascript/app.js', dist_dir);
mix.sass(assets_dir + '/scss/app.scss', dist_dir).sourceMaps();
mix.webpackConfig({ 
        output: {
            chunkFilename: dist_dir + '/[name].js'
        },
	devtool: "inline-source-map" 
});



