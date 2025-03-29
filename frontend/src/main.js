import './assets/main.css'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router/routes.js'

const app = createApp(App)
app.use(router) // Use o Vue Router
app.mount('#app')


// const app = createApp(App);
// app.use(router);
// app.mount('#app');

// createApp(App).use(router).mount('#app')
