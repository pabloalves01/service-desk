<template>
  <div class="min-h-screen flex items-center justify-center bg-black/75 relative overflow-hidden">
    <!-- Background canvas for lines following mouse -->
    <canvas ref="canvas" class="absolute inset-0 w-full h-full"></canvas>
    
    <!-- Login container -->
    <div class="w-full max-w-md px-6 py-8 bg-black/10 border border-zinc-800 backdrop-blur-md rounded-lg shadow-xl z-10 relative">
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Loopn</h1>
        <p class="text-gray-300">Entre para acessar o sistema</p>
      </div>
      
      <form @submit.prevent="login" class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
          <input 
            v-model="email" 
            id="email" 
            type="email" 
            required 
            class="w-full px-4 py-2 bg-black/50 border border-zinc-800 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition"
            placeholder="email@email.com"
          />
        </div>
        
        <div>
          <div class="flex items-center justify-between mb-1">
            <label for="password" class="block text-sm font-medium text-gray-300">Senha</label>
            <a href="#" class="text-sm text-gray-400 hover:text-white">Esqueceu a senha?</a>
          </div>
          <input 
            v-model="password" 
            id="password" 
            type="password" 
            required 
            class="w-full px-4 py-2 bg-black/50 border border-zinc-800 rounded-md text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition"
            placeholder="••••••••"
          />
        </div>
        
        <div class="flex items-center">
          <input id="remember-me" type="checkbox" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-700 rounded bg-gray-800/50">
          <label for="remember-me" class="ml-2 block text-sm text-gray-300">Lembrar-me</label>
        </div>
        
        <div v-if="error" class="bg-red-500/20 border border-red-500 text-red-200 px-4 py-2 rounded-md text-sm">
          {{ error }}
        </div>
        
        <button 
          type="submit" 
          @click="login"
          class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black/50 border-zinc-800 hover:bg-[#274690] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors"
        >
          Entrar
        </button>
      </form>
      
      <div class="mt-6 text-center">
        <p class="text-gray-400 text-sm">
          Não tem uma conta? 
          <router-link to="/register" class="text-gray-400 hover:text-white font-medium">
            Registre-se
          </router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import axiosInstance from '../../axios';

const email = ref('');
const password = ref('');
const error = ref('');
const router = useRouter();
const canvas = ref(null);
let animationFrameId = null;

// Login function
const login = async () => {
    try {
      const response = await axiosInstance.post('/login', {
        email: email.value,
        password: password.value,
      });
  
      localStorage.setItem('token', response.data.token);
  
      router.push('/');
    } catch (err) {
      error.value = 'Credenciais inválidas';
    }
  };

// Background animation with lines following mouse
onMounted(() => {
  const ctx = canvas.value.getContext('2d');
  let width = window.innerWidth;
  let height = window.innerHeight;
  let mouseX = width / 2;
  let mouseY = height / 2;
  let particles = [];
  const particleCount = 75;
  
  // Set canvas size
  canvas.value.width = width;
  canvas.value.height = height;
  
  // Handle mouse movement
  const handleMouseMove = (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
  };
  
  // Handle window resize
  const handleResize = () => {
    width = window.innerWidth;
    height = window.innerHeight;
    canvas.value.width = width;
    canvas.value.height = height;
    initParticles();
  };
  
  // Create particles
  const initParticles = () => {
    particles = [];
    for (let i = 0; i < particleCount; i++) {
      particles.push({
        x: Math.random() * width,
        y: Math.random() * height,
        size: Math.random() * 3 + 1,
        speedX: (Math.random() - 0.5) * 0.5,
        speedY: (Math.random() - 0.5) * 0.5,
        // cor branca
        color: `rgba(255, 255, 255, ${Math.random() * 0.5 + 0.5})`
        // color: `rgba(${Math.floor(Math.random() * 100 + 155)}, ${Math.floor(Math.random() * 100 + 155)}, 255, 0.7)`
      });
    }
  };
  
  // Animation loop
  const animate = () => {
    ctx.clearRect(0, 0, width, height);
    
    // Update and draw particles
    for (let i = 0; i < particles.length; i++) {
      const p = particles[i];
      
      // Move particles
      p.x += p.speedX;
      p.y += p.speedY;
      
      // Boundary check
      if (p.x > width || p.x < 0) p.speedX *= -1;
      if (p.y > height || p.y < 0) p.speedY *= -1;
      
      // Draw particle
      ctx.fillStyle = p.color;
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
      ctx.fill();
      
      // Draw lines to mouse if close enough
      const dx = mouseX - p.x;
      const dy = mouseY - p.y;
      const distance = Math.sqrt(dx * dx + dy * dy);
      
      if (distance < 200) {
        ctx.beginPath();
        ctx.strokeStyle = `rgba(150, 150, 255, ${0.7 - distance / 150})`;
        ctx.lineWidth = 1;
        ctx.moveTo(p.x, p.y);
        ctx.lineTo(mouseX, mouseY);
        ctx.stroke();
      }
      
      // Draw lines between particles if close enough
      for (let j = i + 1; j < particles.length; j++) {
        const p2 = particles[j];
        const dx2 = p.x - p2.x;
        const dy2 = p.y - p2.y;
        const distance2 = Math.sqrt(dx2 * dx2 + dy2 * dy2);
        
        if (distance2 < 150) {
          ctx.beginPath();
          ctx.strokeStyle = `rgba(150, 150, 255, ${0.5 - distance2 / 100})`;
          ctx.lineWidth = 0.5;
          ctx.moveTo(p.x, p.y);
          ctx.lineTo(p2.x, p2.y);
          ctx.stroke();
        }
      }
    }
    
    animationFrameId = requestAnimationFrame(animate);
  };
  
  // Initialize
  window.addEventListener('mousemove', handleMouseMove);
  window.addEventListener('resize', handleResize);
  initParticles();
  animate();
  
  // Cleanup
  onUnmounted(() => {
    window.removeEventListener('mousemove', handleMouseMove);
    window.removeEventListener('resize', handleResize);
    cancelAnimationFrame(animationFrameId);
  });
});
</script>