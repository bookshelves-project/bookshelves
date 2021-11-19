const path = require("path");

const { HeadlessUiResolver } = require("unplugin-vue-components/resolvers");

module.exports = {
  resolve: {
    alias: {
      "@": path.resolve("resources/js"),
      public: path.resolve("public"),
    },
    modules: [
      "node_modules",
      __dirname + "/vendor/spatie/laravel-medialibrary-pro/resources/js",
    ],
  },
  plugins: [
    require("unplugin-vue-components/webpack")({
      /* options */
      dirs: ["resources/js/Components", "resources/js/Layouts"],
      resolvers: [
        // Resolve HeadlessUI Components
        HeadlessUiResolver(),
        // Inertia Resolver
        (name) => {
          const prefix = "Inertia";
          if (name.startsWith(prefix)) {
            // console.log('Found a Inertia Component! Name:', name)
            return {
              importName: name.replace(prefix, ""),
              path: "@inertiajs/inertia-vue3",
            };
          }
        },
      ],
    }),
  ],
};
