const path = require( 'path' );
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

mix.js(assets_dir + '/javascript/app.js', '');
mix.sass(assets_dir + '/scss/app.scss', '').sourceMaps();
mix.webpackConfig({
	entry: {
		imageBlock: './assets/javascript/blocks/imageBlock/index.js',
	},
        output: {
            chunkFilename: dist_dir + '/[name].js',
            path: path.resolve( __dirname, './dist/' ),
            publicPath: dist_dir,
            filename: '[name].js',
        },
	devtool: "inline-source-map" 
});



