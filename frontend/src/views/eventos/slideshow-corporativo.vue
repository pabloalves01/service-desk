<template>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar esquerda -->
    <div
      class="w-64 bg-gradient-to-b from-[#0E396C] to-[#011E41] flex flex-col border-r border-white/20 overflow-y-auto">
      <!-- Aniversariantes -->
      <div class="p-4">
        <img :src="$globals.urlBase() + $globals.logoCorporativa()" alt="Logo"
          class="w-full max-w-[200px] mx-auto mb-4 py-4" />
        <div class="flex gap-2 items-center">
          <Cake class="text-white" />
          <h2 class="font-bold text-lg mb-0">Aniversariantes</h2>
        </div>
        <div class="space-y-3 mt-3">
          <div v-for="(aniversariante, index) in aniversariantes" :key="index"
            class="flex items-start bg-white/10 p-2 rounded-md">
            <span class="text-sm font-black mt-0.5 mr-2 bg-[#D11D20] text-white px-2 py-1 rounded">{{ aniversariante.dia
            }}</span>
            <div>
              <div class="font-semibold text-white">{{ aniversariante.nome }}</div>
              <div class="text-xs text-gray-300">{{ aniversariante.departamento }}</div>
            </div>
          </div>
        </div>
      </div>

      <div class="border-t border-white/20 my-4 mx-4"></div>

      <!-- Previsão do tempo -->
      <div class="p-4">
        <div class="flex gap-2 items-center">
          <CloudSun class="text-white" />
          <h2 class="font-bold text-lg mb-0">Previsão do Tempo</h2>
        </div>
        <div class="flex flex-col bg-white/10 p-3 rounded-md mt-3">
          <div class="flex gap-2">
            <div class="text-yellow-500 mr-3">
              <div v-if="previsao">
                <Sun v-if="previsao.description === 'céu limpo'" />
                <CloudSun v-else-if="previsao.description === 'poucas nuvens'" />
                <CloudSun v-else-if="previsao.description === 'nuvens dispersas'" />
                <Cloud v-else-if="previsao.description === 'nuvens quebradas'" />
                <Cloud v-else-if="previsao.description === 'nublado'" />
                <CloudRain v-else-if="previsao.description === 'chuva leve'" />
                <CloudRain v-else-if="previsao.description === 'chuva'" class="animate-bounce" />
                <CloudLightning v-else-if="previsao.description === 'trovoadas'" />
                <Snowflake v-else-if="previsao.description === 'neve'" />
                <Droplet v-else-if="previsao.description === 'névoa'" />
                <HelpCircle v-else />
              </div>
            </div>
            <span class="font-semibold text-base text-white">{{ previsao.city }}</span>
          </div>
          <div class="flex gap-2 mt-4">
            <Thermometer />
            <span class="ml-4 text-base font-bold text-white">{{ previsao.temperature }}°</span>
          </div>
        </div>
        <div class="flex flex-col bg-white/10 p-3 rounded-md mt-3">
          <div class="flex gap-2">
            <div class="text-yellow-500 mr-3">
              <div v-if="previsaoPien">
                <Sun v-if="previsaoPien.description === 'céu limpo'" />
                <CloudSun v-else-if="previsaoPien.description === 'poucas nuvens'" />
                <CloudSun v-else-if="previsaoPien.description === 'nuvens dispersas'" />
                <Cloud v-else-if="previsaoPien.description === 'nuvens quebradas'" />
                <Cloud v-else-if="previsaoPien.description === 'nublado'" />
                <CloudRain v-else-if="previsaoPien.description === 'chuva leve'" />
                <CloudRain v-else-if="previsaoPien.description === 'chuva'" class="animate-bounce" />
                <CloudLightning v-else-if="previsaoPien.description === 'trovoadas'" />
                <Snowflake v-else-if="previsaoPien.description === 'neve'" />
                <Droplet v-else-if="previsaoPien.description === 'névoa'" />
                <HelpCircle v-else />
              </div>
            </div>
            <span class="font-semibold text-base text-white">{{ previsaoPien.city }}</span>
          </div>
          <div class="flex gap-2 mt-4">
            <Thermometer />
            <span class="ml-4 text-base font-bold text-white">{{ previsaoPien.temperature }}°</span>
          </div>
        </div>
         <div class="flex flex-col bg-white/10 p-3 rounded-md mt-3">
          <div class="flex gap-2">
            <div class="text-yellow-500 mr-3">
              <div v-if="previsaoRioClaro">
                <Sun v-if="previsaoRioClaro.description === 'céu limpo'" />
                <CloudSun v-else-if="previsaoRioClaro.description === 'poucas nuvens'" />
                <CloudSun v-else-if="previsaoRioClaro.description === 'nuvens dispersas'" />
                <Cloud v-else-if="previsaoRioClaro.description === 'nuvens quebradas'" />
                <Cloud v-else-if="previsaoRioClaro.description === 'nublado'" />
                <CloudRain v-else-if="previsaoRioClaro.description === 'chuva leve'" />
                <CloudRain v-else-if="previsaoRioClaro.description === 'chuva'" class="animate-bounce" />
                <CloudLightning v-else-if="previsaoRioClaro.description === 'trovoadas'" />
                <Snowflake v-else-if="previsaoRioClaro.description === 'neve'" />
                <Droplet v-else-if="previsaoRioClaro.description === 'névoa'" />
                <HelpCircle v-else />
              </div>
            </div>
            <span class="font-semibold text-base text-white">{{ previsaoRioClaro.city }}</span>
          </div>
          <div class="flex gap-2 mt-4">
            <Thermometer />
            <span class="ml-4 text-base font-bold text-white">{{ previsaoRioClaro.temperature }}°</span>
          </div>
        </div>
        <div class="flex flex-col bg-white/10 p-3 rounded-md mt-3">
          <div class="flex gap-2">
            <div class="text-yellow-500 mr-3">
              <div v-if="previsaoGuaira">
                <Sun v-if="previsaoGuaira.description === 'céu limpo'" />
                <CloudSun v-else-if="previsaoGuaira.description === 'poucas nuvens'" />
                <CloudSun v-else-if="previsaoGuaira.description === 'nuvens dispersas'" />
                <Cloud v-else-if="previsaoGuaira.description === 'nuvens quebradas'" />
                <Cloud v-else-if="previsaoGuaira.description === 'nublado'" />
                <CloudRain v-else-if="previsaoGuaira.description === 'chuva leve'" />
                <CloudRain v-else-if="previsaoGuaira.description === 'chuva'" class="animate-bounce" />
                <CloudLightning v-else-if="previsaoGuaira.description === 'trovoadas'" />
                <Snowflake v-else-if="previsaoGuaira.description === 'neve'" />
                <Droplet v-else-if="previsaoGuaira.description === 'névoa'" />
                <HelpCircle v-else />
              </div>
            </div>
            <span class="font-semibold text-base text-white">{{ previsaoGuaira.city }}</span>
          </div>
          <div class="flex gap-2 mt-4">
            <Thermometer />
            <span class="ml-4 text-base font-bold text-white">{{ previsaoGuaira.temperature }}°</span>
          </div>
        </div>
      </div>
      <div class="mt-auto p-4 gap-1 flex flex-col rounded-lg mx-2 mb-2 text-[24px] font-semibold">
        <span >{{ diaSemana }}</span>
        <div class="flex">
          {{ dia }} de {{ mes }}
        </div>
        <div class="flex items-center gap-2">
          <Clock />

          {{ hora }}
        </div>
        <!-- <div class="border border-gray-700 my-4"></div> -->
        <div class="flex text-4xl flex justify-center items-center gap-4 text-white mt-2 font-light">
        </div>
      </div>
    </div>
    <!-- Conteúdo principal -->
    <div class="flex-1 flex flex-col">
      <!-- Área do slideshow -->
      <div class="flex-1 relative bg-black">
        <!-- Imagens do Slideshow -->
        <div v-if="fotos.length > 0" class="w-full h-full flex items-center justify-center bg-black">
          <img v-for="(foto, index) in fotos" :key="index" :src="$globals.urlBase() + `/storage/${foto.image_path}`"
            :class="[
              'absolute transition-opacity duration-500',
              currentIndex === index ? 'opacity-100' : 'opacity-0',
              'max-w-full max-h-full w-auto h-auto object-contain'
            ]" style="aspect-ratio: 16/9;" alt="Imagem do evento" />
        </div>

        <!-- Estado vazio -->
        <div v-else class="flex flex-col items-center justify-center h-full text-zinc-500">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" class="mb-4 opacity-50">
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
            stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
            <path d="m15 18-6-6 6-6"></path>
          </svg>
        </button>

        <button v-if="fotos.length > 1" @click="nextSlide"
          class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white rounded-full p-2 hover:bg-black/70 transition-colors"
          aria-label="Próxima imagem">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
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
          <button @click="toggleFullscreen" class="text-white flex items-center justify-center p-2">
            <Fullscreen class="text-white hover:text-zinc-300" size="24" />
          </button>
        </div>
        <div v-if="fotos.length > 0"
          class="absolute top-4 right-4 bg-black/50 text-white text-xs px-3 py-2 rounded font-medium">
          {{ currentIndex + 1 }} / {{ fotos.length }}
        </div>
      </div>

      <!-- Últimas notícias -->
      <div class="bg-[#011E41] text-white">
        <div class="bg-[#D11D20] px-4 py-2 flex items-center">
          <h2 class="font-bold">ÚLTIMAS NOTÍCIAS</h2>
        </div>
        <div class="px-4 py-3 h-24 flex items-center">
          <div v-for="(noticia, index) in noticias" :key="index" :class="[
            'transition-opacity duration-500 w-full',
            noticiaAtualIndex === index ? 'block' : 'hidden'
          ]">
            <h3 class="font-bold text-lg">{{ noticia.titulo }}</h3>
            <p class="text-sm text-gray-300">{{ noticia.descricao }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '../../axios';
import { Fullscreen, Cake, CloudSun, Cloud, CloudRain, CloudLightning, Snowflake, Droplet, HelpCircle, Thermometer, Clock, Sun } from 'lucide-vue-next';

export default {
  components: {
    Fullscreen,
    Cake,
    CloudSun,
    Cloud,
    CloudRain,
    CloudLightning,
    Snowflake,
    Droplet,
    HelpCircle,
    Thermometer,
    Clock,
    Sun
  },
  data() {
    return {
      previsao: null,
      previsaoRioClaro: null,
      previsaoGuaira: null,
      previsaoPien: null,
      fotos: [],
      idEvento: this.$route.params.id,
      currentIndex: 0,
      timer: null,
      noticiaAtualIndex: 0,
      noticiaTimer: null,

      // Dados fixos para o layout
      aniversariantes: [
        // Dados serão preenchidos pela API
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
  async created() {
    await this.getEvento();
    await this.getAniversariantes();
    await this.fetchPrevisao();
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
      return this.currentDate.getDate();
    },
    diaSemana() {
      const diasDaSemana = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
      return diasDaSemana[this.currentDate.getDay()];
    },
    mes() {
      const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
      return meses[this.currentDate.getMonth()];
    },
    hora() {
      return this.currentDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
  },
  methods: {
    fetchPrevisao() {
      return Promise.all([
        this.getPrevisaoTempoImbituba(),
        this.getPrevisaoTempoRioClaro(),
        this.getPrevisaoTempoGuaira(),
        this.getPrevisaoTempoPien()
      ]);
    },
    async getPrevisaoTempoImbituba() {
      const response = await axiosInstance.get('/weather/imbituba');
      this.previsao = response.data;

      console.log(response);
    },
    async getPrevisaoTempoRioClaro() {
      const response = await axiosInstance.get('/weather/rio-claro');
      this.previsaoRioClaro = response.data;

      console.log(response);
    },
    async getPrevisaoTempoGuaira() {
      const response = await axiosInstance.get('/weather/guaira');
      this.previsaoGuaira = response.data;

      console.log(response);
    },
    async getPrevisaoTempoPien() {
      const response = await axiosInstance.get('/weather/pien');
      this.previsaoPien = response.data;

      console.log(response);
    },
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
/* Estilos responsivos */
@media (max-width: 640px) {
  .flex {
    flex-direction: column;
  }

  .w-64 {
    width: 100%;
    height: auto;
  }
}

/* Estilos para o slideshow */
.flex-1.relative {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #000;
  max-height: calc(100vh - 80px);
  /* Altura total menos a altura da barra de notícias */
}

/* Manter proporção 16:9 (1920x1080) */
.flex-1.relative img {
  max-width: 100%;
  max-height: 100%;
  width: auto;
  height: auto;
  object-fit: contain;
  aspect-ratio: 16/9;
}

/* Estilos para telas maiores */
@media (min-width: 1024px) {
  .flex-1.relative {
    height: calc(100vh - 80px);
  }

  .w-64 {
    min-width: 16rem;
    max-width: 16rem;
  }
}

/* Melhorias visuais */
.bg-white\/10 {
  background-color: rgba(255, 255, 255, 0.1);
}

.text-gray-300 {
  color: #d1d5db;
}
</style>
