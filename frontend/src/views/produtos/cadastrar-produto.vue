<template>
    {{ this.$route.params.id }}
    <div class="flex items-center justify-center w-full flex-col">
      <div class="flex flex-col gap-4 w-96">
        <div class="text-white text-2xl">Cadastro de Produtos</div>
        <input 
          v-model="produto.nome" 
          type="text" 
          placeholder="Nome do Produto" 
          class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <input 
          v-model="produto.preco" 
          type="number" 
          placeholder="Preço" 
          class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <input 
          v-model="produto.quantidade" 
          type="number" 
          placeholder="Quantidade" 
          class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <button class="bg-green-500 p-2 rounded-full text-white" @click="saveProduct">Salvar</button>
      </div>
  
     
  
      <!-- <div class="mt-10">
        produtos aqui
        <div v-for="(produto, index) in products" :key="index">
          <div class="flex flex-col gap-4">
            <p>{{ produto.nome }}</p>
            <p>{{ produto.preco }}</p>
            <p>{{ produto.quantidade }}</p>
          </div>
        </div>
      </div> -->
      <RouterLink class="mt-4 text-black bg-white " to="/gerenciar-produtos">
        Gerenciar Produtos
      </RouterLink>
    </div>
  
  
  </template>
  
  <script>
import axios from "../../axios";

export default {
  data() {
    return {
      idProduto: this.$route.params.id,
      produto: {
        nome: "",
        preco: null,
        quantidade: null,
      },
    };
  },
  created() {
    if (this.idProduto) {
      this.getProduto(); 
    }
  },
  methods: {
    async getProduto() {
      try {
        const response = await axios.get(`/product/${this.idProduto}`); 
        console.log("Produto encontrado:", response.data);
        this.produto = response.data; 
        console.log("Produto encontrado:", this.produto);
      } catch (error) {
        console.error("Erro ao buscar o produto:", error);
      }
    },
    async saveProduct() {
      try {
        if (this.idProduto) {
          await axios.put(`/product/${this.idProduto}`, this.produto);
          this.$router.push("/gerenciar-produtos");
        } else {
          await axios.post("/product/save", this.produto);
        }
        console.log("Produto salvo com sucesso!");
      } catch (error) {
        console.error("Erro ao salvar o produto:", error);
      }
    },
  },
};
</script>
