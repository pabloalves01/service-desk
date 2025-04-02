<template>
  <div class="flex flex-col  items-center justify-center bg-zinc-500">
    <div class="text-2xl text-white">
      <div v-if="this.isEditing">Editar Cliente</div>
      <div v-else>Cadastrar</div>
    </div>
    <div class="flex flex-col gap-4 w-96 mt-4">
      <input v-model="cliente.razao_social" class="py-2 px-4 rounded-md" type="text" placeholder="Digite a razão social...">
      <input v-model="cliente.cnpj" class="py-2 px-4 rounded-md" type="number" placeholder="Digite o CNPJ do Cliente">
      <!-- <button @click="saveCliente" class="bg-green-500 mt-4 py-2 rounded-md"> -->
        <button @click="updateClient" class="bg-green-500 rounded-md py-2" v-if="this.isEditing">Salvar</button>
        <button @click="saveCliente" class="bg-green-500 rounded-md py-2" v-else>Cadastrar</button>
      <!-- </button> -->
    </div>
  </div>


  <div class="flex flex-col  items-center justify-center bg-zinc-500 mt-10">
    <div class="text-2xl text-white">Gerenciar Clientes</div>
    <table class="styled-table">
      <thead>
      <tr>
        <th>Razão Social</th>
        <th>CNPJ</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(cliente, index) in clientes" :key="index">
        <td>{{ cliente.razao_social }}</td>
        <td>{{ cliente.cnpj }}</td>
        <td>
          <div class="flex gap-2">
            <button @click="getDataClient(cliente.id)">Editar</button>
            <button @click="deleteClient(cliente.id)">Deletar</button>
          </div>
        </td>
      </tr>
    </tbody>
    </table>
  </div> 

</template>

<script>
import axios from "../axios";
export default {
  data() {
    return {
      isEditing: false,
      clientes: [],
      cliente: {
        razao_social: "",
        cnpj: "",
      },
    }
  },
  created() {
    this.getClient()
  },
  methods: {
    async getClient(){
      try {
        const response = await axios.get("/cliente")
        this.clientes = response.data;
      } catch (error) {
        console.error(error)
      }
    },
    async saveCliente() {
      try {
        const response = await axios.post("/cliente", this.cliente)
        console.log(response.data);
        this.cliente = {
          razao_social: "",
          cnpj: "",
        }
        this.getClient();
      } catch (error) {
        console.error(error)
      }
    },
    async deleteClient(id) {
      try {
        const response = await axios.delete(`/cliente/${id}`)
        this.getClient();
      } catch (error) {
        console.error(error);
      }
    },

    async getDataClient(id) {
     try {
      this.isEditing = true;
      const responde = await axios.get(`/cliente/${id}`)
      this.cliente = responde.data
     } catch (error) {
        console.error(error)
     }
    },
    async updateClient() {
      try {
        const response = await axios.put(`/cliente/${this.cliente.id}`, this.cliente)
        this.getClient();
        this.isEditing = false;
        this.cliente = {
          razao_social: "",
          cnpj: "",
        }
      } catch (error) {
        console.error(error)
      }
    },

  }
}
</script>
