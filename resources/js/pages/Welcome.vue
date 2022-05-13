<script setup>
import { Link } from '@inertiajs/inertia-vue3'
import Head from '@/js/Components/Layout/Head.vue'
</script>

<template>
  <Head title="Welcome to Laravel, Vite and Inertia" />
  Welcome to Laravel with Inertia and Vite
  <Link :href="route('about')">About</Link>
</template>
