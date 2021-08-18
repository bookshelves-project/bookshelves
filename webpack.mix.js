const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js("resources/js/app.js", "public/css")
  .vue()
  .postCss("resources/css/app.css", "public/css", [
    require("postcss-import"),
    require("tailwindcss"),
  ])
  .js("resources/js/blade/blade.js", "public/css")
  .js("resources/js/blade/wiki.js", "public/css")
  .js("resources/js/blade/slide-over.js", "public/css")
  .css("resources/css/markdown.css", "public/css")
  .css("resources/css/code.css", "public/css")
  .postCss("resources/css/wiki.css", "public/css", [require("tailwindcss")])
  .webpackConfig(require("./webpack.config"));

if (mix.inProduction()) {
  mix.version();
}
