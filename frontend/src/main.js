import './assets/main.css'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router/routes.js'
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura'

const app = createApp(App)


app.use(router)
app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});
app.mount('#app')


// const app = createApp(App);
// app.use(router);
// app.mount('#app');

// createApp(App).use(router).mount('#app')
