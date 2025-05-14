<template>
  <div class="p-14 flex flex-col gap-8">
    <Breadcrumb :items="breadcrumbItems">
      <template #buttons>
        <Button class="bg-transparent border border-zinc-700" label="Novo Evento">
          <template #icon>
            <Plus size="20px" />
          </template>
        </Button>
        <Button class="bg-transparent border border-zinc-700" label="Filtrar">
          <template #icon>
            <ListFilter size="20px" />
          </template>
        </Button>
      </template>
    </Breadcrumb>

    <div class="bg-zinc-950 border border-zinc-700 rounded-lg p-6 shadow-lg space-y-6">
      <div class="border-b border-zinc-700 pb-4 mb-4 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-white">{{ evento.nome }}</h2>
        <span class="text-sm text-zinc-500">#{{ evento.codigo }}</span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-zinc-700">
        <div class="flex flex-col space-y-4">
          <div class="flex justify-between items-center">
            <span class="text-zinc-400 text-md">Nome:</span>
            <span class="text-zinc-200">{{ evento.nome }}</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-zinc-400 text-md">Código:</span>
            <span class="text-zinc-200">{{ evento.codigo }}</span>
          </div>
        </div>

        <div class="flex flex-col space-y-4">
          <div class="flex justify-between items-center">
            <span class="text-zinc-400 text-md">Data:</span>
            <span class="text-zinc-200">{{ evento.data }}</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-zinc-400 text-md">Local:</span>
            <span class="text-zinc-200">{{ evento.local }}</span>
          </div>
        </div>
      </div>

      <div class="flex gap-4 pb-6 border-b border-zinc-700">
        <Button class="bg-zinc-800 hover:bg-zinc-700 text-white" @click="redirectToUploadPage(evento.codigo)">
          <template #icon class="bg-red-500">
            <QrCode size="18px" class="mr-2" />
          </template>
          Página do QR Code
        </Button>
        <Button class="bg-zinc-800 hover:bg-zinc-700 text-white" @click="redirectToSlideshow(evento.id)">
          <template #icon>
            <Slideshow size="18px" class="mr-2" />
          </template>
          Acessar Slideshow
        </Button>
      </div>

      <!-- Seção de Fotos -->
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2">
            <Camera size="20px" class="text-blue-400" />
            <h3 class="text-lg font-semibold text-white">Fotos para Aprovação</h3>
          </div>

          <!-- Filtros de status -->
          <div class="flex bg-zinc-900 rounded-lg overflow-hidden">
            <button v-for="filter in filters" :key="filter.value" @click="currentFilter = filter.value" :class="[
              'px-4 py-2 text-sm transition-colors',
              currentFilter === filter.value
                ? 'bg-zinc-800 text-white'
                : 'text-zinc-400 hover:text-zinc-200'
            ]">
              {{ filter.label }}
            </button>
          </div>
        </div>

        <!-- Grid de fotos -->
        <div v-if="filteredFotos.length > 0"
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
          <div v-for="(foto, index) in filteredFotos" :key="index"
            class="bg-zinc-900 border border-zinc-800 rounded-lg overflow-hidden">
            <div class="relative">
              <img :src="$globals.urlBase() + `/storage/${foto.image_path}`" class="w-full h-48 object-cover" />
              <div :class="[
                'absolute top-2 right-2 px-2 py-1 text-xs rounded-md',
                foto.status === 'pendente' ? 'bg-yellow-600' :
                  foto.status === 'aprovada' ? 'bg-green-600' :
                    'bg-red-600'
              ]">
                {{ statusLabel(foto.status) }}
              </div>
            </div>

            <div class="p-3 flex gap-2 items-center">
              <User size="14px" />
              <span class="text-zinc-300 text-sm">{{ foto.nome_remetente || 'Não identificado' }}</span>
            </div>

            <div class="px-3 pb-3 flex gap-2">
              <button v-if="foto.status === 'pendente'" @click="aprovarFoto(foto.id)"
                class="flex items-center justify-center gap-1 bg-green-600/20 hover:bg-green-600/30 text-green-500 px-3 py-1.5 rounded-md text-xs transition-colors">
                <Check size="14px" />
                Aprovar
              </button>
              <button v-if="foto.status === 'pendente'" @click="rejeitarFoto(foto.id)"
                class="flex items-center justify-center gap-1 bg-red-600/20 hover:bg-red-600/30 text-red-500 px-3 py-1.5 rounded-md text-xs transition-colors">
                <X size="14px" />
                Rejeitar
              </button>
              <button v-if="foto.status === 'pendente' || foto.status === 'aprovada'"
                @click="confirmarExclusao(foto.id)"
                class="flex items-center justify-center gap-1 bg-zinc-700/20 hover:bg-zinc-700/30 text-zinc-400 px-3 py-1.5 rounded-md text-xs transition-colors ml-auto">
                <Trash2 size="14px" />
                Excluir
              </button>
            </div>
          </div>
        </div>

        <!-- Estado vazio -->
        <div v-else class="flex flex-col items-center justify-center py-12 text-zinc-500">
          <ImageOff size="48px" class="mb-4 opacity-50" />
          <p>Nenhuma foto encontrada para este filtro</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '../../axios';
import { Plus, ListFilter, Camera, Check, X, Trash2, ImageOff, User } from 'lucide-vue-next';
export default {
  components: {
    Plus,
    ListFilter,
    Camera,
    Check,
    X,
    Trash2,
    ImageOff,
    User
  },
  data() {
    return {
      evento: {
        fotos: []
      },
      breadcrumbItems: [
        { label: 'Eventos', route: '/', icon: 'pi pi-calendar' },
        { label: 'Visualizar Evento', route: '/eventos/visualizar', icon: 'pi pi-eye' },
      ],
      currentFilter: 'pendente',
      filters: [
        { label: 'Todas', value: 'todas' },
        { label: 'Pendentes', value: 'pendente' },
        { label: 'Aprovadas', value: 'aprovada' },
        { label: 'Rejeitadas', value: 'rejeitada' }
      ]
    };
  },
  computed: {
    filteredFotos() {
      if (!this.evento.fotos || !this.evento.fotos.length) return [];

      if (this.currentFilter === 'todas') {
        return this.evento.fotos;
      }

      return this.evento.fotos.filter(foto => foto.status === this.currentFilter);
    }
  },
  created() {
    this.getEvento();
  },
  methods: {
    async getEvento() {
      try {
        const response = await axiosInstance.get(`/event/${this.$route.params.id}`);
        this.evento = response.data.data;
        console.log(this.evento);
      } catch (error) {
        console.error('Erro ao buscar evento:', error);
      }
    },
    redirectToSlideshow(id) {
      this.$router.push({ name: 'slideshow-evento', params: { id } });
    },
    redirectToUploadPage(codigo) {
      this.$router.push({ name: 'upload-evento', params: { codigo } });
    },
    statusLabel(status) {
      const labels = {
        'pendente': 'Pendente',
        'aprovada': 'Aprovada',
        'rejeitada': 'Rejeitada'
      };
      return labels[status] || 'Pendente';
    },
    async aprovarFoto(id) {
      try {
        const response = await axiosInstance.put(`/imagens/aprovar/${id}`);

        if (response.status === 200) {
          const foto = this.evento.fotos.find(f => f.id === id);
          if (foto) foto.status = 'aprovada';
        }
      } catch (error) {
        console.error('Erro ao aprovar foto:', error);
      }
    },
    async rejeitarFoto(id) {
      try {
        const response = await axiosInstance.put(`/imagens/rejeitar/${id}`);
        if (response.status === 200) {
          const foto = this.evento.fotos.find(f => f.id === id);
          if (foto) foto.status = 'rejeitada';
        }
      } catch (error) {
        console.error('Erro ao rejeitar foto:', error);
      }
    },
    confirmarExclusao(id) {
      if (confirm('Tem certeza que deseja excluir esta foto?')) {
        this.excluirFoto(id);
      }
    },
    async excluirFoto(id) {
      try {
        const response = await axiosInstance.delete(`/imagens/excluir/${id}`);
        if (response.status === 200) {
          this.evento.fotos = this.evento.fotos.filter(f => f.id !== id);
        }
      } catch (error) {
        console.error('Erro ao excluir foto:', error);
      }
    }
  }
}
</script>