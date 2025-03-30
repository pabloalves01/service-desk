<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Sidebar from './components/comum/sidebar.vue'

const message = ref('')
const errorMessage = ref('')

const fetchMessage = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/test')
    message.value = response.data.message
  } catch (error) {
    console.error('Erro ao fazer a requisição:', error)
    errorMessage.value = 'Erro ao carregar a mensagem'
  }
}

onMounted(fetchMessage)
</script>

<template>
  <div class="container">
    <!-- <Sidebar /> -->
    <main>
      <router-view />
      <p v-if="message">{{ message }}</p>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
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