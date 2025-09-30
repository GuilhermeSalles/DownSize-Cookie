import "./bootstrap";
import "../css/app.css";
import { createInertiaApp } from "@inertiajs/react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { StrictMode } from "react";
import { createRoot } from "react-dom/client";

const appName =
    document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title ? title + " • " : ""}${appName}`,
    // 🔒 Opção A (helpers do vite plugin) — mantém convenção padrão
    // resolve: (name) =>
    //   resolvePageComponent(
    //     `./Pages/${name}.tsx`,
    //     import.meta.glob("./Pages/**/*.tsx")
    //   ),

    // ✅ Opção B (mais robusta): aceita .tsx e .jsx e tenta normalizar
    resolve: async (name: string) => {
        const pagesTsx = import.meta.glob("./Pages/**/*.tsx", { eager: true });
        const pagesJsx = import.meta.glob("./Pages/**/*.jsx", { eager: true });

        const tryKeys = (n: string) => [
            `./Pages/${n}.tsx`,
            `./Pages/${n}.jsx`,
            `./Pages/${n.toLowerCase()}.tsx`,
            `./Pages/${n.toLowerCase()}.jsx`,
        ];

        let mod: any = undefined;
        for (const key of tryKeys(name)) {
            mod = (pagesTsx as any)[key] || (pagesJsx as any)[key];
            if (mod) break;
        }

        if (!mod) {
            console.error(`[Inertia] Page not found: ${name}`);
            throw new Error(`Page not found: ${name}`);
        }
        return mod.default ?? mod;
    },

    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(
            <StrictMode>
                <App {...props} />
            </StrictMode>
        );
    },
    progress: { color: "#4B5563" },
});
