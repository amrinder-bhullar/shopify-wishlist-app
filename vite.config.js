import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
const { resolve } = require("path");

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/wishlist-app.js",
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: "./public/js",
    },
});
