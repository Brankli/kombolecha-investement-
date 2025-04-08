const mix = require("laravel-mix");

mix.postCss("resources/css/app.css", "public/css", [
    require("postcss-import"),
    require("tailwindcss"),
    require("autoprefixer"),
])
    .js("resources/js/back/back.js", "public/back.js")
    .vue()
    .version();
