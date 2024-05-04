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
        extend: {
            animation: {
                wave: "wave 2.5s infinite",
                shake: "shake 2.5s infinite",
            },
            keyframes: {
                wave: {
                    "0%, 60%, 100%": { transform: "rotate(0deg)" },
                    "10%, 30%": { transform: "rotate(14deg)" },
                    "20%": { transform: "rotate(-8deg)" },
                    "40%": { transform: "rotate(-4deg)" },
                    "50%": { transform: "rotate(10deg)" },
                },
                shake: {
                    "0%,60%,100%": { transform: "translate(0, 0)" },
                    "10%, 30%": { transform: "translate(-1px, 0)" },
                    "20%": { transform: "translate(-3px, 0)" },
                    "40%": { transform: "translate(-4px, 0)" },
                    "50%": { transform: "translate(-7px, 0)" },
                },
            },
        },
        fontFamily: {
            body: [
                "Rototo",
                "Inter",
                "ui-sans-serif",
                "system-ui",
                // other fallback fonts
            ],
            sans: [
                "Inter",
                "ui-sans-serif",
                "system-ui",
                // other fallback fonts
            ],
        },
    },
    plugins: [require("flowbite/plugin")],
};
