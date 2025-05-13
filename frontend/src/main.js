import './assets/main.css'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router/routes.js'
import PrimeVue from 'primevue/config';
import 'primeicons/primeicons.css';
import Aura from '@primeuix/themes/aura'
import Breadcrumb from './components/comum/breadcrumb/breacrumb.vue';
const app = createApp(App)


app.use(router)
app.component('Breadcrumb', Breadcrumb)
app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});
app.mount('#app')