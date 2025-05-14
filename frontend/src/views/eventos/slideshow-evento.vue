<template>
  <div class="flex flex-col gap-8" style="height: 100vh;">
    <div class="relative w-full  h-bg-zinc-900 border border-zinc-800 rounded-lg overflow-hidden shadow-lg">

      <!-- Imagens do Slideshow -->
      <div v-if="fotos.length > 0" class="w-full h-full" style="height: 100vh;">
        <img v-for="(foto, index) in fotos" :key="index" :src="$globals.urlBase() + `/storage/${foto.image_path}`"
          :class="[
            'absolute top-0 left-0 w-full h-full transition-opacity duration-500',
            currentIndex === index ? 'opacity-100' : 'opacity-0',
            'object-contain'
          ]" alt="Imagem do evento" />
      </div>

      <!-- Estado vazio -->
      <div v-else class="flex flex-col items-center justify-center h-full text-zinc-500">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-4 opacity-50">
          <line x1="2" x2="22" y1="2" y2="22"></line>
          <path d="M10.41 10.41a2 2 0 1 1-2.83-2.83"></path>
          <line x1="13.5" x2="6.5" y1="13.5" y2="20.5"></line>
          <path d="M14.5 17.5 5 8"></path>
          <path d="M15 7h.01"></path>
          <rect width="20" height="16" x="2" y="4" rx="2"></rect>
        </svg>
        <p>Nenhuma imagem disponível</p>
      </div>

      <!-- Botões de navegação -->
      <button v-if="fotos.length > 1" @click="prevSlide"
        class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white rounded-full p-2 hover:bg-black/70 transition-colors"
        aria-label="Imagem anterior">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m15 18-6-6 6-6"></path>
        </svg>
      </button>

      <button v-if="fotos.length > 1" @click="nextSlide"
        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white rounded-full p-2 hover:bg-black/70 transition-colors"
        aria-label="Próxima imagem">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m9 18 6-6-6-6"></path>
        </svg>
      </button>

      <!-- Indicadores -->
      <div v-if="fotos.length > 1" class="absolute bottom-4 left-0 right-0 flex justify-center gap-2">
        <button v-for="(foto, index) in fotos" :key="`dot-${index}`" @click="setCurrentIndex(index)"
          class="w-3 h-3 rounded-full transition-colors" :class="currentIndex === index ? 'bg-white' : 'bg-zinc-500'"
          aria-label="Navegar para imagem"></button>
      </div>

      <!-- Botão Fullscreen e Contador de imagens -->
      <div v-if="fotos.length > 0"
        class="absolute top-4 left-4 bg-black/50 text-white text-xs px-2 py-1 rounded flex gap-2">
        <button @click="toggleFullscreen"
          class="bg-zinc-800 hover:bg-zinc-600 text-white p-1 rounded-full flex items-center justify-center p-2">
          <Fullscreen class="text-zinc-500" size="24" />
        </button>
      </div>
      <div v-if="fotos.length > 0" class="absolute top-4 right-4 bg-black/50 text-white text-xs px-2 py-1 rounded">
        {{ currentIndex + 1 }} / {{ fotos.length }}
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '../../axios';
import { Fullscreen } from 'lucide-vue-next';
export default {
  components: {
    Fullscreen
  },
  data() {
    return {
      fotos: [],
      idEvento: this.$route.params.id,
      currentIndex: 0,
      timer: null
    };
  },
  created() {
    this.getEvento();
  },
  mounted() {
    this.startSlideshow();
    window.addEventListener('resize', this.handleResize);
  },
  beforeDestroy() {
    this.stopSlideshow();
    window.removeEventListener('resize', this.handleResize);
  },
  methods: {
    async getEvento() {
      try {
        const response = await axiosInstance.get(`/imagens/evento/${this.idEvento}`);
        this.fotos = response.data[0];
      } catch (error) {
        console.error("Erro ao buscar imagens do evento:", error);
      }
    },
    startSlideshow() {
      this.stopSlideshow();
      this.timer = setInterval(() => {
        this.nextSlide();
      }, 5000);
    },
    stopSlideshow() {
      if (this.timer) {
        clearInterval(this.timer);
        this.timer = null;
      }
    },
    nextSlide() {
      if (this.currentIndex === this.fotos.length - 1) {
        this.getEvento();
      }
      this.currentIndex = (this.currentIndex + 1) % this.fotos.length;
    },
    prevSlide() {
      this.currentIndex = (this.currentIndex - 1 + this.fotos.length) % this.fotos.length;
    },
    setCurrentIndex(index) {
      this.currentIndex = index;
      this.stopSlideshow();
      this.startSlideshow();
    },
    toggleFullscreen() {
      const elem = this.$el.querySelector('.relative');
      if (!document.fullscreenElement) {
        elem.requestFullscreen().catch(err => {
          console.error(`Erro ao entrar em tela cheia: ${err.message}`);
        });
      } else {
        document.exitFullscreen();
      }
    }
  }
};
</script>

<style scoped>
@media (max-width: 640px) {
  .relative {
    height: calc(100vh) !important;
  }
}

@media (min-width: 1024px) {
  .relative {
    height: calc(100vh) !important;
  }
}
</style>
