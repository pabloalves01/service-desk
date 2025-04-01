<template>
    <div>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="produto in produtos" :key="produto.id">
                    <td>{{ produto.nome }}</td>
                    <td>{{ produto.preco }}</td>
                    <td>{{ produto.quantidade }}</td>
                    <td>
                        <div class="flex gap-2">
                            <button class="bg-slate-200 p-2" @click="editarProduto(produto.id)">Editar</button>
                            <button class="bg-slate-200 p-2" @click="openModalDelete(produto)">Deletar</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-if="isOpenModal" class="bg-white p-8 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
        tem certeza que voce deseja deletar o produto {{ selectProduto?.nome }}?
        <button class="bg-red-500 p-4" @click="deletarProduto()">deletar</button>
    </div>

</template>

<script>
import axios from "../../axios"
export default {
    data() {
        return {
            selectProduto: null,
            isOpenModal: false,
            produtos: []
        }
    },
    created() {
        this.getProdutos();
    },
    methods: {
        editarProduto(id) {
            console.log("Editar produto com ID:", id);
            this.$router.push({ path: `/produto/${id}` });
        },
        openModalDelete(produto) {
            this.selectProduto = produto;
            this.isOpenModal = true;
        },
        async deletarProduto() {
            try {
                const response = await axios.delete(`/product/${this.selectProduto.id}`);
                console.log("Produto deletado:", response.data);
                this.getProdutos();
            } catch (error) {
                console.error(error);
            }
        }, 
        async getProdutos() {
            try {
                const response = await axios.get("/products")
                this.produtos = response.data;
                console.log("produtos aqui:", response.data)
            } catch (error) {
                console.error(error);
            }
        }
    }
}

</script>

<style scoped>
.styled-table {
    width: 100%;
    background-color: white;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    font-size: 16px;
    text-align: left;
}

.styled-table thead tr {
    background-color: #009879;
    color: #ffffff;
    text-align: left;
}

.styled-table th,
.styled-table td {
    padding: 12px 15px;
    border: 1px solid #dddddd;
}

.styled-table tbody tr:nth-child(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:hover {
    background-color: #f1f1f1;
}
</style>