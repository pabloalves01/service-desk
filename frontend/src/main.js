import './assets/main.css'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router/routes.js'
import PrimeVue from 'primevue/config';
import 'primeicons/primeicons.css';
import Aura from '@primeuix/themes/aura'
import Breadcrumb from './components/comum/breadcrumb/breacrumb.vue';
import globals from './globals'
const app = createApp(App)

app.config.globalProperties.$globals = globals;

app.use(router)
app.component('Breadcrumb', Breadcrumb)
app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});
app.mount('#app')