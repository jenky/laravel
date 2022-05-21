<template>
  <Head title="Welcome" />
  <div class="hero min-h-screen bg-base-200">
    <div class="hero-content text-center">
      <div class="max-w-md">
        <h1 class="text-5xl font-bold">Welcome to <a href="https://laravel.com">Laravel</a> with <a href="https://inertiajs.com">Inertia</a> and <a href="https://vitejs.dev">Vite</a></h1>
        <p class="py-6">Let's get started!</p>
        <Link :href="route('about')" class="btn btn-primary normal-case">About</Link>
      </div>
    </div>
  </div>
</template>
