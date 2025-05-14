<template>
  <div class="p-14 flex flex-col">
    <h1 class="mb-4 text-lg font-semibold">Gerenciar Aniversariantes</h1>
    <DataTable  :value="employees" :loading="loading" tableStyle="min-width: 50rem">
      <Column field="id" header="ID"></Column>
      <Column field="name" header="Nome"></Column>
      <Column field="sector" header="Setor"></Column>
      <Column field="birthday" header="Data de Nascimento"></Column>
    </DataTable>
  </div>
</template>

<script>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

export default {
  components: {
    DataTable,
    Column,
  },
  name: 'GerenciarAniversariantes',
  data() {
    return {
      employees: [
        { id: 1, name: 'João Silva', sector: 'RH', birthday: '15/05/1985' },
        { id: 2, name: 'Maria Oliveira', sector: 'Financeiro', birthday: '20/06/1990' },
        { id: 3, name: 'Carlos Souza', sector: 'TI', birthday: '12/07/1988' },
        { id: 4, name: 'Ana Costa', sector: 'Marketing', birthday: '22/09/1992' },
        { id: 5, name: 'Pedro Santos', sector: 'Logística', birthday: '03/10/1983' },
        { id: 6, name: 'Fernanda Lima', sector: 'Vendas', birthday: '29/11/1995' },
        { id: 7, name: 'Rafael Almeida', sector: 'Financeiro', birthday: '13/01/1987' },
        { id: 8, name: 'Beatriz Rocha', sector: 'TI', birthday: '05/03/1991' },
        { id: 9, name: 'Lucas Mendes', sector: 'Operações', birthday: '14/12/1989' },
        { id: 10, name: 'Camila Nunes', sector: 'Recursos Humanos', birthday: '27/08/1994' },
      ],
      loading: false,
    };
  },
};
</script>

<style scoped>
/* Estilos adicionais podem ser aplicados aqui */
</style>
