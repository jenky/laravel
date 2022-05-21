// import('./bootstrap');

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { ZiggyVue } from '@/../vendor/tightenco/ziggy/src/js/vue'
import { Ziggy } from './ziggy'
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from './Components/Layout/Layout.vue'

createInertiaApp({
  title: title => `${title} - ${import.meta.env.VITE_APP_NAME}`,
  resolve: async (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue')
    // return (await pages[`./Pages/${name}.vue`]()).default

    // Default layout setup
    const page = (await pages[`./Pages/${name}.vue`]()).default
    page.layout ??= Layout

    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .component('Head', Head)
      .component('Link', Link)
      .mount(el)
  },
})
