<template>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar esquerda -->
    <div
      class="sidebar-width bg-gradient-to-b from-[#0E396C] to-[#011E41] flex flex-col border-r border-white/20 overflow-hidden">
      <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="p-4 flex-shrink-0">
          <img :src="$globals.urlBase() + $globals.logoCorporativa()" alt="Logo"
            class="w-full max-w-[180px] mx-auto mb-2" />
        </div>

        <!-- Conteúdo da sidebar com grid para distribuição de espaço -->
        <div class="flex flex-col flex-grow overflow-hidden">
          <!-- Aniversariantes -->
          <div class="p-3 flex-shrink-0">
            <div class="flex gap-2 items-center mb-2">
              <Cake class="text-white" />
              <h2 class="font-bold text-lg text-white">Aniversariantes</h2>
            </div>
            
            <!-- Seção adaptativa de aniversariantes -->
            <div class="relative" :class="aniversariantesContainerClass">
              <!-- Quando há 5 ou menos aniversariantes, mostra todos -->
              <div v-if="aniversariantes.length <= 5" class="space-y-2">
                <div v-for="(aniversariante, index) in aniversariantes" :key="index || aniversariante.id"
                  class="flex items-start bg-white/10 p-2 rounded-md">
                  <span class="text-sm font-black mt-0.5 mr-2 bg-[#D11D20] text-white px-2 py-1 rounded">{{ aniversariante.dia }}</span>
                  <div class="overflow-hidden">
                    <div class="font-semibold text-white text-sm truncate">{{ aniversariante.nome }}</div>
                    <div class="text-xs text-gray-300 truncate">{{ aniversariante.departamento }}</div>
                  </div>
                </div>
              </div>
              
              <!-- Quando há mais de 5 aniversariantes, usa carrossel -->
              <div v-else class="space-y-2 transition-transform duration-500" 
                :style="{ transform: `translateY(-${currentAniversarianteIndex * 60}px)` }">
                <div v-for="(aniversariante, index) in aniversariantes" :key="index || aniversariante.id"
                  class="flex items-start bg-white/10 p-2 rounded-md">
                  <span class="text-sm font-black mt-0.5 mr-2 bg-[#D11D20] text-white px-2 py-1 rounded">{{ aniversariante.dia }}</span>
                  <div class="overflow-hidden">
                    <div class="font-semibold text-white text-sm truncate">{{ aniversariante.nome }}</div>
                    <div class="text-xs text-gray-300 truncate">{{ aniversariante.departamento }}</div>
                  </div>
                </div>
              </div>
              
              <!-- Indicadores de navegação (apenas quando há mais de 5 aniversariantes) -->
              <div v-if="aniversariantes.length > 5"
                class="absolute bottom-0 left-0 right-0 flex justify-center gap-1 pb-1">
                <button 
                  v-for="i in Math.ceil(aniversariantes.length / 5)" 
                  :key="i" 
                  @click="setAniversariantePage((i-1) * 5)"
                  class="w-1.5 h-1.5 rounded-full transition-colors" 
                  :class="Math.floor(currentAniversarianteIndex / 5) === i-1 ? 'bg-white' : 'bg-zinc-500'"
                  aria-label="Navegar para página de aniversariantes">
                </button>
              </div>
            </div>
          </div>

          <div class="border-t border-white/20 my-2 mx-3"></div>

          <!-- Previsão do tempo - Versão compacta -->
          <div class="p-3 flex-shrink-0 overflow-hidden">
            <div class="flex gap-2 items-center mb-2">
              <CloudSun class="text-white" />
              <h2 class="font-bold text-lg text-white">Previsão do Tempo</h2>
            </div>
            
            <!-- Grid para previsões do tempo -->
            <div class="grid grid-cols-2 gap-2">
              <!-- Imbituba -->
              <div class="flex flex-col bg-white/10 p-2 rounded-md">
                <div class="flex items-center gap-1">
                  <div class="text-yellow-500 mr-1">
                    <div v-if="previsao">
                      <Sun v-if="previsao.description === 'céu limpo'" size="16" />
                      <CloudSun v-else-if="previsao.description === 'poucas nuvens'" size="16" />
                      <Cloud v-else-if="previsao.description === 'nublado'" size="16" />
                      <CloudRain v-else-if="previsao.description === 'chuva'" size="16" />
                      <HelpCircle v-else size="16" />
                    </div>
                  </div>
                  <span class="font-semibold text-sm text-white truncate">{{ previsao ? previsao.city : 'Imbituba' }}</span>
                </div>
                <div class="flex items-center gap-1 mt-1">
                  <Thermometer size="14" />
                  <span class="text-sm font-bold text-white">{{ previsao ? previsao.temperature + '°' : '--°' }}</span>
                </div>
              </div>
              
              <!-- Pien -->
              <div class="flex flex-col bg-white/10 p-2 rounded-md">
                <div class="flex items-center gap-1">
                  <div class="text-yellow-500 mr-1">
                    <div v-if="previsaoPien">
                      <Sun v-if="previsaoPien.description === 'céu limpo'" size="16" />
                      <CloudSun v-else-if="previsaoPien.description === 'poucas nuvens'" size="16" />
                      <Cloud v-else-if="previsaoPien.description === 'nublado'" size="16" />
                      <CloudRain v-else-if="previsaoPien.description === 'chuva'" size="16" />
                      <HelpCircle v-else size="16" />
                    </div>
                  </div>
                  <span class="font-semibold text-sm text-white truncate">{{ previsaoPien ? previsaoPien.city : 'Pien' }}</span>
                </div>
                <div class="flex items-center gap-1 mt-1">
                  <Thermometer size="14" />
                  <span class="text-sm font-bold text-white">{{ previsaoPien ? previsaoPien.temperature + '°' : '--°' }}</span>
                </div>
              </div>
              
              <!-- Rio Claro -->
              <div class="flex flex-col bg-white/10 p-2 rounded-md">
                <div class="flex items-center gap-1">
                  <div class="text-yellow-500 mr-1">
                    <div v-if="previsaoRioClaro">
                      <Sun v-if="previsaoRioClaro.description === 'céu limpo'" size="16" />
                      <CloudSun v-else-if="previsaoRioClaro.description === 'poucas nuvens'" size="16" />
                      <Cloud v-else-if="previsaoRioClaro.description === 'nublado'" size="16" />
                      <CloudRain v-else-if="previsaoRioClaro.description === 'chuva'" size="16" />
                      <HelpCircle v-else size="16" />
                    </div>
                  </div>
                  <span class="font-semibold text-sm text-white truncate">{{ previsaoRioClaro ? previsaoRioClaro.city : 'Rio Claro' }}</span>
                </div>
                <div class="flex items-center gap-1 mt-1">
                  <Thermometer size="14" />
                  <span class="text-sm font-bold text-white">{{ previsaoRioClaro ? previsaoRioClaro.temperature + '°' : '--°' }}</span>
                </div>
              </div>
              
              <!-- Guaira -->
              <div class="flex flex-col bg-white/10 p-2 rounded-md">
                <div class="flex items-center gap-1">
                  <div class="text-yellow-500 mr-1">
                    <div v-if="previsaoGuaira">
                      <Sun v-if="previsaoGuaira.description === 'céu limpo'" size="16" />
                      <CloudSun v-else-if="previsaoGuaira.description === 'poucas nuvens'" size="16" />
                      <Cloud v-else-if="previsaoGuaira.description === 'nublado'" size="16" />
                      <CloudRain v-else-if="previsaoGuaira.description === 'chuva'" size="16" />
                      <HelpCircle v-else size="16" />
                    </div>
                  </div>
                  <span class="font-semibold text-sm text-white truncate">{{ previsaoGuaira ? previsaoGuaira.city : 'Guaira' }}</span>
                </div>
                <div class="flex items-center gap-1 mt-1">
                  <Thermometer size="14" />
                  <span class="text-sm font-bold text-white">{{ previsaoGuaira ? previsaoGuaira.temperature + '°' : '--°' }}</span>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Espaçador flexível -->
          <div class="flex-grow"></div>
          
          <!-- Data e hora -->
          <div class="p-3 flex-shrink-0 text-white">
            <div class="text-xl font-semibold">{{ diaSemana }}</div>
            <div class="text-xl">{{ dia }} de {{ mes }}</div>
            <div class="flex items-center gap-2 text-xl">
              <Clock size="20" />
              {{ hora }}
            </div>
          </div>
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
  data: function() {
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
      
      // Dados para o carrossel de aniversariantes
      aniversariantes: [],
      currentAniversarianteIndex: 0,
      aniversarianteTimer: null,
      
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
  computed: {
    dia: function() {
      return this.currentDate.getDate();
    },
    diaSemana: function() {
      const diasDaSemana = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
      return diasDaSemana[this.currentDate.getDay()];
    },
    mes: function() {
      const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
      return meses[this.currentDate.getMonth()];
    },
    hora: function() {
      return this.currentDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    },
    // Classe dinâmica para o container de aniversariantes
    aniversariantesContainerClass: function() {
      // Se tiver 5 ou menos aniversariantes, altura fixa baseada no número de itens
      if (this.aniversariantes.length <= 5) {
        return 'h-auto max-h-[320px] overflow-hidden';
      } 
      // Se tiver mais de 5, altura fixa para mostrar 5 itens e overflow hidden para o carrossel
      else {
        return 'h-[320px] overflow-hidden';
      }
    }
  },
  created: function() {
    this.getEvento();
    this.getAniversariantes();
    this.fetchPrevisao();
  },
  mounted: function() {
    this.updateTime();
    this.intervalId = setInterval(this.updateTime, 1000);

    this.startSlideshow();
    this.startNoticiaRotation();
    
    // Adicionar dados de teste para aniversariantes se estiver vazio
    if (this.aniversariantes.length === 0) {
      this.aniversariantes = [
        { id: 1, dia: '05', nome: 'João Silva', departamento: 'TI' },
        { id: 2, dia: '12', nome: 'Maria Oliveira', departamento: 'RH' },
        { id: 3, dia: '15', nome: 'Pedro Santos', departamento: 'Financeiro' },
        { id: 4, dia: '18', nome: 'Ana Costa', departamento: 'Marketing' },
        { id: 5, dia: '22', nome: 'Carlos Souza', departamento: 'Vendas' },
        { id: 6, dia: '25', nome: 'Fernanda Lima', departamento: 'Administrativo' },
        { id: 7, dia: '28', nome: 'Roberto Alves', departamento: 'Logística' }
      ];
    }
    
    // Inicia o carrossel apenas se houver mais de 5 aniversariantes
    this.startAniversarianteCarouselIfNeeded();
    
    window.addEventListener('resize', this.handleResize);
  },
  beforeDestroy: function() {
    clearInterval(this.intervalId);
    this.stopSlideshow();
    this.stopNoticiaRotation();
    this.stopAniversarianteCarousel();
    window.removeEventListener('resize', this.handleResize);
  },
  watch: {
    // Observa mudanças na lista de aniversariantes para iniciar ou parar o carrossel conforme necessário
    aniversariantes: function() {
      this.startAniversarianteCarouselIfNeeded();
    }
  },
  methods: {
    fetchPrevisao: function() {
      return Promise.all([
        this.getPrevisaoTempoImbituba(),
        this.getPrevisaoTempoRioClaro(),
        this.getPrevisaoTempoGuaira(),
        this.getPrevisaoTempoPien()
      ]);
    },
    getPrevisaoTempoImbituba: function() {
      return axiosInstance.get('/weather/imbituba')
        .then(function(response) {
          this.previsao = response.data;
        }.bind(this))
        .catch(function(error) {
          console.error("Erro ao buscar previsão de Imbituba:", error);
        });
    },
    getPrevisaoTempoRioClaro: function() {
      return axiosInstance.get('/weather/rio-claro')
        .then(function(response) {
          this.previsaoRioClaro = response.data;
        }.bind(this))
        .catch(function(error) {
          console.error("Erro ao buscar previsão de Rio Claro:", error);
        });
    },
    getPrevisaoTempoGuaira: function() {
      return axiosInstance.get('/weather/guaira')
        .then(function(response) {
          this.previsaoGuaira = response.data;
        }.bind(this))
        .catch(function(error) {
          console.error("Erro ao buscar previsão de Guaíra:", error);
        });
    },
    getPrevisaoTempoPien: function() {
      return axiosInstance.get('/weather/pien')
        .then(function(response) {
          this.previsaoPien = response.data;
        }.bind(this))
        .catch(function(error) {
          console.error("Erro ao buscar previsão de Pien:", error);
        });
    },
    updateTime: function() {
      this.currentDate = new Date();
    },
    getAniversariantes: function() {
      const mesAtual = new Date().getMonth() + 1;
      return axiosInstance.get('/aniversariantes', {
        params: { mes: mesAtual },
      })
        .then(function(response) {
          this.aniversariantes = response.data;
        }.bind(this))
        .catch(function(error) {
          console.error("Erro ao buscar aniversariantes:", error);
        });
    },
    getEvento: function() {
      return axiosInstance.get(`/imagens/evento/${this.idEvento}`)
        .then(function(response) {
          this.fotos = response.data[0];
        }.bind(this))
        .catch(function(error) {
          console.error("Erro ao buscar imagens do evento:", error);
        });
    },
    // Métodos para o slideshow de imagens
    startSlideshow: function() {
      this.stopSlideshow();
      this.timer = setInterval(this.nextSlide, 5000);
    },
    stopSlideshow: function() {
      if (this.timer) {
        clearInterval(this.timer);
        this.timer = null;
      }
    },
    nextSlide: function() {
      if (this.currentIndex === this.fotos.length - 1) {
        this.getEvento();
      }
      this.currentIndex = (this.currentIndex + 1) % this.fotos.length;
    },
    prevSlide: function() {
      this.currentIndex = (this.currentIndex - 1 + this.fotos.length) % this.fotos.length;
    },
    setCurrentIndex: function(index) {
      this.currentIndex = index;
      this.stopSlideshow();
      this.startSlideshow();
    },
    // Métodos para o carrossel de aniversariantes
    startAniversarianteCarouselIfNeeded: function() {
      // Inicia o carrossel apenas se houver mais de 5 aniversariantes
      if (this.aniversariantes.length > 5) {
        this.startAniversarianteCarousel();
      } else {
        this.stopAniversarianteCarousel();
      }
    },
    startAniversarianteCarousel: function() {
      this.stopAniversarianteCarousel();
      this.aniversarianteTimer = setInterval(this.nextAniversariantePage, 5000); // Troca a cada 5 segundos
    },
    stopAniversarianteCarousel: function() {
      if (this.aniversarianteTimer) {
        clearInterval(this.aniversarianteTimer);
        this.aniversarianteTimer = null;
      }
    },
    nextAniversariantePage: function() {
      if (this.aniversariantes.length <= 5) {
        return; // Não há necessidade de rotação se todos cabem na tela
      }
      
      // Avança para o próximo aniversariante, um por um
      this.currentAniversarianteIndex = (this.currentAniversarianteIndex + 1) % this.aniversariantes.length;
    },
    setAniversariantePage: function(index) {
      this.currentAniversarianteIndex = index;
      this.stopAniversarianteCarousel();
      this.startAniversarianteCarousel();
    },
    // Outros métodos
    toggleFullscreen: function() {
      const elem = this.$el.querySelector('.relative');
      if (!document.fullscreenElement) {
        elem.requestFullscreen().catch(function(err) {
          console.error("Erro ao entrar em tela cheia:", err);
        });
      } else {
        document.exitFullscreen();
      }
    },
    handleResize: function() {
      // Método mantido do código original
    },
    startNoticiaRotation: function() {
      this.stopNoticiaRotation();
      this.noticiaTimer = setInterval(this.nextNoticia, 8000);
    },
    stopNoticiaRotation: function() {
      if (this.noticiaTimer) {
        clearInterval(this.noticiaTimer);
        this.noticiaTimer = null;
      }
    },
    nextNoticia: function() {
      this.noticiaAtualIndex = (this.noticiaAtualIndex + 1) % this.noticias.length;
    }
  }
};
</script>

<style scoped>
/* Largura da sidebar */
.sidebar-width {
  width: 16rem;
  min-width: 16rem;
}

/* Estilos responsivos */
@media (max-width: 768px) {
  .flex {
    flex-direction: column;
  }

  .sidebar-width {
    width: 100%;
    min-width: 100%;
    max-height: 40vh;
  }
}

/* Estilos para o slideshow */
.flex-1.relative {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #000;
  max-height: calc(100vh - 80px);
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

/* Melhorias visuais */
.bg-white\/10 {
  background-color: rgba(255, 255, 255, 0.1);
}

.text-gray-300 {
  color: #d1d5db;
}

/* Truncar texto longo */
.truncate {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Efeito de máscara para o carrossel */
.h-\[320px\] {
  mask-image: linear-gradient(to bottom, 
    rgba(0,0,0,1) 90%, 
    rgba(0,0,0,0));
}
</style>