<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'

const count = ref(0)
</script>

<template>
<div class="container mx-auto text-center py-10">
    <button class="button" @click="count++">Counter is: {{ count }}</button>
</div>
<Link href="/">Home</Link>
</template>
