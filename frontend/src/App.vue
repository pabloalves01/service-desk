<script setup>
import { useRoute } from 'vue-router'
import Sidebar from './components/comum/sidebar.vue'

const route = useRoute()

</script>

<template>
  <div class="flex h-screen">
    <Sidebar v-if="route.meta.requiresAuth" class="w-64 bg-gray-800" />
    <main class="flex-1">
      <router-view />
    </main>
  </div>
</template>
