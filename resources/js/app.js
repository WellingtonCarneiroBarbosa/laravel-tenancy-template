import "../../node_modules/preline/dist/preline.js";
import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

if (window.location.pathname.includes("students-app")) {
    createInertiaApp({
        title: (title) => `${title} - ${appName}`,
        resolve: (name) =>
            resolvePageComponent(
                `./StudentsApp/Pages/${name}.vue`,
                import.meta.glob("./StudentsApp/Pages/**/*.vue")
            ),
        setup({ el, App, props, plugin }) {
            let coachAppId = props.initialPage.props?.coach_app_id ?? null;

            if (coachAppId !== null) {
                window.axios.defaults.headers.common["X-Tenant-Id"] =
                    coachAppId;
            }

            return createApp({
                render: () => {
                    return h(App, props);
                },
            })
                .use(plugin)
                .use(ZiggyVue)
                .mount(el);
        },
        progress: {
            color: "#4B5563",
        },
    });
} else {
    createInertiaApp({
        title: (title) => `${title} - ${appName}`,
        resolve: (name) =>
            resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob("./Pages/**/*.vue")
            ),
        setup({ el, App, props, plugin }) {
            let user = props.initialPage.props?.auth?.user ?? null;

            if (user !== null) {
                window.axios.defaults.headers.common["X-Tenant-Id"] =
                    user.current_team_id;
            }

            return createApp({
                render: () => {
                    return h(App, props);
                },
            })
                .use(plugin)
                .use(ZiggyVue)
                .mount(el);
        },
        progress: {
            color: "#4B5563",
        },
    });
}
