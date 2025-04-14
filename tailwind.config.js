/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                enqutatash: "#F39104",
                primary: "#FF6363",
                darkred: "#CA8A04",
                darkblue: "#08244D",
                briteblue: "#0680C1",
                colorbackground: "#2E5895",
                secondary: {
                    100: "#E2E2D5",
                    200: "#888883",
                },
            },
            fontFamily: {
                body: ["Nunito"],
                Cabin: ["Cabin"],
                roboto: ["Roboto"],
            },
        },
        backgroundImage: {
            "hero-pattern": "url('/asset/errorimage/plain.jpg')",
            history: "url('/asset/images/Kombolcha-111.jpg')",
            newsbackground: "url('/asset/images/newsbackground.jpg')",
        },
    },
     plugins: [],
};
