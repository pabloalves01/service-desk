<template>
    <div class="p-14 flex flex-col gap-8">
        <Breadcrumb :items="breadcrumbItems">
            <template #buttons>
                <ButtonComponent class="bg-transparent border border-zinc-700" label="Nova Notícia"
                    @click="visible = true">
                    <template #icon>
                        <Plus size="20px" />
                    </template>
                </ButtonComponent>
            </template>
        </Breadcrumb>
        <DataTable v-if="noticias.length > 0" :value="noticias" :loading="loading" :rows="15" :paginator="true"
            class="rounded-lg overflow-hidden" :rowHover="true" :showGridlines="true" :sortField="'id'" :sortOrder="-1"
            tableStyle="min-width: 60rem background-color: transparent;">
            <Column field="id" header="ID" :sortable="true" style="width: 2%; text-align: center;"></Column>
            <Column field="titulo" header="Titulo" :sortable="true" style="width: 30%;"></Column>
            <Column field="descricao" header="descricao" :sortable="true" style="width: 15%;"></Column>
            <Column header="Ações" style="width: 3%; text-align: center;">
                <template #body="{ data }">
                    <div class="flex justify-center gap-2">
                        <Button icon="pi pi-trash" severity="danger" variant="text" rounded
                            @click="deleteNoticia(data.id)" />
                    </div>
                </template>
            </Column>
        </DataTable>
        <div v-else class="flex items-center justify-center h-40 text-gray-400">
            Não existem notícias cadastradas.
        </div>
    </div>
    <Dialog v-model:visible="visible" header="Cadastrar Nova Notícia" :style="{ width: '30rem' }">
        <span class="text-surface-500 dark:text-surface-400 block mb-8">Preencha as informações.</span>
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <label for="username" class="font-semibold">Título</label>
                <InputText v-model="noticia.titulo" id="username" class="flex-auto" autocomplete="off" />
            </div>
            <div class="flex flex-col gap-2">
                <label for="username" class="font-semibold">Descrição</label>
                <Textarea v-model="noticia.descricao" rows="5" cols="30" />
            </div>
            <div class="flex justify-end gap-2">
                <Button type="button" label="Cancel" severity="secondary" @click="closeModal"></Button>
                <Button type="button" label="Cadastrar" @click="save"></Button>
            </div>
        </div>
    </Dialog>
</template>

<script>
import ButtonComponent from '@/components/comum/buttons/button.vue';
import { Dialog } from 'primevue';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import { Button } from 'primevue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import axiosInstance from '../../axios';
export default {
    components: {
        ButtonComponent,
        Dialog,
        InputText,
        Textarea,
        Button,
        DataTable,
        Column
    },
    data() {
        return {
            noticia: {
                titulo: '',
                descricao: '',
            },
            loading: false,
            noticias: [],
            visible: false,
            breadcrumbItems: [
                { label: 'Gerenciar Notícias', route: '/gerenciar-notocias', icon: 'pi pi-list-check' },
            ],
        };
    },
    created() {
        this.getNoticias();
    },
    methods: {
        closeModal() {
            this.noticia = {
                titulo: '',
                descricao: '',
            };
            this.visible = false;
        },
        async deleteNoticia(id) {
           try {
               await axiosInstance.delete(`/noticia/${id}`);
               this.getNoticias();
           } catch (error) {
               console.error('Error deleting noticia:', error);
           }
        },
        async getNoticias() {
            try {
                const response = await axiosInstance.get('/noticias');
                this.noticias = response.data.data;
            } catch (error) {
                console.error('Error fetching noticias:', error);
            }
        },
        async save() {
            try {
                const response = await axiosInstance.post('/noticias', this.noticia);
                this.closeModal();
                this.getNoticias();
            } catch (error) {
                console.error('Error saving noticia:', error);
            }
        },
    },
}
</script>