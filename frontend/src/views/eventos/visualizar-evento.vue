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
                        <span class="text-zinc-400 font-medium">Nome:</span>
                        <span class="text-zinc-200">{{ evento.nome }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-400 font-medium">Código:</span>
                        <span class="text-zinc-200">{{ evento.codigo }}</span>
                    </div>
                </div>

                <div class="flex flex-col space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-400 font-medium">Data:</span>
                        <span class="text-zinc-200">{{ evento.data }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-zinc-400 font-medium">Local:</span>
                        <span class="text-zinc-200">{{ evento.local }}</span>
                    </div>
                </div>
            </div>
            <div>
                teste
            </div>
        </div>
    </div>
</template>

<script>
import axiosInstance from '../../axios';

export default {
    data() {
        return {
            evento: {
            },
            breadcrumbItems: [
                { label: 'Eventos', route: '/eventos', icon: 'pi pi-calendar' },
                { label: 'Visualizar Evento', route: '/eventos/visualizar', icon: 'pi pi-eye' },
            ],
        };
    },
    created() {
        this.getEvento();
    },
    methods: {
        async getEvento() {
            try {
                const response = await axiosInstance.get(`/event/${this.$route.params.id}`);
                this.evento = response.data.data;
            } catch (error) {
                console.error('Erro ao buscar evento:', error);
            }
        }
    },
}
</script>