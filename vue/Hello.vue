<script setup>
import { Link } from '@inertiajs/inertia-vue3'
defineProps({
    name: String
})
</script>

<template>
    <h1>Hello from Vue</h1>
    <Link href="/welcome">Welcome {{ name }}</Link>
</template>
