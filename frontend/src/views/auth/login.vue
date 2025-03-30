<!-- src/views/Login.vue -->
<template>
    <div>
      <h2>Login</h2>
      <input v-model="email" type="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Senha" />
      <button @click="login">Login</button>
      <p v-if="error">{{ error }}</p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  
  const email = ref('');
  const password = ref('');
  const error = ref('');
  const router = useRouter();
  
  const login = async () => {
    try {
      const response = await http.post('/login', {
        email: email.value,
        password: password.value,
      });
  
      // Salvar o token no localStorage
      localStorage.setItem('token', response.data.token);
  
      // Redirecionar para o Dashboard ou outra página
      router.push('/dashboard');
    } catch (err) {
      error.value = 'Credenciais inválidas';
    }
  };
  </script>
  