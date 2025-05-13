// src/router.js
import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/auth/login.vue'

import { isTokenExpired } from '../utils/auth'
const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/auth/register.vue'),
  },
  {
    path: '/',
    name: 'Eventos',
    component: () => import('../views/eventos/gerenciar-eventos.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/imoveis',
    name: 'Imóveis',
    component: () => import('../views/imoveis/gerenciar-imoveis.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/configuracoes',
    name: 'Configurações',
    component: () => import('../views/configuracoes/gerenciar-configuracoes.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/planejamento',
    name: 'Planejamento',
    component: () => import('../views/planejamento/planejamento.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/eventos/visualizar/:codigo',
    name: 'visualizar-evento',
    component: () => import('../views/eventos/visualizar-evento.vue'),
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');

  if (to.meta.requiresAuth && !token) {
    next('/login');
  } 
  else if (token && isTokenExpired(token)) {
    localStorage.removeItem('token');
    next('/login');
  } 
  else if (token && (to.path === '/login' || to.path === '/register')) {
    next('/');
  } 
  else {
    next();
  }
});

export default router
