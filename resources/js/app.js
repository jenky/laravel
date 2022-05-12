import '../css/app.css';
import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from "@inertiajs/progress";

InertiaProgress.init();

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob('../js/Pages/**/*.vue')

        return (await pages[`../js/Pages/${name}.vue`]()).default;
    },
    setup({ el, app, props, plugin }) {
        createApp({ render: () => h(app, props) })
            .use(plugin)
            .mount(el);
    },
});
