<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
</script>

<template>
  <Head title="Welcome" />
  <div class="text-center">
    <h1>Welcome to Laravel with Inertia and Vite</h1>
    <h3>Let's get started!</h3>
    <Link :href="route('about')">About</Link>
  </div>
</template>
