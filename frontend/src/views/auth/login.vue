<!-- src/views/Login.vue -->
<template>
    <div>
      <h2 class="text-white mb-2 text-lg">Login</h2>
      <input v-model="email" type="email" placeholder="Email" style="margin-right: 10px;" />
      <input v-model="password" type="password" placeholder="Senha" style="margin-right: 10px;" />
      <button class="bg-green-500 px-10" @click="login">Login</button>
      <p v-if="error">{{ error }}</p>
    </div>

    <div class="bg-purple-500 mt-10 w-36">REGISTRE-SE AQUI</div>
    <RouterLink to="/register" class="text-white underline">Registrar</RouterLink>

  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import axiosInstance from '@/axios';
  
  const email = ref('');
  const password = ref('');
  const error = ref('');
  const router = useRouter();
  
  const login = async () => {
    try {
      const response = await axiosInstance.post('/login', {
        email: email.value,
        password: password.value,
      });
  
      // Salvar o token no localStorage
      localStorage.setItem('token', response.data.token);
  
      // Redirecionar para o Dashboard ou outra página
      router.push('/');
    } catch (err) {
      error.value = 'Credenciais inválidas';
    }
  };
  </script>
  