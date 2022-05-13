<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
</script>

<template>
  <Head title="Welcome to Laravel, Vite and Inertia" />
  Welcome to Laravel with Inertia and Vite
  <Link :href="route('about')">About</Link>
</template>
