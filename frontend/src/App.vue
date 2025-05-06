<script setup>
import { useRoute } from 'vue-router'
import Sidebar from './components/comum/sidebar.vue'

const route = useRoute()

</script>

<template>
  <div class="flex h-screen">
    <Sidebar v-if="route.meta.requiresAuth" />
    <main class="flex-1 bg-zinc-900/50 p-10">
      <router-view />
    </main>
  </div>
</template>
