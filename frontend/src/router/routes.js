// src/router.js
import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/auth/login.vue'
import gerenciarProdutos from '@/views/produtos/gerenciar-produtos.vue'
import CadastrarProduto from '@/views/produtos/cadastrar-produto.vue'

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
    name: 'Teste',
    component: () => import('../views/Teste.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/produto',
    name: 'CadastrarProduto',
    component: () => import('../views/produtos/cadastrar-produto.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/produto/:id?',
    name: 'EditarProduto',
    component: () => import('../views/produtos/cadastrar-produto.vue'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/gerenciar-produtos',
    name: 'GerenciarProdutos',
    component: () => import('../views/produtos/gerenciar-produtos.vue'),
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
