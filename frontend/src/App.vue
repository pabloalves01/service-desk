<script setup>
import { ref, onMounted } from 'vue'
import Sidebar from './components/comum/sidebar.vue'
</script>

<template>
  <div class="container">
    <!-- <Sidebar /> -->
    <main>
      <router-view />
    </main>
  </div>
</template>
