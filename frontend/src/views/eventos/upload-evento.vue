<template>
    <div class="flex items-center justify-center w-screen h-screen bg-zinc-950 p-4">
        <div class="border border-zinc-700 rounded-lg w-full max-w-3xl bg-zinc-900 shadow-xl">
            <!-- Cabeçalho -->
            <div class="bg-zinc-800 rounded-t-lg py-3 px-6 font-semibold text-white text-lg">
                Enviar Fotos
            </div>

            <!-- Mensagem informativa -->
            <!-- <div class="m-4 p-4 bg-zinc-800/50 border border-zinc-700 rounded-lg flex items-start gap-3">
                <Info class="text-blue-400 mt-0.5 flex-shrink-0" size="22px" />
                <p class="text-zinc-300 text-sm">
                    Obrigado por compartilhar suas fotos! Após o envio, elas serão revisadas pelo organizador
                    do evento antes de aparecerem no slideshow.
                </p>
            </div> -->

            <!-- Campo de nome -->
            <div class="px-4 pb-2 mt-6">
                <InputText v-model="nome" placeholder="Seu Nome (opcional)"
                    class="w-full bg-zinc-800 border-zinc-700 text-white p-3 rounded-lg" autocomplete="off" />
            </div>

            <!-- Opções de upload -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                <!-- Escolher foto -->
                <div class="border border-dashed border-zinc-700 rounded-lg p-6 flex flex-col items-center justify-center gap-3 hover:bg-zinc-800/50 transition-colors cursor-pointer"
                    @click="escolherArquivo">
                    <div class="p-3 rounded-full bg-zinc-800/70 text-blue-400">
                        <ImageIcon size="22px" />
                    </div>
                    <h3 class="font-semibold text-white text-lg">Escolher Foto</h3>
                    <p class="text-zinc-400 text-sm text-center">Selecione uma foto da sua galeria</p>
                    <button
                        class="mt-2 flex items-center gap-2 bg-zinc-800 hover:bg-zinc-700 text-white py-2 px-4 rounded-lg transition-colors">
                        <Upload size="22px" />
                        Escolher Arquivo
                    </button>
                    <input type="file" ref="fileInput" accept="image/*" multiple class="hidden"
                        @change="onFileSelected" />
                </div>

                <!-- Tirar foto -->
                <div class="border border-dashed border-zinc-700 rounded-lg p-6 flex flex-col items-center justify-center gap-3 hover:bg-zinc-800/50 transition-colors cursor-pointer"
                    @click="abrirCamera">
                    <div class="p-3 rounded-full bg-zinc-800/70 text-blue-400">
                        <Camera size="22px" />
                    </div>
                    <h3 class="font-semibold text-white text-lg">Tirar Foto</h3>
                    <p class="text-zinc-400 text-sm text-center">Use a câmera do seu dispositivo</p>
                    <button
                        class="mt-2 flex items-center gap-2 bg-zinc-800 hover:bg-zinc-700 text-white py-2 px-4 rounded-lg transition-colors">
                        <Camera size="22px" />
                        Abrir Câmera
                    </button>
                </div>
            </div>

            <!-- Fotos enviadas -->
            <div v-if="fotos.length > 0" class="px-4 pb-6">
                <h3 class="font-semibold text-white text-lg mb-4">Fotos Selecionadas</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <div v-for="(foto, index) in fotos" :key="index" class="relative rounded-lg overflow-hidden group">
                        <img :src="foto.url" class="w-full h-32 object-cover" alt="Foto enviada" />
                        <div class="absolute bottom-0 left-0 right-0 bg-black/80 py-1 px-2 text-xs text-white">
                            <div class="bg-blue-500/40 rounded-full px-2">
                                Pendente de aprovação
                            </div>
                        </div>
                        <button @click="removerFoto(index)"
                            class="absolute top-2 right-2 bg-red-500 rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <X size="12px" />
                        </button>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button @click="save" class="bg-blue-500 text-white py-2 px-6 rounded-lg transition-colors">
                        Enviar Fotos
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import InputText from 'primevue/inputtext';
import { ImageIcon, Camera, Upload, Info, X } from 'lucide-vue-next';
import axiosInstance from '../../axios';

export default {
    data() {
        return {
            nome: "",
            fotos: [],
            cameraAtiva: false
        }
    },
    components: {
        InputText,
        ImageIcon,
        Camera,
        Upload,
        Info,
        X
    },
    methods: {
        async save() {
            try {
                const formData = new FormData();
                formData.append('nome', this.nome);
                formData.append('codigo', this.$route.params.codigo);
                this.fotos.forEach(foto => {
                    formData.append('fotos[]', foto.file);
                });
                const response = await axiosInstance.post('/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                this.fotos = [];
            } catch (error) {
                console.error("Erro ao salvar:", error);
            }
        }
        ,
        escolherArquivo() {
            this.$refs.fileInput.click();
        },
        onFileSelected(event) {
            const files = event.target.files;
            if (!files.length) return;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const url = URL.createObjectURL(file);
                this.fotos.push({
                    file,
                    url,
                    status: 'pendente'
                });
            }

            // Limpar o campo de input para permitir selecionar os mesmos arquivos novamente
            event.target.value = '';
        },
        abrirCamera() {
            // Aqui você implementaria a lógica para abrir a câmera
            // Usando APIs como MediaDevices.getUserMedia()
            alert('Funcionalidade de câmera será implementada');
        },
        removerFoto(index) {
            this.fotos.splice(index, 1);
        }
    }
}
</script>

<style scoped>
:deep(.p-inputtext) {
    background-color: #27272a;
    color: white;
    border-color: #3f3f46;
}

:deep(.p-inputtext:focus) {
    border-color: #a855f7;
    box-shadow: 0 0 0 1px rgba(168, 85, 247, 0.2);
}

:deep(.p-inputtext::placeholder) {
    color: #a1a1aa;
}
</style>