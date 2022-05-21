<script setup>
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
    <h1 class="my-10 font-bold text-3xl">This is about page</h1>

    <form @submit.prevent="submit">
      <div class="form-control my-5 w-full max-w-xs">
        <label class="label">
          <span class="label-text">Email</span>
        </label>
        <input type="email" class="input input-bordered my-2 w-full max-w-xs" v-model="form.email">
        <div v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</div>
      </div>
      <div class="form-control my-5 w-full max-w-xs">
        <label>
          <span class="font-label">Name</span>
        </label>
        <input type="text" class="input input-bordered my-2 w-full max-w-xs" v-model="form.name">
        <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
      </div>
      <div class="form-control my-5 w-full max-w-xs">
        <label>
          <span class="form-label">Message</span>
        </label>
        <input type="text" class="input input-bordered my-2 w-full max-w-xs" v-model="form.message">
        <div v-if="form.errors.message" class="text-red-500">{{ form.errors.message }}</div>
      </div>
      <!-- submit -->
      <div class="text-center space-x-2">
        <button type="submit" :class="['btn btn-primary normal-case', { loading: form.processing }]" :disabled="form.processing">Submit</button>
        <Link href="/" class="btn btn-ghost normal-case">Home page</Link>
      </div>
    </form>
  </div>
</template>
