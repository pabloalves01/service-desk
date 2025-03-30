// src/router.js
import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/auth/login.vue'
import Teste from '../views/Teste.vue'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/',
    name: 'Teste',
    component: Teste,
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
  if (to.meta.requiresAuth && !localStorage.getItem('token')) {
    next('/login');
  } else {
    next();
  }
});


export default router
