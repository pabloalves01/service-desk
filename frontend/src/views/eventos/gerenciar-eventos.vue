<template>
    <div class="p-14 flex flex-col gap-8">
        <div class="flex flex-col md:flex-row justify-between gap-4 md:gap-0 md:items-center">
            <div class="flex flex-col gap-1.5">
                <h1 class="font-semibold text-2xl text-gray-200">Painel de Eventos</h1>
                <span class="text-zinc-500">Gerencie seus eventos cadastrados.</span>
            </div>
            <div class="flex gap-4">
                <Button class="bg-transparent border border-zinc-700" label="Novo Evento" @click="visible = true">
                    <template #icon>
                        <Plus size="20px" />
                    </template>
                </Button>
                <Button class="bg-transparent border border-zinc-700" label="Filtrar" @click="openFilterModal">
                    <template #icon>
                        <ListFilter size="20px" />
                    </template>
                </Button>
            </div>
        </div>
        <div v-if="isLoadedEvents" class="grid grid-cols-[repeat(auto-fit,_minmax(150px,_1fr))] gap-4">
            <Skeleton v-for="i in 5" :key="i" class="h-40 sm:h-48 lg:h-56 w-full" height="20rem"></Skeleton>
        </div>
        <div class="grid grid-cols-[repeat(auto-fit,_minmax(300px,_1fr))] gap-6">
            <div v-for="(event, index) in events" :key="index"
                class="border border-zinc-600 rounded-lg p-4 flex flex-col gap-4 cursor-pointer hover:scale-105 transition-transform duration-300"
                @click="visualizarEvento(event.codigo)">
                <div class="w-full bg-zinc-900 h-32 sm:h-40 lg:h-48 object-cover rounded-lg overflow-hidden">
                    <img v-if="event.image_path" :src="`http://127.0.0.1:8000/storage/${event.image_path}`"
                        alt="Imagem do Evento" class="w-full sm:h-32 md:h-40 lg:h-48 object-cover" />
                    <div v-else class="w-full h-full flex justify-center items-center text-white">
                        <span class="font-bold text-lg">Imagem não disponível</span>
                    </div>
                </div>

                <div class="flex justify-between">
                    <h2 class="text-md font-semibold text-gray-200">{{ event.nome }}</h2>
                    <h2 class="text-md text-zinc-700">#{{ event.codigo }}</h2>
                </div>
                <p class="text-sm text-zinc-500">{{ event.data }}</p>
                <p class="text-sm text-zinc-500">{{ event.local }}</p>
            </div>

        </div>
        <div class="flex flex-col items-center justify-center h-64 gap-4 text-zinc-500"
            v-if="events.length < 1 && !isLoadedEvents">
            <Image class="w-16 h-16" />
            <h2 class="text-xl font-semibold">Nenhum evento encontrado</h2>
            <p class="text-sm">Clique no botão <strong>Novo Evento</strong> acima para cadastrar um novo evento.</p>
        </div>
    </div>
    <Dialog v-model:visible="visible" header="Cadastrar Novo Evento" :style="{ width: '30rem' }">
        <span class="text-surface-500 dark:text-surface-400 block mb-8">Preencha as informações.</span>
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <label for="username" class="font-semibold">Nome</label>
                <InputText v-model="evento.nome" id="username" class="flex-auto" autocomplete="off" />
            </div>
            <div class="flex flex-col gap-2">
                <label for="email" class="font-semibold">Local</label>
                <InputText v-model="evento.local" id="email" class="flex-auto" autocomplete="off" />
            </div>
            <div class="flex flex-col gap-2">
                <label for="email" class="font-semibold">Data e Horário</label>
                <DatePicker id="datepicker-24h" v-model="evento.data" showTime hourFormat="24" fluid />
            </div>
            <div class="flex flex-col gap-2">
                <label class="font-semibold">Imagem de Capa</label>
                <Button class="border border-zinc-700 py-10 justify-center" label="Selecionar Imagem"
                    @click="selectImage" style="background-color: black;">
                    <template #icon>
                        <Image />
                    </template>
                </Button>
                <input type="file" ref="imageInput" class="hidden" accept="image/*" @change="onFileChange" />
                <span v-if="evento.imagem" class="text-zinc-500 mt-2">{{ evento.imagem.name }}</span>
            </div>
            <div class="flex justify-end gap-2">
                <Button type="button" label="Cancel" severity="secondary" @click="visible = false"></Button>
                <Button type="button" label="Save" @click="save"></Button>
            </div>
        </div>
    </Dialog>
</template>

<script>
import Button from '@/components/comum/buttons/button.vue';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Skeleton from 'primevue/skeleton';
import DatePicker from 'primevue/datepicker';
import { Image, Plus, ListFilter } from 'lucide-vue-next';
import axiosInstance from '../../axios';

export default {
    components: {
        Button,
        Plus,
        Image,
        ListFilter,
        Dialog,
        InputText,
        DatePicker,
        Skeleton,
    },
    data() {
        return {
            evento: {
                nome: "",
                local: "",
                data: "",
                descricao: "",
                imagem: null,
            },
            visible: false,
            modalFilterIsVisible: false,
            isLoadedEvents: true,
            events: [],
        };
    },
    created() {
        this.getEventos();
    },
    methods: {
        openDialog() {
            this.visible = true;
        },
        openFilterModal() {
            this.modalFilterIsVisible = true;
        },
        onFileChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.evento.imagem = file;
            }
        },

        selectImage() {
            this.$refs.imageInput.click();
        },
        async save() {
            try {
                const formData = new FormData();
                formData.append('nome', this.evento.nome);
                formData.append('local', this.evento.local);
                const dataFormatada = new Date(this.evento.data).toISOString().slice(0, 19).replace('T', ' ');
                formData.append('data_evento', dataFormatada);
                if (this.evento.imagem) {
                    formData.append('imagem', this.evento.imagem);
                }
                // console.log([...formData.entries()]);
                const response = await axiosInstance.post('/events', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                this.getEventos();
                this.visible = false;
                this.resetaValores();
                console.log("Evento salvo com sucesso:", response.data);
            } catch (error) {
                console.error("Erro ao salvar evento:", error);
            }
        },
        async getEventos() {
            try {
                const response = await axiosInstance.get('/events');
                this.events = response.data.data;
                console.log(this.events);
                this.isLoadedEvents = false;
                console.log("Eventos obtidos com sucesso:", this.events);
            } catch (error) {
                this.isLoadedEvents = false;
                console.error("Erro ao obter eventos:", error);
            }
        },
        visualizarEvento(codigo) {
            this.$router.push({ name: 'visualizar-evento', params: { codigo } });
        },
        resetaValores() {
            this.evento.nome = "";
            this.evento.local = "";
            this.evento.data = "";
        },
    },
};
</script>
