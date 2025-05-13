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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="(event, index) in events" :key="index"
                class="border border-zinc-600 rounded-lg p-4 flex flex-col gap-4 cursor-pointer hover:scale-105  transition-transform duration-300">
                <div alt="Evento" class="w-full bg-zinc-900 h-32 object-cover rounded-lg"></div>
                <h2 class="text-lg font-semibold text-gray-200">{{ event.name }}</h2>
                <p class="text-zinc-500">{{ event.time }}</p>
                <p class="text-zinc-500">{{ event.location }}</p>
                <p class="text-zinc-400">{{ event.description }}</p>
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
            <div class="flex justify-end gap-2">
                <Button type="button" label="Cancel" severity="secondary" @click="visible = false"></Button>
                <Button type="button" label="Save" @click="visible = false"></Button>
            </div>
        </div>
    </Dialog>
</template>

<script>
import Button from '@/components/comum/buttons/button.vue';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import { Plus } from 'lucide-vue-next';
import axiosInstance from '@/axios';

export default {
    components: {
        Button,
        Plus,
        Dialog,
        InputText,

    },
    data() {
        return {
            evento: {
                nome: "",
                local: "",
                descricao: "",
            },
            visible: false,
            events: [
                {
                    name: "Workshop de Vue.js",
                    time: "15:00 - 17:00",
                    location: "Auditório A",
                    description: "Aprenda os conceitos básicos e avançados do Vue.js.",
                    image: "https://via.placeholder.com/150x150.png?text=Evento+1",
                },
                {
                    name: "Reunião de Planejamento",
                    time: "10:00 - 11:30",
                    location: "Sala de Reunião 3",
                    description: "Discussão sobre o plano estratégico do próximo trimestre.",
                    image: "https://via.placeholder.com/150x150.png?text=Evento+2",
                },
                {
                    name: "Lançamento de Produto",
                    time: "18:00 - 20:00",
                    location: "Salão Principal",
                    description: "Apresentação do novo produto com coquetel para os convidados.",
                    image: "https://via.placeholder.com/150x150.png?text=Evento+3",
                },
                {
                    name: "Treinamento de Vendas",
                    time: "09:00 - 12:00",
                    location: "Sala de Treinamento 2",
                    description: "Capacitação para a equipe de vendas sobre técnicas de negociação.",
                    image: "https://via.placeholder.com/150x150.png?text=Evento+4",
                },
                {
                    name: "Palestra Motivacional",
                    time: "14:00 - 15:30",
                    location: "Auditório B",
                    description: "Inspire-se com histórias de sucesso de empreendedores locais.",
                    image: "https://via.placeholder.com/150x150.png?text=Evento+5",
                },
            ],
        };
    },
    methods: {
        openDialog() {
            this.visible = true;
        },
        async save() {
            try {
                const response = await axiosInstance.post('/events', {
                    name: this.nome,
                    localizacao: this.localizacao,
                    descricao: this.descricao,
                });
            } catch (error) {
                console.error("Erro ao salvar evento:", error);
            }
        }
    },
};
</script>
