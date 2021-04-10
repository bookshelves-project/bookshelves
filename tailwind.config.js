const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  purge: [
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue",
  ],

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
      height: {
        hero: "32rem",
      },
      maxWidth: {
        extra: "120rem",
      },
    },
  },
  variants: {
    extend: {
      width: ["hover", "focus"],
      textColor: ["responsive", "hover", "focus", "group-hover"],
      scale: ["responsive", "hover", "focus", "active", "group-hover"],
      translate: ["responsive", "hover", "focus", "active", "group-hover"],
      backgroundColor: ["hover", "focus", "group-hover"],
      borderColor: ["hover", "focus", "group-hover"],
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
