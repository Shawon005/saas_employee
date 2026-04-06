export default {
  content: [
    "./app/**/*.php",
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        brand: "#1A2340",
        accent: "#00C896",
        danger: "#EF4444",
        warning: "#F59E0B",
        background: "#F8FAFC",
      },
      fontFamily: {
        sans: ["Inter", "sans-serif"],
        bangla: ["Hind Siliguri", "sans-serif"],
      },
    },
  },
  plugins: [],
};
