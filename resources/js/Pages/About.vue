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
    <h1>This is about page</h1>

    <form @submit.prevent="submit">
      <div>
        <label>Email</label>
        <input type="email" class="form-input block" v-model="form.email">
        <div v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</div>
      </div>
      <div>
        <label>Name</label>
        <input type="text" class="form-input block" v-model="form.name">
        <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
      </div>
      <div>
        <label>Message</label>
        <input type="text" class="form-input block" v-model="form.message">
        <div v-if="form.errors.message" class="text-red-500">{{ form.errors.message }}</div>
      </div>
      <!-- submit -->
      <button type="submit" class="btn btn-primary" :disabled="form.processing">Login</button>
    </form>
  </div>

  <Link href="/" class="link">Home page</Link>
</template>
