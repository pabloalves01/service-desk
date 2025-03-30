<!-- src/views/Login.vue -->
<template>
    <div>
      <h2 class="text-white mb-4 text-7xl">Registro</h2>
      <input v-model="name" type="name" placeholder="Nome" style="margin-right: 10px;" />
      <input v-model="email" type="email" placeholder="Email" style="margin-right: 10px;" />
      <input v-model="password" type="password" placeholder="Senha" style="margin-right: 10px;" />
      <button class="bg-green-500 px-10" @click="register">Registrar</button>
      <p v-if="error">{{ error }}</p>
    </div>

  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import axiosInstance from '../../axios'; 
  
  const name = ref('');
  const email = ref('');
  const password = ref('');
  const error = ref('');
  const router = useRouter();
  
  const register = async () => {
    try {
      const response = await axiosInstance.post('/register', { 
        name: name.value,
        email: email.value,
        password: password.value,
      });
  
      localStorage.setItem('token', response.data.token);
  
      router.push('/');
    } catch (err) {
      error.value = 'Erro ao registrar o usuário.';
      console.error(err);
    }
  };
  </script>
  
  
  