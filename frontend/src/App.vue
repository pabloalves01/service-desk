<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Sidebar from './components/comum/sidebar.vue'

const message = ref('')
const errorMessage = ref('')

</script>

<template>
  <div class="container">
    <!-- <Sidebar /> -->
    <main>
      <router-view />
    </main>
  </div>
</template>

<style scoped>
.container {
  display: flex;
}

main {
  flex: 1;
  padding: 1rem;
}

.error {
  color: red;
}
</style>