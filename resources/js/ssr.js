import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import createServer from '@inertiajs/server'
import { ZiggyVue } from '@/../vendor/tightenco/ziggy/src/js/vue'
import { Ziggy } from './ziggy'
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from './Components/Layout/Layout.vue'

createServer((page) => createInertiaApp({
  page,
  render: renderToString,
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.vue')
    // return (await pages[`./Pages/${name}.vue`]())

    // Default layout setup
    const page = pages[`./Pages/${name}.vue`]()
    page.layout ??= Layout

    return page
  },
  setup({ app, props, plugin }) {
    return createSSRApp({
      render: () => h(app, props),
    }).use(plugin)
      .use(ZiggyVue, Ziggy)
      .component('Head', Head)
      .component('Link', Link)
  },
}))
