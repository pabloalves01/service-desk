// src/router.js
import { createRouter, createWebHistory } from 'vue-router'
import Teste from '../views/Teste.vue'

const routes = [
  {
    path: '/',
    name: 'Teste',
    component: Teste,
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
