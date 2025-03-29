<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import HelloWorld from './components/HelloWorld.vue'
import TheWelcome from './components/TheWelcome.vue'

const message = ref('')

onMounted(() => {
  // Fazendo a requisição GET para a API Laravel
  axios.get('http://localhost:8000/api/test')  // URL do backend Laravel
    .then(response => {
      message.value = response.data.message  // A resposta será exibida no template
    })
    .catch(error => {
      console.error('Erro ao fazer a requisição:', error)
    })
})
</script>

<template>
  <main>
    <router-view></router-view>
  </main>
</template>

<style scoped>


</style>
