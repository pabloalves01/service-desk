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
        <div class="flex flex-col h-full">
          <!-- Seção superior com altura fixa -->
          <div class="flex flex-col flex-shrink-0">
            <!-- Aniversariantes -->
            <div class="p-3">
              <div class="flex gap-2 items-center mb-3">
                <Cake class="text-white" />
                <h2 class="font-bold text-lg text-white">Aniversariantes</h2>
              </div>

              <!-- Seção adaptativa de aniversariantes com altura fixa -->
              <div class="relative aniversariantes-container">
                <!-- Quando há 5 ou menos aniversariantes, mostra todos -->
                <div v-if="aniversariantes.length <= 5" class="space-y-3">
                  <div v-for="(aniversariante, index) in aniversariantes" :key="index || aniversariante.id"
                    class="flex items-start bg-white/10 p-3 rounded-md aniversariante-item">
                    <span class="text-sm font-black mt-0.5 mr-3 bg-[#D11D20] text-white px-2 py-1 rounded">{{
                      aniversariante.dia }}</span>
                    <div class="overflow-hidden flex-1">
                      <div class="font-semibold text-white text-sm truncate">{{ aniversariante.nome }}</div>
                      <div class="text-xs text-gray-300 truncate">{{ aniversariante.departamento }}</div>
                    </div>
                  </div>
                </div>

                <!-- Quando há mais de 5 aniversariantes, usa carrossel -->
                <div v-else class="space-y-3 transition-transform duration-500"
                  :style="{ transform: `translateY(-${currentAniversarianteIndex * aniversarianteItemHeight}px)` }">
                  <div v-for="(aniversariante, index) in aniversariantes" :key="index || aniversariante.id"
                    class="flex items-start bg-white/10 p-3 rounded-md aniversariante-item">
                    <span class="text-sm font-black mt-0.5 mr-3 bg-[#D11D20] text-white px-2 py-1 rounded">{{
                      aniversariante.dia }}</span>
                    <div class="overflow-hidden flex-1">
                      <div class="font-semibold text-white text-sm truncate">{{ aniversariante.nome }}</div>
                      <div class="text-xs text-gray-300 truncate">{{ aniversariante.departamento }}</div>
                    </div>
                  </div>
                </div>

                <!-- Controles de navegação para o carrossel -->
                <div v-if="aniversariantes.length > 5"
                  class="absolute bottom-0 left-0 right-0 flex justify-between items-center px-2 py-1 bg-gradient-to-t from-[#011E41] to-transparent">
                  <!-- Botões de navegação -->
                  <button @click="prevAniversariantePage"
                    class="text-white/70 hover:text-white focus:outline-none transition-colors"
                    aria-label="Aniversariantes anteriores">
                    <ChevronUp size="16" />
                  </button>

                  <!-- Indicadores -->
                  <div class="flex justify-center gap-1">
                    <button v-for="i in Math.ceil(aniversariantes.length / 5)" :key="i"
                      @click="setAniversariantePage((i - 1) * 5)" class="w-1.5 h-1.5 rounded-full transition-colors"
                      :class="Math.floor(currentAniversarianteIndex / 5) === i - 1 ? 'bg-white' : 'bg-zinc-500'"
                      aria-label="Navegar para página de aniversariantes">
                    </button>
                  </div>

                  <button @click="nextAniversariantePage"
                    class="text-white/70 hover:text-white focus:outline-none transition-colors"
                    aria-label="Próximos aniversariantes">
                    <ChevronDown size="16" />
                  </button>
                </div>
              </div>
            </div>

            <div class="border-t border-white/20 my-3 mx-3"></div>
          </div>

          <!-- Seção inferior com flex-grow -->
          <div class="flex flex-col flex-grow overflow-hidden">
            <!-- Previsão do tempo - Versão compacta -->
            <div class="p-3 flex-shrink-0">
              <div class="flex gap-2 items-center mb-3">
                <CloudSun class="text-white" />
                <h2 class="font-bold text-lg text-white">Previsão do Tempo</h2>
              </div>

              <!-- Grid para previsões do tempo -->
              <div class="grid grid-cols-2 gap-3">
                <!-- Imbituba -->
                <div class="flex flex-col bg-white/10 p-3 rounded-md">
                  <div class="flex items-center gap-2">
                    <div class="text-yellow-500 mr-1">
                      <div v-if="previsao">
                        <Sun v-if="previsao.description === 'céu limpo'" size="18" />
                        <CloudSun v-else-if="previsao.description === 'poucas nuvens'" size="18" />
                        <Cloud v-else-if="previsao.description === 'nublado'" size="18" />
                        <CloudRain v-else-if="previsao.description === 'chuva'" size="18" />
                        <HelpCircle v-else size="18" />
                      </div>
                    </div>
                    <span class="font-semibold text-sm text-white truncate">{{ previsao ? previsao.city : 'Imbituba'
                    }}</span>
                  </div>
                  <div class="flex items-center gap-2 mt-2">
                    <Thermometer size="16" />
                    <span class="text-sm font-bold text-white">
                      {{ previsao ? Math.round(previsao.temperature) + '°' : '--°' }}
                    </span>
                  </div>
                </div>

                <!-- Pien -->
                <div class="flex flex-col bg-white/10 p-3 rounded-md">
                  <div class="flex items-center gap-2">
                    <div class="text-yellow-500 mr-1">
                      <div v-if="previsaoPien">
                        <Sun v-if="previsaoPien.description === 'céu limpo'" size="18" />
                        <CloudSun v-else-if="previsaoPien.description === 'poucas nuvens'" size="18" />
                        <Cloud v-else-if="previsaoPien.description === 'nublado'" size="18" />
                        <CloudRain v-else-if="previsaoPien.description === 'chuva'" size="18" />
                        <HelpCircle v-else size="18" />
                      </div>
                    </div>
                    <span class="font-semibold text-sm text-white truncate">{{ previsaoPien ? previsaoPien.city : 'Pien'
                    }}</span>
                  </div>
                  <div class="flex items-center gap-2 mt-2">
                    <Thermometer size="16" />
                    <span class="text-sm font-bold text-white">{{ previsaoPien ? Math.floor(previsaoPien.temperature) +
                      '°' : '--°'
                    }}</span>
                  </div>
                </div>

                <!-- Rio Claro -->
                <div class="flex flex-col bg-white/10 p-3 rounded-md">
                  <div class="flex items-center gap-2">
                    <div class="text-yellow-500 mr-1">
                      <div v-if="previsaoRioClaro">
                        <Sun v-if="previsaoRioClaro.description === 'céu limpo'" size="18" />
                        <CloudSun v-else-if="previsaoRioClaro.description === 'poucas nuvens'" size="18" />
                        <Cloud v-else-if="previsaoRioClaro.description === 'nublado'" size="18" />
                        <CloudRain v-else-if="previsaoRioClaro.description === 'chuva'" size="18" />
                        <HelpCircle v-else size="18" />
                      </div>
                    </div>
                    <span class="font-semibold text-sm text-white truncate">{{ previsaoRioClaro ? previsaoRioClaro.city
                      : 'Rio Claro' }}</span>
                  </div>
                  <div class="flex items-center gap-2 mt-2">
                    <Thermometer size="16" />
                    <span class="text-sm font-bold text-white">{{ previsaoRioClaro ?
                      Math.floor(previsaoRioClaro.temperature) + '°'
                      : '--°' }}</span>
                  </div>
                </div>

                <!-- Guaira -->
                <div class="flex flex-col bg-white/10 p-3 rounded-md">
                  <div class="flex items-center gap-2">
                    <div class="text-yellow-500 mr-1">
                      <div v-if="previsaoGuaira">
                        <Sun v-if="previsaoGuaira.description === 'céu limpo'" size="18" />
                        <CloudSun v-else-if="previsaoGuaira.description === 'poucas nuvens'" size="18" />
                        <Cloud v-else-if="previsaoGuaira.description === 'nublado'" size="18" />
                        <CloudRain v-else-if="previsaoGuaira.description === 'chuva'" size="18" />
                        <HelpCircle v-else size="18" />
                      </div>
                    </div>
                    <span class="font-semibold text-sm text-white truncate">{{ previsaoGuaira ? previsaoGuaira.city :
                      'Guaira' }}</span>
                  </div>
                  <div class="flex items-center gap-2 mt-2">
                    <Thermometer size="16" />
                    <span class="text-sm font-bold text-white">{{ previsaoGuaira ?
                      Math.floor(previsaoGuaira.temperature) + '°' :
                      '--°' }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Espaçador flexível -->
            <div class="flex-grow"></div>

            <!-- Data e hora -->
            <div class="p-4 flex-shrink-0 text-white border-t border-white/10">
              <div class="text-xl font-semibold">{{ diaSemana }}</div>
              <div class="text-xl mt-1">{{ dia }} de {{ mes }}</div>
              <div class="flex items-center gap-2 text-xl mt-1">
                <Clock size="20" />
                {{ hora }}
              </div>
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
import {
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
  Sun,
  ChevronUp,
  ChevronDown
} from 'lucide-vue-next';

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
    Sun,
    ChevronUp,
    ChevronDown
  },
  data: function () {
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
      aniversarianteItemHeight: 64, // Altura de cada item em pixels
      isHoveringAniversariantes: false, // Para pausar o carrossel quando o mouse estiver sobre ele

      currentDate: new Date(),
      temperatura: 26,

      // Notícias de exemplo
      noticias: [
      ]
    };
  },
  computed: {
    dia: function () {
      return this.currentDate.getDate();
    },
    diaSemana: function () {
      const diasDaSemana = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
      return diasDaSemana[this.currentDate.getDay()];
    },
    mes: function () {
      const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
      return meses[this.currentDate.getMonth()];
    },
    hora: function () {
      return this.currentDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
  },
  created: function () {
    this.getEvento();
    this.getAniversariantes();
    this.fetchPrevisao();
    this.getNoticias();
  },
  mounted: function () {
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

    // Detectar tamanho real dos itens após renderização
    this.$nextTick(function () {
      this.calcularAlturaItemAniversariante();
    });

    window.addEventListener('resize', this.handleResize);
  },
  beforeDestroy: function () {
    clearInterval(this.intervalId);
    this.stopSlideshow();
    this.stopNoticiaRotation();
    this.stopAniversarianteCarousel();
    window.removeEventListener('resize', this.handleResize);
  },
  watch: {
    // Observa mudanças na lista de aniversariantes para iniciar ou parar o carrossel conforme necessário
    aniversariantes: function () {
      this.startAniversarianteCarouselIfNeeded();
      this.$nextTick(function () {
        this.calcularAlturaItemAniversariante();
      });
    }
  },
  methods: {
    async getNoticias() {
      try {
        const response = await axiosInstance.get('/noticias');
        this.noticias = response.data.data;
      } catch (error) {
        console.error('Error fetching noticias:', error);
      }
    },
    // Calcula a altura real de um item de aniversariante para usar no carrossel
    calcularAlturaItemAniversariante: function () {
      const items = this.$el.querySelectorAll('.aniversariante-item');
      if (items && items.length > 0) {
        // Pega a altura do primeiro item + margem
        const firstItem = items[0];
        const style = window.getComputedStyle(firstItem);
        const marginBottom = parseInt(style.marginBottom) || 12; // 12px é o valor padrão para space-y-3

        this.aniversarianteItemHeight = firstItem.offsetHeight + marginBottom;
      }
    },
    fetchPrevisao: function () {
      return Promise.all([
        this.getPrevisaoTempoImbituba(),
        this.getPrevisaoTempoRioClaro(),
        this.getPrevisaoTempoGuaira(),
        this.getPrevisaoTempoPien()
      ]);
    },
    getPrevisaoTempoImbituba: function () {
      return axiosInstance.get('/weather/imbituba')
        .then(function (response) {
          this.previsao = response.data;
        }.bind(this))
        .catch(function (error) {
          console.error("Erro ao buscar previsão de Imbituba:", error);
        });
    },
    getPrevisaoTempoRioClaro: function () {
      return axiosInstance.get('/weather/rio-claro')
        .then(function (response) {
          this.previsaoRioClaro = response.data;
        }.bind(this))
        .catch(function (error) {
          console.error("Erro ao buscar previsão de Rio Claro:", error);
        });
    },
    getPrevisaoTempoGuaira: function () {
      return axiosInstance.get('/weather/guaira')
        .then(function (response) {
          this.previsaoGuaira = response.data;
        }.bind(this))
        .catch(function (error) {
          console.error("Erro ao buscar previsão de Guaíra:", error);
        });
    },
    getPrevisaoTempoPien: function () {
      return axiosInstance.get('/weather/pien')
        .then(function (response) {
          this.previsaoPien = response.data;
        }.bind(this))
        .catch(function (error) {
          console.error("Erro ao buscar previsão de Pien:", error);
        });
    },
    updateTime: function () {
      this.currentDate = new Date();
    },
    getAniversariantes: function () {
      const mesAtual = new Date().getMonth() + 1;
      return axiosInstance.get('/aniversariantes', {
        params: { mes: mesAtual },
      })
        .then(function (response) {
          this.aniversariantes = response.data;
        }.bind(this))
        .catch(function (error) {
          console.error("Erro ao buscar aniversariantes:", error);
        });
    },
    getEvento: function () {
      return axiosInstance.get(`/imagens/evento/${this.idEvento}`)
        .then(function (response) {
          this.fotos = response.data[0];
        }.bind(this))
        .catch(function (error) {
          console.error("Erro ao buscar imagens do evento:", error);
        });
    },
    // Métodos para o slideshow de imagens
    startSlideshow: function () {
      this.stopSlideshow();
      this.timer = setInterval(this.nextSlide, 5000);
    },
    stopSlideshow: function () {
      if (this.timer) {
        clearInterval(this.timer);
        this.timer = null;
      }
    },
    nextSlide: function () {
      if (this.currentIndex === this.fotos.length - 1) {
        this.getEvento();
      }
      this.currentIndex = (this.currentIndex + 1) % this.fotos.length;
    },
    prevSlide: function () {
      this.currentIndex = (this.currentIndex - 1 + this.fotos.length) % this.fotos.length;
    },
    setCurrentIndex: function (index) {
      this.currentIndex = index;
      this.stopSlideshow();
      this.startSlideshow();
    },
    // Métodos para o carrossel de aniversariantes
    startAniversarianteCarouselIfNeeded: function () {
      // Inicia o carrossel apenas se houver mais de 5 aniversariantes
      if (this.aniversariantes.length > 5) {
        this.startAniversarianteCarousel();
      } else {
        this.stopAniversarianteCarousel();
      }
    },
    startAniversarianteCarousel: function () {
      this.stopAniversarianteCarousel();
      this.aniversarianteTimer = setInterval(this.nextAniversariantePage, 5000); // Troca a cada 5 segundos
    },
    stopAniversarianteCarousel: function () {
      if (this.aniversarianteTimer) {
        clearInterval(this.aniversarianteTimer);
        this.aniversarianteTimer = null;
      }
    },
    nextAniversariantePage: function () {
      if (this.aniversariantes.length <= 5 || this.isHoveringAniversariantes) {
        return; // Não há necessidade de rotação se todos cabem na tela ou se o mouse estiver sobre o carrossel
      }

      // Avança para o próximo aniversariante, um por um
      this.currentAniversarianteIndex = (this.currentAniversarianteIndex + 1) % this.aniversariantes.length;
    },
    prevAniversariantePage: function () {
      if (this.aniversariantes.length <= 5) {
        return;
      }

      // Volta para o aniversariante anterior
      this.currentAniversarianteIndex = (this.currentAniversarianteIndex - 1 + this.aniversariantes.length) % this.aniversariantes.length;
    },
    setAniversariantePage: function (index) {
      this.currentAniversarianteIndex = index;
      this.stopAniversarianteCarousel();
      this.startAniversarianteCarousel();
    },
    // Outros métodos
    toggleFullscreen: function () {
      const elem = this.$el.querySelector('.relative');
      if (!document.fullscreenElement) {
        elem.requestFullscreen().catch(function (err) {
          console.error("Erro ao entrar em tela cheia:", err);
        });
      } else {
        document.exitFullscreen();
      }
    },
    handleResize: function () {
      // Recalcular altura dos itens quando a janela for redimensionada
      this.calcularAlturaItemAniversariante();
    },
    startNoticiaRotation: function () {
      this.stopNoticiaRotation();
      this.noticiaTimer = setInterval(this.nextNoticia, 8000);
    },
    stopNoticiaRotation: function () {
      if (this.noticiaTimer) {
        clearInterval(this.noticiaTimer);
        this.noticiaTimer = null;
      }
    },
    nextNoticia: function () {
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

/* Altura fixa para o container de aniversariantes */
.aniversariantes-container {
  height: 200px;
  overflow: hidden;
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

  .aniversariantes-container {
    height: 180px;
  }
}

/* Telas grandes e TVs */
@media (min-width: 1440px) {
  .aniversariantes-container {
    height: 220px;
  }
}

@media (min-width: 1920px) {
  .sidebar-width {
    width: 20rem;
    min-width: 20rem;
  }

  .aniversariantes-container {
    height: 240px;
  }

  .aniversariante-item {
    margin-bottom: 0.75rem;
    padding: 0.75rem;
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
.aniversariantes-container {
  mask-image: linear-gradient(to bottom,
      rgba(0, 0, 0, 1) 85%,
      rgba(0, 0, 0, 0.3));
}

/* Espaçamento consistente para aniversariantes */
.aniversariante-item {
  margin-bottom: 0.75rem;
}

/* Último item sem margem inferior */
.aniversariante-item:last-child {
  margin-bottom: 0;
}

/* Efeito de hover para pausar o carrossel */
.space-y-3:hover {
  cursor: pointer;
}
</style>