const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  purge: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue",
  ],
  darkMode: "class",
  theme: {
    container: {
      center: true,
    },
    screens: {
      sm: "360px",
      md: "600px",
      lg: "900px",
      xl: "1300px",
      "2xl": "1536px",
      "3xl": "1920px",
    },
    extend: {
      colors: {
        primary: {
          100: "#e2e0ff",
          200: "#c4c1ff",
          300: "#a7a1ff",
          400: "#8982ff",
          500: "#6c63ff",
          600: "#564fcc",
          700: "#413b99",
          800: "#2b2866",
          900: "#161433",
        },
      },
      fontFamily: {
        quicksand: ["Quicksand"],
        handlee: ["Handlee"],
      },
      typography: (theme) => ({
        DEFAULT: {
          css: {
            h1: {
              fontSize: "2rem",
            },
          },
        },
        light: {
          css: {
            color: theme("colors.gray.100"),
            h1: {
              color: theme("colors.gray.100"),
            },
            h2: {
              color: theme("colors.gray.100"),
            },
            h3: {
              color: theme("colors.gray.100"),
            },
            strong: {
              color: theme("colors.gray.200"),
            },
            blockquote: {
              color: theme("colors.gray.200"),
            },
            a: {
              color: theme("colors.primary.100"),
              "&:hover": {
                color: theme("colors.primary.200"),
              },
            },
          },
        },
      }),
    },
  },
  variants: {
    extend: {
      display: ["dark"],
      opacity: ["dark"],
      width: ["hover", "focus"],
      textColor: ["responsive", "hover", "focus", "group-hover", "dark"],
      scale: ["responsive", "hover", "focus", "active", "group-hover"],
      boxShadow: ["dark"],
      translate: ["responsive", "hover", "focus", "active", "group-hover"],
      backgroundColor: ["hover", "focus", "group-hover", "dark"],
      backgroundOpacity: ["dark"],
      borderColor: ["hover", "focus", "group-hover"],
      borderRadius: ["dark"],
    },
  },
  plugins: [
    require("@tailwindcss/forms"),
    require("@tailwindcss/typography"),
    require("@tailwindcss/aspect-ratio"),
    require("@tailwindcss/line-clamp"),
    require("tailwindcss-debug-screens"),
  ],
};
