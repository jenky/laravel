<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
</script>

<template>
  <Head title="Welcome" />
  <div class="text-center">
    <h1 class="font-bold">Welcome to Laravel with Inertia and Vite</h1>
    <h3>Let's get started!</h3>
    <Link :href="route('about')" class="btn btn-primary my-2 normal-case">About</Link>
  </div>
</template>
