<script setup>
import {route} from '@/Scripts/Routing/Router.js'
import { Link } from '@inertiajs/inertia-vue3'

//...
</script>

<template>
    <div class="container mx-auto text-center py-10">
        <h1 class="font-bold text-4xl mb-2">Welcome</h1>
        <p>Laravel, Tailwind, Vue, Vite and Ziggy</p>
        <hr class="my-5" />
        <div class="w-1/2 mx-auto text-center prose max-w-none">
            <Link href="hello">Hello counter</Link>
        </div>
    </div>
</template>

<style scoped>

</style>
