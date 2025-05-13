<template>
    <div class="p-14 flex flex-col gap-8">
        <!-- Cabeçalho -->
        <div class="flex justify-between items-center">
            <div class="flex flex-col gap-1.5">
                <h1 class="font-semibold text-2xl text-gray-200">Painel de Eventos</h1>
                <span class="text-zinc-500">Gerencie seus eventos cadastrados.</span>
            </div>
            <Button label="Novo Evento" @click="visible = true">
                <template #icon>
                    <Plus />
                </template>
            </Button>
        </div>

        <!-- Lista de Eventos -->
        <div class="grid grid-cols-[repeat(auto-fit,_minmax(200px,_1fr))] gap-6">
            <div v-for="(event, index) in events" :key="index"
                class="border border-zinc-600 rounded-lg p-4 flex flex-col gap-4 cursor-pointer hover:scale-105 transition-transform duration-300">
                <div alt="Evento" class="w-full bg-zinc-900 h-32 object-cover rounded-lg"></div>
                <h2 class="text-lg font-semibold text-gray-200">{{ event.nome }}</h2>
                <p class="text-zinc-500">{{ event.data }}</p>
                <p class="text-zinc-500">{{ event.local }}</p>
                <!-- <p class="text-zinc-400">{{ event.description }}</p> -->
            </div>
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
import DatePicker from 'primevue/datepicker';
import { Plus } from 'lucide-vue-next';
import axiosInstance from '../../axios';

export default {
    components: {
        Button,
        Plus,
        Dialog,
        InputText,
        DatePicker,
    },
    data() {
        return {
            evento: {
                nome: "",
                local: "",
                data: "",
                descricao: "",
            },
            visible: false,
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
        async save() {
            try {
                const response = await axiosInstance.post('/events', {
                    nome: this.evento.nome,
                    local: this.evento.local,
                    data_evento: this.evento.data,
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
                console.log("Eventos obtidos com sucesso:", this.events);
            } catch (error) {
                console.error("Erro ao obter eventos:", error);
            }
        },
        resetaValores() {
            this.evento.nome = "";
            this.evento.local = "";
            this.evento.data = "";
        },
    },
};
</script>
