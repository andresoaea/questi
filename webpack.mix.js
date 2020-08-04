const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel mainlication. By default, we are compiling the Sass
 | file for the mainlication as well as bundling up all the JS files.
 |
 */

// Paths
//mix.setPublicPath("../");
mix.setResourceRoot("../");

// Source maps
if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: "source-map"
    }).sourceMaps();
}

// Compiling options
mix.js("resources/js/main.js", "public/js")
    .sass("resources/sass/main.scss", "public/css")
    .js("resources/js/profile/profile.js", "public/js")
    .sass("resources/sass/profile.scss", "public/css")
    .js("resources/js/admin.js", "public/js")
    .sass("resources/sass/admin.scss", "public/css")
    .options({
        processCssUrls: true
    })
    .browserSync({
        proxy: "http://127.0.0.1/questi/public", // your domain test
        port: 3000 // your port
    });
