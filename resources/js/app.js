import "preline/preline";
import "./bootstrap";
import "../css/app.css";
import "sweetalert2/dist/sweetalert2.min.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import VueSweetAlert from "vue-sweetalert2";

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
            let coach_app_id = window.location.pathname.split("/")[2];

            if (coach_app_id === "" || coach_app_id === undefined) {
                coach_app_id = null;
            }

            if (coach_app_id !== null) {
                localStorage.setItem("coach_app_id", coach_app_id);
            }

            setTimeout(() => {
                window.HSStaticMethods.autoInit();
            }, 100);

            return createApp({
                render: () => {
                    return h(App, props);
                },
            })
                .use(plugin)
                .use(ZiggyVue)
                .use(VueSweetAlert)
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
