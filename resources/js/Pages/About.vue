<script setup>
import { inject } from 'vue'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'

const form = useForm({
  email: '',
  name: '',
  message: '',
})

const route = inject('route')

function submit() {
  form.post(route('contact'), {
    preserveScroll: (page) => Object.keys(page.props.errors).length,
  })
}

</script>

<template>
  <Head title="About" />
  <div class="flex flex-col justify-center items-center">
    <h1 class="my-10 font-bold">This is about page</h1>

    <form @submit.prevent="submit">
      <div class="form-control my-5 w-full max-w-xs">
        <label class="label">
          <span class="label-text">Email</span>
        </label>
        <input type="email" class="input input-bordered input-primary my-2 w-full max-w-xs" v-model="form.email">
        <div v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</div>
      </div>
      <div class="form-control my-5 w-full max-w-xs">
        <label>
          <span class="font-label">Name</span>
        </label>
        <input type="text" class="input input-bordered input-primary my-2 w-full max-w-xs" v-model="form.name">
        <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
      </div>
      <div class="form-control my-5 w-full max-w-xs">
        <label>
          <span class="form-label">Message</span>
        </label>
        <input type="text" class="input input-bordered input-primary my-2 w-full max-w-xs" v-model="form.message">
        <div v-if="form.errors.message" class="text-red-500">{{ form.errors.message }}</div>
      </div>
      <!-- submit -->
      <div class="text-center">
        <button type="submit" :class="['btn btn-primary mx-2 normal-case', { loading: form.processing }]" :disabled="form.processing">Submit</button>
        <Link href="/" class="btn btn-ghost mx-2">Home page</Link>
      </div>
    </form>
  </div>
</template>
