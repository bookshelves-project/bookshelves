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
  .js("resources/js/app.js", "public/assets/js")
  .vue()
  .postCss("resources/css/app.css", "public/assets/css", [
    require("postcss-import"),
    require("tailwindcss"),
  ])
  .js("resources/js/blade/index.js", "public/assets/js/blade")
  // webreader
  .js(
    "resources/js/blade/webreader/index.js",
    "public/assets/js/blade/webreader"
  )
  .js(
    "resources/js/blade/webreader/themes.js",
    "public/assets/js/blade/webreader"
  )
  .js(
    "resources/js/blade/webreader/listener/listener.js",
    "public/assets/js/blade/webreader"
  )
  //
  .js("resources/js/blade/markdown/index.js", "public/assets/js/blade/markdown")
  .js("resources/js/blade/set-color-mode.js", "public/assets/js/blade")
  .postCss("resources/css/blade/index.pcss", "public/assets/css/blade", [
    require("postcss-import"),
    require("tailwindcss"),
  ])
  .postCss("resources/css/blade/webreader.pcss", "public/assets/css/blade", [
    require("postcss-import"),
    require("tailwindcss"),
  ])
  .webpackConfig(require("./webpack.config"));

if (mix.inProduction()) {
  mix.version();
} else {
  let withBrowserSync = process.env.BROWSER_SYNC;
  if (withBrowserSync) {
    let appUrl = process.env.APP_URL;
    appUrl = appUrl.replace(/(^\w+:|^)\/\//, "");

    /**
     * Browser sync
     */
    const PATHS = {
      src: "src",
      dist: "resources",
      proxy: appUrl,
    };

    mix
      .disableSuccessNotifications()
      // .setPublicPath(PATHS.dist)
      .options({ processCssUrls: false })
      .browserSync({
        ui: false,
        injectChanges: true,
        notify: true,
        host: "localhost",
        port: 8001,
        proxy: `${PATHS.proxy}`,
        // files: [`${PATHS.dist}/*.*`],
        files: [
          "public/css/**/*.css",
          "public/js/**/*.js",
          "app/**/*",
          "routes/**/*",
          "resources/js/**/*",
          "resources/css/**/*",
          "resources/views/**/*",
          "resources/lang/**/*",
        ],
      });
  }
}
