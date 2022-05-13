<script setup>
import { Head } from '@inertiajs/inertia-vue3'

defineProps({
  'title': String
})

</script>

<template>
<Head :title="title ? `${title} - ${$page.props.app.name}` : $page.props.app.name">
  <slot />
</Head>
</template>
