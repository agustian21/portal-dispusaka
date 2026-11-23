import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { bunny } from "laravel-vite-plugin/fonts";
import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/dispusaka.css",
                "resources/css/profile.css",
                "resources/css/berita.css",
                "resources/css/multimedia.css",
                "resources/css/pamflet.css",
                "resources/css/informasi-publik.css",
                "resources/css/accessibility.css",
                "resources/css/faq.css",
                "resources/css/visimisi.css",
                "resources/css/alamat.css",
                "resources/css/struktur.css",
                "resources/css/koleksibuku.css",
                "resources/js/app.js",
                "resources/js/dispusaka.js",
                "resources/js/berita.js",
                "resources/js/multimedia.js",
                "resources/js/informasi-publik.js",
                "resources/js/accessibility.js",
                "resources/js/faq.js",
            ],
            refresh: true,
            fonts: [
                bunny("Instrument Sans", {
                    weights: [400, 500, 600],
                }),
            ],
        }),

        tailwindcss(),
        vue(),
    ],
});
