/** @type {import('tailwindcss').Config} */
import preset from "./vendor/filament/support/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
    ],
    theme: {
        colors: {
            primary: {
                50: "#EEF2FF",
                100: "#E0E7FF",
                200: "#C7D2FE",
                300: "#A5B4FC",
                400: "#818CF8",
                500: "#6366F1",
                600: "#4F46E5",
                700: "#4338CA",
                800: "#3730A3",
                900: "#312E81",
                950: "#1E1B4B",
            },
        },
        extend: {},
    },
    plugins: [require("flowbite/plugin")],
};
