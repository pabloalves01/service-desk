<template>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar esquerda -->
    <div class="w-64 bg-gradient-to-b from-[#0E396C] to-[#011E41] flex flex-col border-r border-white/20">
      <!-- Aniversariantes -->
      <div class="p-4">
        <img :src="$globals.urlBase() + $globals.logoCorporativa()" alt="Logo" class="w-64 mb-4 py-4" />
        <div class="flex gap-2">
            <Cake />
        <h2 class="font-bold text-lg mb-4">Aniversáriantes</h2>
        </div>
        <div class="space-y-2">
          <div v-for="(aniversariante, index) in aniversariantes" :key="index" class="flex">
            <span class="text-sm font-black mt-0.5 mr-2">{{ aniversariante.dia }}</span>
            <div>
              <div class="font-semibold">{{ aniversariante.nome }}</div>
              <div class="text-xs text-gray-500">{{ aniversariante.departamento }}</div>
            </div>
          </div>
        </div>
      </div>

      <div class="border-t border-white/20 my-4 mx-4"></div>

      <!-- Previsão do tempo -->
      <div class="p-4">
        <h2 class="font-bold text-lg mb-4">PREVISÃO DO TEMPO</h2>
        <div class="flex items-center">
          <div class="text-yellow-500 mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="5"></circle>
              <line x1="12" y1="1" x2="12" y2="3"></line>
              <line x1="12" y1="21" x2="12" y2="23"></line>
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
              <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
              <line x1="1" y1="12" x2="3" y2="12"></line>
              <line x1="21" y1="12" x2="23" y2="12"></line>
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
              <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
          </div>
          <div>
            <span class="font-semibold">IMBITUBA</span>
            <span class="ml-4">{{ temperatura }}°</span>
          </div>
        </div>
      </div>

      <div class="mt-auto p-4">
        <div class="text-6xl text-gray-300 font-light">{{ dia }}</div>
        <div class="text-xl text-gray-400 uppercase">{{ diaSemana }}<span class="ml-2">{{ mes }}</span></div>
        <div class="text-4xl text-gray-300 mt-2">{{ hora }}</div>
      </div>
    </div>

    <!-- Conteúdo principal -->
    <div class="flex-1 flex flex-col">
      <!-- Área do slideshow -->
      <div class="flex-1 relative bg-black">
        <!-- Título central -->
        <!-- <div class="absolute inset-0 flex items-center justify-center z-10 pointer-events-none">
          <h1 class="text-6xl font-bold text-black">VIDEOS E IMAGENS</h1>
        </div> -->

        <!-- Imagens do Slideshow -->
        <div v-if="fotos.length > 0" class="w-full h-full">
          <img v-for="(foto, index) in fotos" :key="index" :src="$globals.urlBase() + `/storage/${foto.image_path}`"
            :class="[
              'absolute top-0 left-0 w-full h-full transition-opacity duration-500',
              currentIndex === index ? 'opacity-100' : 'opacity-0',
              'object-cover'
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
          class="absolute top-4 left-4 bg-black/50 text-white text-xs px-2 py-1 rounded-full flex gap-2">
          <button @click="toggleFullscreen"
            class="text-white p-1 flex items-center justify-center p-2">
            <Fullscreen class="text-zinc-500 hover:text-zinc-300" size="24" />
          </button>
        </div>
        <div v-if="fotos.length > 0" class="absolute top-4 right-4 bg-black/50 text-white text-xs px-2 py-1 rounded">
          {{ currentIndex + 1 }} / {{ fotos.length }}
        </div>
      </div>

      <!-- Últimas notícias -->
      <div class="bg-[#011E41] text-white">
        <div class="bg-[#D11D20] px-4 py-2">
          <h2 class="font-bold">ÚLTIMAS NOTÍCIAS</h2>
        </div>
        <div class="px-4 py-3 h-20">
          <div v-for="(noticia, index) in noticias" :key="index" 
               :class="[
                 'transition-opacity duration-500',
                 noticiaAtualIndex === index ? 'block' : 'hidden'
               ]">
            <h3 class="font-bold">{{ noticia.titulo }}</h3>
            <p class="text-sm">{{ noticia.descricao }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '../../axios';
import { Fullscreen, Cake } from 'lucide-vue-next';

export default {
  components: {
    Fullscreen,
    Cake
  },
  data() {
    return {
      fotos: [],
      idEvento: this.$route.params.id,
      currentIndex: 0,
      timer: null,
      noticiaAtualIndex: 0,
      noticiaTimer: null,
      
      // Dados fixos para o layout
      aniversariantes: [
       
      ],
      currentDate: new Date(),
      temperatura: 26,
      
      // Notícias de exemplo
      noticias: [
        { 
          titulo: 'Expansão do Brics: bloco anuncia seis novos membros', 
          descricao: 'O Brics, formado por Brasil, Rússia, Índia, China e África do Sul, anunciou um processo de expansão do bloco.' 
        },
        { 
          titulo: 'Novo recorde na bolsa de valores', 
          descricao: 'Índices atingem máxima histórica impulsionados por resultados positivos no setor de tecnologia.' 
        },
        { 
          titulo: 'Previsão de chuvas intensas no sul do país', 
          descricao: 'Meteorologistas alertam para possibilidade de temporais nos próximos dias em toda região sul.' 
        }
      ]
    };
  },
  created() {
    this.getEvento();
    this.getAniversariantes();
  },
  mounted() {
    this.updateTime();
    this.intervalId = setInterval(this.updateTime, 1000);

    this.startSlideshow();
    this.startNoticiaRotation();
    window.addEventListener('resize', this.handleResize);
  },
  beforeDestroy() {
    clearInterval(this.intervalId);
    this.stopSlideshow();
    this.stopNoticiaRotation();
    window.removeEventListener('resize', this.handleResize);
  },
  computed: {
     dia() {
      return this.currentDate.getDate(); // Retorna o dia do mês
    },
    diaSemana() {
      const diasDaSemana = ['DOMINGO', 'SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SÁBADO'];
      return diasDaSemana[this.currentDate.getDay()]; // Retorna o dia da semana
    },
    mes() {
      const meses = ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'];
      return meses[this.currentDate.getMonth()]; // Retorna o mês abreviado
    },
    hora() {
      return this.currentDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
  },
  methods: {
    updateTime() {
      this.currentDate = new Date();
    },
    async getAniversariantes() {
        const mesAtual = new Date().getMonth() + 1;
        try {
            const response = await axiosInstance.get('/aniversariantes', {
                params: { mes: mesAtual },
            });
            this.aniversariantes = response.data;
        } catch (error) {
          console.error("Erro ao buscar aniversariantes:", error);
        }
    },
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
    },
    handleResize() {
      // Método mantido do código original
    },
    startNoticiaRotation() {
      this.stopNoticiaRotation();
      this.noticiaTimer = setInterval(() => {
        this.nextNoticia();
      }, 8000);
    },
    stopNoticiaRotation() {
      if (this.noticiaTimer) {
        clearInterval(this.noticiaTimer);
        this.noticiaTimer = null;
      }
    },
    nextNoticia() {
      this.noticiaAtualIndex = (this.noticiaAtualIndex + 1) % this.noticias.length;
    }
  }
};
</script>

<style scoped>
@media (max-width: 640px) {
  .flex {
    flex-direction: column;
  }
  
  .w-64 {
    width: 100%;
    height: auto;
  }
}

.flex-1.relative {
  aspect-ratio: 16/9;
  max-height: calc(100vh - 80px); /* Altura total menos a altura da barra de notícias */
  overflow: hidden;
}

@media (min-width: 1024px) {
  .flex-1.relative img {
    width: 100%;
    height: 100%;
    object-position: center;
  }
}
</style>
