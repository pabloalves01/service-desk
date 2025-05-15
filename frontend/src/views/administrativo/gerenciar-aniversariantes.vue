<template>
  <div class="p-14 flex flex-col gap-8">
    <Breadcrumb :items="breadcrumbItems">
      <template #buttons>
        <ButtonComponent class="bg-transparent border border-zinc-700" label="Novo Aniversariante"
          @click="visible = true">
          <template #icon>
            <Plus size="20px" />
          </template>
        </ButtonComponent>
      </template>
    </Breadcrumb>
    <!-- <h1 class="mb-4 text-xl font-bold text-gray-100">Gerenciar Aniversariantes</h1> -->
    <DataTable size="small" :paginator="true" :value="aniversariantes" :loading="loading" :rows="15"
      class="rounded-lg overflow-hidden" :rowHover="true" :showGridlines="true"
      tableStyle="min-width: 60rem background-color: transparent;">
      <Column field="id" header="ID" :sortable="true" style="width: 2%; text-align: center;"></Column>
      <Column field="nome" header="Nome" :sortable="true" style="width: 30%;"></Column>
      <Column field="setor" header="Setor" :sortable="true" style="width: 15%;"></Column>
      <Column field="data_nascimento" header="Data de Nascimento" :sortable="true" style="width:10%;"></Column>
      <Column header="Ações" style="width: 3%; text-align: center;">
        <template #body="{ data }">
          <div class="flex justify-center gap-2">
            <Button icon="pi pi-pencil" severity="secondary" variant="text" rounded aria-label="Bookmark" />
            <Button icon="pi pi-trash" severity="danger" variant="text" rounded aria-label="Bookmark" />
            <!-- <Button label="Editar" icon="pi pi-pencil" class="p-button-info p-button-rounded p-button-sm" @click="editEmployee(data)" />
            <Button label="Excluir" icon="pi pi-trash" class="p-button-danger p-button-rounded p-button-sm" @click="deleteEmployee(data.id)" /> -->
          </div>
        </template>
      </Column>
    </DataTable>
  </div>
  <Dialog v-model:visible="visible" header="Cadastrar Novo Aniversáriante" :style="{ width: '30rem' }">
    <span class="text-surface-500 dark:text-surface-400 block mb-8">Preencha as informações.</span>
    <div class="flex flex-col gap-4">
      <div class="flex flex-col gap-2">
        <label for="username" class="font-semibold">Nome do Funcionário</label>
        <InputText v-model="aniversariante.nome" id="username" class="flex-auto" autocomplete="off" />
      </div>
      <div class="flex flex-col gap-2">
        <label for="email" class="font-semibold">Nascimento</label>
        <DatePicker
          id="datepicker-24h"
          v-model="aniversariante.data_nascimento"
          fluid
          dateFormat="dd/mm/yy"
        />
      </div>
      <div class="flex flex-col gap-2">
        <label for="email" class="font-semibold">Setor</label>
        <Select v-model="aniversariante.setor" :options="setores" optionLabel="name" optionValue="id"
          placeholder="Selecione um Setor" class="w-full" />
      </div>

      <div class="flex justify-end gap-2">
        <Button type="button" label="Cancel" severity="secondary" @click="closeModal"></Button>
        <Button type="button" label="Cadastrar" @click="save"></Button>
      </div>
    </div>
  </Dialog>
</template>

<script>
// import Button from '@/components/comum/buttons/button.vue';
import { Button } from 'primevue';
import ButtonComponent from '@/components/comum/buttons/button.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { Plus, X } from 'lucide-vue-next';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import DatePicker from 'primevue/datepicker';
import axiosInstance from '../../axios';
export default {
  components: {
    DataTable,
    Column,
    Button,
    ButtonComponent,
    Dialog,
    InputText,
    Select,
    DatePicker,
    Plus,
    X,
  },
  name: 'GerenciarAniversariantes',
  data() {
    return {
      visible: false,
      aniversariante: {
        nome: '',
        setor: '',
        data_nascimento: '',
      },
      setores: [
        { id: 1, name: 'Financeiro' },
        { id: 2, name: 'Marketing' },
        { id: 3, name: 'RH' },
        { id: 4, name: 'TI' },
      ],
      breadcrumbItems: [
        { label: 'Eventos', route: '/eventos', icon: 'pi pi-calendar' },
        { label: 'Gerenciar Eventos', route: '/eventos/gerenciar', icon: 'pi pi-list-check' },
      ],
      aniversariantes: [],
      loading: false,
    };
  },
  created() {
    this.getAniversariantes();
  },
  methods: {
    async getAniversariantes() {
      try {
        const response = await axiosInstance.get('/aniversariante');
        this.aniversariantes = response.data.data;
      } catch (error) {
        console.error('Erro ao buscar aniversariantes:', error);
      }
    },

    closeModal() {
      this.visible = false;
      this.aniversariante.nome = '';
      this.aniversariante.setor = '';
      this.aniversariante.data_nascimento = '';
    },
    async save() {
      try {
        const response = await axiosInstance.post('/aniversariante', {
          nome: this.aniversariante.nome,
          setor_id: this.aniversariante.setor,
          data_nascimento: this.aniversariante.data_nascimento,
        });
        this.closeModal();
      } catch (error) {
        console.error('Erro ao salvar:', error);
      }
    },
    editEmployee(employee) {
      console.log('Editar:', employee);
      // Implementar lógica de edição
    },
    deleteEmployee(id) {
      console.log('Excluir:', id);
      // Implementar lógica de exclusão
    },
  },
};
</script>