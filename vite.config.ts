import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    //base: "http://172.25.6.51:8080/portfolioNew2/public/build",
    plugins: [
        laravel({
            input: ["resources/js/app.ts", "resources/sass/app.scss"],
            refresh: true,
            //publicPath: "http://172.25.6.51:8080/portfolioNew2/public/build", // update this to the correct public path
        }),
        react(),
    ],
});
