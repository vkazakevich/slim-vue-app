<template>
  <header>
    <h1 class="app-title">Book Management System</h1>
  </header>

  <main>
    <book-list/>
  </main>

  <Toast/>
</template>

<script setup>
import BookList from './components/BookList.vue'
import Toast from 'primevue/toast'
</script>


